<?php
declare(strict_types=1);

// Configuration de la connexion PDO à la base de données MySQL
$host = 'localhost';
$database = 'sara_farms';
$user = 'root';
$password = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',
];

try {
    $pdo = new PDO($dsn, $user, $password, $options);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE `$database`");

    $pdo->exec("CREATE TABLE IF NOT EXISTS roles (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nom_role VARCHAR(50) NOT NULL UNIQUE,
        description VARCHAR(255) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $pdo->exec("CREATE TABLE IF NOT EXISTS utilisateurs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(100) NOT NULL,
        prenom VARCHAR(100) NOT NULL,
        email VARCHAR(150) NOT NULL UNIQUE,
        mot_de_pass VARCHAR(255) NOT NULL,
        telephone VARCHAR(20) DEFAULT NULL,
        role_id INT NOT NULL,
        CONSTRAINT fk_utilisateur_role FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE RESTRICT ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $pdo->exec("CREATE TABLE IF NOT EXISTS intrants (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(150) NOT NULL,
        categorie VARCHAR(100) NOT NULL,
        quantite_disponible DECIMAL(10,2) NOT NULL DEFAULT 0,
        unite_mesure VARCHAR(20) NOT NULL,
        seuil_alerte DECIMAL(10,2) NOT NULL DEFAULT 0
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $pdo->exec("CREATE TABLE IF NOT EXISTS cultures (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nom_culture VARCHAR(150) NOT NULL,
        code_parcelle VARCHAR(50) NOT NULL,
        surface_hectares DECIMAL(8,2) NOT NULL,
        statut VARCHAR(50) NOT NULL,
        date_semis DATE NOT NULL,
        date_recolte_prevue DATE NOT NULL,
        date_recolte_effective DATE DEFAULT NULL,
        quantite_recoltee DECIMAL(10,2) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $pdo->exec("CREATE TABLE IF NOT EXISTS interventions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        culture_id INT NOT NULL,
        utilisateur_id INT NOT NULL,
        type_action VARCHAR(100) NOT NULL,
        description TEXT,
        date_intervention DATETIME NOT NULL,
        CONSTRAINT fk_intervention_culture FOREIGN KEY (culture_id) REFERENCES cultures(id) ON DELETE CASCADE ON UPDATE CASCADE,
        CONSTRAINT fk_intervention_utilisateur FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $pdo->exec("CREATE TABLE IF NOT EXISTS produits_catalogue (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nom_produit VARCHAR(150) NOT NULL,
        description TEXT NOT NULL,
        prix_unitaire DECIMAL(10,2) NOT NULL,
        unite_vente VARCHAR(50) NOT NULL,
        stock_disponible INT NOT NULL DEFAULT 0,
        image_url VARCHAR(255) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $pdo->exec("CREATE TABLE IF NOT EXISTS commandes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        utilisateur_id INT DEFAULT NULL,
        nom_client_externe VARCHAR(150) DEFAULT NULL,
        date_commande DATETIME NOT NULL,
        statut_paiement VARCHAR(50) NOT NULL,
        montant_total DECIMAL(10,2) NOT NULL,
        CONSTRAINT fk_commande_utilisateur FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE SET NULL ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $pdo->exec("CREATE TABLE IF NOT EXISTS details_commandes (
        commande_id INT NOT NULL,
        produit_id INT NOT NULL,
        quantite INT NOT NULL,
        prix_unitaire_facture DECIMAL(10,2) NOT NULL,
        PRIMARY KEY (commande_id, produit_id),
        CONSTRAINT fk_detail_commande FOREIGN KEY (commande_id) REFERENCES commandes(id) ON DELETE CASCADE ON UPDATE CASCADE,
        CONSTRAINT fk_detail_produit FOREIGN KEY (produit_id) REFERENCES produits_catalogue(id) ON DELETE RESTRICT ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $stmt = $pdo->prepare('INSERT IGNORE INTO roles (nom_role, description) VALUES (:role, :description)');
    $roles = [
        ['role' => 'admin', 'description' => 'Administrateur du système'],
        ['role' => 'employe', 'description' => 'Ouvrier agricole en charge des interventions'],
        ['role' => 'client', 'description' => 'Client de la boutique en ligne'],
    ];
    foreach ($roles as $item) {
        $stmt->execute($item);
    }
} catch (PDOException $exception) {
    http_response_code(500);
    echo 'Erreur de connexion à la base de données.';
    exit;
}

/**
 * Retourne l'objet PDO global pour l'application.
 *
 * @return PDO
 */
function getPDO(): PDO
{
    global $pdo;
    return $pdo;
}

/**
 * Supprime les emojis et caractères non désirés d'un texte avant insertion.
 *
 * @param string $text
 * @return string
 */
function sanitizeText(string $text): string
{
    $clean = trim($text);
    $clean = preg_replace('/[\x{1F600}-\x{1F64F}\x{1F300}-\x{1F5FF}\x{1F680}-\x{1F6FF}\x{1F700}-\x{1F77F}\x{1F780}-\x{1F7FF}\x{1F800}-\x{1F8FF}\x{1F900}-\x{1F9FF}\x{1FA00}-\x{1FA6F}\x{1FA70}-\x{1FAFF}]/u', '', $clean);
    return htmlspecialchars($clean, ENT_QUOTES, 'UTF-8');
}
