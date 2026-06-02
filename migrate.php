<?php
// Script de migration pour la base de données
require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/config/database.php';

$db = Database::getInstance()->getConnection();

try {
    echo "Début de la migration...\n";
    
    // Vérifier et ajouter les colonnes à la table orders
    $queries = [
        "ALTER TABLE orders ADD COLUMN IF NOT EXISTS payment_method VARCHAR(50) DEFAULT 'livraison' AFTER status",
        "ALTER TABLE orders ADD COLUMN IF NOT EXISTS mobile_money_reference VARCHAR(100) NULL AFTER payment_method",
        "ALTER TABLE orders ADD COLUMN IF NOT EXISTS payment_status ENUM('pending', 'completed', 'failed') DEFAULT 'pending' AFTER mobile_money_reference"
    ];
    
    foreach($queries as $query) {
        $db->query($query);
        echo "✓ " . substr($query, 0, 50) . "...\n";
    }
    
    echo "\n✓ Migration terminée avec succès!\n";
} catch(Exception $e) {
    echo "✗ Erreur: " . $e->getMessage() . "\n";
}
?>
