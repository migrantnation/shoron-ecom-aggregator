(function ($) {
    "use strict";
    $(document).ready(function () {
        $("#plx__tree li > a").each(function () {
            $(this).on("click", function (e) {
                e.preventDefault();
                var targetUl = $(this).attr("href");
                $(this).toggleClass("is-open");
                $(targetUl).toggleClass("expanded");
            })
        });
        var flag_value = 0;
        $(document).on("click", "#expandToggle", function (e) {
            //alert(flag_value);
            e.preventDefault();
            if (flag_value == 0) {
                flag_value = 1;
                // console.log(flag_value);
                $(this).text("Collapse All");
            } else {
                flag_value = 0;
                // console.log(flag_value);
                $(this).text("Expand All");
            }
            $("#plx__tree ul").toggleClass("expanded");
        })
    })
}(jQuery))

var preOpen = function (id, selectedId) {
    $("#parent" + id + " a").each(function () {
        if ($("#cat" + selectedId).prop("checked")) {
            $("#cat" + selectedId).parents("#plx__tree ul").addClass("expanded");
            $(this).addClass("is-open");
        } else {
            return;
        }
    });
}

