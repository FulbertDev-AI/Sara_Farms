<?php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../models/RawMaterial.php';
require_once __DIR__ . '/../../models/StockMovement.php';
require_once __DIR__ . '/../../models/FinancialRecord.php';

class StockController extends Controller {
    public function __construct() {
        $this->adminRequired();
    }

    public function index() {
        $model = new RawMaterial();
        $materials = $model->getAll();
        $this->view('admin/stock/index', ['materials' => $materials]);
    }

    public function create() {
        $this->view('admin/stock/create');
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = new RawMaterial();
            $model->create($_POST); // nom, categorie, stock, seuil
            $this->redirect('admin/stock/index');
        }
    }

    // Ajouter du stock (Achat d'intrants)
    public function addStock($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $qty = (int)$_POST['quantite'];
            $cost = (float)$_POST['cout_unitaire'];
            $totalCost = $qty * $cost;

            $rawModel = new RawMaterial();
            $movementModel = new StockMovement();
            $financeModel = new FinancialRecord();

            // Transaction
            $this->db->beginTransaction();
            try {
                // 1. Mettre à jour stock
                $rawModel->updateStock($id, $qty, 'increment');
                
                // 2. Logger mouvement
                $movementModel->log('intrant', $id, 'entree', $qty, $cost, 'Achat intrants');

                // 3. Enregistrer Dépense Financière
                $financeModel->log('depense', $totalCost, 'Achat Intrants', 'Stock ajouté', date('Y-m-d'), $id);

                $this->db->commit();
            } catch (Exception $e) {
                $this->db->rollBack();
            }

            $this->redirect('admin/stock/index');
        }
    }
}
?>