let links = [];
let contentLinks = [];
let deleteIndex = -1;
let linkToDeleteId = null;

window.onload = function () {
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

document.getElementById('linkForm').addEventListener('submit', async function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    try {
        const res = await fetch('saveLinks', {
            method: 'POST',
            body: formData
        });
        const data = await res.json();

        if (data.status === 'success') {
            saveLinks();
            displayLinks();
            this.reset();
            showNotification('Link adicionado com sucesso!', 'success');
        }
    } catch (error) {
        console.error('Erro ao processar registro do link');
    }
});

function clearForm() {
    document.getElementById('linkForm').reset();
}

async function displayLinks(linksToShow = links) {
    const linksList = document.getElementById('linksList');

    try {
        const res = await fetch("listLinks", { method: 'GET' });
        const dataLinks = await res.json();
        contentLinks = dataLinks.data;

        if (contentLinks.length === 0) {
            linksList.innerHTML = `
                <div class="empty-state">
                    <div class="empty-icon">🔗</div>
                    <h3>Nenhum link encontrado</h3>
                    <p>Adicione seu primeiro link usando o formulário acima</p>
                </div>`;
            return;
        }

        linksList.innerHTML = contentLinks.map((link, index) => `
            <div class="link-item">
                <div class="link-header">
                    <div>
                        <input type="hidden" name="link_id" value="${link.id}">
                        <div class="link-title">${link.title}</div>
                        <a href="redirect.php?id=${link.id}" target="_blank" class="link-url">${link.url_link}</a>
                    </div>
                    <div class="link-actions">
                        <button onclick="editLink(${index})" class="btn btn-secondary btn-small">✏️ Editar</button>
                        <button class="btn btn-danger btn-small deleteLinkRef" data-id="${link.id}">🗑️ Excluir</button>
                    </div>
                </div>
                ${link.description ? `<div class="link-description">${link.description}</div>` : ''}
            </div>
        `).join('');

        deleteLink(); // agora os botões existem no DOM
    } catch (error) {
        console.error(error);
    }
}

function editLink(index) {
    const link = contentLinks[index];
    document.getElementById('editTitle').value = link.title;
    document.getElementById('editUrl').value = link.url_link;
    document.getElementById('editDescription').value = link.description;
    document.getElementById('linkIdHidden').value = link.id;
    document.getElementById('editForm').style.display = 'block';
    document.getElementById('editForm').scrollIntoView({ behavior: 'smooth' });
}

function cancelEdit() {
    document.getElementById('editForm').style.display = 'none';
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

function deleteLink() {
    const deleteBtns = document.querySelectorAll('.deleteLinkRef');

    deleteBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            linkToDeleteId = this.getAttribute('data-id');
            openDeleteModal(); // Abre modal de confirmação
        });
    });
}

function openDeleteModal() {
    const modal = document.getElementById('delete-modal');
    modal.style.display = 'block';
}

function closeDeleteModal() {
    const modal = document.getElementById('delete-modal');
    modal.style.display = 'none';
    linkToDeleteId = null;
}

function confirmDelete() {
    if (!linkToDeleteId) return;

    fetch("removeLinks", {
        method: "POST",
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `link_id=${encodeURIComponent(linkToDeleteId)}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            showNotification('Link excluído com sucesso!', 'success');
            loadLinks();
            this.reset();
        } else {
            showNotification('Erro ao excluir o link.', 'error');
        }
    })
    .catch(error => {
        console.error("Erro ao excluir:", error);
    });
    
    closeDeleteModal();
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.classList.add('show');
    }, 100);

    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

window.onclick = function (event) {
    const modal = document.getElementById('delete-modal');
    if (event.target === modal) {
        closeDeleteModal();
    }
}
