<?php
require_once __DIR__ . '/../../core/Controller.php';
class ServicesController extends Controller {
    public function index() {
        $this->view('frontend/services/index', [
            'pageTitle' => 'Services',
            'active' => 'services'
        ]);
    }
}
?>