<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Links</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f7f7;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .header {
            background-color: #4285f4;
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            display: flex;
            align-items: center;
        }
        
        .logo-icon {
            margin-right: 10px;
            font-size: 1.8rem;
        }
        
        .nav-buttons {
            display: flex;
            gap: 1rem;
        }
        
        .btn {
            padding: 0.6rem 1.2rem;
            border-radius: 5px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }
        
        .btn-login {
            background-color: transparent;
            border: 2px solid white;
            color: white;
        }
        
        .btn-login:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .btn-register {
            background-color: white;
            border: 2px solid white;
            color: #4285f4;
        }
        
        .btn-register:hover {
            background-color: #f1f1f1;
        }
        
        .hero {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        
        .hero-content {
            max-width: 1000px;
            display: flex;
            align-items: center;
            gap: 2rem;
        }
        
        .hero-text {
            flex: 1;
        }
        
        .hero-title {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #333;
        }
        
        .hero-subtitle {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            color: #666;
        }
        
        .feature-list {
            margin-bottom: 2rem;
        }
        
        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .feature-icon {
            margin-right: 10px;
            color: #4285f4;
            font-weight: bold;
        }
        
        .hero-buttons {
            display: flex;
            gap: 1rem;
        }
        
        .btn-primary {
            background-color: #4285f4;
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
        }
        
        .btn-primary:hover {
            background-color: #3367d6;
        }
        
        .btn-secondary {
            background-color: transparent;
            border: 2px solid #4285f4;
            color: #4285f4;
            padding: 0.8rem 1.5rem;
        }
        
        .btn-secondary:hover {
            background-color: rgba(66, 133, 244, 0.1);
        }
        
        .hero-image {
            flex: 1;
            display: flex;
            justify-content: center;
        }
        
        .hero-image img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .footer {
            background-color: #333;
            color: #aaa;
            text-align: center;
            padding: 1.5rem;
            font-size: 0.9rem;
        }
        
        @media (max-width: 768px) {
            .hero-content {
                flex-direction: column;
                text-align: center;
            }
            
            .hero-image {
                order: -1;
            }
            
            .hero-buttons {
                justify-content: center;
            }
            
            .feature-item {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="logo">
                <span class="logo-icon">🔗</span>
                Gerenciador de Links
            </div>
            <div class="nav-buttons">
                <a href="login" class="btn btn-login">Login</a>
                <a href="register" class="btn btn-register">Cadastro</a>
            </div>
        </header>
        
        <main class="hero">
            <div class="hero-content">
                <div class="hero-text">
                    <h1 class="hero-title">Gerenciador de Links</h1>
                    <p class="hero-subtitle">Organize, compartilhe e gerencie todos os seus links importantes em um só lugar.</p>
                    
                    <div class="feature-list">
                        <div class="feature-item">
                            <span class="feature-icon">✓</span>
                            <span>Encurte URLs longos com apenas um clique</span>
                        </div>
                        <div class="feature-item">
                            <span class="feature-icon">✓</span>
                            <span>Simplifique URLs complexos para compartilhamento fácil</span>
                        </div>
                    </div>
                    
                    <div class="hero-buttons">
                        <a href="register" class="btn btn-primary">Começar agora</a>
                        <a href="#saiba-mais" class="btn btn-secondary">Saiba mais</a>
                    </div>
                </div>

            </div>
        </main>
        
        <footer class="footer">
            &copy; 2025 Gerenciador de Links. Todos os direitos reservados.
        </footer>
    </div>
    
</body>
</html>