<?php
require_once __DIR__ . '/../../core/Controller.php';
class ShopController extends Controller {
    public function index() {
        // Données simulées pour l'interface (remplacées par la BDD plus tard)
        $products = [
            ['id'=>1, 'name'=>'Plateau d\'œufs (30)', 'desc'=>'ufs frais de ferme, poules nourries aux grains naturels.', 'price'=>2500, 'img'=>'uploads/oeufs.jpg'],
            ['id'=>2, 'name'=>'Sac de Maïs (50kg)', 'desc'=>'Maïs séché de qualité supérieure, idéal pour alimentation ou semence.', 'price'=>15000, 'img'=>'uploads/mais.jpg'],
            ['id'=>3, 'name'=>'Poulet de chair (vif)', 'desc'=>'Poulet élevé en plein air, poids moyen 2.5kg.', 'price'=>4500, 'img'=>'uploads/poulet.jpg'],
            ['id'=>4, 'name'=>'Kit Semences Maraîchères', 'desc'=>'Assortiment de tomates, piments, aubergines et choux.', 'price'=>8000, 'img'=>'uploads/semences.jpg'],
        ];
        $this->view('frontend/shop/index', [
            'pageTitle' => 'Boutique',
            'active' => 'shop',
            'products' => $products
        ]);
    }
}
?>