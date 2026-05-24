<?php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../models/Order.php';
require_once __DIR__ . '/../../models/Product.php';
require_once __DIR__ . '/../../models/FinancialRecord.php';
require_once __DIR__ . '/../../models/StockMovement.php';

class OrderManagementController extends Controller {
    public function __construct() {
        $this->adminRequired();
    }

    public function index() {
        $model = new Order();
        $orders = $model->getAllOrders();
        $this->view('admin/orders/index', ['orders' => $orders]);
    }

    public function detail($id) {
        $orderModel = new Order();
        $order = $orderModel->findById($id);
        $items = $orderModel->getItemsByOrderId($id);
        $this->view('admin/orders/detail', ['order' => $order, 'items' => $items]);
    }

    // ACTION: Valider une commande
    public function validate($id) {
        $orderModel = new Order();
        $productModel = new Product();
        $financeModel = new FinancialRecord();
        $stockModel = new StockMovement();

        $order = $orderModel->findById($id);
        $items = $orderModel->getItemsByOrderId($id);

        // Vérifier le stock avant de valider
        foreach ($items as $item) {
            $prod = $productModel->findById($item['product_id']);
            if ($prod['stock_disponible'] < $item['quantite']) {
                $this->redirect('admin/orders/detail/' . $id); // Ou afficher une erreur
            }
        }

        // DÉBUT TRANSACTION (Atomicité)
        $this->db->beginTransaction();
        try {
            // 1. Changer statut commande
            $orderModel->updateStatus($id, 'validee');

            // 2. Décrémenter stock produits & Logger mouvements
            foreach ($items as $item) {
                $productModel->updateStock($item['product_id'], $item['quantite'], 'decrement');
                $stockModel->log('produit', $item['product_id'], 'sortie', $item['quantite'], $item['prix_unitaire'], 'Vente commande #' . $id);
            }

            // 3. Enregistrer Revenu Financier
            $financeModel->log('revenu', $order['total_amount'], 'Vente', 'Commande #' . $id, date('Y-m-d'), $id);

            $this->db->commit();
        } catch (Exception $e) {
            $this->db->rollBack();
        }

        $this->redirect('admin/orders/index');
    }

    // ACTION: Rejeter une commande
    public function reject($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $motif = $_POST['motif'] ?? 'Non spécifié';
            $orderModel = new Order();
            $orderModel->updateStatus($id, 'rejetee', $motif);
            $this->redirect('admin/orders/index');
        }
    }
}
?>