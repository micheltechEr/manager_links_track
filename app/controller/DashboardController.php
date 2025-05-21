<?php
class DashboardController{
    public function index(){
        $viewPath = __DIR__  . '/../view/dashboard.php';
        if(!file_exists($viewPath)){
            http_response_code(500);
            echo "Nenhum dashboard encontrado";
            return;
        }
        require $viewPath;
    }
}
?>