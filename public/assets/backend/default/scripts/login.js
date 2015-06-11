var Login = function () {


    return {

        //main function to initiate the module
        init: function () {

            jQuery('#forget-password').click(function () {
                jQuery('#loginform').hide();
                jQuery('#forgotform').show(200);
            });

            jQuery('#forget-btn').click(function () {

                jQuery('#loginform').slideDown(200);
                jQuery('#forgotform').slideUp(200);
            });
        }

    };

}();