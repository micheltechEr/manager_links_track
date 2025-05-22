<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gerenciador de Links</title>
    <link rel="stylesheet" href="css/login.css" />
</head>
<body id="login-page">
    <header class="header">
        <a href="index.html" class="logo">
            <span class="logo-icon">🔗</span>
            Gerenciador de Links
        </a>
    </header>
    
    <main class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1 class="login-title">Bem-vindo de volta</h1>
                <p class="login-subtitle">Entre para acessar seus links encurtados</p>
            </div>
            
            <form id="login-form" method="POST" action="loginUser">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Seu email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Senha</label>
                    <input type="password" id="password" name="password" placeholder="Sua senha" required>
                </div>

                <span class="error-message feedback"></span>
                
               <!-- <div class="forgot-password">
                    <a href="#">Esqueceu a senha?</a>
                </div> !-->
                
                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember_me">
                    <label for="remember">Lembrar de mim</label>
                </div>
                
                <button type="submit">Entrar</button>
            </form>
                        
            <div class="login-footer">
                Não tem uma conta? <a href="register">Registre-se agora</a>
            </div>
        </div>
    </main>
    
    <footer class="footer">
        &copy; 2025 Gerenciador de Links. Todos os direitos reservados.
    </footer>
    <script src="js/auth.js"> </script>

</body>
</html>