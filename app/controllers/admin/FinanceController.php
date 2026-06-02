<?php
require_once __DIR__ . '/../../../core/Controller.php';
require_once __DIR__ . '/../../models/Dashboard.php';

class FinanceController extends Controller {
    public function __construct() {
        parent::__construct();
        $this->adminRequired();
    }

    public function index() {
        $month = $_GET['month'] ?? date('m');
        $year = $_GET['year'] ?? date('Y');

        $model = new Dashboard();
        $balance = $model->getMonthlyBalance($month, $year) ?: [];

        $balance = array_merge([
            'revenus' => 0,
            'depenses' => 0,
            'benefice' => 0,
            'taux' => 0
        ], $balance);

        $balance['benefice'] = $balance['revenus'] - $balance['depenses'];
        $balance['taux'] = $balance['revenus'] > 0 ? (($balance['benefice'] / $balance['revenus']) * 100) : 0;

        $this->view('admin/finance/index', [
            'balance' => $balance,
            'currentMonth' => $month,
            'currentYear' => $year
        ]);
    }
}
?>