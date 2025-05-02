<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Registro</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        
        .container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            padding: 40px;
        }
        
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
            color: #555;
        }
        
        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }
        
        input:focus {
            outline: none;
            border-color: #4285f4;
            box-shadow: 0 0 0 2px rgba(66, 133, 244, 0.2);
        }
        
        button {
            background-color: #4285f4;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
            transition: background-color 0.2s;
        }
        
        button:hover {
            background-color: #3367d6;
        }
        
        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #555;
            font-size: 14px;
        }
        
        .login-link a {
            color: #4285f4;
            text-decoration: none;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
    <script src="js/validator.js"> </script>
</head>
<body>
    <div class="container">
    <div id="feedback"></div>

        <h1>Criar Conta</h1>
        <form id="register-form" method="POST" action="process_data/user_process_data.php">
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
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

</body>
</html>