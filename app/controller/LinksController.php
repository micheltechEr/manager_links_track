<?php
require_once __DIR__ . '/../model/Link.php';
require_once __DIR__ . '/../model/User.php';
class LinksController
{
    private $model;
    private $modelLink;
    public function __construct()
    {
        session_start();
        $this->model = new User();
        $this->modelLink = new Link();
    }

    public function showLinkController()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $isLogged = $this->model->isLogged();
        
        if ($isLogged['success'] == true) {
            $viewPath = __DIR__ . '/../view/link_manager.php';
            if (!file_exists($viewPath)) {
                http_response_code(500);
                echo "Nenhum gerenciador de links encontrado";
                return;
            }
            require $viewPath;
        }
        else{
            header('Location: login');
        }
    }
    public function saveLinks(){
        try{
            header('Content-Type:application/json');
            $title = trim($_POST['linkTitle'] ?? '');
            $urlLink = trim($_POST['linkUrl'] ?? '');
            $linkDescription = trim($_POST['linkDescription'] ?? '');
            $user_id = $_SESSION['user_id'];
            if(empty($title) || empty($urlLink) || empty($linkDescription)){
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Preencha todos os campos'
                ]);
                return;
            }
            $doesExistUrl = $this->modelLink->doesExistLink($urlLink);
            if($doesExistUrl){
                echo json_encode([
                'status' => 'failed',
                'message' => 'Link já existente'
            ]);  
            }
            $this->modelLink->registerLink($title,$urlLink,$linkDescription,$user_id);
            echo json_encode([
                'status' => 'success',
                'message' => 'Link cadastrado com sucesso'
            ]);
        }
        catch(PDOException){
            echo json_encode([
                'status' => 'error',
                'message' => 'Erro ao cadastrar link',
            ]);
        }
    }

 public function listLinks(){
    header('Content-Type: application/json');

    try {
        // 1. Verifique se o usuário está logado antes de acessar a sessão.
        if (!isset($_SESSION['user_id'])) {
            // Se o usuário não estiver logado, retorne uma resposta de erro e pare a execução.
            echo json_encode([
                'status'  => 'error',
                'message' => 'Usuário não autenticado.'
            ]);
            exit; 
        }

        $user_id = $_SESSION['user_id'];
        $listedLinks = $this->modelLink->showLinks($user_id);

        echo json_encode([
            'status'  => 'success',
            'message' => 'Links listados com sucesso.',
            'data'    => $listedLinks
        ]);

    } catch (PDOException $e) {
        error_log($e->getMessage()); 
        echo json_encode([
            'status'  => 'error',
            'message' => 'Erro ao listar os links. Tente novamente mais tarde.'
        ]);
    }
}
}
?>