function fetch() {
  var input = jQuery('#keyword').val();
    jQuery.ajax({
      type: "POST",
      url: t8ajax.ajaxurl,
      data: {action: 'data_fetch', keyword: input},
      success: function (data) {
        jQuery('#loop_part').html(data);
      }
    });
}

jQuery(document).ready(function() {

  jQuery('#t8_but').click(function () {
    fetch();
  });

  jQuery('#keyword').keypress(function (e) {
    if (e.which == 13) {
      fetch();
      return false;
      }
    });

});
