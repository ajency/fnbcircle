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

  $('body').on('click', '#select-export-states', function() {
    var selected, url;
    selected = [];
    $('#export-state-filter input[name="exportState[]"]:checked').each(function() {
      return selected.push(this.value);
    });
    console.log(selected);
    url = document.head.querySelector('[property="export-state-display"]').content;
    return $.ajax({
      type: 'post',
      url: url,
      data: {
        states: selected
      },
      success: function(response) {
        return $('div#display-export-state').html(response['html']);
      }
    });
  });

  $('body').on('click', '#select-export-statuses', function() {
    var selected, url;
    selected = [];
    $('#export-status-filter input[name="exportStatus[]"]:checked').each(function() {
      return selected.push(this.value);
    });
    console.log(selected);
    url = document.head.querySelector('[property="export-status-display"]').content;
    return $.ajax({
      type: 'post',
      url: url,
      data: {
        statuses: selected
      },
      success: function(response) {
        return $('div#display-export-status').html(response['html']);
      }
    });
  });

  $('body').on('click', '#select-export-premium', function() {
    var selected, url;
    selected = $('#export-premium input[name="exportPremium"]').prop('checked');
    console.log(selected);
    url = document.head.querySelector('[property="export-premium-display"]').content;
    return $.ajax({
      type: 'post',
      url: url,
      data: {
        premium: selected
      },
      success: function(response) {
        return $('div#display-export-premium').html(response['html']);
      }
    });
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

  $('body').on('click', '#select-export-usertypes', function() {
    var selected, url;
    selected = [];
    $('#export-usertypes input[name="usertypes[]"]:checked').each(function() {
      return selected.push(this.value);
    });
    console.log(selected);
    url = document.head.querySelector('[property="export-usertype-display"]').content;
    return $.ajax({
      type: 'post',
      url: url,
      data: {
        userTypes: selected
      },
      success: function(response) {
        return $('div#display-export-usertypes').html(response['html']);
      }
    });
  });

  $('body').on('click', '#select-export-usersubtypes', function() {
    var selected, url;
    selected = [];
    $('#export-usersubtypes input[name="usersubtypes[]"]:checked').each(function() {
      return selected.push(this.value);
    });
    console.log(selected);
    url = document.head.querySelector('[property="export-usersubtype-display"]').content;
    return $.ajax({
      type: 'post',
      url: url,
      data: {
        userSubTypes: selected
      },
      success: function(response) {
        return $('div#display-export-usersubtypes').html(response['html']);
      }
    });
  });

  $('body').on('click', '#select-export-jobbusinesstypes', function() {
    var selected, url;
    selected = [];
    $('#export-jobbusinesstypes input[name="jobbusinesstypes[]"]:checked').each(function() {
      return selected.push(this.value);
    });
    console.log(selected);
    url = document.head.querySelector('[property="export-jobtype-display"]').content;
    return $.ajax({
      type: 'post',
      url: url,
      data: {
        jobTypes: selected
      },
      success: function(response) {
        return $('div#display-export-jobtypes').html(response['html']);
      }
    });
  });

  $('body').on('click', '#select-export-jobroles', function() {
    var selected, url;
    selected = [];
    $('#export-jobroles input[name="jobroles[]"]:checked').each(function() {
      return selected.push(this.value);
    });
    console.log(selected);
    url = document.head.querySelector('[property="export-jobrole-display"]').content;
    return $.ajax({
      type: 'post',
      url: url,
      data: {
        jobRoles: selected
      },
      success: function(response) {
        return $('div#display-export-jobroles').html(response['html']);
      }
    });
  });

  $('body').on('click', '#select-export-signuptypes', function() {
    var selected, url;
    selected = [];
    $('#export-signuptype-filter input[name="exportsignuptype[]"]:checked').each(function() {
      return selected.push(this.value);
    });
    console.log(selected);
    url = document.head.querySelector('[property="export-signup-display"]').content;
    return $.ajax({
      type: 'post',
      url: url,
      data: {
        signup: selected
      },
      success: function(response) {
        return $('div#display-export-signup').html(response['html']);
      }
    });
  });

  $('body').on('click', '#select-export-active', function() {
    var selected, url;
    selected = [];
    $('#export-active input[name="exportActive[]"]:checked').each(function() {
      return selected.push(this.value);
    });
    console.log(selected);
    url = document.head.querySelector('[property="export-active-display"]').content;
    return $.ajax({
      type: 'post',
      url: url,
      data: {
        active: selected
      },
      success: function(response) {
        return $('div#display-export-active').html(response['html']);
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
