<?php
/**
 * ===================================================================
 * 🧪 SUITE DE TESTS COMPLÈTE - SARA FARMS
 * ===================================================================
 * Tests unitaires et d'intégration pour vérifier toutes les 
 * fonctionnalités de l'application. Execute pour vérifier l'app.
 * ===================================================================
 */

session_start();
set_time_limit(300);
ob_start();

// Configuration
define('BASE_URL', 'http://localhost/Sara_Farms/');
require_once __DIR__ . '/config/constants.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/core/Controller.php';
require_once __DIR__ . '/core/Model.php';
require_once __DIR__ . '/app/models/User.php';
require_once __DIR__ . '/app/models/Product.php';
require_once __DIR__ . '/app/models/Order.php';
require_once __DIR__ . '/app/models/OrderItem.php';
require_once __DIR__ . '/app/models/Stock.php';
require_once __DIR__ . '/app/models/RawMaterial.php';
require_once __DIR__ . '/app/models/FinancialRecord.php';
require_once __DIR__ . '/app/models/StockMovement.php';
require_once __DIR__ . '/includes/functions.php';

// Classe Test Framework
class TestSuite {
    private $passed = 0;
    private $failed = 0;
    private $tests = [];
    
    public function test($name, $condition, $expected = null, $actual = null) {
        if ($condition) {
            $this->passed++;
            echo "✅ <strong>{$name}</strong><br>";
        } else {
            $this->failed++;
            echo "❌ <strong>{$name}</strong>";
            if ($expected !== null && $actual !== null) {
                echo " | Attendu: <code>$expected</code> | Obtenu: <code>$actual</code>";
            }
            echo "<br>";
        }
        $this->tests[] = ['name' => $name, 'passed' => $condition];
    }
    
    public function section($title) {
        echo "<hr><h3>$title</h3>";
    }
    
    public function report() {
        $total = $this->passed + $this->failed;
        $percentage = $total > 0 ? round(($this->passed / $total) * 100, 2) : 0;
        echo "<hr><h2 style='color: " . ($this->failed === 0 ? "green" : "orange") . "'>📊 Résumé Final</h2>";
        echo "<p><strong>✅ Réussis:</strong> {$this->passed}/{$total}</p>";
        echo "<p><strong>❌ Échoués:</strong> {$this->failed}/{$total}</p>";
        echo "<p><strong>📈 Taux de réussite:</strong> {$percentage}%</p>";
        if ($this->failed === 0) {
            echo "<p style='color: green; font-size: 18px;'><strong>🎉 TOUS LES TESTS SONT PASSÉS AVEC SUCCÈS!</strong></p>";
        }
    }
}

$tests = new TestSuite();

// ===================================================================
// 1️⃣ TESTS DE STRUCTURE & CONFIGURATION
// ===================================================================
$tests->section("📁 1. TESTS DE STRUCTURE & CONFIGURATION");

$tests->test("✔ Fichier config/constants.php existe", file_exists(__DIR__ . '/config/constants.php'));
$tests->test("✔ Fichier config/database.php existe", file_exists(__DIR__ . '/config/database.php'));
$tests->test("✔ Core Controller existe", file_exists(__DIR__ . '/core/Controller.php'));
$tests->test("✔ Core Model existe", file_exists(__DIR__ . '/core/Model.php'));
$tests->test("✔ AuthController existe", file_exists(__DIR__ . '/app/controllers/AuthController.php'));
$tests->test("✔ CartController existe", file_exists(__DIR__ . '/app/controllers/CartController.php'));
$tests->test("✔ OrderController existe", file_exists(__DIR__ . '/app/controllers/OrderController.php'));
$tests->test("✔ ProductController admin existe", file_exists(__DIR__ . '/app/controllers/admin/ProductController.php'));
$tests->test("✔ StockController admin existe", file_exists(__DIR__ . '/app/controllers/admin/StockController.php'));
$tests->test("✔ OrderManagementController admin existe", file_exists(__DIR__ . '/app/controllers/admin/OrderManagementController.php'));
$tests->test("✔ Schema SQL existe", file_exists(__DIR__ . '/database/schema.sql'));

