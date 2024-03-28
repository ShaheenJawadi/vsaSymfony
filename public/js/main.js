(function($) {
    "use strict";
    var $window = $(window);
    $window.on('load', function(key, value) {


    });

    $(document).ready(function() {
        $.get('/auth/load/popup/login', function(response) {
            $('#authModel .modal-content').html(response);
        });

        $("#openForgetPws").on("click", function() {
            $.get('/auth/load/popup/reset_pws', function(response) {
                $('#authModel .modal-content').html(response);
            });
        });
        $("#openRegister").on("click", function() {
            $.get('/auth/load/popup/register', function(response) {
                $('#authModel .modal-content').html(response);
            });
        });



        $("#openLoginPopup").on("click", function() {
            $.get('/auth/load/popup/login', function(response) {
                $('#authModel .modal-content').html(response);
            });
        });

        /* *********************General popup****** */

        $("[openGeneralPopup]").on("click", function() {

            $.get($(this).data('link'), function(response) {
                $('#generalModel  .modal-content .general').html(response);
                $('#generalModel').modal('show');
            });
        });

        /* *********************End General popup****** */



        $("[dynamic-add]").on("click", function() {

            const parent = $(this).data('parent');

            $.get($(this).data('link'), function(response) {
                $(parent).append(response);
            });

        });


    })





})(jQuery);