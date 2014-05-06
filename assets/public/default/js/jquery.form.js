$(function() {
    // These first three lines of code compensate for Javascript being turned on and off. 
    // It simply changes the submit input field from a type of "submit" to a type of "button".

    var paraTag = $('input#submit').parent('p');
    $(paraTag).children('input').remove();
    $(paraTag).append('<input type="button" name="submit" id="submit" value="Send" />');

    $('#contact-form input#submit').click(function() {
        $('#contact-form').append('<img src="images/ajax-loader.gif" class="loaderIcon" alt="Loading..." />');

        var name = $('input#name').val();
        var email = $('input#email').val();
        var comments = $('textarea#comments').val();

        $.ajax({
            type: 'post',
            url: 'sendEmail.php',
            data: 'name=' + name + '&email=' + email + '&comments=' + comments,

            success: function(results) {
                $('#contact-form img.loaderIcon').fadeOut(1000);
                $('#response').html(results);
            }
        }); // end ajax
    });
});
		