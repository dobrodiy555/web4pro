jQuery(document).ready(function($) {

    // make home menu orange in homepage
    var x = $("body").attr("class");
    if (x.includes('home')) {
        $("#home_nav_menu_item").addClass("current");
    }

    // display comment form and existing comments in sidebar when clicking on 'comment' button in single post page
    $('#comment_button').click(function() {
        $('#comment_form').toggle();
    });

    // to make portfolio categories link where user is active (orange)
    var name_of_category_page = $("#category_page_title").text();
    $('.page_text .portfolio_categories li.active').removeClass('active');
    $("li:contains('" + name_of_category_page + "')").addClass('active');


});
