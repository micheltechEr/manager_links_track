<?php
require_once __DIR__ . '/../model/User.php';

class UserController{
    private $model;
    
    public function __construct(){
        $this->model = new User();
    }

    public function showSignUpPage(){
        $viewPath = __DIR__ . '/../register';
        if (!file_exists($viewPath)) {
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
                return 'Preencha todos os campos';
            }
    
            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                return 'Preencha com um endereço de e-mail válido';
                echo json_encode([
                    'status' => 'error',
                    'message' =>  'Formato de e-mail inválido.'
                ]);
            }
            
            $hashedPassword = password_hash($password,PASSWORD_BCRYPT);

            $this->model->register($name,$email,$hashedPassword);
            header("Location: /../view/register.php");
            return "Usuário cadastrado com sucesso";
        }
        catch(PDOException){
            return "Erro ao cadastrar usuário";
        }

    }
}
?>