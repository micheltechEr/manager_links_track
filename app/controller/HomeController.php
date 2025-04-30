<?php
class HomeController {
    public function index() {
        $viewPath = __DIR__ . '/../view/home.php';
        if (!file_exists($viewPath)) {
            http_response_code(500);
            echo "Erro: Visualização não encontrada";
            return;
        }
        require $viewPath;
    }
}