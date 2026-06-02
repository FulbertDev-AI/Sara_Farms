<?php
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../models/Product.php';
class ShopController extends Controller {
    public function index() {
        $model = new Product();
        $products = $model->getAll();

        if (empty($products)) {
            $products = [
                ['id'=>1, 'nom'=>"Plateau d'œufs (30)", 'description'=>'Oeufs frais de ferme, poules nourries aux grains naturels.', 'prix'=>2500, 'image'=>'oeufs.svg', 'stock_disponible' => 20],
                ['id'=>2, 'nom'=>'Sac de Maïs (50kg)', 'description'=>'Maïs séché de qualité supérieure, idéal pour alimentation ou semence.', 'prix'=>15000, 'image'=>'mais.svg', 'stock_disponible' => 10],
                ['id'=>3, 'nom'=>'Poulet de chair (vif)', 'description'=>'Poulet élevé en plein air, poids moyen 2.5kg.', 'prix'=>4500, 'image'=>'poulet.svg', 'stock_disponible' => 12],
                ['id'=>4, 'nom'=>'Kit Semences Maraîchères', 'description'=>'Assortiment de tomates, piments, aubergines et choux.', 'prix'=>8000, 'image'=>'semences.svg', 'stock_disponible' => 30],
                ['id'=>5, 'nom'=>'Miel Naturel (500g)', 'description'=>'Miel de fleurs d’acacia pur, sans additif.', 'prix'=>6500, 'image'=>'miel.svg', 'stock_disponible' => 18],
                ['id'=>6, 'nom'=>'Tomates Bio (1kg)', 'description'=>'Tomates mûries au soleil, parfaites pour salades et sauces.', 'prix'=>3200, 'image'=>'tomates.svg', 'stock_disponible' => 25],
                ['id'=>7, 'nom'=>'Lait Frais Local (1L)', 'description'=>'Lait ferme non homogénéisé, riche en nutriments.', 'prix'=>2000, 'image'=>'lait.svg', 'stock_disponible' => 15],
                ['id'=>8, 'nom'=>'Engrais Organique (10kg)', 'description'=>'Engrais naturel pour potagers et cultures biologiques.', 'prix'=>9500, 'image'=>'engrais.svg', 'stock_disponible' => 14],
                ['id'=>9, 'nom'=>'Fromage de Ferme', 'description'=>'Fromage traditionnel à pâte molle, fabriqué artisanalement.', 'prix'=>10800, 'image'=>'fromage.svg', 'stock_disponible' => 8],
            ];
        }

        $this->view('frontend/shop/index', [
            'pageTitle' => 'Boutique',
            'active' => 'shop',
            'products' => $products
        ]);
    }
}
?>