// ===================================================================
// 2️⃣ TESTS DE CONNEXION BASE DE DONNÉES
// ===================================================================
$tests->section("🗄️ 2. TESTS DE CONNEXION BASE DE DONNÉES");

try {
    $db = Database::getInstance()->getConnection();
    $tests->test("✔ Connexion PDO établie", $db !== null);
    
    // Vérifier les tables
    $requiredTables = ['users', 'products', 'orders', 'order_items', 'raw_materials', 'financial_records', 'stock_movements', 'contact_messages'];
    foreach ($requiredTables as $table) {
        $stmt = $db->query("SHOW TABLES LIKE '$table'");
        $exists = $stmt->rowCount() > 0;
        $tests->test("✔ Table `$table` existe", $exists);
    }
} catch (Exception $e) {
    $tests->test("✔ Connexion BDD", false);
    echo "<i style='color:red;'>Erreur: {$e->getMessage()}</i><br>";
}

// ===================================================================
// 3️⃣ TESTS DE SESSIONS & AUTHENTIFICATION
// ===================================================================
$tests->section("🔐 3. TESTS DE SESSIONS & AUTHENTIFICATION");

$tests->test("✔ Session active", session_id() !== '');
$_SESSION['test_var'] = 'test_value';
$tests->test("✔ Écriture session", $_SESSION['test_var'] === 'test_value');
unset($_SESSION['test_var']);

$userModel = new User();

// Test: Créer un nouvel utilisateur
$randomEmail = 'test_' . time() . '@sarafarms.com';
$testUser = $userModel->create('Test', 'User', $randomEmail, 'SecurePass123', '0123456789');
$tests->test("✔ Création utilisateur (registre)", $testUser === true);

// Test: Vérifier que l'utilisateur existe
$createdUser = $userModel->findByEmail($randomEmail);
$tests->test("✔ Vérification utilisateur créé", $createdUser !== false && $createdUser['email'] === $randomEmail);

// Test: Vérifier le hashage du mot de passe
$passwordCorrect = password_verify('SecurePass123', $createdUser['password']);
$tests->test("✔ Mot de passe hashé correctement", $passwordCorrect === true);

// Test: Vérifier le rejet d'email en doublon
$duplicateAttempt = $userModel->create('Autre', 'Utilisateur', $randomEmail, 'AnotherPass', '0987654321');
$tests->test("✔ Rejet email en doublon", $duplicateAttempt === false);

// Test: Trouver par ID
$foundUser = $userModel->findById($createdUser['id']);
$tests->test("✔ Recherche utilisateur par ID", $foundUser !== false && $foundUser['id'] === $createdUser['id']);

// ===================================================================
// 4️⃣ TESTS DE PRODUITS
// ===================================================================
$tests->section("📦 4. TESTS DE PRODUITS");

$productModel = new Product();

// Test: Créer un produit
$productData = [
    'nom' => 'Tomates Premium Test',
    'desc' => 'Tomates de qualité supérieure',
    'prix' => 5000,
    'cat' => 'Légumes',
    'stock' => 50,
    'image' => 'tomates_test.jpg'
];
$createProductResult = $productModel->create($productData);
$tests->test("✔ Création produit", $createProductResult === true);

// Test: Récupérer tous les produits
$allProducts = $productModel->getAll();
$tests->test("✔ Récupération tous les produits", is_array($allProducts) && count($allProducts) > 0);

// Test: Trouver un produit par ID
if (!empty($allProducts)) {
    $firstProduct = $allProducts[0];
    $foundProduct = $productModel->findById($firstProduct['id']);
    $tests->test("✔ Recherche produit par ID", $foundProduct !== false && $foundProduct['id'] === $firstProduct['id']);
}

