jQuery("a.navmobile").click(function(){
   jQuery("nav ul").toggle(300);
});

//integratepage
function showItem(element,p) {
    jQuery(".integ-menu ul li a").removeClass("selected");
    jQuery("#integratepage .info-content").css("display","none");
    
    jQuery(element).addClass("selected");
    jQuery("#"+p).css("display","block");
}