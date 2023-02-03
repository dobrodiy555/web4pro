jQuery(document).ready(function($) {

    // make items orange in top menu if user is in this page
    var x = $("body").attr("class");
    if (x.includes('home')) {
        $("#home_nav_menu_item").addClass("current");
    } else if (x.includes('gallery')) {
        $("#gallery_nav_menu_item").addClass("current");
    } else if (x.includes('post-type-archive')) {
        $("#portfolio_nav_menu_item").addClass("current");
    } else if (x.includes('archive-post-php')) {
        $("#blog_nav_menu_item").addClass("current");
    }
    var y = $(".page_title").text();
    if (y.includes('Contact us')) {
        $("#contact_nav_menu_item").addClass("current");
    } else if (y.includes('About us')) {
        $("#about_nav_menu_item").addClass("current");
    }

    // display comment form and existing comments in sidebar when clicking on 'comment' button in single post page
    $('#comment_button').click(function() {
        $('#comment_form').toggle();
        // $('#tt7_sidebar').hide();
    });

    // to make portfolio categories link where user is active (orange)
    var name_of_category_page = $("#category_page_title").text();
    $('.page_text .portfolio_categories li.active').removeClass('active');
    $("li:contains('" + name_of_category_page + "')").addClass('active');

});
