<?php 
require_once __DIR__ . '/../config/database.php';

class Link{
    private $pdo;

    public function __construct(){
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function doesExistLink($url){
        $stmt = $this->pdo->prepare("SELECT id, url_link FROM links WHERE url_link = ?");
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
            $stmt = $this->pdo->prepare("SELECT `id`,`title`,`url_link`,`description` FROM links WHERE user_id = ?");
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
    public function getLinkById($link_id) {
        try {
            $stmt = $this->pdo->prepare("SELECT `id`, `title`, `url_link`, `description` FROM links WHERE id = ?");
            $stmt->execute([$link_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar link por ID: " . $e->getMessage());
            return false;
        }
    }
    public function countLinks($user_id){
        try{
            $stmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM links WHERE user_id=?");
            $stmt->execute([$user_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if($result){
                return $result['total'];
            }
        }
        catch(PDOException $e){
            error_log("Erro durante a contagem dos links");
            return false;
        }
    }

    public function registerClick($link_id,$ip_address, $browser, $referer) {
        try {
            $timestampAtual = time();
            $clicked_at = date("Y-m-d H:i:s", $timestampAtual);
            $stmt = $this->pdo->prepare("INSERT INTO link_clicks (link_id, clicked_at ,ip_address, user_agent, referrer) VALUES (?, ?,?, ?, ?)");
            $stmt->execute([$link_id, $clicked_at,$ip_address, $browser, $referer]);
            return true;
        } catch (PDOException $e) {
            echo("Erro ao registrar clique: " . $e->getMessage());
            return false;
        }
    }
    public function editLink($link_id, $newTitle = null, $newUrl = null, $newDescription = null) {
        try {
            // Remover aspas simples/duplas do início e fim, se existirem
            $clean = function($v) {
                if (is_null($v)) return $v;
                $v = trim($v);
                $v = preg_replace('/^["\']+|["\']+$/', '', $v); // remove aspas do início/fim
                return $v;
            };
            $filledFields = [
                'title'      => $clean($newTitle),
                'url_link'   => $clean($newUrl),
                'description'=> $clean($newDescription)
            ];

            $fields = [];
            $values = [];

            foreach ($filledFields as $column => $value) {
                if (!is_null($value) && $value !== '') {
                    $fields[] = "`$column` = ?";
                    $values[] = $value;
                }
            }

            if (empty($fields)) {
                throw new Exception("Nenhum campo para atualizar.");
            }

            $sql = "UPDATE links SET " . implode(', ', $fields) . " WHERE id = ?";
            $values[] = $link_id;

            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($values);
        } catch (PDOException $e) {
            error_log("Erro durante a edição dos links: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("Erro: " . $e->getMessage());
            return false;
        }
    }
    public function deleteLink($link_id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM links WHERE id = ?");
            if(empty($link_id)) {
            return[
                'success' => false,
                'message' => 'ID não encontrado'
            ];
            }
            return $stmt->execute([$link_id]);
        } catch (PDOException $e) {
            return[
                'success' => false,
                'message' => 'Erro ao deletar link: ' . $e->getMessage()
            ];
        }
    }

}
?>