$(function () {
    var warn_on_unload = false; //default false


    $('input,textarea,select').on('change', function () {
        //making true when user types in , or select
        warn_on_unload = true;
    });

    $(':submit').click(function () {
        warn_on_unload = false;
    });

    $(window).bind('beforeunload', function(){
        //warns user if not saving form and closing or browsing other page
        if(warn_on_unload)
        {
            return 'Es posible que los cambios no se guarden.';
        }

    });
});