(function() {
  $('input[type=radio][name=plan-select]').change(function() {
    if ($(this).is(':checked')) {
      $(this).closest('.pricing-table__cards').addClass('active').siblings().removeClass('active');
      console.log($('input[type=radio][name=plan-select]:checked').val());
      console.log($('#pending-plan').val());
      if ($('input[type=radio][name=plan-select]:checked').val() === $('#pending-plan').val()) {
        $('#submit-btn').prop('disabled', true);
      } else {
        $('#submit-btn').prop('disabled', false);
      }
    }
    if ($('#next-plan-selected').val() === '1' || $('#submit-terms-check').prop('checked') === false) {
      $('#submit-btn').prop('disabled', true);
    }
  });

  $('body').on('change', '#submit-terms-check', function() {
    if ($('#submit-terms-check').prop('checked') === false) {
      return $('#submit-btn').prop('disabled', true);
    } else {
      return $('input[type=radio][name=plan-select]').change();
    }
  });

  $('body').on('click', '#subscribe-btn', function(e) {
    var form, parameters, planContainer, planID, url;
    planID = $('input[type=radio][name=plan-select]:checked').val();
    planContainer = $('input[type=radio][name=plan-select]:checked').closest('.plans__footer');
    url = document.head.querySelector('[property="premium-url"]').content;
    parameters = {};
    parameters['id'] = document.getElementById('listing_id').value;
    parameters['type'] = 'listing';
    parameters['plan_id'] = planID;
    form = $('<form></form>');
    form.attr("method", "post");
    form.attr("action", url);
    $.each(parameters, function(key, value) {
      var field;
      field = $('<input></input>');
      field.attr("type", "hidden");
      field.attr("name", key);
      field.attr("value", value);
      form.append(field);
      console.log(key + '=>' + value);
    });
    $(document.body).append(form);
    return form.submit();
  });

  window.validatePremium = function() {
    var form, parameters;
    parameters = {};
    parameters['listing_id'] = document.getElementById('listing_id').value;
    parameters['step'] = 'business-premium';
    if (window.submit === 1) {
      parameters['submitReview'] = 'yes';
    }
    if (window.archive === 1) {
      parameters['archive'] = 'yes';
    }
    if (window.publish === 1) {
      parameters['publish'] = 'yes';
    }
    form = $('<form></form>');
    form.attr("method", "post");
    form.attr("action", "/listing");
    $.each(parameters, function(key, value) {
      var field;
      field = $('<input></input>');
      field.attr("type", "hidden");
      field.attr("name", key);
      field.attr("value", value);
      form.append(field);
      console.log(key + '=>' + value);
    });
    $(document.body).append(form);
    form.submit();
  };

  $('input[type=radio][name=plan-select]').change();

}).call(this);
