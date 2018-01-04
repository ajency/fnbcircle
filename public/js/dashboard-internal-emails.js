(function() {
  $('body').on('change', '#internal-email-type', function() {
    var url;
    if (this.value !== "") {
      url = document.head.querySelector('[property="mailtype-change-url"]').content;
      return $.ajax({
        type: 'post',
        url: url,
        data: {
          type: this.value
        },
        success: function(response) {
          console.log(response);
          $('#filter-area').html(response);
          $('#submissionDate').daterangepicker({
            autoUpdateInput: false,
            maxDate: moment()
          });
          return $('#submissionDate').on('apply.daterangepicker', function(ev, picker) {
            return $('#submissionDate').val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
          });
        }
      });
    }
  });

  $('body').on('show.bs.modal', '#category-select', function() {
    return getCategoryDom("#category-select #level-one-category-dom", "level_1");
  });

}).call(this);
