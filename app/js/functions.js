
        let links = [];
        let editingIndex = -1;
        let deleteIndex = -1;

        // Carrega links salvos no início
        window.onload = function() {
            loadLinks();
            updateStats();
        };

        function loadLinks() {
            const savedLinks = JSON.parse(localStorage.getItem('savedLinks') || '[]');
            links = savedLinks;
            displayLinks();
            updateStats();
        }

        function saveLinks() {
            localStorage.setItem('savedLinks', JSON.stringify(links));
        }

        // Cadastrar novo link
        document.getElementById('linkForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const title = document.getElementById('linkTitle').value.trim();
            const url = document.getElementById('linkUrl').value.trim();
            const description = document.getElementById('linkDescription').value.trim();
            
            if (title && url) {
                const newLink = {
                    id: Date.now(),
                    title: title,
                    url: url,
                    description: description,
                    dateAdded: new Date().toLocaleDateString('pt-BR'),
                    dateCreated: new Date()
                };
                
                links.unshift(newLink);
                saveLinks();
                displayLinks();
                updateStats();
                
                // Limpar formulário
                document.getElementById('linkForm').reset();
                
                // Feedback visual
                showNotification('Link adicionado com sucesso!', 'success');
            }
        });

        // Limpar formulário
        function clearForm() {
            document.getElementById('linkForm').reset();
        }

        // Exibir links
        function displayLinks(linksToShow = links) {
            const linksList = document.getElementById('linksList');
            
            if (linksToShow.length === 0) {
                linksList.innerHTML = `
                    <div class="empty-state">
                        <div class="empty-icon">🔗</div>
                        <h3>Nenhum link encontrado</h3>
                        <p>Adicione seu primeiro link usando o formulário acima</p>
                    </div>
                `;
                return;
            }
            
            linksList.innerHTML = linksToShow.map((link, index) => `
                <div class="link-item">
                    <div class="link-header">
                        <div>
                            <div class="link-title">${link.title}</div>
                            <a href="${link.url}" target="_blank" class="link-url">${link.url}</a>
                        </div>
                        <div class="link-actions">
                            <button onclick="editLink(${links.indexOf(link)})" class="btn btn-secondary btn-small">
                                <span>✏️</span> Editar
                            </button>
                            <button onclick="deleteLink(${links.indexOf(link)})" class="btn btn-danger btn-small">
                                <span>🗑️</span> Excluir
                            </button>
                        </div>
                    </div>
                    ${link.description ? `<div class="link-description">${link.description}</div>` : ''}
                    <div class="link-meta">
                        Adicionado em: ${link.dateAdded}
                    </div>
                </div>
            `).join('');
        }

        // Editar link
        function editLink(index) {
            editingIndex = index;
            const link = links[index];
            
            document.getElementById('editTitle').value = link.title;
            document.getElementById('editUrl').value = link.url;
            document.getElementById('editDescription').value = link.description || '';
            
            document.getElementById('editForm').style.display = 'block';
            document.getElementById('editForm').scrollIntoView({ behavior: 'smooth' });
        }

        function saveEdit() {
            if (editingIndex >= 0) {
                const title = document.getElementById('editTitle').value.trim();
                const url = document.getElementById('editUrl').value.trim();
                const description = document.getElementById('editDescription').value.trim();
                
                if (title && url) {
                    links[editingIndex] = {
                        ...links[editingIndex],
                        title: title,
                        url: url,
                        description: description
                    };
                    
                    saveLinks();
                    displayLinks();
                    cancelEdit();
                    showNotification('Link atualizado com sucesso!', 'success');
                }
            }
        }

        function cancelEdit() {
            editingIndex = -1;
            document.getElementById('editForm').style.display = 'none';
        }

        // Excluir link
        function deleteLink(index) {
            deleteIndex = index;
            document.getElementById('delete-modal').style.display = 'block';
        }

        function confirmDelete() {
            if (deleteIndex >= 0) {
                links.splice(deleteIndex, 1);
                saveLinks();
                displayLinks();
                updateStats();
                closeDeleteModal();
                showNotification('Link excluído com sucesso!', 'success');
                
                // Se estava editando o link excluído, cancela a edição
                if (editingIndex === deleteIndex) {
                    cancelEdit();
                }
            }
        }

        function closeDeleteModal() {
            document.getElementById('delete-modal').style.display = 'none';
            deleteIndex = -1;
        }

        // Filtrar links
        function filterLinks() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const filteredLinks = links.filter(link => 
                link.title.toLowerCase().includes(searchTerm) ||
                link.url.toLowerCase().includes(searchTerm) ||
                (link.description && link.description.toLowerCase().includes(searchTerm))
            );
            
            displayLinks(filteredLinks);
            updateStats(filteredLinks.length);
        }

        // Atualizar estatísticas
        function updateStats(filtered = null) {
            const today = new Date().toLocaleDateString('pt-BR');
            const recentCount = links.filter(link => link.dateAdded === today).length;
            
            document.getElementById('totalLinks').textContent = links.length;
            document.getElementById('filteredLinks').textContent = filtered !== null ? filtered : links.length;
            document.getElementById('recentLinks').textContent = recentCount;
        }

        // Notificação
        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            // Mostrar notificação
            setTimeout(() => {
                notification.classList.add('show');
            }, 100);
            
            // Esconder notificação
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Fechar modal ao clicar fora
        window.onclick = function(event) {
            const modal = document.getElementById('delete-modal');
            if (event.target === modal) {
                closeDeleteModal();
            }
        }
