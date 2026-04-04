$(document).ready(function() {
    
    $('#addCourse').click(function() {
        var newRow = $('.row').first().clone();
        newRow.find('input').val('');
        newRow.append(`
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm remove-row">X</button>
            </div>
        `);
        $('#courses').append(newRow);
    });
    
    $(document).on('click', '.remove-row', function() {
        $(this).closest('.row').remove();
    });
    
    $('#gpaForm').submit(function(e) {
        e.preventDefault(); 
        
        var formData = $(this).serialize();
        
        $.ajax({
            url: 'calculate.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(data) {
            
                $('#result').html(`
                    <div class="alert alert-success mt-3">
                        <h3>GPA: ${data.gpa}</h3>
                        <p>${data.interpretation}</p>
                        ${data.table}
                    </div>
                `);
            }
        });
    });
});
