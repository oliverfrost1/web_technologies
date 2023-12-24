document.getElementById('registerFormAjax').addEventListener('submit', function (e) {
    e.preventDefault();

    let formData = new FormData(this);
    let csrf = this.querySelector('input[name="_token"]').value;

    fetch('auth/register', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrf
        },
        body: formData
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

