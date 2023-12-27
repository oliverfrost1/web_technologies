document.getElementById('LoginFormAjax').addEventListener('submit', function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch('auth/login', {
        method: 'POST',
        headers: {
            "Content-type": "application/json",
            "Accept": "application/json"
        },
        body: JSON.stringify({
            email: formData.get('email'),
            password: formData.get('password'),
            _token: formData.get('_token')
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = '/';
            } else {
                displayLoginError(data.message);
            }
        })
        .catch(error => {
            displayLoginError('An error occurred.');
        });
});

function displayLoginError(message) {
    const errorElement = document.querySelector('#login-error');
    if (errorElement) {
        errorElement.textContent = message;
    }
}
