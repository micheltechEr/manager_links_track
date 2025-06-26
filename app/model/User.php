<?php
require_once __DIR__ . '/../config/database.php';
date_default_timezone_set('America/Sao_Paulo');
class User
{
    private $pdo;
    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function doesExistUser($email)
    {
        $stmt = $this->pdo->prepare("SELECT id, password, email,name,update_password_at FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            return $user;
        }
        return false;
    }

    public function register($name, $email, $password)
    {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO users (`name`,email,`password`) VALUES (?,?,?)");
            $stmt->execute([$name, $email, $password]);
            return true;
        } catch (PDOException $e) {
            error_log("Erro durante a criação do usuário");
            return false;
        }
    }
    public function createTokenAuthUser($email)
    {
        $token = bin2hex(random_bytes(50));
        $expires = date('Y-m-d H:i:s', strtotime('+7 days'));

        $stmt = $this->pdo->prepare("UPDATE users SET remember_token = ?, remember_expires = ? WHERE email = ?");
        $stmt->execute([$token, $expires, $email]);

        setcookie(
            'remember_token',
            $token,
            [
                'expires' => time() + (86400 * 7),
                'path' => '/',
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Strict'
            ]
        );
    }

    public function isLogged(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['user_id'])) {
            return [
                'success' => true,
                'logged' => true,
                'message' => 'Usuário já autenticado'
            ];
        } else {
            return [
                'success' => false,
                'logged' => false,
                'message' => 'Usuário não está autenticado'
            ];
        }
    }

    public function login($email, $password)
    {
        try {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            if (empty($email) || empty($password)) {
                return [
                    'success' => false,
                    'message' => 'Preencha com ambos os campos'
                ];
            }

            $user = $this->doesExistUser($email);

            if (!$user) {
                return [
                    'success' => false,
                    'message' => 'Email ou senha incorretos'
                ];
            }

            if (!password_verify($password, $user['password'])) {
                return [
                    'success' => false,
                    'message' => 'Email ou senha incorretos.'
                ];
            }
            
            if ($this->isLogged()['logged']) {
                return [
                    'success' => false,
                    'redirect' => 'dashboard',
                    'message' => 'Usuário já está autenticado'
                ];
            }

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['password'] = $user['password'];
            $_SESSION['update_password_at'] = $user['update_password_at'];

            return[
                'success' => true,
                'message' => 'Login realizado com sucesso',
                'redirect' => 'dashboard'
            ];

        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Erro ao realizar o login'
            ];
        }
    }
   public function logout()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $_SESSION = [];
    session_destroy();
    return ['status'=> 'success','message'=> ''];
}
    public function update_user_info($email,$name){
        try{
            if(!$this->isLogged()['logged']){
                return[
                    'success' => false,
                    'logged' => false,
                    'message' => 'Usuário não autenticado'
                ];
            }
            $stmt = $this->pdo->prepare("UPDATE `users` SET `email` = ? ,`name` = ? WHERE id = ? ");
            $userId = $_SESSION['user_id'];
            $stmt->execute([$email,$name,$userId]);
             $this->logout();
            return[
                'success'=> true,
                'message' => 'Dados atualizados com sucesso'
            ];
        }
        catch (PDOException $e) {
            return[
                'success'=> false,
                'message' => 'Os dados não foram atualizados porque ' . $e
            ];
        }
    }
    public function changepass($oldPassword,$password){
        try{
            if(!$this->isLogged()['logged']){
                return[
                    'success' => false,
                    'logged' => false,
                    'message' => 'Usuário não autenticado'
                ];
            }
            $stmt = $this->pdo->prepare("SELECT password FROM users WHERE id = ?");
            $stmt->execute([$_SESSION['user_id']]);
            $user = $stmt->fetch();

            if(!password_verify($oldPassword, $user['password'])) {
                return[
                    'success' => false,
                    'logged' => false,
                    'message' => 'Senha antiga incorreta'
                ];
            }
            $userId = $_SESSION['user_id'];
            $hashedPassword = password_hash($password,PASSWORD_BCRYPT);
            $stmt = $this->pdo->prepare("UPDATE users SET `password` = ? , update_password_at = ? WHERE `id` = ? ");
            $timestampAtual = time();
            $timetoBd = date("Y-m-d H:i:s", $timestampAtual);
            $stmt->execute([$hashedPassword,$timetoBd,$userId]);
            $this->logout();
                return[
                    'success' => true,
                    'message' => 'Senha atualizada com sucesso',
                    'redirect' => 'dashboard',
                ];
        }
        catch (PDOException $e) {
                return [
                    'success' => false,
                    'logged' => false,
                    'message' => 'Houve algum erro na atualização da senha'
                ];
        }
    }
    public function deleteuser(){
        try{
            $userId = $_SESSION['user_id'];
            $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute($userId);
            $this->logout();
            return[
                'success' => true,
                'message'=> 'Deletado com sucesso'
            ];
        }
        catch(PDOException $e){
            return[
                'success' => false,
                'logged' => false,
                'message' => 'Houve algum erro na deleção'
            ];
        }
    }
}
?>
