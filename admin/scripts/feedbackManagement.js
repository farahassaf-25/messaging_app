$(document).ready(function() {

    // view feedback
    $('.viewFeedbackBtn').on('click', function() {
        var userId = $(this).data('user-id');
        var modal = $('#viewFeedbackModal');
        var feedbackContent = $('#feedbackContent');

        console.log("View feedback clicked for user ID: " + userId);

        if (userId) {
            // fetch feedback for the user
            $.ajax({
                url: 'php/feedbackManagement/getFeedback.php',
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

    // delete feedback
    $('#deleteFeedbackBtn').on('click', function() {
        var feedbackId = $(this).data('feedback-id');

        if (feedbackId) {
            $.ajax({
                url: 'php/feedbackManagement/deleteFeedback.php',
                type: 'POST',
                data: { feedbackId: feedbackId },
                success: function(response) {
                    console.log("Delete feedback response:", response);
                    try {
                        response = JSON.parse(response);
                        if (response.success) {
                            $('#feedbackContent').text('Feedback deleted successfully.');
                            $('#viewFeedbackModal').modal('hide'); 
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
        } else {
            console.error('Missing feedback ID');
        }
    });
});
