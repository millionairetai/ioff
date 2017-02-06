jQuery("a.navmobile").click(function () {
    jQuery("nav ul").toggle(300);
});

//integratepage
function showItem(element, p) {
    jQuery(".integ-menu ul li a").removeClass("selected");
    jQuery("#integratepage .info-content").css("display", "none");

    jQuery(element).addClass("selected");
    jQuery("#" + p).css("display", "block");
}

//Choose max user and max storage.
$("#signupform-maxuser[type='text']").ionRangeSlider({
    type: "single",
    step: 5,
    postfix: " user",
    min: 5,
    max: 1500,
    grid: true
});

$("#signupform-maxstorage[type='text']").ionRangeSlider({
    type: "single",
    step: 5,
    postfix: " GB",
    min: 5,
    max: 5005,
    grid: true
});

//Process when loading at first time.
var initializeSelectPackage = function (value) {    
    if (value == 'free' || value == '') {
        $('.choose-info-plan-type').hide();
    } else {
        $('.choose-info-plan-type, .max-user').show();
        if (value == 'premium') {
            $('.max-user').hide();
        }
    }
}

initializeSelectPackage($('#signupform-plan_type').val());
$('#signupform-plan_type').change(function() {
    initializeSelectPackage($(this).val());
});