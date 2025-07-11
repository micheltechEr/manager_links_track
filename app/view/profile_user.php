 
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - Gerenciador de Links</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        /* Header */
        .header {
            background-color: #4285f4;
            color: white;
            padding: 0.8rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .logo {
            font-size: 1.3rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            text-decoration: none;
            color: white;
        }
        
        .logo-icon {
            margin-right: 10px;
            font-size: 1.5rem;
        }
        
        
        .notifications {
            position: relative;
            cursor: pointer;
        }
        
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #ff4444;
            color: white;
            font-size: 0.7rem;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Main layout */
        .container {
            display: flex;
            flex: 1;
        }
        
        /* Sidebar */
        .sidebar {
            width: 240px;
            background-color: #fff;
            border-right: 1px solid #e9ecef;
            padding: 1.5rem 0;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.03);
        }
        
        .sidebar-menu {
            list-style: none;
        }
        
        .sidebar-menu li {
            margin-bottom: 0.3rem;
        }
        
        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 0.8rem 1.5rem;
            color: #555;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }
        
        .sidebar-menu a:hover {
            background-color: #f5f7fa;
            color: #4285f4;
        }
        
        .sidebar-menu a.active {
            background-color: #ebf2fe;
            color: #4285f4;
            border-left: 3px solid #4285f4;
        }
        
        .menu-icon {
            margin-right: 0.8rem;
            font-size: 1.1rem;
        }
        
        .sidebar-divider {
            height: 1px;
            background-color: #e9ecef;
            margin: 1rem 0;
        }
        
        /* Main content */
        .main-content {
            flex: 1;
            padding: 1.5rem;
            overflow-y: auto;
        }
        
        .page-header {
            margin-bottom: 1.5rem;
        }
        
        .page-title {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 0.5rem;
        }
        
        .page-subtitle {
            color: #666;
            font-size: 0.95rem;
        }
        
        /* Profile sections */
        .profile-section {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #333;
            display: flex;
            align-items: center;
        }
        
        .section-icon {
            margin-right: 0.5rem;
            font-size: 1.2rem;
        }
        
        /* Avatar section */
        .avatar-section {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }
        

        
        .avatar-info {
            flex: 1;
        }
        
        .avatar-name {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.3rem;
        }
        
        .avatar-email {
            color: #666;
            margin-bottom: 0.8rem;
        }
        
        .change-avatar-btn {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .change-avatar-btn:hover {
            background-color: #e9ecef;
            border-color: #bbb;
        }
        
        /* Form styles */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1rem;
        }
        
        .form-group {
            margin-bottom: 1rem;
        }
        
        .form-group.full-width {
            grid-column: 1 / -1;
        }
        
        label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #555;
            font-size: 0.9rem;
        }
        
        input, textarea, select {
            width: 100%;
            padding: 0.7rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 0.9rem;
            transition: border-color 0.3s;
        }
        
        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: #4285f4;
            box-shadow: 0 0 0 2px rgba(66, 133, 244, 0.2);
        }
        
        textarea {
            min-height: 80px;
            resize: vertical;
        }
        
        /* Buttons */
        .btn {
            padding: 0.7rem 1.2rem;
            border-radius: 5px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-primary {
            background-color: #4285f4;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #3367d6;
        }
        
        .btn-secondary {
            background-color: #f8f9fa;
            color: #333;
            border: 1px solid #ddd;
        }
        
        .btn-secondary:hover {
            background-color: #e9ecef;
            border-color: #bbb;
        }
        
        .btn-danger {
            background-color: #dc3545;
            color: white;
        }
        
        .btn-danger:hover {
            background-color: #c82333;
        }
        
        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 1.5rem;
        }
        
        /* Security section */
        .security-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #eee;
        }
        
        .security-item:last-child {
            border-bottom: none;
        }
        
        .security-info h4 {
            margin-bottom: 0.3rem;
            font-size: 0.95rem;
        }
        
        .security-info p {
            color: #666;
            font-size: 0.85rem;
        }
        
        /* Danger zone */
        .danger-zone {
            border: 1px solid #dc3545;
            border-radius: 8px;
            background-color: #fff5f5;
        }
        
        .danger-zone .section-title {
            color: #dc3545;
            margin-bottom: 1rem;
        }
        
        .danger-actions {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .danger-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .danger-info h4 {
            color: #dc3545;
            margin-bottom: 0.3rem;
            font-size: 0.95rem;
        }
        
        .danger-info p {
            color: #666;
            font-size: 0.85rem;
        }
        
        /* Modal for delete confirmation */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }
        
        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            border-radius: 10px;
            padding: 2rem;
            max-width: 400px;
            width: 90%;
        }
        
        .modal-header {
            text-align: center;
            margin-bottom: 1rem;
        }
        
        .modal-icon {
            font-size: 3rem;
            color: #dc3545;
            margin-bottom: 1rem;
        }
        
        .modal-title {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            color: #333;
        }
        
        .modal-text {
            color: #666;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        
        .modal-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }
        
        /* Footer */
        .footer {
            background-color: #fff;
            border-top: 1px solid #e9ecef;
            padding: 1rem 1.5rem;
            text-align: center;
            color: #888;
            font-size: 0.85rem;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .container {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid #e9ecef;
                padding: 0.5rem 0;
            }
            
            .sidebar-menu {
                display: flex;
                overflow-x: auto;
                padding: 0.5rem;
            }
            
            .sidebar-menu li {
                margin-bottom: 0;
                margin-right: 0.5rem;
            }
            
            .sidebar-menu a {
                border-left: none;
                border-bottom: 3px solid transparent;
                padding: 0.6rem 1rem;
                white-space: nowrap;
            }
            
            .sidebar-menu a.active {
                border-left: none;
                border-bottom: 3px solid #4285f4;
            }
            
            .sidebar-divider {
                display: none;
            }
        }
        
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .avatar-section {
                flex-direction: column;
                text-align: center;
            }
            
            .form-actions {
                flex-direction: column;
            }
            
            .danger-item {
                flex-direction: column;
                align-items: stretch;
            }
        }
    </style>
