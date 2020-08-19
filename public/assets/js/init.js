(function ($) {
    //console.log("Hello Ek-Shop User!");
    productCarousel();

    $('#mainAdds').owlCarousel({
        loop: true,
        margin: 30,
        nav: false,
        items: 1,
        autoplay: true,
        autoplayTimeout: 3500
    });
    $(document).ready(function () {
        var incValue = 1;

        // $('.p-qnt-counter').each(function () {
        //     var increasedValue = incValue++;
        //
        //     $(this).children(".qnt-btn").click(function () {
        //         var pQntInput = $(this).attr("data-qntValue"),
        //             qty = $(pQntInput).val();
        //
        //         if ($(this).attr('data-operation') === 'add') {
        //             qty++;
        //         } else {
        //             qty--;
        //         }
        //
        //         if (qty < 0) {
        //             qty = 1;
        //         }
        //         // if ($(pQntInput).max > qty) {
        //             $(pQntInput).val(qty);
        //         // }
        //     });
        // });

        $("#glasscase").glassCase({
            'widthDisplay': 560,
            'heightDisplay': 560,
            'thumbsPosition': 'left',
            'colorIcons': '#F15129',
            'colorActiveThumb': '#F15129',
            'isDownloadEnabled': false
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

        $(document).on("click", ".toggleExpand", function (e) {
            e.preventDefault();
            var targetBlock = $(this).attr("href");
            $(this).toggleClass("expand");
            $(targetBlock).slideToggle("fast");
        });

        $(".attr-list").each(function () {
            var ul = $(this),
                lis = ul.find('li:gt(3)'),
                isExpanded = ul.hasClass('expanded');
            lis[isExpanded ? 'show' : 'hide']();

            if (lis.length > 0) {
                ul.append($('<li class="moreBtn"><a href="#"><small>' + (isExpanded ? 'View Less' : 'View More') + '</small></a></li>')
                    .click(function (event) {
                        var isExpanded = ul.hasClass('expanded');
                        event.preventDefault();
                        $(this).html(isExpanded ? "<a href='#'><small>View More</small></a>" : "<a href='#'><small>View Less</small></a>");
                        ul.toggleClass('expanded');
                        lis.toggle();
                    }));
            }
        });

        $(".cat-inner-list li").each(function () {
            var catToggleBtn = $(this).children(".catlistToggleBtn"),
                catTargetList = $(this).children(".cat-inner-list");

            $(catToggleBtn).on("click", function (e) {
                e.preventDefault();
                $(this).toggleClass('open');
                $(catTargetList).slideToggle("fast");
            })
        })
        $('.refineSearch').on('click', function (e) {
            e.preventDefault();
            //e.stopPropagation();
            $(this).toggleClass('active');
            $('.refine-search-list').toggle();
        })

        var refineDefaultItem = $('.rsDefault > input[type="checkbox"]');
        var refineSecondaryItem = $('.rsEp > input[type="checkbox"]');
        var refineItem = $('.refineItem > input[type="checkbox"]');

        // checkRefineItem (refineDefaultItem, refineSecondaryItem);
        //
        // $(refineItem).change(function () {
        //     console.log();
        //     checkRefineItem (refineDefaultItem, refineSecondaryItem);
        // })
    });

}(jQuery));

// function checkRefineItem(defaultItem, secondaryItem) {
//     if ($(secondaryItem).prop('checked')) {
//         $(defaultItem).removeAttr('checked');
//     } else {
//         // $(defaultItem).attr("checked", "checked");
//         // $(secondaryItem).removeAttr('checked');
//     }
// }

function productCarousel() {
    $('.productCarousel').owlCarousel({
        loop: true,
        margin: 30,
        nav: true,
        autoplay: true,
        autoplayTimeout: 1500,
        autoplayHoverPause: true,
        navText: ["<i class='icon-arrow-left'></i>", "<i class='icon-arrow-right'></i>"],
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 4,
                mouseDrag: false
            }
        }
    });

}

//ENGLISH TO BANGLA CONVERSION
var english_number;
var finalEnlishToBanglaNumber={'0':'০','1':'১','2':'২','3':'৩','4':'৪','5':'৫','6':'৬','7':'৭','8':'৮','9':'৯'};
String.prototype.getDigitBanglaFromEnglish = function() {
    var retStr = this;
    for (var x in finalEnlishToBanglaNumber) {
        retStr = retStr.replace(new RegExp(x, 'g'), finalEnlishToBanglaNumber[x]);
    }
    return retStr;
};


function number_format(number, decimals, dec_point, thousands_sep) {
    // http://kevin.vanzonneveld.net
    // +   original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +     bugfix by: Michael White (http://getsprink.com)
    // +     bugfix by: Benjamin Lupton
    // +     bugfix by: Allan Jensen (http://www.winternet.no)
    // +    revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // +     bugfix by: Howard Yeend
    // +    revised by: Luke Smith (http://lucassmith.name)
    // +     bugfix by: Diogo Resende
    // +     bugfix by: Rival
    // +      input by: Kheang Hok Chin (http://www.distantia.ca/)
    // +   improved by: davook
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // +      input by: Jay Klehr
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // +      input by: Amir Habibi (http://www.residence-mixte.com/)
    // +     bugfix by: Brett Zamir (http://brett-zamir.me)
    // +   improved by: Theriault
    // +   improved by: Drew Noakes
    // *     example 1: number_format(1234.56);
    // *     returns 1: '1,235'
    // *     example 2: number_format(1234.56, 2, ',', ' ');
    // *     returns 2: '1 234,56'
    // *     example 3: number_format(1234.5678, 2, '.', '');
    // *     returns 3: '1234.57'
    // *     example 4: number_format(67, 2, ',', '.');
    // *     returns 4: '67,00'
    // *     example 5: number_format(1000);
    // *     returns 5: '1,000'
    // *     example 6: number_format(67.311, 2);
    // *     returns 6: '67.31'
    // *     example 7: number_format(1000.55, 1);
    // *     returns 7: '1,000.6'
    // *     example 8: number_format(67000, 5, ',', '.');
    // *     returns 8: '67.000,00000'
    // *     example 9: number_format(0.9, 0);
    // *     returns 9: '1'
    // *    example 10: number_format('1.20', 2);
    // *    returns 10: '1.20'
    // *    example 11: number_format('1.20', 4);
    // *    returns 11: '1.2000'
    // *    example 12: number_format('1.2000', 3);
    // *    returns 12: '1.200'
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        toFixedFix = function (n, prec) {
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            var k = Math.pow(10, prec);
            return Math.round(n * k) / k;
        },
        s = (prec ? toFixedFix(n, prec) : Math.round(n)).toString().split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}