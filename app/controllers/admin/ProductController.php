<?php
require_once __DIR__ . '/../../../core/Controller.php';
require_once __DIR__ . '/../../models/Product.php';

class ProductController extends Controller {
    public function __construct() {
        parent::__construct();
        $this->adminRequired();
    }

    public function index() {
        $model = new Product();
        $products = $model->getAll();
        $this->view('admin/products/index', ['products' => $products]);
    }

    public function create() {
        $this->view('admin/products/create');
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nom' => $_POST['nom'],
                'desc' => $_POST['description'],
                'prix' => $_POST['prix'],
                'cat' => $_POST['categorie'],
                'stock' => $_POST['stock']
            ];

            // Gestion de l'image
            $imageName = 'default.jpg';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $targetDir = __DIR__ . '/../../../public/assets/images/uploads/';
                $imageName = uniqid() . '_' . basename($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], $targetDir . $imageName);
            }
            $data['image'] = $imageName;

            $model = new Product();
            $model->create($data);
            $this->redirect('admin/products/index');
        }
    }

    public function edit($id) {
        $model = new Product();
        $product = $model->findById($id);
        $this->view('admin/products/edit', ['product' => $product]);
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nom' => $_POST['nom'],
                'desc' => $_POST['description'],
                'prix' => $_POST['prix'],
                'cat' => $_POST['categorie'],
                'stock' => $_POST['stock']
            ];

            // Optionnel: gérer la nouvelle image si uploadée
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $targetDir = __DIR__ . '/../../../public/assets/images/uploads/';
                $data['image'] = uniqid() . '_' . basename($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], $targetDir . $data['image']);
            } else {
                // Garder l'ancienne image
                $oldProd = (new Product())->findById($id);
                $data['image'] = $oldProd['image'];
            }

            $model = new Product();
            $model->update($id, $data);
            $this->redirect('admin/products/index');
        }
    }

    public function delete($id) {
        $model = new Product();
        $model->delete($id); // Soft delete (is_active = 0)
        $this->redirect('admin/products/index');
    }
}
?>