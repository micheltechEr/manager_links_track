<?php
require_once __DIR__ . '/../model/User.php';

class DashboardController
{
    private $model;
    public function __construct()
    {
        $this->model = new User();
    }

    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $isLogged = $this->model->isLogged();
        
        if ($isLogged['success'] == true) {
            $viewPath = __DIR__ . '/../view/dashboard.php';
            if (!file_exists($viewPath)) {
                http_response_code(500);
                echo "Nenhum dashboard encontrado";
                return;
            }
            require $viewPath;
        }
        else{
            header('Location: login');
        }
    }
}
?>