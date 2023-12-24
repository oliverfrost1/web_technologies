const logoutButton = document.getElementById('logout-button');
var loginModal = document.getElementById("loginModal");
var loginBtn = document.getElementById("login-button");
var registerModal = document.getElementById("registerModal");
var registerBtn = document.getElementById("register-button");
var span = document.getElementsByClassName("close")[0];
var span2 = document.getElementsByClassName("close")[1];

if (logoutButton) {
    logoutButton.addEventListener('click', function (event) {
        event.preventDefault();
        document.getElementById('logout-form').submit()
    });
}

if (loginBtn) {
    loginBtn.onclick = function () {
        loginModal.style.display = "block";
    }
}
if (registerBtn) {
    registerBtn.onclick = function () {
        registerModal.style.display = "block";
    }
}
if (span) {
    span.onclick = function () {
        loginModal.style.display = "none";
    }
}
if (span2) {
    span2.onclick = function () {
        registerModal.style.display = "none";
    }
}

window.onclick = function (event) {
    if (event.target == loginModal) {
        loginModal.style.display = "none";
    }
    if (event.target == registerModal) {
        registerModal.style.display = "none";
    }
}

document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
        loginModal.style.display = "none";
        registerModal.style.display = "none";
    }
});