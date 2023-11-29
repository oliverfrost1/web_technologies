const logoutButton = document.getElementById('logout-button');

if(logoutButton) {
    logoutButton.addEventListener('click', function(event) {
        console.log("called")
        event.preventDefault();
        document.getElementById('logout-form').submit()
    });
}



