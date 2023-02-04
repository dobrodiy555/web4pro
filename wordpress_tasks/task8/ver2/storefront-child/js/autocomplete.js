jQuery(document).ready(function() {
  var url = t8ac.url + "?action=add_autocomplete";
  jQuery('#keyword').autocomplete({
    source: url,
    minLength: 3
  });
});


