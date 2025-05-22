<?php
require_once __DIR__ . '/../config/database.php';

class User
{
    private $pdo;
    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function doesExistUser($email)
    {
        $stmt = $this->pdo->prepare("SELECT id, password, email FROM users WHERE email = ?");
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

    public function login($email, $password)
    {
        try {
            if (empty($email) || empty($password)) {
                return [
                    'success' => 'false',
                    'message' => 'Preencha com ambos os campos'
                ];
            }

            $user = $this->doesExistUser($email);

            if (!password_verify($password, $user['password'])) {
                return [
                    'success' => 'false',
                    'message' => 'Email ou senha incorretos.'
                ];
            }

            if (isset($$_SESSION['user_id'])) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];

                return [
                    'success' => 'success',
                    'message' => 'Login realizado com sucesso'
                ];
            }
            else{
                return[
                    'success'=> 'false',
                    'message'=> 'Usuário já autenticado'
                ];
            }
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => 'Erro ao realizar o login'
            ];
        }
    }

    public function logout()
    {
        session_start();
        $_SESSION = [];
        session_destroy();
        return [
            'status' => 'success',
            'message' => 'Logout realizado com sucesso',
        ];
    }

}
?>
