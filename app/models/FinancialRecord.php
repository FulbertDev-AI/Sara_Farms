<?php
require_once __DIR__ . '/../../core/Model.php';

class FinancialRecord extends Model {
    public function log($type, $amount, $category, $desc, $date, $refId = null) {
        $sql = "INSERT INTO financial_records (type_transaction, montant, categorie, description, date_transaction, reference_id) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $this->query($sql, [$type, $amount, $category, $desc, $date, $refId]);
    }

    public function getMonthlyBalance($month, $year) {
        $sql = "
            SELECT 
                SUM(CASE WHEN type_transaction = 'revenu' THEN montant ELSE 0 END) as total_revenus,
                SUM(CASE WHEN type_transaction = 'depense' THEN montant ELSE 0 END) as total_depenses
            FROM financial_records 
            WHERE MONTH(date_transaction) = ? AND YEAR(date_transaction) = ?
        ";
        return $this->query($sql, [$month, $year])->fetch();
    }

    public function getDailyRevenue() {
        return $this->query("
            SELECT COALESCE(SUM(montant), 0) as total 
            FROM financial_records 
            WHERE type_transaction = 'revenu' AND date_transaction = CURDATE()
        ")->fetch()['total'];
    }
}
?>