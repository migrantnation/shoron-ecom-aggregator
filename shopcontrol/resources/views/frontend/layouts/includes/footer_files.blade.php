
<!--/
# Javascript /-->

<!-- Plugins -->
<script src="{{url('public/assets')}}/js/owl.carousel.min.js"></script>
<script src="{{url('public/assets')}}/js/jquery.glasscase.min.js"></script>
<script src="{{url('public/assets')}}/js/jquery.rateyo.min.js"></script>

<!--Bootstrap-->
<script src="{{url('public/assets')}}/js/bootstrap.min.js"></script>

<!-- Init -->
<script src="{{url('public/assets')}}/js/init.js"></script>

<script>

    $(document).ready(function () {
        var mainSearchForm = $('.main-search-form');
        $(mainSearchForm).keyup(function () {
            showSearchListModal();
        });
        $(mainSearchForm).focus(function (e) {
            e.stopPropagation();
            showSearchListModal();
        });

        $(mainSearchForm).on('click', function (e) {
            e.stopPropagation();
            showSearchListModal();
        });
        function showSearchListModal() {
            $('.search-result-mini').show();
            if (mainSearchForm.val() !== '') {
                $('.search-list').show();
                $('.search-list.alt').hide();
                $('.read-more .plxKeyword').text(mainSearchForm.val());
                if ($('#myUL > li:visible').length === 0) {
                    $('#myUL').hide();
                }
            } else {
                $('.search-list').hide();
                $('.read-more').hide();
                $('.search-list.alt').show();
            }
        }

        $(document).on('click', function (e) {
            var searchResult = $('.search-result-mini');
            if (!searchResult.is(e.target) && searchResult.has(e.target).length === 0) {
                searchResult.hide();
            }
        })
    });
    function myFunction() {
        // Declare variables
        var input, filter, ul, li, a, i;
        input = document.getElementById('myInput');
        var res = input.value.charAt(0);
        if (res == '#') {
            $("#myUL").addClass('hidden');
        } else {
            $("#myUL").removeClass('hidden');
            filter = input.value.toUpperCase();
            ul = document.getElementById("myUL");
            li = ul.getElementsByTagName('li');
            // Loop through all list items, and hide those who don't match the search query
            for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByTagName("a")[0];
                if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";
                }
            }
        }
    }
    $('.main-search-form').one("click", function (e) {
        $.ajax({
            type: 'post',
            url: '{{route('frontend.search.datalist')}}',
            data: {
                '_token': "{{csrf_token()}}",
            },
            dataType: 'json',
            success: function (data) {
                $("#myUL").empty();
                $("#myUL").html(data);
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });


    $(document).on("click", '.removeBtn', function (e) {
        var rowId = $(this).data('rowid');
        var li = $(this).closest('li');
        $.ajax({
            type: 'post',
            url: '{{route('frontend.search.deleteRow')}}',
            data: {
                '_token': "{{csrf_token()}}",
                'row_id': rowId,
            },
            dataType: 'json',
            success: function (data) {
                $(li).remove();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });

</script>

<script src="{{url('public/admin_ui_assets')}}/global/scripts/tree.js" type="text/javascript"></script>

<script src="{{url('public/assets')}}/js/jquery.toast.js"></script>
<script src="{{url('public/assets')}}/js/jquery-confirm.js"></script>

<script src="{{url('public/js/front/cart.js')}}"></script>