<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Registro</title>
    <link rel="stylesheet" href="css/register.css" />
</head>
<body>
    <div class="container">
        <h1>Criar Conta</h1>
        <span class="error-message feedback"></span>

        <form id="register-form" method="POST" action=" registerUser">
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
                <span class="error-message feedback"></span>
            </div>
            
            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit">Registrar</button>
        </form>
        
        <div class="login-link">
            Já tem uma conta? <a href="#">Faça login</a>
        </div>
    </div>
    <script src="js/validator.js"> </script>

</body>
</html>