(function() {
  $('body').on('change', '#export-type', function() {
    var url;
    if (this.value !== "") {
      url = document.head.querySelector('[property="export-type-change-url"]').content;
      return $.ajax({
        type: 'post',
        url: url,
        data: {
          type: this.value
        },
        success: function(response) {
          $('#filter-area').html(response);
          if ($('#export-categories') !== void 0) {
            return $('#export-categories').jstree({
              'plugins': ['checkbox', 'search'],
              'core': {
                'data': {
                  'url': 'http://localhost:8000/get-categories-data',
                  'dataType': 'json',
                  'data': function(node) {
                    return {
                      'id': node.id
                    };
                  }
                }
              }
            });
          }
        }
      });
    } else {
      return $('#filter-area').html("");
    }
  });

  $('body').on('click', '#select-export-categories', function() {
    var instance, selected, url;
    instance = $('#export-categories').jstree(true);
    selected = instance.get_selected();
    console.log(selected);
    url = document.head.querySelector('[property="category-hierarchy"]').content;
    return $.ajax({
      type: 'post',
      url: url,
      data: {
        categories: selected
      },
      success: function(response) {
        return $('div#display-export-categories').html(response['html']);
      }
    });
  });

  $('body').on('keyup', '#jobtypesearch', function() {
    var value;
    value = $(this).val().toLowerCase();
    $('#export-jobbusinesstypes .jobbusinesstype').filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
  });

  $('body').on('keyup', '#jobrolesearch', function() {
    var value;
    value = $(this).val().toLowerCase();
    $('#export-jobroles .jobrole').filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
  });

}).call(this);
