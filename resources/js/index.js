(function($) {

    $('#advancedOptionsLabel').click(function() {

        $('#showMoreOptions').toggle();
        $('#hideMoreOptions').toggle();
        $('#advancedOptions').slideToggle();
    });

    $('#with-other').click(function() {
        $('#other-chars').parent().slideToggle();
    });
    $("#primary").tinycolorpicker();
    var picker = $('#primary').data("plugin_tinycolorpicker");
    picker.setColor("#1ABC9C");

    $("#secondary").tinycolorpicker();
    var picker = $('#secondary').data("plugin_tinycolorpicker");
    picker.setColor("#ffffff");


})(jQuery);
