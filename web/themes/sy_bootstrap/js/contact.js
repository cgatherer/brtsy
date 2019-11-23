(function ($) {
    $(document).ready(function(){
        $('.para-webform-select').on('change', function(){
            var formvalue = $(this).val();
            $(".field--name-field-para-webform .field--item").css('display', 'none');
            $(".field--name-field-para-webform .field--item.item-"+formvalue).css('display', 'block');
        });
    });
})(jQuery);
