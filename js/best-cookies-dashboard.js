;
(function ($) {

    $(document).ready(function () {
        
        $('.best-cookies__form-active').change(function () {
            $('.best-cookies__form-bottom').toggleClass('disabled');
        });
        
    });
    
}(jQuery));