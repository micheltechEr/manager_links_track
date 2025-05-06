function validateData() {
    document.getElementById('register-form').addEventListener('submit', async function (e) {
        e.preventDefault();
        const formData = new FormData(this);

        try {
            const res = await fetch('registerUser', {
                method: 'POST',
                body: formData
            });

            const data = await res.json();

            document.querySelector('.feedback').textContent = data.message;

            if (data.status === 'success') {
                window.location.href = data.redirect;
            }
        } catch (error) {
            console.error('Erro ao processar o cadastro:', error);
            document.querySelector('.feedback').textContent = 'Erro interno no servidor';
        }
    });
}

window.addEventListener("load", validateData);
