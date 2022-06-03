(function($, Drupal) {
    Drupal.AjaxCommands.prototype.getProductAjax = function(ajax, response, status){
        $('#divProducts').html(response.content);
        if (response.show == true) {
            $('#divProducts').css('display','block');
        } else {
            $('#divProducts').css('display','none');
        }
    }
})(jQuery, Drupal);
