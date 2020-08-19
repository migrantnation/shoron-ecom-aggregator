/*
 * FRONT END CART MANAGEMENT PROCESS
 * */

var Cart = function () {

    var handleCart = function () {

        var appandedSection = function () {
            return '<div class="row">Dummy</div>';
        };

        $(document).on("click", ".removeOne", function () {

        });

        $(function () {
            "use strict";

            $(document).on("click", ".removeAttr", function () {

            });

            $(document).on("click", "#newAttribute", function (e) {

            })
        })

        $('#id_name').on('click', function () {

        })

        $('.class_name').on('blur', function () {

        })

        $('.class_name').on('change', function () {

        });

        $('#add_to_cart_btn').on('click', function () {
            check_product_required_information();
        });

        function check_product_required_information() {
            var checkPass = true;
            console.log('checking product required information...');

            $(".changeable").prop('disabled', true);
            for (var i = 0; i < attribute_array.length; i++) {
                console.log("attribute id for " + attribute_array[i] + ":" + selectedAttributeValues[attribute_array[i]]);
                if (selectedAttributeValues[attribute_array[i]] == undefined) {
                    $("#attribute-message-" + attribute_array[i]).html("Please select " + attribute_name[i] + " attribute");
                    checkPass = false;
                    $(".changeable").prop('disabled', false);
                    return;
                } else {
                    $("#attribute-message-" + attribute_array[i]).html("");
                }
            }

            if (checkPass) {
                add_to_cart();
            }
        }

        function add_to_cart() {
            console.log('adding product in your cart...');
            var productQuantity = $("#product_available_quantity").text();
            $.ajax({
                type: 'POST',
                url: baseUrl + '/pl-xhr/add-to-cart',
                data: {
                    "_token": csrfToken,
                    "selected_attribute_value": selectedAttributeValues,
                    "product_available_quantity": productQuantity,
                    "quantity": $("#product_quantity").val(),
                    "product_id": productId
                },
                success: function (data) {
                    jsonObj = JSON.parse(data);
                    console.log(jsonObj.meta.status);
                    console.log(jsonObj.response.mini_cart_view);
                    if (jsonObj.meta.status == '200') {
                        $('#header-mini-cart').html(jsonObj.response.mini_cart_view);
                        $('.cart-number').html(jsonObj.response.cart_total_item);
                        miniCart.init();
                        $('#CartModal').modal('show');
                    } else if (jsonObj.meta.status == '100') {
                        if (jsonObj.response.different_store == true) {
                            $('#CartMessage').modal('show');
                        }
                    }

                    $(".changeable").prop('disabled', false);

                }
            });
        }

        $(".qnt-btn-plus, .qnt-btn-minus").on('click', function () {

            var pQntInput = $(this).data("qntvalue"),
                qty = $(pQntInput).val(),
                availableQuantity = $(pQntInput).data("available-quantity");

            if ($(pQntInput).is(':disabled')) {
                console.log('disabled');
            } else {

                if ($(this).attr('data-operation') === 'add') {
                    qty++;
                } else {
                    qty--;
                }

                if (qty <= 0) {
                    qty = 1;
                }

                if (availableQuantity >= qty) {
                    $(pQntInput).val(qty);
                }

                update_and_calculate_price($(pQntInput));
            }

        });

        var givenQuantity = 0;
        $('.product-quantity ').on('change', function () {

            update_and_calculate_price($(this));

        });

        function update_and_calculate_price(element) {
            // this = element;
            productQuantity = $(element).data("available-quantity");
            pricePerPiece = $(element).data("price-per-piece");
            prevqty = $(element).data("prev-quantity");
            rowId = $(element).data("rowid");

            $(".changeable").prop('disabled', true);

            var qty = $(element).val();
            update_cart_item(qty, rowId);


            if (updateCartStatus == 200) {
                if (productQuantity < "" + $(element).val()) {
                    $(element).val(productQuantity);
                }
                var newqty = calculatePrice(prevqty, $(element).val(), pricePerPiece);
                $(element).data("prev-quantity", newqty);
            }
        }

        var updateCartStatus = 100;

        function update_cart_item(quantity, rowId) {
            $.ajax({
                type: 'POST',
                url: baseUrl + '/pl-xhr/update-cart',
                data: {
                    "_token": csrfToken,
                    "quantity": quantity,
                    "row_id": rowId
                },
                success: function (data) {
                    jsonObj = JSON.parse(data);
                    if (jsonObj.meta.status == '200') {
                        updateCartStatus = 200;
                        $('#header-mini-cart').html(jsonObj.response.mini_cart_view);
                        $('.cart-number').html(jsonObj.response.cart_total_item);
                        miniCart.init();
                    }
                    $(".changeable").prop('disabled', false);
                }
            });
        }

        function calculatePrice(prevqty, givenQuantity, pricePerPiece) {
            var totalPrice = parseInt($('#cart_view_total_price').text());
            var get_sub_total = 0;
            if (givenQuantity >= 0) {
                itemPrePrice = prevqty * pricePerPiece;
                totalPrice = totalPrice - itemPrePrice;
                get_sub_total = givenQuantity * pricePerPiece;
                totalPrice = get_sub_total + totalPrice;
                $('#cart_view_total_price').html(totalPrice);
            }
            return givenQuantity;
        }


        $('#clear_cart_the_add_to_cart').on('click', function (e) {
            $.ajax({
                type: 'POST',
                url: baseUrl + '/pl-xhr/clear-cart',
                data: {
                    "_token": csrfToken
                },
                success: function (data) {
                    jsonObj = JSON.parse(data);

                    if (jsonObj.meta.status == '200') {
                        // remove_cart_row(getClass);
                        $('#header-mini-cart').html(jsonObj.response.mini_cart_view);
                        $('.cart-number').html(jsonObj.response.cart_total_item);
                        add_to_cart();

                        $('#CartMessage').modal('hide');
                        miniCart.init();
                    }
                }
            });
        });

        $('.remove-cart-item').on('click', function (e) {
            var rowId = $(this).data("row-id");
            var reload = $(this).data("reload");
            $.ajax({
                type: 'POST',
                url: baseUrl + '/pl-xhr/remove-cart-item',
                data: {
                    "_token": csrfToken,
                    "row_id": rowId
                },
                success: function (data) {
                    jsonObj = JSON.parse(data);
                    console.log(jsonObj.meta.status);
                    console.log(jsonObj.response.mini_cart_view);
                    if (jsonObj.meta.status == '200') {
                        // remove_cart_row(getClass);
                        $('#header-mini-cart').html(jsonObj.response.mini_cart_view);
                        $('.cart-number').html(jsonObj.response.cart_total_item);
                        if (reload === true) {
                            location.reload();
                        }
                        miniCart.init();
                    }
                }
            });
        });

        function get_cart_information() {
            console.log('getting your mini cart view...');
            $.ajax({
                type: 'POST',
                url: baseUrl + '/pl-xhr/get-cart-info',
                data: {
                    "_token": csrfToken
                },
                success: function (data) {
                    jsonObj = JSON.parse(data);

                    if (jsonObj.response.status) {
                        $('#mini_cart').html(jsonObj.response.cart.mini_cart);
                    }
                }
            });
        }

    }

    return {
        //main function to initiate the module
        init: function () {
            handleCart();
        }
    };

}();

var miniCart = function () {

    var handleMiniCart = function () {

        $('.remove-cart-item').on('click', function (e) {
            var rowId = $(this).data("row-id");
            var reload = $(this).data("reload");
            $.ajax({
                type: 'POST',
                url: baseUrl + '/pl-xhr/remove-cart-item',
                data: {
                    "_token": csrfToken,
                    "row_id": rowId
                },
                success: function (data) {
                    jsonObj = JSON.parse(data);
                    console.log(jsonObj.meta.status);
                    console.log(jsonObj.response.mini_cart_view);
                    if (jsonObj.meta.status == '200') {
                        // remove_cart_row(getClass);
                        $('#header-mini-cart').html(jsonObj.response.mini_cart_view);
                        $('.cart-number').html(jsonObj.response.cart_total_item);
                        if ($(".cart-table").length) {
                            location.reload();
                        }
                    }
                    miniCart.init();
                }
            });
        });
    }

    return {
        //main function to initiate the module
        init: function () {
            handleMiniCart();
        }
    };

}();

$(document).ready(function () {
    Cart.init();
    miniCart.init();
});