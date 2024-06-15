$(document).ready(function() {
    // Handle edit user button click
    $('.editUserBtn').on('click', function() {
        var userId = $(this).data('user-id');
        var username = $(this).data('username');
        var email = $(this).data('email');
        
        console.log("Edit user clicked for user ID: " + userId);

        // Populate the modal fields with the user data
        $('#editUserUsername').val(username);
        $('#editUserEmail').val(email);
    });

    // Handle view feedback button click
    $('.viewFeedbackBtn').on('click', function() {
        var userId = $(this).data('user-id');
        var modal = $('#viewFeedbackModal');
        var feedbackContent = $('#feedbackContent');

        console.log("View feedback clicked for user ID: " + userId);

        if (userId) {
            // Fetch feedback for the user
            $.ajax({
                url: 'php/getFeedback.php',
                type: 'GET',
                data: { userId: userId },
                success: function(response) {
                    console.log("Feedback response:", response);
                    try {
                        response = JSON.parse(response);
                        if (response.success) {
                            feedbackContent.text(response.feedback || 'No feedback available for this user.');
                            $('#deleteFeedbackBtn').data('feedback-id', response.feedback_id || '');
                        } else {
                            feedbackContent.text('Failed to load feedback: ' + response.message);
                        }
                    } catch (e) {
                        console.error('Parsing error:', e);
                        feedbackContent.text('Unexpected response from the server');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching feedback:', status, error);
                    feedbackContent.text('Error fetching feedback');
                }
            });
        } else {
            feedbackContent.text('No feedback available for this user.');
        }
    });


    var currentViewButton = null;
    // Handle view report button click
    $('.viewReportBtn').on('click', function() {
        var userId = $(this).data('report-id');
        var modal = $('#viewReportModal');
        var reportReason = $('#reportReason');
        currentViewButton = $(this); 

        console.log("View report clicked for user ID: " + userId);

        if (userId) {
            $.ajax({
                url: 'php/getReport.php',
                type: 'GET',
                data: { userId: userId },
                success: function(response) {
                    console.log("Report response:", response);
                    try {
                        response = JSON.parse(response);
                        if (response.success) {
                            reportReason.text(response.report || 'No report available for this user.');
                            $('#deleteReportBtn').data('report-id', response.report_id || '');
                            currentViewButton.addClass('viewed');
                            modal.modal('show');
                        } else {
                            reportReason.text('Failed to load report: ' + response.message);
                        }
                    } catch (e) {
                        console.error('Parsing error:', e);
                        reportReason.text('Unexpected response from the server');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching report:', status, error);
                    reportReason.text('Error fetching report');
                }
            });
        } else {
            reportReason.text('No report available for this user.');
        }
    });

    // Remove opacity class when the modal is closed
    $('#viewReportModal').on('hidden.bs.modal', function() {
        if(currentViewButton) {
            currentViewButton.addClass('viewed');
        }
    });

    $('#cancelReportBtn').on('click', function() {
        $('#viewReportModal').modal('hide');
    });

    var reportIdToDelete = null;
    var rowToDelete = null;

    // Handle delete report button click
    $(document).on('click', '.deleteReportBtn', function() {
        reportIdToDelete = $(this).data('report-id');
        rowToDelete = $(this).closest('tr');

        // Show the confirmation modal
        $('#deleteConfirmationModal').modal('show');
    });

    // Handle confirm delete button click
    $('#confirmDeleteBtn').on('click', function() {
        if (reportIdToDelete) {
            $.ajax({
                url: 'php/deleteReport.php',
                type: 'POST',
                data: { reportId: reportIdToDelete },
                success: function(response) {
                    try {
                        response = JSON.parse(response);
                        if (response.success) {
                            rowToDelete.remove();  // Remove the row from the table
                            console.log('Report deleted successfully');
                        } else {
                            console.error('Failed to delete report: ' + response.message);
                        }
                    } catch (e) {
                        console.error('Parsing error:', e);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error deleting report:', status, error);
                }
            });
        }

        // Hide the confirmation modal
        $('#deleteConfirmationModal').modal('hide');
    });




    var userIdToDelete = null;

    // Handle delete user button click
    $('.deleteUserBtn').on('click', function() {
        userIdToDelete = $(this).data('user-id');
        rowToDelete.remove(); // Store reference to the row

        var modal = $('#deleteConfirmationUserModal');
        var modalBody = modal.find('.modal-body');

        // Clear previous messages
        modalBody.text('Loading...');

        $.ajax({
            url: 'php/checkUserStatus.php',
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

                        // Show the modal
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

    // Handle confirm delete button click
    $('#confirmUserDeleteBtn').on('click', function() {
        if (userIdToDelete) {
            $.ajax({
                url: 'php/deleteUser.php',
                type: 'POST',
                data: { userId: userIdToDelete },
                success: function(response) {
                    try {
                        response = JSON.parse(response);
                        if (response.success) {
                            // Remove the row from the table
                            $('#user-' + userIdToDelete).remove();

                            // Hide the modal
                            $('#deleteConfirmationUserModal').modal('hide');
                            rowToDelete.remove(); 
                            // alert('User deleted successfully.');
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

    // Handle delete feedback button click
    // var currentdeleteFeedbackButton = null;
    $('#deleteFeedbackBtn').on('click', function() {
        var feedbackId = $(this).data('feedback-id');
        // currentdeleteFeedbackButton = $(this);

        if (feedbackId) {
            if (confirm('Are you sure you want to delete this feedback?')) {
            $.ajax({
                url: 'php/deleteFeedback.php',
                type: 'POST',
                data: { feedbackId: feedbackId },
                success: function(response) {
                    console.log("Delete feedback response:", response);
                    try {
                        response = JSON.parse(response);
                        if (response.success) {
                             // Feedback deleted successfully
               $('#feedbackContent').text('Feedback deleted successfully.');
               // Close the modal (optional)
               $('#viewFeedbackModal').modal('hide');

               // Update the user table based on feedbackButtonClass
               var feedbackButtonClass = response.feedbackButtonClass || '';
               if (feedbackButtonClass) {
                   $('#user-' + feedbackId + ' .viewFeedbackBtn').addClass(feedbackButtonClass);
               }
                            alert('Feedback deleted successfully.');
                            location.reload();
                        } else {
                            $('#feedbackContent').text('Failed to delete feedback: ' + response.message);
                        }
                    } catch (e) {
                        console.error('Parsing error:', e);
                        $('#feedbackContent').text('An error occurred. Please try again later.');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX error:', textStatus, errorThrown);
                    $('#feedbackContent').text('An error occurred. Please try again later.');
                }
            });
        }
    } else {
        console.error('Missing feedback ID');
    }
});
    
});



