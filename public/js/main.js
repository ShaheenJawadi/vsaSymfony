(function($) {
    "use strict";
    var $window = $(window);
    $window.on('load', function(key, value) {


    });

    $(document).ready(function() {

        var cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        displayCartItems();

        $(".add-to-cart").click(function() {
            var product = $(this).closest(".product");
            var id = product.data("id");
            var name = product.data("name");
            var price = parseFloat(product.data("price"));
            var quantity = 1;

            var existingItem = $("#cart-items li[data-id='" + id + "']");
            if (existingItem.length) {
                quantity = parseInt(existingItem.data("quantity")) + 1;
                existingItem.data("quantity", quantity);
                existingItem.find(".quantity").text(quantity);
            } else {
                var image = product.data("image");
                $("#cart-items").append("<li data-id='" + id + "' data-name='" + name + "' data-price='" + price + "' data-quantity='" + quantity + "'><div class='product-info'><div class='product-image'><img src='" + image + "' alt='" + name + "'></div><div><h4>" + name + "</h4><p class='prix'><span>Prix:</span>" + price + " DT</p><input type='number' min='1' value='" + quantity + "' class='quantity-input'> <button class='remove'> <i class='fa-solid fa-trash'></i></button></div></div></li>");
            }

            saveCartItems();
        });

        $(".remove").click(function() {
            $(this).closest("li").remove();
            saveCartItems();
        });

        $(".quantity-input").change(function() {
            var newQuantity = parseInt($(this).val());
            if (newQuantity < 1) {
                $(this).val(1);
                newQuantity = 1;
            }
            $(this).closest("li").data("quantity", newQuantity);
            $(this).closest("li").find(".quantity").text(newQuantity);
            saveCartItems();
        });

        $("#checkout").click(function() {});

        function displayCartItems() {
            $("#cart-items").empty();
            for (var i = 0; i < cartItems.length; i++) {
                var item = cartItems[i];
                $("#cart-items").append("<li data-id='" + item.id + "' data-name='" + item.name + "' data-price='" + item.price + "' data-quantity='" + item.quantity + "'><div class='product-info'><div class='product-image'><img src='" + item.image + "' alt='" + item.name + "'></div><div><h4>" + item.name + "</h4><p class='prix'><span>Prix:</span>" + item.price + " DT</p><input type='number' min='1' value='" + item.quantity + "' class='quantity-input'> <button class='remove'> <i class='fa-solid fa-trash'></i></button></div></div></li>");
            }
        }

        function saveCartItems() {
            var items = [];
            $("#cart-items li").each(function() {
                var item = {
                    id: $(this).data("id"),
                    name: $(this).data("name"),
                    price: $(this).data("price"),
                    quantity: $(this).data("quantity"),
                    image: $(this).find('.product-image img').attr('src')
                };
                items.push(item);
            });
            localStorage.setItem('cartItems', JSON.stringify(items));
            cartItems = items;
        }


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


    $(document).on('click', '#openReg', function() {

        $.get('/auth/load/popup/register', function(response) {
            $('#authModel .modal-content').html(response);
        });
    });

    $(document).on('click', '#openForgetPws', function() {

        $.get('/auth/load/popup/reset_pws', function(response) {
            $('#authModel .modal-content').html(response);
        });
    });


    $(document).on('click', '#openLoginPopup , #openLogin', function() {

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
        $('.form-control').removeClass('error');

        $.ajax({
            method: "POST",
            url: $(this).prop('action'),
            data: new FormData(this),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {

                if (data.success) {
                    // Redirect to the route returned by the server
                    window.location.href = data.route;
                }

            },
            error: function(data) {
                var response = data.responseJSON;
                var errors = response.errors;




                $.each(errors, function(key, value) {
                    if (Array.isArray(value)) {
                        for (var i = 0; i < value.length; i++) {
                            $('[name="' + key + '[]"]').eq(i).addClass('error');

                        }

                    } else {
                        $('[name="' + key + '"]').addClass('error');
                    }
                    // $('[name="' + key + '"]').addClass('error');
                });
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