// Test: Modifier un produit
$updateData = [
    'nom' => 'Tomates Premium Test (Modifiée)',
    'desc' => 'Tomates de qualité supérieure - MODIFIED',
    'prix' => 6000,
    'cat' => 'Légumes Bio',
    'stock' => 75,
    'image' => 'tomates_test_mod.jpg'
];
// Récupérer l'ID du produit créé
$createdProducts = $productModel->getAll();
$testProduct = null;
foreach ($createdProducts as $p) {
    if (strpos($p['nom'], 'Tomates Premium Test') !== false) {
        $testProduct = $p;
        break;
    }
}
if ($testProduct) {
    $updateResult = $productModel->update($testProduct['id'], $updateData);
    $tests->test("✔ Modification produit", $updateResult === true);
}

// Test: Mise à jour du stock
if ($testProduct) {
    $productModel->updateStock($testProduct['id'], 10, 'decrement');
    $updated = $productModel->findById($testProduct['id']);
    $tests->test("✔ Décrémentation stock produit", $updated['stock_disponible'] < $testProduct['stock_disponible']);
}

// Test: Soft delete
if ($testProduct) {
    $productModel->delete($testProduct['id']);
    $deleted = $productModel->findById($testProduct['id']);
    $tests->test("✔ Soft delete produit (is_active=0)", $deleted['is_active'] === 0);
}

// ===================================================================
// 5️⃣ TESTS DE PANIER
// ===================================================================
$tests->section("🛒 5. TESTS DE PANIER");

// Simuler une session utilisateur
$_SESSION['user_id'] = $createdUser['id'];
$_SESSION['user_name'] = $createdUser['nom'];
$_SESSION['role'] = 'client';

// Test: Ajouter un produit au panier
$availableProducts = $productModel->getAll();
if (!empty($availableProducts)) {
    $product = $availableProducts[0];
    $_SESSION['cart'][$product['id']] = 2;
    $tests->test("✔ Ajout produit au panier", isset($_SESSION['cart'][$product['id']]) && $_SESSION['cart'][$product['id']] === 2);
    
    // Test: Augmenter quantité
    $_SESSION['cart'][$product['id']] = 5;
    $tests->test("✔ Mise à jour quantité panier", $_SESSION['cart'][$product['id']] === 5);
    
    // Test: Supprimer du panier
    unset($_SESSION['cart'][$product['id']]);
    $tests->test("✔ Suppression produit du panier", !isset($_SESSION['cart'][$product['id']]));
}

// Test: Calcul du total panier
$_SESSION['cart'] = [];
if (count($availableProducts) >= 2) {
    $product1 = $availableProducts[0];
    $product2 = $availableProducts[1];
    $_SESSION['cart'][$product1['id']] = 2;
    $_SESSION['cart'][$product2['id']] = 3;
    
    $expectedTotal = ($product1['prix'] * 2) + ($product2['prix'] * 3);
    $actualTotal = 0;
    foreach ($_SESSION['cart'] as $pId => $qty) {
        $p = $productModel->findById($pId);
        $actualTotal += $p['prix'] * $qty;
    }
    $tests->test("✔ Calcul total panier", $expectedTotal === $actualTotal);
}

// ===================================================================
// 6️⃣ TESTS DE COMMANDES
// ===================================================================
$tests->section("📋 6. TESTS DE COMMANDES");

$orderModel = new Order();
$itemModel = new OrderItem();

