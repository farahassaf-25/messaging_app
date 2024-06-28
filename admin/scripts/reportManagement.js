$(document).ready(function() {
    var currentViewButton = null;

    // disable delete reports initially
    $('#deleteSelectedReportsBtn').prop('disabled', true);

    // disable delete button in each row initially
    $('.deleteReportBtn').prop('disabled', true);

    // view report
    $(document).on('click', '.viewReportBtn', function() {
        var userId = $(this).data('report-id');
        var modal = $('#viewReportModal');
        var reportReason = $('#reportReason');
        currentViewButton = $(this); 

        console.log("View report clicked for user ID: " + userId);

        if (userId) {
            $.ajax({
                url: 'php/reportManagement/getReport.php',
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
                            currentViewButton.closest('tr').find('.deleteReportBtn').prop('disabled', false); // Enable delete button for this row
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

    // remove opacity class when the modal is closed
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

    // delete report
    $(document).on('click', '.deleteReportBtn', function() {
        reportIdToDelete = $(this).data('report-id');
        rowToDelete = $(this).closest('tr');
        $('#deleteConfirmationModal').modal('show');
    });

    // confirm delete
    $('#confirmDeleteBtn').on('click', function() {
        if (reportIdToDelete) {
            $.ajax({
                url: 'php/reportManagement/deleteReport.php',
                type: 'POST',
                data: { reportId: reportIdToDelete },
                success: function(response) {
                    try {
                        response = JSON.parse(response);
                        if (response.success) {
                            rowToDelete.remove();  
                            console.log('Report deleted successfully');
                            alert('Report deleted successfully.');
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
        $('#deleteConfirmationModal').modal('hide');

    });

    // select or deselect all checkboxes
    $('#selectAllReports').click(function () {
        $('.selectReportCheckbox').prop('checked', this.checked);
        $('#deleteSelectedReportsBtn').prop('disabled', !this.checked);
    });

    // update select all checkbox based on individual checkboxes and enable/disable delete button
    $(document).on('change', '.selectReportCheckbox', function () {
        const anyChecked = $('.selectReportCheckbox:checked').length > 0;
        $('#selectAllReports').prop('checked', $('.selectReportCheckbox:checked').length === $('.selectReportCheckbox').length);
        $('#deleteSelectedReportsBtn').prop('disabled', !anyChecked);
    });

    // delete selected reports on button click
    $('#confirmDeleteSelectedReportsBtn').click(function () {
        const selectedReports = $('.selectReportCheckbox:checked').map(function () {
            return $(this).val();
        }).get();

        // filter viewed and non-viewed reports
        const viewedReports = selectedReports.filter(function (reportId) {
            return $('input[value="' + reportId + '"]').closest('tr').find('.viewReportBtn').hasClass('viewed');
        });

        const notViewedReports = selectedReports.filter(function (reportId) {
            return !$('input[value="' + reportId + '"]').closest('tr').find('.viewReportBtn').hasClass('viewed');
        });

        if (viewedReports.length > 0) {
            $.ajax({
                url: 'php/reportManagement/deleteReports.php',
                type: 'POST',
                data: { report_ids: viewedReports },
                success: function (response) {
                    response = JSON.parse(response); 
                    if (response.success) {
                        viewedReports.forEach(function (reportId) {
                            $('input[value="' + reportId + '"]').closest('tr').remove();
                        });

                        $('#deleteSelectedReportsModal').modal('hide');
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                        
                        $('#selectAllReports').prop('checked', false);
                        $('#deleteSelectedReportsBtn').prop('disabled', true);
                        
                        let message = 'Viewed reports have been successfully deleted.';
                        if (notViewedReports.length > 0) {
                            message += ' Some reports could not be deleted because they were not viewed.';
                        }
                        alert(message);
                    } else {
                        alert('Error deleting reports: ' + (response.error || 'Unknown error'));
                    }
                },
                error: function () {
                    alert('Error deleting reports');
                }
            });
        } else {
            alert('No viewed reports selected');
        }
    });

    var initialTableContent = $('#reportsTableBody').html();

    // rearch report by ID, Reporter ID, or Reported ID
    $('#searchReport').on('input', function() {
        var searchTerm = $(this).val().trim();

        if (searchTerm) {
            $.ajax({
                url: 'php/reportManagement/searchReport.php',
                type: 'GET',
                data: { search_term: searchTerm },
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.success) {
                        var reports = response.reports;
                        var reportRows = reports.map(function(report) {
                            return "<tr>" +
                                "<td><input type='checkbox' class='selectReportCheckbox' value='" + report.report_id + "'></td>" +
                                "<td>" + report.report_id + "</td>" +
                                "<td>" + report.reporter_id + "</td>" +
                                "<td>" + report.reported_id + "</td>" +
                                "<td><button class='btn btn-secondary btn-sm viewReportBtn' data-bs-toggle='modal' data-bs-target='#viewReportModal' data-report-id='" + report.report_id + "'>View</button></td>" +
                                "<td><button class='btn btn-danger btn-sm deleteReportBtn' data-report-id='" + report.report_id + "' disabled>Delete</button></td>" +
                                "</tr>";
                        }).join('');

                        $('#reportsTableBody').html(reportRows);
                    } else {
                        $('#reportsTableBody').html("<tr><td colspan='6'>No reports found</td></tr>");
                    }
                },
                error: function() {
                    $('#reportsTableBody').html("<tr><td colspan='6'>Error searching for reports</td></tr>");
                }
            });
        } else {
            $('#reportsTableBody').html(initialTableContent); 
        }
    });
});
