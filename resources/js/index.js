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
    var primaryPicker = $('#primary').data("plugin_tinycolorpicker");
    primaryPicker.setColor("#1ABC9C");

    $("#secondary").tinycolorpicker();
    var secondaryPicker = $('#secondary').data("plugin_tinycolorpicker");
    secondaryPicker.setColor("#ffffff");


})(jQuery);