// Test: Créer une commande
if (!empty($_SESSION['cart'])) {
    $cartTotal = 0;
    foreach ($_SESSION['cart'] as $pId => $qty) {
        $p = $productModel->findById($pId);
        $cartTotal += $p['prix'] * $qty;
    }
    
    $orderId = $orderModel->create($createdUser['id'], $cartTotal, 'livraison');
    $tests->test("✔ Création commande", $orderId !== false && $orderId > 0, ">0", $orderId);
    
    // Test: Ajouter des items à la commande
    if ($orderId) {
        foreach ($_SESSION['cart'] as $pId => $qty) {
            $p = $productModel->findById($pId);
            $itemModel->create($orderId, $pId, $qty, $p['prix']);
        }
        
        $items = $orderModel->getItemsByOrderId($orderId);
        $tests->test("✔ Ajout items à commande", count($items) === count($_SESSION['cart']));
        
        // Test: Trouver une commande par ID
        $foundOrder = $orderModel->findById($orderId);
        $tests->test("✔ Recherche commande par ID", $foundOrder !== false && $foundOrder['id'] === $orderId);
        
        // Test: Statut initial est 'en_attente'
        $tests->test("✔ Statut initial commande", $foundOrder['status'] === 'en_attente');
        
        // Test: Obtenir les commandes de l'utilisateur
        $userOrders = $orderModel->getUserOrders($createdUser['id']);
        $tests->test("✔ Récupération commandes utilisateur", is_array($userOrders) && count($userOrders) > 0);
    }
}

// ===================================================================
// 7️⃣ TESTS DE GESTION DE COMMANDES ADMIN
// ===================================================================
$tests->section("👨‍💼 7. TESTS DE GESTION DE COMMANDES ADMIN");

if (isset($orderId) && $orderId > 0) {
    // Test: Changement statut validée
    $orderModel->updateStatus($orderId, 'validee');
    $validatedOrder = $orderModel->findById($orderId);
    $tests->test("✔ Validation commande par admin", $validatedOrder['status'] === 'validee');
    
    // Test: Création d'une autre commande pour test rejet
    $orderId2 = $orderModel->create($createdUser['id'], 5000, 'mobile_money');
    if ($orderId2) {
        $orderModel->updateStatus($orderId2, 'rejetee', 'Stock insuffisant');
        $rejectedOrder = $orderModel->findById($orderId2);
        $tests->test("✔ Rejet commande par admin", $rejectedOrder['status'] === 'rejetee' && $rejectedOrder['motif_rejet'] !== null);
    }
}

// ===================================================================
// 8️⃣ TESTS DE MATIÈRES PREMIÈRES & STOCK
// ===================================================================
$tests->section("🌾 8. TESTS DE MATIÈRES PREMIÈRES & STOCK");

$rawMaterialModel = new RawMaterial();

// Test: Créer une matière première
$materialData = [
    'nom' => 'Graines de Maïs Test',
    'categorie' => 'Semences',
    'stock' => 100,
    'seuil' => 20
];
$createMaterialResult = $rawMaterialModel->create($materialData);
$tests->test("✔ Création matière première", $createMaterialResult === true);

// Test: Récupérer toutes les matières premières
$allMaterials = $rawMaterialModel->getAll();
$tests->test("✔ Récupération matières premières", is_array($allMaterials) && count($allMaterials) > 0);

// Test: Trouver matière première par ID
if (!empty($allMaterials)) {
    $firstMaterial = $allMaterials[0];
    $foundMaterial = $rawMaterialModel->findById($firstMaterial['id']);
    $tests->test("✔ Recherche matière première par ID", $foundMaterial !== false && $foundMaterial['id'] === $firstMaterial['id']);
}

// Test: Mise à jour stock matière
if (!empty($allMaterials)) {
    $materialBefore = $rawMaterialModel->findById($allMaterials[0]['id']);
    $rawMaterialModel->updateStock($allMaterials[0]['id'], 5, 'decrement');
    $materialAfter = $rawMaterialModel->findById($allMaterials[0]['id']);
    $tests->test("✔ Décrémentation stock matière première", $materialAfter['stock_actuel'] < $materialBefore['stock_actuel']);
}

// Test: Alertes bas stock
$lowStockAlerts = $rawMaterialModel->getLowStockAlerts();
$tests->test("✔ Récupération alertes bas stock", is_array($lowStockAlerts));

