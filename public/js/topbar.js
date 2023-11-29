const logoutButton = document.getElementById('logout-button');
logoutButton.addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('logout-form').submit()
});


