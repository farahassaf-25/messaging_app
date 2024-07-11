$(document).ready(function() {
    $('#subscribeBtn').click(function() {
        var name = $('#name').val();
        var email = $('#email').val();

        $.ajax({
            url: 'landing/php/subscribe.php',
            type: 'POST',
            data: {
                name: name,
                email: email
            },
            success: function(response) {
                $('#response').html(response);
            },
            error: function(xhr, status, error) {
                $('#response').html('An error occurred: ' + error);
            }
        });
    });
});
