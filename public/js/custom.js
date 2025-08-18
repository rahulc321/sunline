$(document).on('submit', '#followUpForm', function(e) {
    e.preventDefault(); // stop normal form submission

    let formData = $(this).serialize(); // serialize form fields

    $.ajax({
        url: '/save-follow-up',   // 🔹 change this to your backend route
        type: 'POST',
        data: formData,
        success: function(response) {
            // show success message
            alert('Follow-up saved successfully!');
            
            // close modal
            $('#createFollowUpModal').modal('hide');

            // optional: reset form
            $('#followUpForm')[0].reset();

            // optional: refresh table/list of follow-ups
            // loadFollowUps();
        },
        error: function(xhr) {
            // handle validation or server errors
            alert('Error: ' + (xhr.responseJSON?.message ?? 'Something went wrong'));
        }
    });
});
