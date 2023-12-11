const logoutButton = document.getElementById('logout-button');

if(logoutButton) {
    logoutButton.addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('logout-form').submit()
    });
}

var loginModal = document.getElementById("loginModal");
var loginBtn = document.getElementById("login-button");
var registerModal = document.getElementById("registerModal");
var registerBtn = document.getElementById("register-button");
var span = document.getElementsByClassName("close")[0];

loginBtn.onclick = function() {
    loginModal.style.display = "block";
  console.log("clicked");
}
registerBtn.onclick = function() {
    registerModal.style.display = "block";
  console.log("clicked");
}

span.onclick = function() {
    loginModal.style.display = "none";
    registerModal.style.display = "none";
}

window.onclick = function(event) {
  if (event.target == loginModal) {
    loginModal.style.display = "none";
  }
  if (event.target == registerModal) {
    registerModal.style.display = "none";
  }
}


$("#login_form").submit(function(e) {
    e.preventDefault();

    var all = $(this).serialize();

    $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: all,
            beforeSend: function() {
                $(document).find('span.error-text').text('');
            },

            success: function(data) {
                if (data.status == 0) {
                    $.each(data.error, function(prefix, val) {
                        $('span.' + prefix + '_error').text(val[0]);
                    });
                }

                if (data == 1) {
                    window.location.replace(
                        '{{route("dashboard.index")}}'
                    );
                } else if (data == 2) {
                    $("#show_error").hide().html("Invalid login details ");
                    }
                }
            })

    });

