/**
 * Created by SHAWON on 04-07-17.
 */

var Product = function () {

    var handleProduct = function () {

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

        var productPrice = 0;
        var productQuantity = 0;

        $(document).on("load", function () {
            productPrice = $("#product_price").data("product-price");
            productQuantity = $("#product_quantity").data("product-quantity");
        });

        function get_product_information() {

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

        $('.attributeValue').on('click', function () {
            var attribute = $(this).data('attribute');
            var attributeValue = $(this).data('attribute-value');
            selectedAttributeValues["" + attribute] = attributeValue;

            get_product_information();
        });

        var givenQuantity = 0;
        $('#product_quantity').on('input', function () {

            $(".changeable").prop('disabled', true);
            productQuantity = $("#product_available_quantity").data("quantity");
            if (productQuantity < "" + $(this).val()) {
                $(this).val(productQuantity);
            }
            givenQuantity = $(this).val();
            calculatePrice();

            $(".changeable").prop('disabled', false);
        });

        function calculatePrice() {
            if (givenQuantity != 0) {
                productPrice = $("#product_price").data("product-price");
                var totalPrice = givenQuantity * productPrice;
                $('.total_price').html('TK ' + totalPrice);
            }
        }
    }


    return {
        //main function to initiate the module
        init: function () {
            handleProduct();
        }
    };

}();
$(document).ready(function () {
    Product.init();
});