<?php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/OrderItem.php';
require_once __DIR__ . '/../../includes/functions.php';

class OrderController extends Controller {
    public function index() {
        $this->authRequired();
        $model = new Order();
        $orders = $model->getUserOrders($_SESSION['user_id']);
        $this->view('frontend/orders/index', ['pageTitle'=>'Mes Commandes', 'orders'=>$orders]);
    }

    public function detail($id) {
        $this->authRequired();
        $orderModel = new Order();
        $itemModel = new OrderItem();
        $order = $orderModel->findById($id);
        
        if($order['user_id'] != $_SESSION['user_id']) $this->redirect('orders');
        
        $items = $itemModel->getByOrderId($id);
        $this->view('frontend/orders/detail', ['pageTitle'=>'Détail Commande', 'order'=>$order, 'items'=>$items]);
    }

    public function cancel($id) {
        $this->authRequired();
        $model = new Order();
        $order = $model->findById($id);
        if($order && $order['user_id'] == $_SESSION['user_id'] && $order['status'] == 'en_attente') {
            $model->updateStatus($id, 'rejetee', 'Annulé par le client');
            flashMessage('info', 'Commande annulée.');
        }
        $this->redirect('orders');
    }

    public function confirmMobileMoneyPayment($id) {
        $this->authRequired();
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect("orders/detail/$id");
        }

        $orderModel = new Order();
        $order = $orderModel->findById($id);

        // Vérifier la propriété de la commande
        if(!$order || $order['user_id'] != $_SESSION['user_id']) {
            flashMessage('error', 'Commande non trouvée.');
            $this->redirect('orders');
        }

        $mobileMoneyRef = $_POST['mobile_money_reference'] ?? '';
        if(!$mobileMoneyRef) {
            flashMessage('error', 'Veuillez entrer le numéro de transaction Mobile Money.');
            $this->redirect("orders/detail/$id");
        }

        // Mise à jour du statut de paiement
        $this->db->query(
            "UPDATE orders SET mobile_money_reference = ?, payment_status = 'completed' WHERE id = ?",
            [$mobileMoneyRef, $id]
        );

        flashMessage('success', 'Paiement confirmé! Nous vérifierons votre transaction et vous contacterons.');
        $this->redirect("orders/detail/$id");
    }
}
?>