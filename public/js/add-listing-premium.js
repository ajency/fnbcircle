(function() {
  $('input[type=radio][name=plan-select]').change(function() {
    if ($(this).is(':checked')) {
      $(this).closest('.pricing-table__cards').addClass('active').siblings().removeClass('active');
      if ($(this).closest('.pricing-table__cards').hasClass('free-plan')) {
        $('#subscribe-btn').prop('disabled', true);
      } else {
        $('#subscribe-btn').prop('disabled', false);
      }
    }
  });

  $('body').on('click', '#subscribe-btn', function(e) {
    var planContainer, planID, url;
    planID = $('input[type=radio][name=plan-select]:checked').val();
    planContainer = $('input[type=radio][name=plan-select]:checked').closest('.plan__footer');
    if (confirm('are you sure?')) {
      url = document.head.querySelector('[property="premium-url"]').content;
      $.ajax({
        type: 'post',
        url: url,
        data: {
          'plan_id': planID,
          'type': 'listing',
          'id': document.getElementById('listing_id').value
        },
        success: function(data) {
          if (data['status'] === '200') {
            $('#pending-request').html('(Request Pending)');
            $('#subscribe-btn').remove();
            $('.alert-success').find('.success-message').html('Plan request sent successfully');
            return $('.alert-success').addClass('active');
          }
        }
      });
      return console.log('request sent of plan' + planID);
    }
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
