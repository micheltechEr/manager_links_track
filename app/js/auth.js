function validateSignUpData() {
    var signUpPage = document.getElementById('sign_up_page');
    if (signUpPage) {
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
}

function validateSignIn() {
    var loginPage = document.getElementById('login-page');
    if (loginPage) {
        document.getElementById('login-form').addEventListener('submit', async function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const urlSearchParams = new URLSearchParams();
            for (const pair of formData.entries()) {
                urlSearchParams.append(pair[0], pair[1]);
            }

            try {
                const res = await fetch('loginUser', {
                    method: 'POST',
                    body: urlSearchParams.toString(),
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                });

                const data = await res.json();
                console.log(urlSearchParams.toString())

                document.querySelector('.feedback').textContent = data.message;
                if (data.status === 'success') {
                    window.location.href = data.redirect;
                }

            } catch (error) {
                console.error('Erro ao processar o login:', error);
                document.querySelector('.feedback').textContent = 'Erro interno no servidor';
            }
        });
    }
}

function logoutUser() {
    let isDashboard = document.querySelector(".dashboard-links");
    if (isDashboard) {
        document.getElementById('logout').addEventListener("click", async function (e) {
            try {
                const response = await fetch('logout', {
                    method: 'POST',
                    credentials: 'same-origin'

                });
                const data = await response.json();
                if (data.status == 'success') {
                    window.location.href = data.redirect;
                    console.log('Sucesso')
                }
            }
            catch (error) {
                console.log('Erro durante logout');
            }
        })
    }
}

function changePassword(){
    var userProfilePage = document.getElementById('user-profile');
    if(userProfilePage){
        document.getElementById('change-password').addEventListener("submit",async function (e){
            e.preventDefault();
            const formData = new FormData(this);
            const urlSearchParams = new URLSearchParams();
            for (const pair of formData.entries()) {
                urlSearchParams.append(pair[0], pair[1]);
            }
            try {
                const res = await fetch('changePassword', {
                    method: 'POST',
                    body: urlSearchParams.toString(),
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                });

                const data = await res.json();
                console.log(urlSearchParams.toString())

                document.querySelector('.feedback').textContent = data.message;
                if (data.status === 'success') {
                    window.location.href = data.redirect;
                }

            } catch (error) {
                console.error('Erro ao processar o login:', error);
                document.querySelector('.feedback').textContent = 'Erro interno no servidor';
            } 

        })
    }
}

function changeInfo(){  
  var userProfilePage = document.getElementById('user-profile');
  if(userProfilePage){
        document.getElementById('update-user-info').addEventListener("submit",async function (e){
            e.preventDefault();
            const formData = new FormData(this);
            const urlSearchParams = new URLSearchParams();
            for (const pair of formData.entries()) {
                urlSearchParams.append(pair[0], pair[1]);
            }
            
            try {
                const res = await fetch('updateUserInfo', {
                    method: 'POST',
                    body: urlSearchParams.toString(),
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                });

                const data = await res.json();
                console.log(urlSearchParams.toString())

                document.querySelector('.feedback').textContent = data.message;
                if (data.status === 'success') {
                    window.location.href = data.redirect;
                }

            } catch (error) {
                console.error('Erro ao processar os dados:', error);
                document.querySelector('.feedback').textContent = 'Erro interno no servidor';
            } 

        })
    }
}

function deleteUserAccount(){  
  var userProfilePage = document.getElementById('user-profile');
  if(userProfilePage){
        document.getElementById('delete-account-btn').addEventListener("click",async function (e){
            e.preventDefault();            
            try {
                const res = await fetch('deleteUserAccount', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                });

                const data = await res.json();
                document.querySelector('.feedback').textContent = data.message;
                if (data.status === 'success') {
                    window.location.href = data.redirect;
                }

            } catch (error) {
                console.error('Erro ao processar os dados:', error);
                document.querySelector('.feedback').textContent = 'Erro interno no servidor';
            } 

        })
    }
}

window.addEventListener("load", function () {
    validateSignUpData();
    validateSignIn();
    logoutUser();
    changePassword();
    changeInfo();
    deleteUserAccount();
});




