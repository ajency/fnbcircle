(function() {
  if ($('.expSelect').length) {
    $('.expSelect').multiselect({
      includeSelectAllOption: true,
      numberDisplayed: 2,
      delimiterText: ',',
      nonSelectedText: 'Select Experience'
    });
  }

  $(document).ready(function() {
    if ($('.job-keywords').length) {
      $('.job-keywords').flexdatalist({
        removeOnBackspace: false,
        searchByWord: true,
        searchContain: true,
        selectionRequired: true,
        minLength: 0,
        maxShownResults: 5000,
        url: '/get-keywords',
        searchIn: ["label"]
      });
    }
  });

}).call(this);
