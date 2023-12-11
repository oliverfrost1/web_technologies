var btn = document.getElementById("login-form");

btn.onclick = function() {
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

