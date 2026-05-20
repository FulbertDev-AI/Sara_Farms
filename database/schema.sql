-- Script SQL de création de la base de données Sara Farms
CREATE DATABASE IF NOT EXISTS sara_farms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sara_farms;

CREATE TABLE IF NOT EXISTS roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom_role VARCHAR(50) NOT NULL UNIQUE,
    description VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    mot_de_pass VARCHAR(255) NOT NULL,
    telephone VARCHAR(20) DEFAULT NULL,
    role_id INT NOT NULL,
    CONSTRAINT fk_utilisateur_role FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS intrants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    categorie VARCHAR(100) NOT NULL,
    quantite_disponible DECIMAL(10,2) NOT NULL DEFAULT 0,
    unite_mesure VARCHAR(20) NOT NULL,
    seuil_alerte DECIMAL(10,2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS cultures (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom_culture VARCHAR(150) NOT NULL,
    code_parcelle VARCHAR(50) NOT NULL,
    surface_hectares DECIMAL(8,2) NOT NULL,
    statut VARCHAR(50) NOT NULL,
    date_semis DATE NOT NULL,
    date_recolte_prevue DATE NOT NULL,
    date_recolte_effective DATE DEFAULT NULL,
    quantite_recoltee DECIMAL(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS interventions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    culture_id INT NOT NULL,
    utilisateur_id INT NOT NULL,
    type_action VARCHAR(100) NOT NULL,
    description TEXT,
    date_intervention DATETIME NOT NULL,
    CONSTRAINT fk_intervention_culture FOREIGN KEY (culture_id) REFERENCES cultures(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_intervention_utilisateur FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS produits_catalogue (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom_produit VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    prix_unitaire DECIMAL(10,2) NOT NULL,
    unite_vente VARCHAR(50) NOT NULL,
    stock_disponible INT NOT NULL DEFAULT 0,
    image_url VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS commandes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT DEFAULT NULL,
    nom_client_externe VARCHAR(150) DEFAULT NULL,
    date_commande DATETIME NOT NULL,
    statut_paiement VARCHAR(50) NOT NULL,
    montant_total DECIMAL(10,2) NOT NULL,
    CONSTRAINT fk_commande_utilisateur FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS details_commandes (
    commande_id INT NOT NULL,
    produit_id INT NOT NULL,
    quantite INT NOT NULL,
    prix_unitaire_facture DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (commande_id, produit_id),
    CONSTRAINT fk_detail_commande FOREIGN KEY (commande_id) REFERENCES commandes(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_detail_produit FOREIGN KEY (produit_id) REFERENCES produits_catalogue(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO roles (nom_role, description) VALUES
('admin', 'Administrateur du système'),
('employe', 'Ouvrier agricole en charge des interventions'),
('client', 'Client de la boutique en ligne');