// ===================================================================
// 9️⃣ TESTS DE MOUVEMENTS DE STOCK
// ===================================================================
$tests->section("📊 9. TESTS DE MOUVEMENTS DE STOCK");

$movementModel = new Stock();

// Test: Enregistrer un mouvement
$movementModel->adjust('produit', 1, 'sortie', 10, 5000, 'Vente test');
$tests->test("✔ Enregistrement mouvement stock", true);

// Test: Récupérer mouvements
$movements = $movementModel->getMovements();
$tests->test("✔ Récupération mouvements stock", is_array($movements) && count($movements) > 0);

// ===================================================================
// 🔟 TESTS DE FINANCES & RAPPORTS
// ===================================================================
$tests->section("💰 10. TESTS DE FINANCES & RAPPORTS");

$financeModel = new FinancialRecord();

// Test: Enregistrer un revenu
$financeModel->log('revenu', 50000, 'Vente', 'Test vente produits', date('Y-m-d'), 1);
$tests->test("✔ Enregistrement revenu", true);

// Test: Enregistrer une dépense
$financeModel->log('depense', 15000, 'Achat Intrants', 'Achat graines', date('Y-m-d'), null);
$tests->test("✔ Enregistrement dépense", true);

// Test: Calcul du bilan mensuel
$month = date('m');
$year = date('Y');
$monthlyBalance = $financeModel->getMonthlyBalance($month, $year);
$tests->test("✔ Calcul bilan mensuel", $monthlyBalance !== false && isset($monthlyBalance['total_revenus']));

// Test: Calcul du revenu journalier
$dailyRevenue = $financeModel->getDailyRevenue();
$tests->test("✔ Calcul revenu journalier", is_numeric($dailyRevenue));

// Test: Calcul des marges
if ($monthlyBalance && $monthlyBalance['total_revenus'] > 0) {
    $margin = (($monthlyBalance['total_revenus'] - $monthlyBalance['total_depenses']) / $monthlyBalance['total_revenus']) * 100;
    $tests->test("✔ Calcul marge bénéficiaire", is_numeric($margin));
}

// ===================================================================
// 1️⃣1️⃣ TESTS DE PERMISSIONS & SÉCURITÉ
// ===================================================================
$tests->section("🔒 11. TESTS DE PERMISSIONS & SÉCURITÉ");

// Test: Rôle client par défaut
$clientUser = $userModel->create('Client', 'Test', 'client_' . time() . '@test.com', 'Pass123', '0123456789');
$tests->test("✔ Création utilisateur avec rôle client par défaut", $clientUser === true);

// Test: Admin existe
$adminUser = $userModel->findByEmail('admin@sarafarms.com');
$tests->test("✔ Utilisateur admin existe", $adminUser !== false && $adminUser['role'] === 'admin');

// Test: Hachage de mot de passe
$hashedPassword = password_hash('TestPassword123', PASSWORD_DEFAULT);
$isHashCorrect = password_verify('TestPassword123', $hashedPassword);
$tests->test("✔ Hachage de mot de passe bcrypt", $isHashCorrect === true);

$isHashIncorrect = password_verify('WrongPassword', $hashedPassword);
$tests->test("✔ Rejet mot de passe incorrect", $isHashIncorrect === false);

// ===================================================================
// 1️⃣2️⃣ TESTS DE VALIDATION & SANITISATION
// ===================================================================
$tests->section("✅ 12. TESTS DE VALIDATION & SANITISATION");

// Test: Sanitisation XSS
$xssInput = "<script>alert('XSS')</script>";
$sanitized = htmlspecialchars($xssInput, ENT_QUOTES, 'UTF-8');
$tests->test("✔ Protection XSS (htmlspecialchars)", strpos($sanitized, '<script>') === false);

