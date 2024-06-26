$(document).ready(function() {

// Store initial table content
var initialTableContent = $('#adminTableBody').html();

// Search user by ID, Name, or Email
$('#searchAdmin').on('input', function() {
    var searchTerm = $(this).val().trim();

    if (searchTerm) {
        $.ajax({
            url: 'php/searchAdmin.php',
            type: 'GET',
            data: { search_term: searchTerm },
            success: function(response) {
                response = JSON.parse(response);
                if (response.success) {
                    var admins = response.admins;
                    var adminRows = admins.map(function(admin) {
                        return "<tr>" +
                         "<td>" + admin.id + "</td>" +
                         "<td>" + admin.name + "</td>" +
                         "<td>" + admin.email + "</td>" +
                         "<td><button id='editAdminBtn' class='btn btn-success btn-sm' data-bs-toggle='modal' data-bs-target='#editAdminModal'>Update</button></td>" +
                         "<td><button class='btn btn-danger btn-sm'>Delete</button></td>" +
                         "</tr>";
                    }).join('');

                    $('#adminTableBody').html(adminRows);
                } else {
                    $('#adminTableBody').html("<tr><td colspan='7'>No admins found</td></tr>");
                }
            },
            error: function() {
                $('#adminTableBody').html("<tr><td colspan='7'>Error searching for admins</td></tr>");
            }
        });
    } else {
        $('#adminTableBody').html(initialTableContent); 
    }
});

    // Handle add admin form submission
    $('#addAdminForm').on('submit', function(e) {
        e.preventDefault();
        
        var username = $('#username').val().trim();
        var email = $('#email').val().trim();
        var password = $('#password').val().trim();
        var confirmPassword = $('#confirmpassword').val().trim();
        var image = $('#image')[0].files[0];
        var imageUrl = $('#imageUrl').val().trim();

        if (password !== confirmPassword) {
            alert('Passwords do not match!');
            return;
        }

        var formData = new FormData();
        formData.append('username', username);
        formData.append('email', email);
        formData.append('password', password);

        if (image) {
            formData.append('image', image);
        } else if (imageUrl) {
            formData.append('imageUrl', imageUrl);
        }

        $.ajax({
            url: 'php/addAdmin.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                try {
                    response = JSON.parse(response);
                    if (response.success) {
                        alert('Admin added successfully');
                        location.reload();
                    } else {
                        alert('Failed to add admin: ' + response.message);
                    }
                } catch (e) {
                    console.error('Failed to parse JSON response:', response);
                    alert('An error occurred while adding the admin');
                }
            },
            error: function(xhr, status, error) {
                alert('An error occurred while adding the admin');
                console.error(xhr.responseText);
            }
        });
    });

    $(document).on('click', '.editAdminBtn', function() {
        var userId = $(this).data('user-id');
        var username = $(this).data('username');
        var email = $(this).data('email');
        var imageUrl = $(this).data('image-url'); // Assuming you have an image URL stored
    
        $('#editAdminForm').data('user-id', userId);
        $('#editAdminUsername').val(username);
        $('#editAdminEmail').val(email);
        $('#editAdminImageUrl').val(imageUrl); // Set the image URL in the form
    });
    
    $('#editAdminImageToggle').on('change', function() {
        if ($(this).val() === 'upload') {
            $('#editAdminImageUploadDiv').show();
            $('#editAdminImageUrlDiv').hide();
        } else {
            $('#editAdminImageUploadDiv').hide();
            $('#editAdminImageUrlDiv').show();
        }
    });
    
    // Handle the form submission of admin update
    $('#editAdminForm').on('submit', function(event) {
        event.preventDefault();
    
        var userId = $(this).data('user-id');
        var formData = new FormData(this);
        formData.append('userId', userId);
    
        $.ajax({
            url: 'php/updateAdmin.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                try {
                    response = JSON.parse(response);
                    if (response.success) {
                        alert('Admin updated successfully');
                        location.reload();
                    } else {
                        alert('Failed to update admin: ' + response.message);
                    }
                } catch (e) {
                    console.error('Failed to parse JSON response:', response);
                    alert('Failed to update admin.');
                }
            },
            error: function(xhr, status, error) {
                alert('Error updating admin');
            }
        });
    });    

});