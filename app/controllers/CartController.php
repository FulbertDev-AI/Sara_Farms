<?php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/OrderItem.php';
require_once __DIR__ . '/../../includes/validator.php';
require_once __DIR__ . '/../../includes/functions.php';

class CartController extends Controller {
    public function index() {
        $this->authRequired();
        $cart = $_SESSION['cart'] ?? [];
        $productModel = new Product();
        $items = []; $total = 0;

        foreach($cart as $id => $qty) {
            $p = $productModel->findById($id);
            if($p) {
                $p['qty'] = $qty;
                $p['subtotal'] = $p['prix'] * $qty;
                $total += $p['subtotal'];
                $items[] = $p;
            }
        }
        $this->view('frontend/shop/cart', ['pageTitle'=>'Panier', 'items'=>$items, 'total'=>$total]);
    }

    // Remplacez juste la méthode add() dans votre CartController existant
public function add($id) {
    $this->authRequired();
    if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
    
    // Incrémente la quantité
    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
    
    // Retour au shop avec confirmation
    $_SESSION['flash'] = ['type' => 'success', 'message' => 'Produit ajouté au panier'];
    $this->redirect('shop');
}

    public function remove($id) {
        $this->authRequired();
        unset($_SESSION['cart'][$id]);
        $this->redirect('cart');
    }

    public function update($id) {
        $this->authRequired();
        $qty = $_POST['qty'] ?? null;

        if($qty === null) {
            $raw = file_get_contents('php://input');
            $json = json_decode($raw, true);
            if(is_array($json) && isset($json['qty'])) {
                $qty = $json['qty'];
            }
        }

        if(isset($_SESSION['cart'][$id]) && $qty !== null) {
            $_SESSION['cart'][$id] = max(1, (int)$qty);
        }
        echo json_encode(['success'=>true]);
    }

    public function checkout() {
        $this->authRequired();
        $cart = $_SESSION['cart'] ?? [];
        if(empty($cart)) $this->redirect('shop');

        // Récupère le mode de paiement (par défaut: livraison)
        $paymentMethod = $_POST['payment_method'] ?? 'livraison';
        if(!in_array($paymentMethod, ['livraison', 'mobile_money'])) {
            $paymentMethod = 'livraison';
        }

        $productModel = new Product();
        $orderModel = new Order();
        $itemModel = new OrderItem();
        $total = 0;

        foreach($cart as $id => $qty) {
            $p = $productModel->findById($id);
            if(!$p || $p['stock_disponible'] < $qty) {
                flashMessage('error', 'Stock insuffisant pour certains produits.');
                $this->redirect('cart');
            }
            $total += $p['prix'] * $qty;
        }

        $this->db->beginTransaction();
        try {
            $orderId = $orderModel->create($_SESSION['user_id'], $total, $paymentMethod);
            foreach($cart as $id => $qty) {
                $p = $productModel->findById($id);
                $itemModel->create($orderId, $id, $qty, $p['prix']);
                $productModel->updateStock($id, $qty, 'decrement');
            }
            $this->db->commit();
            unset($_SESSION['cart']);
            
            // Redirection selon le mode de paiement
            if($paymentMethod === 'mobile_money') {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Commande créée. Veuillez effectuer le paiement Mobile Money.'];
                $this->redirect('orders');
            } else {
                flashMessage('success', 'Commande validée avec succès. Vous serez contacté pour la livraison.');
                $this->redirect('shop');
            }
        } catch(Exception $e) {
            $this->db->rollBack();
            flashMessage('error', 'Erreur lors de la validation.');
        }
        $this->redirect('shop');
    }
}
?>