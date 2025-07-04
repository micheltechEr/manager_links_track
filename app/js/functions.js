
        let links = [];
        let editingIndex = -1;
        let deleteIndex = -1;
        let contentLinks = [];

        window.onload = function() {
            loadLinks();
        };

        function loadLinks() {
            const savedLinks = JSON.parse(localStorage.getItem('savedLinks') || '[]');
            links = savedLinks;
            displayLinks();
        }

        function saveLinks() {
            localStorage.setItem('savedLinks', JSON.stringify(links));
        }

        document.getElementById('linkForm').addEventListener('submit',async function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            try{
                const res = await fetch('saveLinks', {
                    method: 'POST',
                    body: formData
                });
                const data = await res.json();
                
                if(data.status === 'success'){
                    saveLinks();
                    displayLinks();
                    document.getElementById('linkForm').reset();                
                    showNotification('Link adicionado com sucesso!', 'success');
                }
            }
            catch(error){
                console.error('Erro ao processar registro do link')
            }
        });

        function clearForm() {
            document.getElementById('linkForm').reset();
        }

        // Exibir links
    async function displayLinks(linksToShow = links) {
            const linksList = document.getElementById('linksList');
            
            try{
                const res =  await fetch("listLinks",{
                    method: 'GET'
                });
                const dataLinks = await res.json();
                 contentLinks = dataLinks.data;
                if (contentLinks.length == 0) {
                linksList.innerHTML = `
                    <div class="empty-state">
                        <div class="empty-icon">🔗</div>
                        <h3>Nenhum link encontrado</h3>
                        <p>Adicione seu primeiro link usando o formulário acima</p>
                    </div>
                `;
                return;
            }
            linksList.innerHTML = contentLinks.map((link, index) => `
                <div class="link-item">
                    <div class="link-header">
                        <div>
                            <input type="hidden" id="linkIdHidden" name="link_id" value=${link.id} >
                            <div class="link-title">${link.title}</div>
                            <a href="${link.url_link}" target="_blank" class="link-url">${link.url_link}</a>
                        </div>
                        <div class="link-actions">
                            <button onclick="editLink(${contentLinks.indexOf(link)})" class="btn btn-secondary btn-small">
                                <span>✏️</span> Editar
                            </button>
                            <button onclick="deleteLink(${contentLinks.indexOf(link)})" class="btn btn-danger btn-small">
                                <span>🗑️</span> Excluir
                            </button>
                        </div>
                    </div>
                    ${link.description ? `<div class="link-description">${link.description}</div>` : ''}
                </div>
            `).join('');

        }

            catch(error){
                console.error(error);
            }
    }

    function editLink(index) {
        const link = contentLinks[index]; // pegar o link do array
        document.getElementById('editTitle').value = link.title;
        document.getElementById('editUrl').value = link.url_link;
        document.getElementById('editDescription').value = link.description;
        document.getElementById('linkIdHidden').value = link.id; // muito importante!
        document.getElementById('editForm').style.display = 'block';
        document.getElementById('editForm').scrollIntoView({ behavior: 'smooth' });
    }


    function saveEdit() {
    try {
        const formData = new FormData();
        formData.append("editTitle", document.getElementById("editTitle").value);
        formData.append("editUrl", document.getElementById("editUrl").value);
        formData.append("editDescription", document.getElementById("editDescription").value);
        formData.append("link_id", document.getElementById("linkIdHidden").value);

        fetch("editLinks", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            
            if (data.status === "success") {
                saveLinks();
                displayLinks();
                cancelEdit();
                showNotification('Link atualizado com sucesso!', 'success');
            } else {
                showNotification(data.message, 'error');
                console.warn("Resposta com erro:", data);
            }
        })
        .catch(err => {
            console.error("Erro ao enviar:", err);
            showNotification('Erro ao atualizar link!', 'error');
        });
    } catch (error) {
        console.error(error);
    }
}

        function cancelEdit() {
            editingIndex = -1;
            document.getElementById('editForm').style.display = 'none';
        }

        function deleteLink(index) {
            deleteIndex = index;
            document.getElementById('delete-modal').style.display = 'block';
        }

        function confirmDelete() {
            if (deleteIndex >= 0) {
                links.splice(deleteIndex, 1);
                saveLinks();
                displayLinks();
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
