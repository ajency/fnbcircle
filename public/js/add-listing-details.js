(function() {
  var today, yyyy;

  window.Parsley.addValidator('urlstrict', {
    validateString: function(value) {
      var regExp;
      regExp = /^(https?|s?ftp|git):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i;
      if ('' !== value) {
        return regExp.test(value);
      } else {
        return false;
      }
    },
    messages: {
      en: 'Must be a valid URL'
    }
  });

  today = new Date;

  yyyy = today.getFullYear();

  $('input#established-year').attr('data-parsley-max', yyyy);

  $('body').on('change', 'input#selectall', function() {
    if ($(this).prop('checked')) {
      return $('.payment-modes input[type="checkbox"]').each(function() {
        return $(this).prop('checked', true);
      });
    } else {
      return $('.payment-modes input[type="checkbox"]').each(function() {
        return $(this).prop('checked', false);
      });
    }
  });

  $('body').on('change', '.payment-modes input[type="checkbox"]', function() {
    if ($(this).prop('checked')) {
      if ($('.payment-modes input[type="checkbox"]').length === $('.payment-modes input[type="checkbox"]:checked').length) {
        return $('input#selectall').prop('checked', true);
      }
    } else {
      if ($('input#selectall').prop('checked')) {
        return $('input#selectall').prop('checked', false);
      }
    }
  });

  $('body').on('click', '.add-highlight', function() {
    var highlight_group, highlight_group_clone;
    highlight_group = $(this).closest('.highlight-input-group');
    highlight_group_clone = highlight_group.clone();
    highlight_group_clone.find('.add-highlight').remove();
    highlight_group_clone.find('.delete-highlight').removeClass('hidden');
    highlight_group_clone.insertBefore(highlight_group);
    return highlight_group.find('.highlight-input').val('');
  });

  $('body').on('click', '.delete-highlight', function() {
    return $(this).closest('.highlight-input-group').remove();
  });

  window.validateBusinessDetails = function() {
    var form, instance, parameters;
    instance = $('#info-form').parsley();
    if (!instance.validate()) {
      return false;
    }
    parameters = {};
    parameters['listing_id'] = document.getElementById('listing_id').value;
    parameters['step'] = 'business-details';
    parameters['change'] = window.change;
    parameters['description'] = $('.business-details textarea').val();
    $('input.fnb-input.highlight-input').each(function(index, item) {
      return parameters['highlights[' + index + ']'] = $(item).val();
    });
    parameters['established'] = $('input#established-year').val();
    parameters['website'] = $('input#business-website').val();
    $('.payment-modes input[type="checkbox"]').each(function(index, item) {
      if ($(item).prop('checked')) {
        parameters['payment[' + $(item).attr('id') + ']'] = "1";
      } else {
        parameters['payment[' + $(item).attr('id') + ']'] = "0";
      }
    });
    if (window.submit === 1) {
      parameters['submitReview'] = 'yes';
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

}).call(this);
