<?php
session_start();
require_once 'config/constants.php';
require_once 'config/database.php';
require_once 'core/Controller.php';

class TestController extends Controller {
    public function run() {
        echo "✅ Controller chargé avec succès<br>";
        echo "✅ adminRequired() existe : " . (method_exists($this, 'adminRequired') ? 'OUI' : 'NON') . "<br>";
        echo "✅ authRequired() existe : " . (method_exists($this, 'authRequired') ? 'OUI' : 'NON') . "<br>";
    }
}

$test = new TestController();
$test->run();
?>