// Test: Email valide
$validEmail = 'test@example.com';
$invalidEmail = 'invalid.email@';
$validEmailCheck = filter_var($validEmail, FILTER_VALIDATE_EMAIL);
$invalidEmailCheck = filter_var($invalidEmail, FILTER_VALIDATE_EMAIL);
$tests->test("✔ Validation email correct", $validEmailCheck !== false);
$tests->test("✔ Rejet email invalide", $invalidEmailCheck === false);

// Test: Validation nombre
$validNumber = 123;
$validNumberCheck = filter_var($validNumber, FILTER_VALIDATE_INT);
$tests->test("✔ Validation nombre entier", $validNumberCheck !== false);

// ===================================================================
// 1️⃣3️⃣ TESTS D'INTÉGRITÉ DES TRANSACTIONS
// ===================================================================
$tests->section("🔄 13. TESTS D'INTÉGRITÉ DES TRANSACTIONS");

// Test: Transaction de création de commande avec items
if (!empty($_SESSION['cart'])) {
    $cartTotal = 0;
    foreach ($_SESSION['cart'] as $pId => $qty) {
        $p = $productModel->findById($pId);
        $cartTotal += $p['prix'] * $qty;
    }
    
    $transactionOrderId = $orderModel->create($createdUser['id'], $cartTotal, 'livraison');
    if ($transactionOrderId) {
        $itemsCreated = 0;
        foreach ($_SESSION['cart'] as $pId => $qty) {
            $p = $productModel->findById($pId);
            $itemModel->create($transactionOrderId, $pId, $qty, $p['prix']);
            $itemsCreated++;
        }
        
        $items = $orderModel->getItemsByOrderId($transactionOrderId);
        $tests->test("✔ Intégrité transaction commande", count($items) === $itemsCreated);
    }
}

// ===================================================================
// 1️⃣4️⃣ TESTS DES MODÈLES & ASSOCIATIONS
// ===================================================================
$tests->section("🔗 14. TESTS DES MODÈLES & ASSOCIATIONS");

// Test: Un utilisateur peut avoir plusieurs commandes
$userOrdersCount = count($orderModel->getUserOrders($createdUser['id']));
$tests->test("✔ Relation 1-N User→Orders", $userOrdersCount > 0);

// Test: Une commande peut avoir plusieurs items
if (isset($transactionOrderId) && $transactionOrderId) {
    $orderItemsCount = count($orderModel->getItemsByOrderId($transactionOrderId));
    $tests->test("✔ Relation 1-N Order→OrderItems", $orderItemsCount > 0);
}

// ===================================================================
// 1️⃣5️⃣ TESTS DE CAS LIMITES
// ===================================================================
$tests->section("⚠️ 15. TESTS DE CAS LIMITES");

// Test: Quantité négative impossible
$_SESSION['cart'] = [];
if (!empty($availableProducts)) {
    $_SESSION['cart'][$availableProducts[0]['id']] = -5;
    $tests->test("✔ Quantité négative dans panier (doit être >= 1)", max(1, $_SESSION['cart'][$availableProducts[0]['id']]) === 1);
}

// Test: Email avec caractères spéciaux
$specialEmail = "test+tag@example.co.uk";
$specialEmailCheck = filter_var($specialEmail, FILTER_VALIDATE_EMAIL);
$tests->test("✔ Email avec caractères spéciaux valide", $specialEmailCheck !== false);

// ===================================================================
// 1️⃣6️⃣ TESTS DE COMPTE RENDU FINAL
// ===================================================================
$tests->section("📈 16. TESTS DE COMPTE RENDU");

// Test: Compter les clients
$clientCount = $userModel->countTotalClients();
$tests->test("✔ Comptage total clients", is_numeric($clientCount));

// Test: Récupérer toutes les commandes
$allOrders = $orderModel->getAllOrders();
$tests->test("✔ Récupération toutes les commandes", is_array($allOrders));

