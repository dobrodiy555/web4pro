jQuery(document).ready( function () {
    jQuery.ajax({
        type: "GET",
        dataType: "html",
        url: script_vars.ajaxurl,
        data: { action: 'show', title: script_vars.title, from_date: script_vars.from_date },
        success: function( response ) {
            jQuery("#response").append( response );
        }
    });
});

