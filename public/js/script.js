var setDefaultActive = function() {
    var path = window.location.pathname;

    var element = $("li > a[href='"+path+"']").parent();

    element.addClass("active");
}