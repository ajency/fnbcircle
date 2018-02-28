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
                  'url': '/get-categories-data',
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
    selected = [];
    $('#export-premium input[name="exportPremium[]"]:checked').each(function() {
      return selected.push(this.value);
    });
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

  $('body').on('click', '#getExportCount', function() {
    var active, categories, exportType, jobBusinessType, jobRole, premium, signupType, state, status, url, userSubType, userType;
    exportType = $('input[name="export-type"]').val();
    state = $('#selected-export-states').val();
    status = $('#selected-export-status').val();
    premium = $('#selected-export-premium').val();
    categories = $('#selected-export-categories').val();
    userType = $('#selected-export-usertypes').val();
    userSubType = $('#selected-export-usersubtypes').val();
    jobBusinessType = $('#selected-export-jobtypes').val();
    jobRole = $('#selected-export-jobRoles').val();
    signupType = $('#selected-export-signup').val();
    active = $('#selected-export-active').val();
    url = document.head.querySelector('[property="export-count"]').content;
    return $.ajax({
      type: 'post',
      url: url,
      data: {
        exportType: exportType,
        state: state,
        status: status,
        premium: premium,
        categories: categories,
        userType: userType,
        userSubType: userSubType,
        jobBusinessType: jobBusinessType,
        jobRole: jobRole,
        signupType: signupType,
        active: active
      },
      success: function(response) {
        if (response['status'] === false) {
          $('#confirm-mail-message').html('There was a server error, Please contact site administrator');
          $('#export-confirm').prop('disabled', true);
          $('#confirmBox').modal('show');
          return;
        }
        if (response['count'] === 0) {
          $('#confirm-mail-message').html('No users available to export for current selection');
          $('#export-confirm').prop('disabled', true);
          $('#confirmBox').modal('show');
          return;
        }
        if (response['count'] > 5000) {
          $('#confirm-mail-message').html('More than 5000 users in the current selection. Export will take a long time. Please change your filters.');
          $('#export-confirm').prop('disabled', true);
          $('#confirmBox').modal('show');
          return;
        }
        $('#export-confirm').prop('disabled', false);
        $('#confirm-mail-message').html('There are total ' + response['count'] + ' users in your selection.Are you sure you want to export?');
        return $('#confirmBox').modal('show');
      }
    });
  });

  $('body').on('click', '#export-confirm', function() {
    var active, categories, exportType, form, jobBusinessType, jobRole, parameters, premium, signupType, state, status, url, userSubType, userType;
    exportType = $('input[name="export-type"]').val();
    state = $('#selected-export-states').val();
    status = $('#selected-export-status').val();
    premium = $('#selected-export-premium').val();
    categories = $('#selected-export-categories').val();
    userType = $('#selected-export-usertypes').val();
    userSubType = $('#selected-export-usersubtypes').val();
    jobBusinessType = $('#selected-export-jobtypes').val();
    jobRole = $('#selected-export-jobRoles').val();
    signupType = $('#selected-export-signup').val();
    active = $('#selected-export-active').val();
    url = document.head.querySelector('[property="export-download"]').content;
    form = $('<form></form>');
    form.attr('method', 'post');
    form.attr('action', url);
    parameters = {};
    parameters['exportType'] = exportType;
    parameters['state'] = state;
    parameters['status'] = status;
    parameters['premium'] = premium;
    parameters['categories'] = categories;
    parameters['userType'] = userType;
    parameters['userSubType'] = userSubType;
    parameters['jobBusinessType'] = jobBusinessType;
    parameters['jobRole'] = jobRole;
    parameters['signupType'] = signupType;
    parameters['active'] = active;
    $.each(parameters, function(key, value) {
      var field;
      field = $('<input></input>');
      field.attr('type', 'hidden');
      field.attr('name', key);
      field.attr('value', value);
      form.append(field);
      console.log(key + '=>' + value);
    });
    $(document.body).append(form);
    return form.submit();
  });

  $('body').on('click', '#clear-filters', function() {
    $('div#display-export-active').html('<input type="hidden" id="selected-export-active" name="selected-export-active" value="">');
    $('div#display-export-state').html('<input type="hidden" id="selected-export-states" name="selected-export-states" value="">');
    $('div#display-export-status').html('input type="hidden" id="selected-export-status" name="selected-export-status" value="">');
    $('div#display-export-premium').html('<input type="hidden" id="selected-export-premium" name="selected-export-premium" value="false">');
    $('div#display-export-categories').html('<input type="hidden" id="selected-export-categories"  name="selected-categories" value="">');
    $('div#display-export-usertypes').html('<input type="hidden" id="selected-export-usertypes" name="selected-export-status" value="">');
    $('div#display-export-usersubtypes').html('<input type="hidden" id="selected-export-usersubtypes" name="selected-export-usersubtypes" value="">');
    $('div#display-export-jobtypes').html('input type="hidden" id="selected-export-jobtypes" name="selected-export-jobtypes" value="">');
    $('div#display-export-jobroles').html('<input type="hidden" id="selected-export-jobRoles" name="selected-export-jobRoles" value="">');
    return $('div#display-export-signup').html('<input type="hidden" id="selected-export-signup" name="selected-export-signup" value="">');
  });

}).call(this);
