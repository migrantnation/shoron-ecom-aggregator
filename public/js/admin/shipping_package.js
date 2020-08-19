var ShippingPackage = function () {

    var handleShippingPackage = function () {

        $('.attribute_name').on('blur', function () {
            // set_values();
            // create_variations();
        })

        $('.attribute_values').on('change', function () {
            // set_values();
            // create_variations();
        });

        $('#from_city_id').on("change input", function () {
            get_location();
        });

        $(document).ready(function () {
            get_location();
        });

        function get_location() {
            var city_id = $("#from_city_id").val();
            if (city_id > 0) {
                $.ajax({
                    type: 'POST',
                    url: baseUrl + "/admin/lp/get-location-by-city-id",
                    data: {
                        "_token": csrfToken,
                        "city_id": city_id
                    },
                    success: function (data) {
                        $("#location_tree").html(data);
                        location_tree_for_package();
                        $("#location_div").show();
                        checkSelected();
                    }
                });
            }
            else {
                $("#location_div").hide();
            }
        }



        $("#add_more").on("click", function () {
            $('#package_weight_price  tbody').append(
                '<tr class="weight-price">' +
                '<td>' +
                '<input type="text" class="form-control numeric error required" placeholder="Min Weight"' +
                ' name="min_weight[]" value="" required="required" aria-required="true">' +
                '</td>' +
                '<td>' +
                '<input type="text" class="form-control numeric error required" placeholder="Max Weight" data-key=""' +
                'name="max_weight[]"  required="required" aria-required="true" value="">' +
                '</td>' +
                '<td>' +
                '<input type="text" class="form-control numeric error required" placeholder="Price" data-key=""' +
                'required="required" aria-required="true" value="" name="price[]">' +
                '</td>' +
                '<td><a href="javascript:;" class="remove-pkg-weight-price">Remove</a></td>' +
                '</tr>');
            set_remove_btn();
        });

        function set_remove_btn() {
            $(".remove-pkg-weight-price").on("click", function () {
                $(this).closest(".weight-price").remove();
            });
        }


        $(document).ready(function () {
            //called when key is pressed in textbox
            $(".numeric").keypress(function (e) {
                return isFloat(e);
            });
        });

        function isFloat(evt) {
            var charCode = (event.which) ? event.which : event.keyCode;
            if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            } else {
                //if dot sign entered more than once then don't allow to enter dot sign again. 46 is the code for dot sign
                var parts = evt.srcElement.value.split('.');
                if (parts.length > 1 && charCode == 46) {
                    return false;
                }
                return true;
            }
        }

    }

    return {
        //main function to initiate the module
        init: function () {
            handleShippingPackage();
        }

    };


}();
jQuery(document).ready(function () {
    ShippingPackage.init();
});