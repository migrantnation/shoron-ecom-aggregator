/**
 * Created by SHAWON on 04-07-17.
 */

var AddProduct = function () {

    var handleTogleSwitch = function () {
        $('.BSswitch').bootstrapSwitch('state', true);

        $('#CheckBoxValue').text();

        $('.BSswitch').on('switchChange.bootstrapSwitch', function () {
            var id = $(this).data("key");
            console.log(id);
            if ($(".BSswitch").bootstrapSwitch('state')) {
                console.log($('#variant_price-' + id));
                $('#variant_price-' + id).attr("required", "true");
                $('#variant_price-' + id).attr("aria-required", "true");

                $('#variant_quantity-' + id).attr("required", "true");
                $('#variant_quantity-' + id).attr("aria-required", "true");
            } else {
                $('#variant_price-' + id).removeAttr("required");
                $('#variant_price-' + id).removeAttr("aria-required");
                $('#variant_quantity-' + id).removeAttr("required");
                $('#variant_quantity-' + id).removeAttr("aria-required");
            }
        });

        $('.probeProbe').bootstrapSwitch('state', true);

        $('.probeProbe').on('switchChange.bootstrapSwitch', function (event, state) {

        });

        $('#toggleSwitches ').click(function () {
            $('.BSswitch ').bootstrapSwitch('toggleDisabled');
            if ($('.BSswitch ').attr('disabled')) {
                $(this).text('Enable All Switches ');
            } else {
                $(this).text('Disable All Switches ');
            }
        });
    }

    var handleAddProduct = function () {


        var appandedSection = function () {
            return '<div class="seefood row">' +
                '<div class="col-md-4">' +
                '<div class="">' +
                '<label class=" control-label">Option name:</label>' +
                '<div class="">' +
                '<input type="text" class="form-control attribute_name" placeholder="Name" name="attribute_name[]">' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="col-md-6">' +
                '<div class="">' +
                '<label class=" control-label">Option values:</label>' +
                '<div class="input-group">' +
                '<input type="text" class="form-control attribute_values"' +
                'placeholder="value" data-role="tagsinput"' +
                'name="attribute_values[]">' +
                '<span class="input-group-btn">' +
                '<button type="button" class="removeOne btn btn-danger pull-right">Remove </button>' +
                '</span>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>';
        };

        $(document).on("click", ".removeOne", function () {
            $(this).closest(".seefood").remove();
            set_values();
            create_variations();
        });

        $(function () {
            "use strict";
            var attribute_count = totalAttibute;
            $(document).on("click", ".removeAttr", function () {
                $(this).closest(".attribute").remove();
                attribute_count--;
                set_values();
                //create_variations();
                $("#attribute_message").html("");
            });

            $(document).on("click", "#newAttribute", function (e) {
                if (attribute_count < 2) {
                    e.preventDefault();

                    var attrElement = '<div class="attribute">'+
                    '<div class="attr-body row">'+
                    '<div class="col-sm-6">'+
                    '<div class="form-group">'+
                    '<label for="" class="control-label">Name</label>'+
                        '<input type="text" class="form-control attribute_name" placeholder="Attribute Name" name="attribute_name[]" required="required" aria-required="true">'+
                    '</div>'+
                    '</div>'+
                    '<div class="col-sm-6">'+
                    '<div class="form-group">'+
                    '<label for="" class="control-label">Value(s)</label>'+
                        '<input type="text" value="" data-role="tagsinput" class="form-control attribute_values" placeholder="" name="attribute_values[]" required>'+
                    '</div>'+
                    '</div>'+
                        '<div class="col-sm-12 margin-bottom-10">'+
                        '<a href="javascript:;" class="removeAttr text-danger">Remove</a>'+
                        '</div>'+
                    '</div>'+
                    '</div>';

                    $("#attributes").append(attrElement);
                    $('input[data-role="tagsinput"]').tagsinput('refresh');
                    attribute_count++;
                } else {
                    $("#attribute_message").html("You can create maximum <b>two attribute</b>");
                }
            });

        });


        var attribute_values = [];
        var attribute_name = [];

        $('#generate_variant').on('click', function () {
            set_values();
            create_variations();
            $('#recombination').val('1');
        })

        $('.attribute_name').on('blur', function () {
            // set_values();
            // create_variations();
        })

        $('.attribute_values').on('change', function () {
            // set_values();
            // create_variations();
        });

        $('#add_variation').on('click', function () {
            $.ajax({
                type: 'POST',
                url: baseUrl + '/admin/product/add-variation',
                data: {
                    "_token": csrfToken,
                    "product_id": $(this).data('product-id'),
                    "product_url": $(this).data('product-url')
                },
                success: function (data) {
                    $('#variationForm').html(data);
                    console.log(data);
                    slim_init();
                    handleTogleSwitch();
                    setValidationRules();
                }
            });
        });

        function setValidationRules() {
            $("#addVariationForm").validate({
                messages: {
                    product_id: "Please reload this page",
                    product_url: "Please reload this page",
                    attribute_value: "Please enter attribute value",
                    variant_price: "Please enter price",
                    variant_quantity: "Please enter product quantity",
                }
            });
        }

        $('#save_variation').on('click', function () {
            $.ajax({
                type: 'POST',
                url: baseUrl + '/admin/product/save-variation',
                data: {
                    "_token": csrfToken,
                    "variation_price": $('#variation_price').val(),
                    "variation_quantity": $('#variation_quantity').val(),
                    "variation_status": $('#variation_status').val(),
                },
                success: function (data) {

                }
            })
            ;

        });

        function set_values() {
            attribute_values = [];
            attribute_name = [];
            $('input[name^="attribute_name"]').each(function () {
                attribute_name.push($(this).val());
            });
            $('input[name^="attribute_values"]').each(function () {
                attribute_values.push($(this).val());
            });
        }

        function create_variations() {
            if (attribute_name[0] !== undefined && attribute_name[0] !== null && attribute_name[0] !== ""
                && attribute_values[0] !== undefined && attribute_values[0] !== null && attribute_values[0] !== "") {
                $.ajax({
                    type: 'POST',
                    url: baseUrl + '/admin/product/get-attribute-variations',
                    data: {
                        "_token": csrfToken,
                        "attribute_name": attribute_name,
                        "attribute_values": attribute_values
                    },
                    success: function (data) {
                        $("#variations").html(data);
                        $("#attribute_message").html("");

                        $(".make-switch").bootstrapSwitch();
                        slim_init();
                        handleTogleSwitch();
                    }
                });
            } else {
                $("#variations").html("");
                $("#attribute_message").html("Please enter attribute <b>Name</b> and <b>Value</b>");
            }
        }

    }

    return {
        //main function to initiate the module
        init: function () {
            handleAddProduct();
            handleTogleSwitch();
        }

    };


}();
jQuery(document).ready(function () {
    AddProduct.init();
});