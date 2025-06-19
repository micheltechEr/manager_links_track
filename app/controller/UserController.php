<?php
require_once __DIR__ . '/../model/User.php';
require_once __DIR__ .'/../helpers/DateTimeConverter.php';
class UserController{
    private $model;
    
    public function __construct(){
        $this->model = new User();
    }

    public function showSignUpPage(){
        $viewPath = __DIR__ . '/../view/register.php';
        if (!file_exists($viewPath)) {
            http_response_code(500);
            echo "Erro: Visualização não encontrada";
            return;
        }
        require $viewPath;
    }
    

    public function showLoginPage(){

        $viewPath = __DIR__ .'/../view/login.php';
        if(!file_exists($viewPath)){
            http_response_code(500);
            echo "Erro: Visualização não encontrada";
            return;
        }
        $isUserLogged = $this->model->isLogged();
        if($isUserLogged['logged'] == true){
            header('Location:dashboard');
            exit;
        }
        require $viewPath;
    }

    public function showProfilePage(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $viewPath = __DIR__ . '/../view/profile_user.php';
        if(!file_exists($viewPath)){
            http_response_code(500);
            echo "Erro: Visualização não encontrada";
            return;
        }

        $isUserLogged = $this->model->isLogged();
        if($isUserLogged['logged'] == false){
            header('Location:login');
         }
    $userName = htmlspecialchars($_SESSION['name']);
    $userEmail = htmlspecialchars($_SESSION['email']);
    $passLastUpdate = $_SESSION['update_password_at'] ?? null;
    $passLastUpdateFormatted = $passLastUpdate 
        ? DateTimeConverter::lapsedTimeConversor($passLastUpdate) 
        : 'Desconhecido';

        require $viewPath;
    }    
    public function registerUser(){
        try{
            header('Content-Type: application/json');
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            
            if(empty($name) || empty($email) || empty($password)){
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Preencha todos os campos'
                ]);
                return;
            }
    
            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                echo json_encode([
                    'status' => 'error',
                    'message' =>  'Formato de e-mail inválido.'
                ]);
                return;
            }

            $hashedPassword = password_hash($password,PASSWORD_BCRYPT);
            $existMail = $this->model->doesExistUser($email);
            if($existMail){
                echo json_encode([
                    'status' => 'error',
                    'message' =>  'E-mail já existente'
                ]);
                return;
            }
            $this->model->register($name,$email,$hashedPassword);
            echo json_encode([
                'status' => 'success',
                'message' => 'Usuário cadastrado com sucesso',
                'redirect' => 'login'
            ]);
        }
        catch(PDOException){
            echo json_encode([
                'status' => 'error',
                'message' => 'Erro ao cadastrar usuário',
            ]);
        }
    }
    public function loginUser(){
        try{
            header('Content-Type: application/json');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $isRememberEnabled = isset($_POST['remember_me']) ? true : false;

            if(empty($email) || empty($password)){
                http_response_code(400);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Preencha todos os campos'
                ]);
                error_log("Conteúdo de \$_POST: " . print_r($_POST, true));
                return;
            }
    
            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                http_response_code(400);
                echo json_encode([
                    'status' => 'error',
                    'message' =>  'Formato de e-mail inválido.'
                ]);
                return;
            }

            $resultLogin = $this->model->login($email,$password);
             if($resultLogin['success'] == true){
                if($isRememberEnabled){
                    $this->model->createTokenAuthUser($email);
                }

                http_response_code(200);
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Login realizado com sucesso',
                    'redirect' => 'dashboard'
                ]);
            }

            else{
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Usuário ou senha incorretos'
                ]);
            }
        }
        catch(PDOException){
            echo json_encode([
                'status' => 'error',
                'message' => 'Erro ao logar',
            ]);
        }
    }
    public function logoutUser(){
        try{
            $logoutSuccess =  $this->model->logout();
            if($logoutSuccess['status'] == 'success'){
                echo json_encode([
                'status' => 'success',
                'message' => 'Logout realizado com sucesso',
                'redirect' => './'
                ]);
            }
        }
        catch(PDOException){
            echo json_encode([
                'status' => 'error',
                'message' => 'Erro durante o logout'
            ]);
        }
    }

    public function changePassword(){
        try{
             header('Content-Type: application/json');
             $oldPass = trim($_POST['current_password'] ?? '');
             $newPass = trim($_POST['new_password'] ?? '');
             
             if(empty($oldPass) || empty($newPass)){
                echo json_encode([
                    'status'=> 'error',
                    'message'=> 'Preencha ambos os campos',
                ]);
             }
            $result = $this->model->changepass($oldPass,$newPass);
            if($result['success'] === true){
                echo json_encode([
                    'status'=> 'success',
                    'message'=> 'Senha atualizada com sucesso',
                    'redirect' => './'
                ]);
            }
            else {
            echo json_encode([
                'status' => 'error',
                'message' => $result['message']
            ]);
        }
        }
        catch(PDOException){
            echo json_encode([
                'status' => 'error',
                'message' => 'Erro ao atualizar senha',
            ]);
        }
    }

    // public function updateUserInfo(){

    // }
}
?>