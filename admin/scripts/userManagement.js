$(document).ready(function() {
    // updtae user btn click
    $('.editUserBtn').on('click', function() {
        var userId = $(this).data('user-id');
        var username = $(this).data('username');
        var email = $(this).data('email');

        $('#editUserForm').data('user-id', userId);
        $('#editUserUsername').val(username);
        $('#editUserEmail').val(email);
    });

    //user update
    $('#editUserForm').on('submit', function(event) {
        event.preventDefault();

        var userId = $(this).data('user-id');
        var username = $('#editUserUsername').val();
        var email = $('#editUserEmail').val();
        var status = $('#editUserStatus').val();
        var type = (status === 'active') ? 0 : 1;

        $.ajax({
            url: 'php/userManagement/updateUser.php',
            type: 'POST',
            data: {
                userId: userId,
                username: username,
                email: email,
                type: type
            },
            success: function(response) {
                response = JSON.parse(response);
                if (response.success) {
                    alert('User updated successfully');
                    location.reload();
                } else {
                    alert('Failed to update user: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                alert('Error updating user');
            }
        });
    });

    var userIdToDelete = null;
    var rowToDelete = null;

    // delete user 
    $('.deleteUserBtn').on('click', function() {
        userIdToDelete = $(this).data('user-id');
        rowToDelete = $(this).closest('tr');

        var modal = $('#deleteConfirmationUserModal');
        var modalBody = modal.find('.modal-body');

        // clear previous messages
        modalBody.text('Loading...');

        $.ajax({
            url: 'php/userManagement/checkUserStatus.php',
            type: 'GET',
            data: { userId: userIdToDelete },
            success: function(response) {
                try {
                    response = JSON.parse(response);
                    if (response.success) {
                        var message = "This user ";
                        if (response.hasReport && response.hasFeedback) {
                            message += "has reports and feedback.";
                        } else if (response.hasReport) {
                            message += "has reports.";
                        } else if (response.hasFeedback) {
                            message += "has feedback.";
                        } else {
                            message += "has no reports or feedback.";
                            $('#confirmUserDeleteBtn').prop('disabled', false);
                        }
                        modalBody.text(message);
                        modal.modal('show');
                    } else {
                        modalBody.text('Error checking user status: ' + response.message);
                    }
                } catch (e) {
                    console.error('Parsing error:', e);
                    modalBody.text('Unexpected response from the server');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error checking user status:', status, error);
                modalBody.text('Error checking user status');
            }
        });
    });

    // confirm delete
    $('#confirmUserDeleteBtn').on('click', function() {
        if (userIdToDelete) {
            $.ajax({
                url: 'php/userManagement/deleteUser.php',
                type: 'POST',
                data: { userId: userIdToDelete },
                success: function(response) {
                    try {
                        response = JSON.parse(response);
                        if (response.success) {
                            rowToDelete.remove();
                            $('#deleteConfirmationUserModal').modal('hide');
                            alert('User deleted successfully.');
                            $('.modal-backdrop').remove();
                            $('body').removeClass('modal-open');
                            $('body').css('padding-right', '');
                        } else {
                            alert('Error deleting user: ' + response.message);
                        }
                    } catch (e) {
                        console.error('Parsing error:', e);
                        alert('Unexpected response from the server');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error deleting user:', status, error);
                    alert('Error deleting user.');
                }
            });
        } else {
            alert('No user selected to delete.');
        }
    });

    function toggleDeleteButton() {
        if ($('.selectUserCheckbox:checked').length > 0) {
            $('#deleteSelectedUsersBtn').prop('disabled', false);
        } else {
            $('#deleteSelectedUsersBtn').prop('disabled', true);
        }
    }

    $('#selectAll').on('click', function() {
        $('.selectUserCheckbox').prop('checked', this.checked);
        toggleDeleteButton();
    });

    $(document).on('change', '.selectUserCheckbox', function() {
        toggleDeleteButton();
        if ($('.selectUserCheckbox:checked').length === $('.selectUserCheckbox').length) {
            $('#selectAll').prop('checked', true);
        } else {
            $('#selectAll').prop('checked', false);
        }
    });

    $('#confirmDeleteSelectedUsersBtn').on('click', function() {
        var selectedUsers = [];
        $('.selectUserCheckbox:checked').each(function() {
            selectedUsers.push($(this).val());
        });

        if (selectedUsers.length > 0) {
            $.ajax({
                url: 'php/userManagement/deleteUsers.php',
                type: 'POST',
                data: { userIds: selectedUsers },
                dataType: 'json',
                success: function(response) {
                    let message = '';
                    let successMessage = '';
                    let issueMessage = 'Some users could not be deleted because:\n';

                    if (response.success) {
                        if (Array.isArray(response.deletedUsers) && response.deletedUsers.length > 0) {
                            response.deletedUsers.forEach(function(userId) {
                                $('.selectUserCheckbox[value="' + userId + '"]').closest('tr').remove();
                            });
                            successMessage = 'Users deleted successfully.\n';
                        }

                        let issueDetails = response.issueDetails;
                        if (Array.isArray(issueDetails.usersWithFeedback) && issueDetails.usersWithFeedback.length > 0) {
                            issueMessage += '- They have feedback.\n';
                        }
                        if (Array.isArray(issueDetails.usersWithReports) && issueDetails.usersWithReports.length > 0) {
                            issueMessage += '- They have made reports.\n';
                        }
                        if (Array.isArray(issueDetails.usersReportedByOthers) && issueDetails.usersReportedByOthers.length > 0) {
                            issueMessage += '- They are reported by others.\n';
                        }

                        if (issueMessage !== 'Some users could not be deleted because:\n') {
                            message = successMessage + issueMessage;
                        } else {
                            message = successMessage;
                        }
                    } else {
                        message = 'Error deleting users: ' + response.message;
                    }

                    alert(message);
                    $('#deleteUsersModal').modal('hide'); 
                    toggleDeleteButton(); 
                },
                error: function(xhr, status, error) {
                    console.error('Error deleting users:', status, error);
                    console.log(xhr.responseText); 
                    alert('Error deleting users: ' + status + ' ' + error);
                }
            });
        } else {
            alert('No users selected to delete.');
        }
    });

    var initialTableContent = $('#userTableBody').html();

    // search user by ID, Name, or Email
    $('#searchUser').on('input', function() {
        var searchTerm = $(this).val().trim();

        if (searchTerm) {
            $.ajax({
                url: 'php/userManagement/searchUser.php',
                type: 'GET',
                data: { search_term: searchTerm },
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.success) {
                        var users = response.users;
                        var userRows = users.map(function(user) {
                            return "<tr>" +
                                "<td><input type='checkbox' class='selectUserCheckbox' value='" + user.id + "'></td>" +
                                "<td>" + user.id + "</td>" +
                                "<td>" + user.name + "</td>" +
                                "<td>" + user.email + "</td>" +
                                "<td><button class='btn btn-success btn-sm editUserBtn' data-bs-toggle='modal' data-bs-target='#editUserModal' data-user-id='" + user.id + "' data-username='" + user.name + "' data-email='" + user.email + "'>Update</button></td>" +
                                "<td><button class='btn btn-sm viewFeedbackBtn " + (user.feedback_exists ? 'btn-secondary' : 'btn-secondary opacity-50') + "' data-bs-toggle='modal' data-bs-target='#viewFeedbackModal' data-user-id='" + user.id + "'>View</button></td>" +
                                "<td><button class='btn btn-danger btn-sm deleteUserBtn' data-user-id='" + user.id + "' data-bs-toggle='modal' data-bs-target='#deleteConfirmationUserModal'>Delete</button></td>" +
                                "</tr>";
                        }).join('');

                        $('#userTableBody').html(userRows);
                    } else {
                        $('#userTableBody').html("<tr><td colspan='7'>No users found</td></tr>");
                    }
                },
                error: function() {
                    $('#userTableBody').html("<tr><td colspan='7'>Error searching for users</td></tr>");
                }
            });
        } else {
            $('#userTableBody').html(initialTableContent); 
        }
    });
});