</head>
<body id="user-profile">
    <header class="header">
        <a href="dashboard.html" class="logo">
            <span class="logo-icon">🔗</span>
            Gerenciador de Links
        </a>
    </header>
    
    <div class="container">

    <?php require_once __DIR__ . '/partials/user_sidebar.php'  ?>
        <main class="main-content">
            <div class="page-header">
                <h1 class="page-title">Perfil do Usuário</h1>
                <p class="page-subtitle">Gerencie suas informações pessoais e configurações de conta</p>
            </div>
            
            <!-- Informações Pessoais -->
            <div class="profile-section">
                <h2 class="section-title">
                    <span class="section-icon">👤</span>
                    Informações Pessoais
                </h2>
                
                <div class="avatar-section">
                    <div class="avatar-info">
                        <div class="avatar-name"><?= $userName ?></div>
                        <div class="avatar-email"><?= $userEmail ?></div>
                    </div>
                </div>
                
                <form id="update-user-info" action="updateUserInfo" method="POST">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name">Nome</label>
                            <input type="text" id="newname" name="newname" value= <?= $userName ?> required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="newemail" name="newemail" value="<?= htmlspecialchars($userEmail, ENT_QUOTES, 'UTF-8') ?>" required>
                        </div>
                        
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary">Cancelar</button>
                        <button  type="submit" class="btn btn-primary">
                            <span>💾</span> Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Segurança -->
            <div class="profile-section">
                <h2 class="section-title">
                    <span class="section-icon">🔒</span>
                    Segurança
                </h2>
                
                <div class="security-item">
                    <div class="security-info">
                        <h4>Senha</h4>
                        <p>Última alteração  <?= $passLastUpdateFormatted ?> </p>
                    </div>
                </div>
                <div class="change-pass">
                    <form id="change-password"  action="changePassword" method="post">                          
                        <div class="form-group">
                            <label for="current_password">Senha atual</label>
                            <input type="password" id="current_password" name="current_password"  required/>
                        </div>
                        <div class="form-group">
                            <label for="new_password">Nova senha</label>
                            <input type="password"  id="new_password" name="new_password" required/>
                        </div>
                        <button type="submit" class="btn btn-secondary">Alterar Senha</button>

                    </form>
                    <span class="feedback"></span>
                </div>
                
            </div>
            
            <!-- Zona de Perigo -->
            <div class="profile-section danger-zone">
                <h2 class="section-title">
                    <span class="section-icon">⚠️</span>
                    Zona de Perigo
                </h2>
                
                <div class="danger-actions">
                    <div class="danger-item">
                        <div class="danger-info">
                            <h4>Excluir Conta</h4>
                            <p>Remova permanentemente sua conta e todos os dados associados. Esta ação não pode ser desfeita.</p>
                        </div>
                    <form id="delete-account-form">
                        <button type="submit" class="btn btn-danger" id="delete-account-btn">
                            <span>🗑️</span> Excluir Conta
                        </button>
                    </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <!-- Modal de Confirmação de Exclusão -->
    <div class="modal" id="delete-modal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-icon">⚠️</div>
                <h3 class="modal-title">Excluir Conta</h3>
            </div>
            <p class="modal-text">
                Tem certeza de que deseja excluir sua conta? Esta ação é irreversível e todos os seus dados, incluindo links e estatísticas, serão permanentemente removidos.
            </p>
            <div class="modal-actions">
                <button class="btn btn-secondary" id="cancel-delete">Cancelar</button>
                <button class="btn btn-danger" id="confirm-delete">
                    <span>🗑️</span> Sim, Excluir Conta
                </button>
            </div>
        </div>
    </div>
    
    <footer class="footer">
        &copy; 2025 Gerenciador de Links. Todos os direitos reservados.
    </footer>
<script src="js/auth.js"> </script>
</body>
</html>