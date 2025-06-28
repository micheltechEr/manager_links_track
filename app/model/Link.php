<?php 
require_once __DIR__ . '/../config/database.php';

class Link{
    private $pdo;

    public function __construct(){
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function doesExistLink($url){
            $stmt = $this->pdo->prepare("SELECT url_link FROM links WHERE url_link ?");
            $stmt->execute([$url]);
            $link = $stmt->fetch(PDO::FETCH_ASSOC);
            if($link){
                return $link;
            }
            return false;
    }

    public function registerLink($title,$url_link,$description,$user_id){
        try{
            $stmt = $this->pdo->prepare("INSERT INTO links (`title`,`url_link`,`description`,`user_id`) VALUES(?,?,?,?)");
            $stmt->execute([$title,$url_link,$description,$user_id]);
            return true;
        }
        catch(PDOException $e){
            error_log("Erro durante a criação de link");
            return false;
        }
    }
    public function showLinks($user_id){
        try{
            $stmt = $this->pdo->prepare("SELECT `title`,`url_link`,`description` FROM links WHERE user_id = ?");
            $stmt->execute([$user_id]);
            $query_result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if($query_result){
                return $query_result;
            }
            return false;
        }
        catch(PDOException $e){
            error_log("Erro durante a listagem dos links");
            return false;  
        }
    }
}
?>