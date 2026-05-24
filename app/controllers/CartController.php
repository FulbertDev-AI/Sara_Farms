<?php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/OrderItem.php';
require_once __DIR__ . '/../../includes/validator.php';

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

    public function add($id) {
        $this->authRequired();
        if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
        $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
        echo json_encode(['success'=>true, 'count'=>count($_SESSION['cart'])]);
    }

    public function remove($id) {
        $this->authRequired();
        unset($_SESSION['cart'][$id]);
        $this->redirect('cart');
    }

    public function update($id) {
        $this->authRequired();
        if(isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] = max(1, (int)$_POST['qty']);
        }
        echo json_encode(['success'=>true]);
    }

    public function checkout() {
        $this->authRequired();
        $cart = $_SESSION['cart'] ?? [];
        if(empty($cart)) $this->redirect('shop');

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
            $orderId = $orderModel->create($_SESSION['user_id'], $total);
            foreach($cart as $id => $qty) {
                $p = $productModel->findById($id);
                $itemModel->create($orderId, $id, $qty, $p['prix']);
                $productModel->updateStock($id, $qty, 'decrement');
            }
            $this->db->commit();
            unset($_SESSION['cart']);
            flashMessage('success', 'Commande validée avec succès.');
        } catch(Exception $e) {
            $this->db->rollBack();
            flashMessage('error', 'Erreur lors de la validation.');
        }
        $this->redirect('shop');
    }
}
?>