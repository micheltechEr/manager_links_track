<?php
require_once  __DIR__  . '/../config/database.php';

class User{
    private $pdo;
    public function __construct(){
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function doesExistUser($email){
        $stmt = $this->pdo->prepare("SELECT email FROM users WHERE ?");
        $stmt->execute([$email]);
        if($stmt->fetch()){
            return true;
        }
        return false;
    }

    public function register($name,$email,$password){
        try{
            $stmt = $this->pdo->prepare("INSERT INTO users (`name`,email,`password`) VALUES (?,?,?)");
            $doesExistEmail = $this->doesExistUser($email);
            if(!$doesExistEmail){
                $stmt->execute([$name,$email,$password]);
            }
            return true;
        }
        catch (PDOException $e){
            error_log("Erro durante a criação do usuário");
            return false;
        }
    }
}
?>