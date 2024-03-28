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




        $("#generalModel .modal-content").load('../components/teacher/quiz/cours_quizz_popup.html')

    })




})(jQuery);