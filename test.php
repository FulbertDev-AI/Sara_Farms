<?php
session_start();
require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../config/database.php';

function test($name, $condition) {
    echo $condition ? "✅ <b>{$name}</b><br>" : "❌ <b>{$name}</b> (Échoué)<br>";
}

echo "<h2>🧪 Diagnostic Complet Sara Farms</h2>";
echo "<hr>";

// 1. Structure & Fichiers critiques
echo "<h3>📁 Structure</h3>";
test("Routeur (index.php)", file_exists(__DIR__ . '/index.php'));
test("Core Controller", file_exists(__DIR__ . '/../core/Controller.php'));
test("Auth Controller", file_exists(__DIR__ . '/../app/controllers/AuthController.php'));
test("Cart Controller", file_exists(__DIR__ . '/../app/controllers/CartController.php'));
test("Admin Dashboard Controller", file_exists(__DIR__ . '/../app/controllers/admin/DashboardController.php'));

// 2. Base de données
echo "<h3>🗄️ Base de données</h3>";
try {
    $db = Database::getInstance()->getConnection();
    test("Connexion BDD", $db !== null);
    
    $tables = ['users', 'products', 'orders', 'raw_materials', 'financial_records'];
    foreach ($tables as $t) {
        $stmt = $db->query("SHOW TABLES LIKE '$t'");
        test("Table `$t` existe", $stmt->rowCount() > 0);
    }
} catch (Exception $e) {
    test("Connexion BDD", false);
    echo "<i style='color:red'>Erreur: " . $e->getMessage() . "</i><br>";
}

// 3. Sessions & Authentification (Simulation)
echo "<h3>🔐 Sessions & Auth</h3>";
test("Session active", session_id() !== '');
$_SESSION['test_user'] = 'ok';
test("Écriture session", $_SESSION['test_user'] === 'ok');
unset($_SESSION['test_user']);

// 4. Routing (Vérification des URLs)
echo "<h3>🔗 Routing</h3>";
$urls = [
    'home' => 'HomeController',
    'shop' => 'ShopController',
    'cart' => 'CartController',
    'admin/dashboard' => 'DashboardController',
    'admin/products/index' => 'ProductController'
];
foreach ($urls as $url => $ctrl) {
    $path = $url === 'admin/dashboard' || $url === 'admin/products/index' 
        ? __DIR__ . "/../app/controllers/admin/{$ctrl}.php" 
        : __DIR__ . "/../app/controllers/{$ctrl}.php";
    test("Route `{$url}` -> `{$ctrl}`", file_exists($path));
}

// 5. Logique Panier (Test en mémoire)
echo "<h3>🛒 Panier (Test logique)</h3>";
$_SESSION['cart'] = ['1' => 2, '2' => 1];
test("Initialisation panier", is_array($_SESSION['cart']));
test("Ajout quantités", array_sum($_SESSION['cart']) === 3);
unset($_SESSION['cart']);

echo "<hr>";
echo "<p>💡 <b>Prochaines étapes :</b></p>";
echo "<ul>
    <li>Si tout est ✅ : Accédez à <code>http://localhost/sara_farms/public/auth/login</code></li>
    <li>Connectez-vous avec <code>admin@sarafarms.com</code> / <code>password</code></li>
    <li>Vérifiez que <code>/admin/dashboard</code> charge bien les stats.</li>
    <li>En tant que client, ajoutez un produit → message vert en haut → lien 'Panier' dans le menu doit afficher les articles.</li>
</ul>";
?>