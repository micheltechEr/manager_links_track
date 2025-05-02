fetch('process_data/user_process_data.php',{
    method:'POST',
    body: new FormData(document.getElementById('register-form'))
})

.then(res => res.json())
.then(data => {
    const msgBox = document.getElementById('feedback');

    msgBox.innerHTML = data.message;
    msgBox.style.color = data.status === 'error' ? 'red' : 'green';
});