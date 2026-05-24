<?php
require_once __DIR__ . '/../../core/Controller.php';
class ContactController extends Controller {
    public function index() {
        $this->view('frontend/contact/index', [
            'pageTitle' => 'Contact',
            'active' => 'contact'
        ]);
    }
}
?>