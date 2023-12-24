document.getElementById('LoginFormAjax').addEventListener('submit', function (e) {
    e.preventDefault();

    let formData = new FormData(this);
    let csrf = this.querySelector('input[name="_token"]').value;

    fetch('auth/login', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrf
        },
        body: formData
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
