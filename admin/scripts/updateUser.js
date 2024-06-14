$(document).ready(function() {
    // Handle the edit button click event
    $('.editUserBtn').on('click', function() {
        var userId = $(this).data('user-id');
        var username = $(this).data('username');
        var email = $(this).data('email');

        console.log("Edit button clicked for user ID: " + userId);

        $('#editUserForm').data('user-id', userId);
        $('#editUserUsername').val(username);
        $('#editUserEmail').val(email);
    });

    // Handle the form submission
    $('#editUserForm').on('submit', function(event) {
        event.preventDefault();

        var userId = $(this).data('user-id');
        var username = $('#editUserUsername').val();
        var email = $('#editUserEmail').val();
        var status = $('#editUserStatus').val();
        var type = (status === 'active') ? 0 : 1;  
        // var password = $('#updatePassword').val();
        // var confirmPassword = $('#updateConfirmPassword').val();

        console.log("Form submitted for user ID: " + userId);

        // if (password !== confirmPassword) {
        //     alert('Passwords do not match');
        //     return;
        // }

        $.ajax({
            url: 'php/updateUser.php',
            type: 'POST',
            data: {
                userId: userId,
                username: username,
                email: email,
                type: type
                // password: password
            },
            success: function(response) {
                console.log("Response from server: " + response);
                response = JSON.parse(response);
                if (response.success) {
                    alert('User updated successfully');
                    location.reload();
                } else {
                    alert('Failed to update user: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error updating user:', status, error);
                alert('Error updating user');
            }
        });
    });
});
