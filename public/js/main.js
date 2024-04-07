(function($) {
    "use strict";
    var $window = $(window);
    $window.on('load', function(key, value) {


    });

    $(document).ready(function() {



        $.get('/auth/load/popup/login', function(response) {
            $('#authModel .modal-content').html(response);
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



    $(document).on('click', '#openRegister', function() {


        $.get('/auth/load/popup/register', function(response) {
            $('#authModel .modal-content').html(response);
        });
    });



    $(document).on('click', '#openForgetPws', function() {

        $.get('/auth/load/popup/reset_pws', function(response) {
            $('#authModel .modal-content').html(response);
        });
    });


    $(document).on('click', '#openLoginPopup', function() {

        $.get('/auth/load/popup/login', function(response) {
            $('#authModel .modal-content').html(response);
        });



    });








    $(document).on('click', '.delete_lesson', function() {

        $(this).closest('.single').remove();
    });

    $(document).on('click', '.toggle_edit_comment', function() {

        $(this).closest('.single_comment').addClass('add');
    });


    $(document).on('submit', "[ajaxForm]", function(e) {

        e.preventDefault();
        var $this = $(this).parent();


        $.ajax({
            method: "POST",
            url: $(this).prop('action'),
            data: new FormData(this),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {

                alert('suuc')

            },
            error: function(request, status, error) {
                alert('error')
            }

        });



    });


    $(document).on('mouseover', '.header .nav-item.dropdown .single_item', function() {

        $(this).find('.subcategories').addClass('show');
    });
    $(document).on('mouseout', '.header .nav-item.dropdown .single_item', function() {

        $(this).find('.subcategories').removeClass('show');
    });

})(jQuery);