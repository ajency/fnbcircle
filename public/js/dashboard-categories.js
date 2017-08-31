(function() {
  var resetFilters;

  resetFilters = function() {
    $('#datatable-categories th option:selected').each(function() {
      return $(this).prop('selected', false);
    });
    $('#catNameSearch').val('');
    $('#catNameSearch').keyup();
    $('#datatable-categories select').each(function() {
      return $(this).multiselect('refresh');
    });
    $('input[type="checkbox"]').each(function(index, value) {
      $(this).change();
    });
  };

  $('body').on('click', '#resetfilter', function() {
    resetFilters();
  });

}).call(this);
