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
          return $('#filter-area').html(response);
        }
      });
    }
  });

  $('body').on('show.bs.modal', '#category-select', function() {
    return getCategoryDom("#category-select #level-one-category-dom", "level_1");
  });

}).call(this);
