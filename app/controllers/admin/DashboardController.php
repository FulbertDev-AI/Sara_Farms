<?php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../models/Dashboard.php';
require_once __DIR__ . '/../../models/RawMaterial.php';
require_once __DIR__ . '/../../models/Order.php';

class DashboardController extends Controller {
    public function index() {
        $this->adminRequired();

        $dashModel = new Dashboard();
        $rawMatModel = new RawMaterial();
        $orderModel = new Order();

        // 1. Statistiques 24h
        $stats = $dashModel->getStats24h();
        
        // 2. Alertes de stock (Intrants bas)
        $alerts = $rawMatModel->getLowStockAlerts();

        // 3. Dernières commandes
        $recentOrders = $orderModel->getAllOrders();
        // Limiter à 5 pour le dashboard
        $recentOrders = array_slice($recentOrders, 0, 5);

        // 4. Nombre total de clients
        require_once __DIR__ . '/../../models/User.php';
        $userModel = new User();
        $totalClients = $userModel->countTotalClients();

        $this->view('admin/dashboard/index', [
            'pageTitle' => 'Tableau de bord',
            'stats' => $stats,
            'alerts' => $alerts,
            'recentOrders' => $recentOrders,
            'totalClients' => $totalClients
        ]);
    }
}
?>