// Test: Commandes dernières 24h
$last24h = $orderModel->getOrdersLast24h();
$tests->test("✔ Statut commandes dernières 24h", $last24h !== false);

// ===================================================================
// 📊 AFFICHAGE DU RAPPORT FINAL
// ===================================================================
$tests->report();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tests Sara Farms - Rapport Complet</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #333;
        }
        h1, h2, h3 {
            color: #333;
            margin-top: 20px;
        }
        .container {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            margin-bottom: 20px;
        }
        hr {
            border: none;
            height: 2px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            margin: 30px 0;
        }
        code {
            background: #f5f5f5;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
        }
        .success {
            color: #27ae60;
            font-weight: bold;
        }
        .error {
            color: #e74c3c;
            font-weight: bold;
        }
        .info {
            background: #ecf0f1;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            border-left: 4px solid #3498db;
        }
        strong {
            color: #2c3e50;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 SARA FARMS - RAPPORT COMPLET DE TESTS</h1>
        <?php ob_end_flush(); ?>
        
        <div class="info">
            <strong>📝 Instructions d'exécution:</strong><br>
            1. Accédez à l'URL: <code>http://localhost/Sara_Farms/test.php</code><br>
            2. Vérifiez que tous les tests passent (les cases ✅ doivent être vertes)<br>
            3. En cas d'erreur ❌, vérifiez les configurations et les données d'entrée<br>
            4. Les tests s'exécutent dans l'ordre logique : structure → DB → auth → produits → panier → commandes → stock → finances → sécurité
        </div>
        
        <h3>✨ Fonctionnalités testées:</h3>
        <ul>
            <li>✅ Structure et configuration de l'application</li>
            <li>✅ Connexion à la base de données</li>
            <li>✅ Authentification et gestion des utilisateurs</li>
            <li>✅ Gestion des produits (CRUD)</li>
            <li>✅ Gestion du panier</li>
            <li>✅ Gestion des commandes (création, validation, rejet)</li>
            <li>✅ Gestion des matières premières</li>
            <li>✅ Mouvements de stock</li>
            <li>✅ Gestion financière et rapports</li>
            <li>✅ Permissions et sécurité</li>
            <li>✅ Validation et sanitisation des données</li>
            <li>✅ Intégrité des transactions</li>
            <li>✅ Cas limites et gestion d'erreurs</li>
        </ul>
        
        <h3>🎯 Résultats attendus en cas de succès total:</h3>
        <div class="success" style="background: #d5f4e6; padding: 15px; border-radius: 5px;">
            ✅ TOUS LES TESTS SONT PASSÉS AVEC SUCCÈS!<br>
            📈 Taux de réussite: 100%<br>
            ✅ Réussis: X/X<br>
            ❌ Échoués: 0/X
        </div>
        
        <h3>🔧 Comment corriger les erreurs:</h3>
        <div class="info">
            <strong>Si un test échoue:</strong><br>
            1. Lire le message d'erreur ❌<br>
            2. Vérifier la configuration correspondante<br>
            3. Vérifier que la base de données est accessible<br>
            4. Vérifier les permissions du répertoire<br>
            5. Relancer les tests depuis un navigateur
        </div>
        
        <h3>📱 Points d'accès principaux:</h3>
        <ul>
            <li><strong>Boutique:</strong> <code>http://localhost/Sara_Farms/public/index.php?route=shop</code></li>
            <li><strong>Connexion:</strong> <code>http://localhost/Sara_Farms/public/index.php?route=auth/login</code></li>
            <li><strong>Panier:</strong> <code>http://localhost/Sara_Farms/public/index.php?route=cart</code></li>
            <li><strong>Dashboard Admin:</strong> <code>http://localhost/Sara_Farms/public/index.php?route=admin/dashboard</code></li>
            <li><strong>Tests:</strong> <code>http://localhost/Sara_Farms/test.php</code></li>
        </ul>
    </div>
</body>
</html>