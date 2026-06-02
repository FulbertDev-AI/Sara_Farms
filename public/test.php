<?php
session_start();

// Chemins relatifs depuis public/
require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../config/database.php';

function test($name, $condition) {
    echo $condition ? "✅ <b>{$name}</b><br>" : "❌ <b>{$name}</b> (Échoué)<br>";
}

echo "<h2>🧪 Diagnostic Complet Sara Farms</h2>";
echo "<style>body{font-family:Arial,sans-serif;padding:20px;background:#f5f5f5;}h2{color:#2C5E43;}h3{color:#88B04B;margin-top:20px;border-bottom:2px solid #2C5E43;padding-bottom:5px;}hr{border:none;border-top:1px solid #ddd;margin:20px 0;}</style>";
echo "<hr>";

// 1. Structure & Fichiers critiques
echo "<h3>📁 Structure des fichiers</h3>";
test("Routeur (index.php)", file_exists(__DIR__ . '/index.php'));
test("Core Controller", file_exists(__DIR__ . '/../core/Controller.php'));
test("Core Model", file_exists(__DIR__ . '/../core/Model.php'));
test("Auth Controller", file_exists(__DIR__ . '/../app/controllers/AuthController.php'));
test("Cart Controller", file_exists(__DIR__ . '/../app/controllers/CartController.php'));
test("Admin Dashboard Controller", file_exists(__DIR__ . '/../app/controllers/admin/DashboardController.php'));
test("Product Controller", file_exists(__DIR__ . '/../app/controllers/admin/ProductController.php'));
test("Order Controller", file_exists(__DIR__ . '/../app/controllers/admin/OrderManagementController.php'));

// 2. Modèles
echo "<h3>📊 Modèles</h3>";
test("User Model", file_exists(__DIR__ . '/../app/models/User.php'));
test("Product Model", file_exists(__DIR__ . '/../app/models/Product.php'));
test("Order Model", file_exists(__DIR__ . '/../app/models/Order.php'));
test("Dashboard Model", file_exists(__DIR__ . '/../app/models/Dashboard.php'));
test("RawMaterial Model", file_exists(__DIR__ . '/../app/models/RawMaterial.php'));
test("FinancialRecord Model", file_exists(__DIR__ . '/../app/models/FinancialRecord.php'));

// 3. Base de données
echo "<h3>🗄️ Base de données</h3>";
try {
    $db = Database::getInstance()->getConnection();
    test("Connexion BDD réussie", $db !== null);
    
    $tables = ['users', 'products', 'orders', 'order_items', 'raw_materials', 'stock_movements', 'financial_records'];
    foreach ($tables as $t) {
        $stmt = $db->query("SHOW TABLES LIKE '$t'");
        test("Table `$t` existe", $stmt->rowCount() > 0);
    }
    
    // Vérifier s'il y a un admin
    $stmt = $db->query("SELECT COUNT(*) as count FROM users WHERE role='admin'");
    $adminCount = $stmt->fetch()['count'];
    test("Admin existe en BDD", $adminCount > 0);
    
} catch (Exception $e) {
    test("Connexion BDD", false);
    echo "<i style='color:red'>❌ Erreur BDD: " . htmlspecialchars($e->getMessage()) . "</i><br>";
}

// 4. Sessions & Authentification
echo "<h3>🔐 Sessions</h3>";
test("Session PHP active", session_id() !== '');
$_SESSION['test_var'] = 'ok';
test("Écriture en session", $_SESSION['test_var'] === 'ok');
unset($_SESSION['test_var']);

// 5. Constants
echo "<h3>⚙️ Configuration</h3>";
test("BASE_URL définie", defined('BASE_URL'));
test("SITE_NAME défini", defined('SITE_NAME'));
if(defined('BASE_URL')) {
    echo "<small>BASE_URL = " . htmlspecialchars(BASE_URL) . "</small><br>";
}

// 6. Vues essentielles
echo "<h3>🎨 Vues (Templates)</h3>";
test("Layout Header", file_exists(__DIR__ . '/../app/views/layouts/header.php'));
test("Layout Footer", file_exists(__DIR__ . '/../app/views/layouts/footer.php'));
test("Admin Header", file_exists(__DIR__ . '/../app/views/layouts/admin-header.php'));
test("Admin Sidebar", file_exists(__DIR__ . '/../app/views/layouts/admin-sidebar.php'));
test("Home View", file_exists(__DIR__ . '/../app/views/frontend/home/index.php'));
test("Shop View", file_exists(__DIR__ . '/../app/views/frontend/shop/index.php'));
test("Login View", file_exists(__DIR__ . '/../app/views/frontend/auth/login.php'));
test("Dashboard View", file_exists(__DIR__ . '/../app/views/admin/dashboard/index.php'));

// 7. Assets
echo "<h3>📦 Assets (CSS/JS)</h3>";
test("main.css", file_exists(__DIR__ . '/assets/css/main.css'));
test("admin.css", file_exists(__DIR__ . '/assets/css/admin.css'));
test("main.js", file_exists(__DIR__ . '/assets/js/main.js'));

echo "<hr>";
echo "<h3>📋 RÉSUMÉ DES TESTS</h3>";
echo "<p><b>✅ Si tous les tests sont verts :</b></p>";
echo "<ol>
    <li>Accédez à : <code style='background:#e0e7e3;padding:2px 6px;border-radius:4px;'>http://localhost/sara_farms/public/auth/login</code></li>
    <li>Connectez-vous avec : <b>admin@sarafarms.com</b> / <b>password</b></li>
    <li>Vous devriez être redirigé vers le dashboard admin</li>
    <li>Testez l'ajout au panier en tant que client</li>
</ol>";

echo "<p><b>❌ Si des tests sont rouges :</b></p>";
echo "<p>Vérifiez que :</p>";
echo "<ul>
    <li>La base de données <b>sara_farms</b> est créée</li>
    <li>Le fichier <b>config/constants.php</b> existe avec les bonnes constantes</li>
    <li>Tous les dossiers (app, core, public, config) sont bien créés</li>
</ul>";
?>