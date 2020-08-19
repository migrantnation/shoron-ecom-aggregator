var Checkout = function () {

    var handleCheckout = function () {

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

        $('#submit_shipping_form').on('click', function () {

            $('#checkout_processing').show();
            $('#loading_message').html("Sending verification code");

            $.ajax({
                type: 'POST',
                url: baseUrl + '/pl-xhr/send-mobile-verification-code',
                data: {
                    "_token": csrfToken,
                    "contact_number": $("#contact_number").val(),
                    "logistic_partner": $('input[name=logistic_partner]:checked', '#shippingForm').val()
                },
                success: function (data) {
                    jsonObj = JSON.parse(data);

                    if (jsonObj.meta.status == 200) {

                        $('#contact_number_form').hide();
                        $('#verification_form').show();
                        $(".contact_number_value").html(jsonObj.response.contact_number_value);

                    } else {

                        $("#logistic_partner_message").html(jsonObj.response.message[0]);
                        $("#contact_number_message").html(jsonObj.response.message[1]);
                        $("#form_message").html(jsonObj.response.message);

                    }

                    setTimeout(function () {
                        $('#checkout_processing').hide();
                    }, 200);

                }
            });
        });

        $('#submit_verification_code').on('click', function () {

            $('#checkout_processing').show();
            $('#loading_message').html("Sending verification code");

            $.ajax({
                type: 'POST',
                url: baseUrl + '/pl-xhr/submit-mobile-verification-code',
                data: {
                    "_token": csrfToken,
                    "varification_code": $("#varification_code").val()
                },
                success: function (data) {
                    jsonObj = JSON.parse(data);

                    if (jsonObj.meta.status == 200) {
                        $('#contact_number_form').hide();
                        $('#verification_form').show();
                        $(".contact_number_value").html(jsonObj.response.contact_number_value);
                    }

                    setTimeout(function () {
                        $('#checkout_processing').hide();
                    }, 500);

                }
            });
        });


        function get_Checkout_information() {

            $(".changeable").prop('disabled', true);
            $("#product_core_detail").show();

            $.ajax({
                type: 'POST',
                url: baseUrl + '/pl-xhr/get-product-info',
                data: {
                    "_token": csrfToken,
                    "product_id": productId,
                    "product_url": productUrl,
                    "selected_attribute_value": selectedAttributeValues
                },
                success: function (data) {
                    jsonObj = JSON.parse(data);

                    if (jsonObj.response.product_info.quantity) {
                        var quantity = jsonObj.response.product_info.quantity;
                        $('.quantity').html(jsonObj.response.product_info.quantity);
                        $('.quantity').data("quantity", jsonObj.response.product_info.quantity);
                        productQuantity = jsonObj.response.product_info.quantity;
                        $("#product_quantity").attr({
                            "max": jsonObj.response.product_info.quantity,
                            "min": 1,
                            "value": 1
                        });

                        $("#product_quantity").val(1);
                    }

                    if (jsonObj.response.product_info.base_price) {
                        productPrice = jsonObj.response.product_info.base_price;
                        $('.d-price').html('TK <span id="product_price" data-product-price="' + productPrice + '">' + productPrice + '</span>');
                        productPrice = jsonObj.response.product_info.base_price;
                    }

                    $('.gc-display-display').attr("src", jsonObj.response.image);
                    $('#base_sku').html(jsonObj.response.product_info.base_sku);
                    // $('.c-price').html(jsonObj.response.product_info.base_price);

                    setTimeout(function () {
                        $(".changeable").prop('disabled', false);

                        $("#product_core_detail").hide();
                    }, 500);

                }
            });
        }

    }


    return {
        //main function to initiate the module
        init: function () {
            handleCheckout();
        }
    };

}();

$(document).ready(function () {
    Checkout.init();
});