$(document).ready(function() {
    $('#subscription-form').submit(function(e) {
        e.preventDefault();

        var email = $('#email').val();
        $.ajax({
            type: 'POST',
            url: './landing/php/subscribe.php',
            data: { email: email },
            success: function(response) {
                $('#response').html(response);
            }
        });
    });
});
