<?php
require_once __DIR__ . '/../model/User.php';
require_once __DIR__ . '/../model/Link.php';

class DashboardController
{
    private $model;
    private $linkModel;
    public function __construct()
    {
        $this->model = new User();
        $this->linkModel = new Link();
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
            $totalLinks = $this->linkModel->countLinks($_SESSION['user_id']);
            $totalCountLinks = $this->linkModel->countClickLinks($_SESSION['user_id']);
                if ($totalLinks === false || $totalCountLinks === false) {
                    http_response_code(500);
                    echo "Erro ao contar links";
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