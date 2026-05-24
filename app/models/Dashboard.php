<?php
require_once __DIR__ . '/../../core/Model.php';

class Dashboard extends Model {
    public function getStats24h() {
        // Commandes & valeur financière
        $orders = $this->query("
            SELECT COUNT(*) as count, COALESCE(SUM(total_amount), 0) as value 
            FROM orders WHERE created_at >= NOW() - INTERVAL 24 HOUR
        ")->fetch();
        
        // Revenus du jour
        $revenue = $this->query("
            SELECT COALESCE(SUM(montant), 0) as total 
            FROM financial_records WHERE type_transaction = 'revenu' AND date_transaction = CURDATE()
        ")->fetch()['total'];

        return [
            'orders_count' => $orders['count'],
            'orders_value' => $orders['value'],
            'daily_revenue' => $revenue
        ];
    }

    public function getMonthlyBalance($month, $year) {
        $data = $this->query("
            SELECT 
                SUM(CASE WHEN type_transaction = 'revenu' THEN montant ELSE 0 END) as revenus,
                SUM(CASE WHEN type_transaction = 'depense' THEN montant ELSE 0 END) as depenses
            FROM financial_records 
            WHERE MONTH(date_transaction) = ? AND YEAR(date_transaction) = ?
        ", [$month, $year])->fetch();

        $data['benefice'] = $data['revenus'] - $data['depenses'];
        return $data;
    }
}
?>