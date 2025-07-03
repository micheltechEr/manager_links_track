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
        
        /* Stats */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .stat-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            text-align: center;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #4285f4;
            display: block;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            color: #666;
            font-size: 0.9rem;
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
        
        .btn-small {
            padding: 0.4rem 0.8rem;
            font-size: 0.8rem;
        }
        
        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 1.5rem;
        }
        
        /* Search */
        .search-box {
            margin-bottom: 1rem;
        }
        
        .search-input {
            width: 100%;
            max-width: 400px;
            padding: 0.7rem 0.7rem 0.7rem 2.5rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 0.9rem;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="%23666" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>') no-repeat 0.7rem center;
            background-size: 1rem;
        }
        
        /* Link items */
        .link-item {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }
        
        .link-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            border-color: #4285f4;
        }
        
        .link-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.5rem;
        }
        
        .link-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.3rem;
        }
        
        .link-url {
            color: #4285f4;
            text-decoration: none;
            font-weight: 500;
            word-break: break-all;
            font-size: 0.9rem;
        }
        
        .link-url:hover {
            text-decoration: underline;
        }
        
        .link-actions {
            display: flex;
            gap: 0.5rem;
        }
        
        .link-description {
            color: #666;
            margin-top: 0.5rem;
            line-height: 1.5;
            font-size: 0.9rem;
        }
        
        .link-meta {
            font-size: 0.8rem;
            color: #999;
            margin-top: 0.5rem;
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #666;
        }
        
        .empty-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
        
        .edit-form {
            background: #e3f2fd;
            border: 2px solid #4285f4;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        /* Modal */
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
        
        /* Notification */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            z-index: 1001;
            transform: translateX(100%);
            transition: transform 0.3s ease;
        }
        
        .notification.show {
            transform: translateX(0);
        }
        
        .notification.success {
            background-color: #28a745;
        }
        
        .notification.error {
            background-color: #dc3545;
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
            
            .form-actions {
                flex-direction: column;
            }
            
            .link-header {
                flex-direction: column;
                gap: 1rem;
            }
            
            .link-actions {
                align-self: flex-start;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body id="link-manager">
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
                <h1 class="page-title">Gerenciador de Links</h1>
                <p class="page-subtitle">Organize e gerencie seus links favoritos</p>
            </div>
            
            <!-- Estatísticas -->
            <div class="stats-grid">
                <div class="stat-card">
                    <span class="stat-number" id="totalLinks"><?= $totalLinks ?></span>
                    <span class="stat-label">Total de Links</span>
                </div>
            </div>

            <!-- Cadastro de Links -->
            <div class="profile-section">
                <h2 class="section-title">
                    <span class="section-icon">➕</span>
                    Cadastrar Novo Link
                </h2>
                
                <form method="POST" action="saveLinks"  id="linkForm" name="linkForm">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="linkTitle">Título do Link</label>
                            <input type="text" id="linkTitle" name="linkTitle" placeholder="Ex: Google" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="linkUrl">URL</label>
                            <input type="url" id="linkUrl" name="linkUrl" placeholder="https://exemplo.com" required>
                        </div>
                        
                        <div class="form-group full-width">
                            <label for="linkDescription">Descrição (opcional)</label>
                            <textarea id="linkDescription" name="linkDescription" placeholder="Breve descrição do link"></textarea>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="clearForm()">Limpar</button>
                        <button type="submit" class="btn btn-primary">
                            <span>💾</span> Adicionar Link
                        </button>
                    </div>
                </form>
            </div>

            <!-- Lista de Links -->
            <div class="profile-section">
                <h2 class="section-title">
                    <span class="section-icon">📋</span>
                    Meus Links
                </h2>
                
                <!-- Formulário de Edição -->
                <div id="editForm" class="edit-form" style="display: none;" >
                    <h3>✏️ Editando Link</h3>
                    <form action="editLink" id="editLink" method="POST" name="editForm">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="editTitle">Título</label>
                            <input type="text" id="editTitle" name="editTitle">
                        </div>
                        
                        <div class="form-group">
                            <label for="editUrl">URL</label>
                            <input type="url" id="editUrl" name="editUrl">
                        </div>
                        
                        <div class="form-group full-width">
                            <label for="editDescription">Descrição</label>
                            <textarea id="editDescription" name="editDescription"></textarea>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="cancelEdit()">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="saveEdit()">
                            <span>💾</span> Salvar Alterações
                        </button>
                    </div>
                </span>
                    </form>
                </div>
                
                <div id="linksList"></div>
            </div>
        </main>
    </div>
    
    <!-- Modal de Confirmação de Exclusão -->
    <div class="modal" id="delete-modal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-icon">⚠️</div>
                <h3 class="modal-title">Excluir Link</h3>
            </div>
            <p class="modal-text">
                Tem certeza de que deseja excluir este link? Esta ação não pode ser desfeita.
            </p>
            <div class="modal-actions">
                <button class="btn btn-secondary" onclick="closeDeleteModal()">Cancelar</button>
                <button class="btn btn-danger" onclick="confirmDelete()">
                    <span>🗑️</span> Sim, Excluir
                </button>
            </div>
        </div>
    </div>
    
    <footer class="footer">
        &copy; 2025 Gerenciador de Links. Todos os direitos reservados.
    </footer>
<script src="js/functions.js"> </script>
</body>
</html>