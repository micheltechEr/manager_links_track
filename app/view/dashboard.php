<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Gerenciador de Links</title>
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
        
        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4285f4;
            font-weight: bold;
            cursor: pointer;
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
        
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .page-title {
            font-size: 1.5rem;
            color: #333;
        }
        
        .create-link {
            background-color: #4285f4;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 0.6rem 1.2rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            transition: background-color 0.2s;
        }
        
        .create-link:hover {
            background-color: #3367d6;
        }
        
        .btn-icon {
            margin-right: 0.5rem;
        }
        
        /* Stats cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .stat-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 1.2rem;
            display: flex;
            flex-direction: column;
        }
        
        .stat-title {
            color: #888;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        
        .stat-value {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .stat-trend {
            display: flex;
            align-items: center;
            font-size: 0.8rem;
        }
        
        .trend-up {
            color: #28a745;
        }
        
        .trend-down {
            color: #dc3545;
        }
        
        .trend-icon {
            margin-right: 0.3rem;
        }
        
        /* Chart section */
        .chart-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 1.2rem;
            margin-bottom: 1.5rem;
        }
        
        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .chart-title {
            font-size: 1.1rem;
            font-weight: 600;
        }
        
        .chart-filters {
            display: flex;
            gap: 0.5rem;
        }
        
        .chart-filter {
            border: 1px solid #ddd;
            background-color: white;
            border-radius: 5px;
            padding: 0.4rem 0.8rem;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .chart-filter:hover {
            border-color: #bbb;
        }
        
        .chart-filter.active {
            background-color: #f0f4ff;
            border-color: #4285f4;
            color: #4285f4;
        }
        
        .chart-placeholder {
            width: 100%;
            height: 250px;
            background-color: #f8f9fa;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #aaa;
        }
        
        /* Links table */
        .links-section {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 1.2rem;
            margin-bottom: 1.5rem;
        }
        
        .links-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .links-title {
            font-size: 1.1rem;
            font-weight: 600;
        }
        
        .search-box {
            display: flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 0.4rem 0.8rem;
            width: 250px;
            transition: all 0.2s;
        }
        
        .search-box:focus-within {
            border-color: #4285f4;
            box-shadow: 0 0 0 2px rgba(66, 133, 244, 0.1);
        }
        
        .search-icon {
            color: #888;
            margin-right: 0.5rem;
        }
        
        .search-input {
            border: none;
            outline: none;
            background: transparent;
            flex: 1;
            font-size: 0.9rem;
        }
        
        .links-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .links-table th {
            text-align: left;
            padding: 0.8rem;
            border-bottom: 2px solid #e9ecef;
            font-weight: 600;
            color: #555;
            font-size: 0.9rem;
        }
        
        .links-table td {
            padding: 0.8rem;
            border-top: 1px solid #e9ecef;
            font-size: 0.9rem;
        }
        
        .links-table tr:hover {
            background-color: #f8f9fa;
        }
        
        .link-url {
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .original-url {
            color: #666;
            font-size: 0.85rem;
        }
        
        .short-url {
            font-weight: 600;
            color: #4285f4;
            text-decoration: none;
        }
        
        .short-url:hover {
            text-decoration: underline;
        }
        
        .link-clicks {
            font-weight: 600;
        }
        
        .link-date {
            color: #888;
        }
        
        .link-status {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 3px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .status-active {
            background-color: #e8f5e9;
            color: #28a745;
        }
        
        .status-inactive {
            background-color: #f5f5f5;
            color: #888;
        }
        
        .link-actions {
            display: flex;
            gap: 0.5rem;
        }
        
        .action-btn {
            background-color: transparent;
            border: none;
            cursor: pointer;
            color: #777;
            transition: color 0.2s;
        }
        
        .action-btn:hover {
            color: #4285f4;
        }
        
        .pagination {
            display: flex;
            justify-content: flex-end;
            gap: 0.3rem;
            margin-top: 1rem;
        }
        
        .page-btn {
            border: 1px solid #ddd;
            background-color: white;
            border-radius: 5px;
            min-width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .page-btn:hover {
            border-color: #aaa;
        }
        
        .page-btn.active {
            background-color: #4285f4;
            border-color: #4285f4;
            color: white;
        }
        
        .page-btn.disabled {
            opacity: 0.5;
            cursor: not-allowed;
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
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .search-box {
                width: 100%;
                margin-top: 1rem;
            }
            
            .links-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .links-table th:nth-child(3),
            .links-table td:nth-child(3),
            .links-table th:nth-child(4),
            .links-table td:nth-child(4) {
                display: none;
            }
        }
    </style>
</head>
<body class="dashboard-links">
    <header class="header">
        <a href="#" class="logo">
            <span class="logo-icon">🔗</span>
            Gerenciador de Links
        </a>
        <div class="user-menu">

            <div class="user-avatar">JS</div>
        </div>
    </header>
    
    <div class="container">
        <aside class="sidebar">
            <ul class="sidebar-menu">
                <li><a href="#" class="active"><span class="menu-icon">📊</span> Dashboard</a></li>
                <li><a href="#"><span class="menu-icon">🔗</span> Meus Links</a></li>
                <li><a href="#"><span class="menu-icon">📈</span> Estatísticas</a></li>
                
                <div class="sidebar-divider"></div>
                
                <li><a href="profilePage"><span class="menu-icon">👤</span> Perfil</a></li>
                <li><a href="#"><span class="menu-icon">⚙️</span> Configurações</a></li>
                <li><a href="#"><span class="menu-icon">❓</span> Ajuda</a></li>
                <li><a  id="logout"><span class="menu-icon">🚪</span> Sair</a></li>
            </ul>
        </aside>
        
        <main class="main-content">
            <div class="dashboard-header">
                <h1 class="page-title">Dashboard</h1>
                <button class="create-link">
                    <span class="btn-icon">➕</span> Novo Link
                </button>
            </div>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-title">Total de Links</div>
                    <div class="stat-value">156</div>
                    <div class="stat-trend trend-up">
                        <span class="trend-icon">↑</span> 12% este mês
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-title">Total de Cliques</div>
                    <div class="stat-value">24.8K</div>
                    <div class="stat-trend trend-up">
                        <span class="trend-icon">↑</span> 18% este mês
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-title">Taxa de Cliques</div>
                    <div class="stat-value">4.2%</div>
                    <div class="stat-trend trend-up">
                        <span class="trend-icon">↑</span> 2.1% este mês
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-title">Links Ativos</div>
                    <div class="stat-value">142</div>
                    <div class="stat-trend trend-down">
                        <span class="trend-icon">↓</span> 3% este mês
                    </div>
                </div>
            </div>
            
            <div class="chart-container">
                <div class="chart-header">
                    <h2 class="chart-title">Desempenho dos Links</h2>
                    <div class="chart-filters">
                        <button class="chart-filter">Dia</button>
                        <button class="chart-filter active">Semana</button>
                        <button class="chart-filter">Mês</button>
                        <button class="chart-filter">Ano</button>
                    </div>
                </div>
                
                <div class="chart-placeholder">
                    [Gráfico de Desempenho dos Links]
                </div>
            </div>
            
            <div class="links-section">
                <div class="links-header">
                    <h2 class="links-title">Links Recentes</h2>
                    <div class="search-box">
                        <span class="search-icon">🔍</span>
                        <input type="text" class="search-input" placeholder="Buscar links...">
                    </div>
                </div>
                
                <table class="links-table">
                    <thead>
                        <tr>
                            <th>Link</th>
                            <th>Cliques</th>
                            <th>Data de Criação</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="link-url">
                                <div class="original-url">https://exemplo.com/pagina-com-url-muito-longo-que-precisa-ser-encurtado</div>
                                <a href="#" class="short-url">encrt.io/a1b2c3</a>
                            </td>
                            <td class="link-clicks">1,245</td>
                            <td class="link-date">12/05/2025</td>
                            <td><span class="link-status status-active">Ativo</span></td>
                            <td class="link-actions">
                                <button class="action-btn" title="Editar">✏️</button>
                                <button class="action-btn" title="Estatísticas">📊</button>
                                <button class="action-btn" title="Copiar">📋</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
    
    <footer class="footer">
        &copy; 2025 Gerenciador de Links. Todos os direitos reservados.
    </footer>
    <script src="js/auth.js"> </script>

</body>
</html>