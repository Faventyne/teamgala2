
var resizeTimeout;
$(window).resize(function(){
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(function(){
        location.reload();
    }, 500);
});
