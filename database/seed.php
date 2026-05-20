<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/db.php';

try {
    $pdo = getPDO();
    
    // Récupérer les IDs des rôles
    $stmt = $pdo->prepare('SELECT id FROM roles WHERE nom_role = :role');
    $stmt->execute(['role' => 'admin']);
    $adminRoleId = $stmt->fetchColumn();
    
    $stmt->execute(['role' => 'employe']);
    $employeRoleId = $stmt->fetchColumn();
    
    if (!$adminRoleId || !$employeRoleId) {
        echo "Erreur : Les rôles n'ont pas pu être trouvés.\n";
        exit(1);
    }
    
    // Créer l'utilisateur admin
    $stmt = $pdo->prepare('INSERT IGNORE INTO utilisateurs (nom, prenom, email, mot_de_pass, role_id) VALUES (:nom, :prenom, :email, :mot_de_pass, :role_id)');
    
    $adminPassword = password_hash('admin123', PASSWORD_BCRYPT);
    $stmt->execute([
        'nom' => 'Admin',
        'prenom' => 'Sara Farms',
        'email' => 'admin@sarafarms.com',
        'mot_de_pass' => $adminPassword,
        'role_id' => $adminRoleId,
    ]);
    
    // Créer l'utilisateur employé
    $employePassword = password_hash('employe123', PASSWORD_BCRYPT);
    $stmt->execute([
        'nom' => 'Ouvrier',
        'prenom' => 'Agricole',
        'email' => 'employe@sarafarms.com',
        'mot_de_pass' => $employePassword,
        'role_id' => $employeRoleId,
    ]);
    
    echo "✓ Utilisateurs créés avec succès !\n";
    echo "\nIdentifiants :\n";
    echo "Admin:\n";
    echo "  Email: admin@sarafarms.com\n";
    echo "  Mot de passe: admin123\n";
    echo "\nEmployé:\n";
    echo "  Email: employe@sarafarms.com\n";
    echo "  Mot de passe: employe123\n";
    
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
    exit(1);
}
