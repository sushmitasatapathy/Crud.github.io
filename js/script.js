$(document).ready(function() {
    loadRecords();

    function loadRecords() {
        $.ajax({
            url: 'api.php',
            method: 'GET',
            dataType: 'json',
            data: { action: 'get_records' },
            beforeSend: function() {
                $('#loader').show();
            },
            success: function(response) {
                $('#loader').hide();

                if (response.error) {
                    $('#message').text(response.message);
                } else {
                    $('#message').text('');

                    if (response.records.length === 0) {
                        $('#records-table tbody').html('<tr><td colspan="4">No records available</td></tr>');
                    } else {
                        var rows = '';
                        $.each(response.records, function(index, record) {
                            rows += '<tr>';
                            rows += '<td>' + record.id + '</td>';
                            rows += '<td>' + record.name + '</td>';
                            rows += '<td>' + record.email + '</td>';
                            rows += '<td><a href="#" class="edit-btn" data-id="' + record.id + '">Edit</a> | <a href="#" class="delete-btn" data-id="' + record.id + '">Delete</a></td>';
                            rows += '</tr>';
                        });
                        $('#records-table tbody').html(rows);
                    }
                }
            },
            error: function() {
                $('#loader').hide();
                $('#message').text('Error occurred while loading records.');
            }
        });
    }

    // Insert record
    $('#insert-form').submit(function(e) {
        e.preventDefault();

        var name = $('#name').val();
        var email = $('#email').val();

        $.ajax({
            url: 'api.php',
            method: 'POST',
            dataType: 'json',
            data: {
                action: 'insert_record',
                name: name,
                email: email
            },
            beforeSend: function() {
                $('#loader').show();
            },
            success: function(response) {
                $('#loader').hide();

                if (response.error) {
                    $('#message').text(response.message);
                } else {
                    $('#message').text('Record inserted successfully.');

                    // Clear the form fields
                    $('#name').val('');
                    $('#email').val('');

                    // Refresh the records
                    loadRecords();
                }
            },
            error: function() {
                $('#loader').hide();
                $('#message').text('Error occurred while inserting the record.');
            }
        });
    });

    // Update record
    $('#records-table').on('click', '.edit-btn', function(e) {
        e.preventDefault();

        var id = $(this).data('id');
        var name = prompt('Enter the updated name:');
        var email = prompt('Enter the updated email:');

        if (name !== null && email !== null) {
            $.ajax({
                url: 'api.php',
                method: 'POST',
                dataType: 'json',
                data: {
                    action: 'update_record',
                    id: id,
                    name: name,
                    email: email
                },
                beforeSend: function() {
                    $('#loader').show();
                },
                success: function(response) {
                    $('#loader').hide();

                    if (response.error) {
                        $('#message').text(response.message);
                    } else {
                        $('#message').text('Record updated successfully.');

                        // Refresh the records
                        loadRecords();
                    }
                },
                error: function() {
                    $('#loader').hide();
                    $('#message').text('Error occurred while updating the record.');
                }
            });
        }
    });

    // Delete record
    $('#records-table').on('click', '.delete-btn', function(e) {
        e.preventDefault();

        var id = $(this).data('id');
        var confirmDelete = confirm('Are you sure you want to delete this record?');

        if (confirmDelete) {
            $.ajax({
                url: 'api.php',
                method: 'POST',
                dataType: 'json',
                data: {
                    action: 'delete_record',
                    id: id
                },
                beforeSend: function() {
                    $('#loader').show();
                },
                success: function(response) {
                    $('#loader').hide();

                    if (response.error) {
                        $('#message').text(response.message);
                    } else {
                        $('#message').text('Record deleted successfully.');

                        // Refresh the records
                        loadRecords();
                    }
                },
                error: function() {
                    $('#loader').hide();
                    $('#message').text('Error occurred while deleting the record.');
                }
            });
        }
    });
});
