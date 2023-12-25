document.getElementById('registerFormAjax').addEventListener('submit', function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch('auth/register', {
        method: 'POST',
        headers: {
            "Content-type": "application/json",
            "Accept": "application/json"
        },
        body: JSON.stringify({
            name: formData.get('name'),
            email: formData.get('email'),
            password: formData.get('password'),
            _token: formData.get('_token')
        })
    })
        .then(response => response.json())
        .then(data => {
            document.getElementById('name-error').textContent = '';
            document.getElementById('email-error').textContent = '';
            document.getElementById('password-error').textContent = '';

            if (data.success) {
                window.location.href = '/';
            } else {
                console.log(data.message);
                displayRegisterError(data.message);
            }
        })
        .catch(error => {
            console.log('An error occurred.');
        });
});

function displayRegisterError(message) {
    for (let key in message) {
        if (message.hasOwnProperty(key)) {
            let errorElement = document.getElementById(key + '-error');
            if (errorElement) {
                errorElement.textContent = message[key][0];
            }
        }
    }
}

