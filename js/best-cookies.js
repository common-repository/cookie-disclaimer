/**
 * jsDoc - author: Brudj
 */

(function($){
    //check for cookie
    function getCookie(cname) {
        var name = cname + "=",
            ca = document.cookie.split(';');
        for( var i = 0; i < ca.length; i++ ) {
            var c = ca[i];
            while ( c.charAt(0) == ' ' ) c = c.substring(1);
            if ( c.indexOf(name) == 0 ) return c.substring( name.length, c.length );
        }
        return "";
    }

    //remove cookie disclaimer if cookie exists
    var hide_disclaimer = getCookie("hide_disclaimer");
    if (hide_disclaimer != "") {
        $('.best-cookies').remove();
    }

    $(document).ready(function(){
        
        if( $('.best-cookies').length ){
            //show popup
            $('.best-cookies').addClass('best-cookies__rdy');
            //add hide cookie disclaimer on click
            $(document).on('click','.best-cookies__close',function(){
                $('.best-cookies').removeClass('best-cookies__rdy',function(){
                    $('.best-cookies').remove();
                });
            });
            //add cookie and hide popup
            $(document).on('click','.best-cookies__button',function(){
                var endDate = new Date();
                endDate.setMonth(endDate.getMonth() + 1);
                document.cookie="hide_disclaimer=1;expires="+endDate.toGMTString();
                $('.best-cookies').removeClass('best-cookies__rdy',function(){
                    $('.best-cookies').remove();
                });
            });
        }

    });

}(jQuery));