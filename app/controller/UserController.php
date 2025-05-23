<?php
require_once __DIR__ . '/../model/User.php';

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
        require $viewPath;
    }

    public function showProfilePage(){
        $viewPath = __DIR__ . '/../view/profile_user.php';
        if(!file_exists($viewPath)){
            http_response_code(500);
            echo "Erro: Visualização não encontrada";
            return;
        }
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
}
?>