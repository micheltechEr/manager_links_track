<?php
require_once  __DIR__  . '/../config/database.php';

class User{
    private $pdo;
    public function __construct(){
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function register($name,$email,$password){
        try{
            $stmt = $this->pdo->prepare("INSERT INTO users (`name`,email,`password`) VALUES (?,?,?)");
            $stmt->execute([$name,$email,$password]);
            return true;
        }
        catch (PDOException $e){
            error_log("Erro durante a criação do usuário");
            return false;
        }
    }
}
?>