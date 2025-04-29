<?php
require_once __DIR__ . '/../model/User.php';

class UserController{
    private $model;
    
    public function __construct(){
        $this->model = new User();
    }

    public function registerUser(){
        try{
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
    
            if(empty($name) || empty($email) || empty($password)){
                return 'Preencha todos os campos';
            }
    
            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                return 'Preencha com um endereço de e-mail válido';
            }
            
            $hashedPassword = password_hash($password,PASSWORD_BCRYPT);
            $this->model->create($name,$email,$password);
            return "Usuário cadastrado com sucesso";
        }
        catch(PDOException){
            return "Erro ao cadastrar usuário";
        }

    }
}
?>