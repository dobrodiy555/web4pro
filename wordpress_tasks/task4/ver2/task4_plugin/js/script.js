jQuery(document).ready(function() {
    jQuery("form").submit(function(e) {
        e.preventDefault(); 
        var number_of_posts = jQuery("#number").text();
        var title = jQuery("#title").val();
        var from_date = jQuery("#from_date").val();
        jQuery.ajax({
            type: "GET",
            dataType: "html",
            url: tp4ajax.ajaxurl,
            data: {action: 'show', number_of_posts: number_of_posts, title: title, from_date: from_date},
            success: function(response) {
                jQuery("#response").empty(); 
                jQuery('#response').html(response);
            }
        });
    });
});



