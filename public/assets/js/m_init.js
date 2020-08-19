(function ($) {
    "use strict";

    $(document).ready(function () {
        var body = $("body"),
            overlay = $(".m__n-overlay");

        $('.m__add-banner').owlCarousel({
            loop: true,
            margin: 30,
            nav: false,
            items: 1,
            autoplay: true,
            autoplayTimeout: 3500
        });

        $(".m__toggle-btn").on("click", function (e) {
            e.preventDefault();
            $('body').addClass('m__navbar-open');
            $('.m__n-overlay').fadeIn(300);
        });
        $(overlay).on("click", function (e) {
            e.preventDefault();
            $(this).fadeOut(100);
            $('body').removeClass('m__navbar-open');
        });

        $(".m__sorting").on("click", function (e) {
            e.preventDefault();
            $(body).addClass('m__open-sorting');
            $('.m__n-overlay').fadeIn(300);
        });
        $(overlay).on("click", function (e) {
            e.preventDefault();
            $(this).fadeOut(200);
            $('body').removeClass('m__open-sorting');
        });

        // m__search-toggle-btn
        $(".m__search-toggle-btn").on("click", function (e) {
            e.preventDefault();
            $(body).addClass('m__search-navigation-open');
            setTimeout(function () {
                $(".m__search-control").focus();
            }, 300);
        });
        $(".m__closeBtn").on("click", function (e) {
            e.preventDefault();
            $(body).removeClass('m__search-navigation-open');
        });

        $(".m__category-list li").each(function () {
            console.log(this);
            var mListToggleBtn = $(this).children(".m__list-toggle-btn"),
                subList = $(this).children(".m__sub-list");

            $(mListToggleBtn).on("click", function (e) {
                e.preventDefault();
                $(this).toggleClass('m__open');
                $(subList).slideToggle();
            })
        });

        var productContainer = $(".m__product-list");
        $(document).on("click", ".m__view-type", function (e) {
            e.preventDefault();
            $(this).toggleClass('m__grid');
            $(productContainer).toggleClass('m_view-in-list')
        });

        var rangerWidth = $(".m__range").width() - 20;
        var rangeSlider = $('.range-slider');
        rangeSlider.jRange({
            from: 0,
            to: 2000,
            step: 50,
            scale: [0, 250, 500, 750, 1000, 1250, 1500, 1750, 2000],
            format: '%s',
            width: rangerWidth,
            showLabels: false,
            isRange: true,
            snap: true,
            theme: "theme-green"
        });
        rangeSlider.jRange('setValue', '0, 2000');

        $(document).on("click", ".toggleExpand", function (e) {
            e.preventDefault();
            var targetBlock = $(this).attr("href");
            $(this).toggleClass("expand");
            $(targetBlock).slideToggle("fast");
        });

        //
        // ratingYo
        $("#rateYo").rateYo({
            rating: 0,
            halfStar: true,
            starWidth: "25px",
            normalFill: "rgba(200,200,200, .4)",
            ratedFill: "#FFC107",
            onSet: function (rating, rateYoInstance) {
                $("#ratingValue").val(rating);
            }
        });
        $(".static-rating").each(function () {
            var value = $(this).attr("data-value");
            if (value >= 5) {
                value = 5;
            }
            $(this).rateYo({
                rating: value,
                halfStar: true,
                starWidth: "16px",
                normalFill: "rgba(200,200,200, .4)",
                ratedFill: "#FFC107"
            });
        });
        $(".static-rating-lg").each(function () {
            var value = $(this).attr("data-value");
            if (value >= 5) {
                value = 5;
            }
            $(this).rateYo({
                rating: value,
                halfStar: true,
                starWidth: "30px",
                normalFill: "rgba(200,200,200, .4)",
                ratedFill: "#FFC107"
            });
        });

        $(".m__filter").on("click", function (e) {
            e.preventDefault();
            $(body).addClass('m__filter-navigation-open');
        });
        $(".plx__closeBtn").on("click", function (e) {
            e.preventDefault();
            $(body).removeClass('m__filter-navigation-open');
        });

        var incValue = 1;
        $('.p-qnt-counter').each(function () {
            var increasedValue = incValue++;

            $(this).children(".qnt-btn").click(function(){
                var pQntInput = $(this).attr("data-qntValue"),
                    qty = $(pQntInput).val();

                console.log(pQntInput);

                if($(this).attr('data-operation')==='add'){
                    qty++;
                } else {
                    qty--;
                }
                if (qty < 0) {
                    qty = 0;
                }
                $(pQntInput).val(qty);
            });
        });

        $('#productThumb').WimmViewer({
            miniatureWidth: 100,
            miniatureHeight: 100,
            nextText: '<span class="pe-7s-angle-right"></span>',
            prevText: '<span class="pe-7s-angle-left"></span>'
        });

        $('.m__nav-tab > a').on("click", function (e) {
            e.preventDefault();
            var targetContent = $(this).attr("href");
            $('.m__nav-tab > a').removeClass('current');
            $(this).addClass('current');
            $('.m__tab-content').removeClass('active');
            $(targetContent).addClass('active');
        });

        fixedCartButtons();
        $(window).scroll(function (e) {
            fixedCartButtons();
        });

        getMinMaxValue(rangeSlider);
        $(rangeSlider).on("change", function () {
            getMinMaxValue(this);
        });

        function getMinMaxValue(element) {
            var rangeValue  = $(element).val(),
                newValues = rangeValue.split(',');
            $('.m__min-val').text(newValues[0]);
            $('.m__max-val').text(newValues[1]);
        }
    });

    function fixedCartButtons() {
        var scroll_top          = $(window).scrollTop(),
            buttonList          = $("#btnList"),
            buttonListHeight    = $(buttonList).height(),
            buttonListOffsetTop = $(buttonList).offset().top + buttonListHeight;
        if(scroll_top > buttonListOffsetTop) {
            $(".m__action-btn").addClass('m__btns-fixed');
        } else {
            $(".m__action-btn").removeClass('m__btns-fixed');
        }
    }
}(jQuery));