(function() {
  var checkDuplicateEntries, verifyContactDetail;

  $(document).on('change', 'select[name="job_city[]"]', function() {
    var city, html, jobCityObj;
    jobCityObj = $(this);
    html = '';
    jobCityObj.closest('.location-select').find('.job-areas').html(html);
    jobCityObj.closest('.city').find('.city-errors').text('');
    city = $(this).val();
    if (city === '') {
      return;
    }
    jobCityObj.closest('.areas-select').find('select[name="job_city[]"]').each(function() {
      if (jobCityObj.get(0) !== $(this).get(0) && $(this).val() === city) {
        jobCityObj.closest('.city').find('.city-errors').text('City already selected');
        jobCityObj.val('');
      }
    });
    return $.ajax({
      type: 'post',
      url: '/get_areas',
      data: {
        'city': city
      },
      success: function(data) {
        var key;
        for (key in data) {
          html += '<option value="' + data[key]['id'] + '">' + data[key]['name'] + '</option>';
        }
        console.log(html);
        jobCityObj.closest('.location-select').find('.job-areas').html(html);
        jobCityObj.closest('.location-select').find('.job-areas').multiselect('destroy');
        jobCityObj.closest('.location-select').find('.job-areas').multiselect({
          includeSelectAllOption: true,
          numberDisplayed: 5,
          delimiterText: ',',
          nonSelectedText: 'Select Area(s)'
        });
        jobCityObj.closest('.location-select').find('.job-areas').attr('name', 'job_area[' + city + '][]');
      },
      error: function(request, status, error) {
        throwError();
      }
    });
  });

  $('input[name="salary_type"]').click(function(e) {
    return $('.salary-amt').attr('data-parsley-required', true);
  });

  $('.years-experience').flexdatalist({
    selectionRequired: true,
    minLength: 1,
    removeOnBackspace: false
  });

  setTimeout((function() {
    $('.job-keywords').flexdatalist({
      removeOnBackspace: false,
      searchByWord: true,
      searchContain: true,
      selectionRequired: true,
      minLength: 1,
      url: '/get-keywords',
      searchIn: ["label"]
    });
  }), 500);

  $('.job-save-btn').click(function(e) {
    e.preventDefault();
    CKEDITOR.instances.editor.updateElement();
    $('form').submit();
  });

  $('#salary_lower').on('change', function() {
    var salaryLower, salaryUpper;
    salaryLower = parseInt($(this).val());
    salaryUpper = parseInt($('#salary_upper').val());
    if (salaryLower !== '') {
      $('#salary_upper').attr('data-parsley-min', salaryLower);
      if (salaryUpper === '' && salaryUpper < salaryLower) {
        $('#salary_upper').val(parseInt(salaryLower + 1));
        $('#salary_upper').attr(min(salaryLower));
      }
    } else {
      $('#salary_upper').removeAttr('data-parsley-min');
      $('#salary_upper').val('');
      $('#salary_upper').removeAttr(min(salaryLower));
    }
  });

  $('body').on('click', '.add-another', function(e) {
    var contact_group, contact_group_clone, input;
    e.preventDefault();
    contact_group = $(this).closest('.business-contact').find('.contact-group');
    contact_group_clone = contact_group.clone();
    contact_group_clone.removeClass('contact-group hidden');
    input = contact_group_clone.find('.fnb-input');
    input.attr('data-parsley-required', true);
    return contact_group_clone.insertBefore(contact_group);
  });

  $('body').on('click', '.removeRow', function() {
    if ($(this).closest('.contact-info').find('.contact-container').length === 2) {
      $(this).closest('.contact-info').find('.add-another').click();
    }
    return $(this).closest('.get-val').parent().remove();
  });

  $('body').on('click', '.add-custom', function(e) {
    e.preventDefault();
    $('.auto-exp-select').addClass('hidden');
    return $('.custom-exp').removeClass('hidden');
  });

  $('body').on('click', '.auto-select', function(e) {
    e.preventDefault();
    event.preventDefault();
    $('.auto-exp-select').removeClass('hidden');
    $('.custom-exp').addClass('hidden');
    return $('.custom-row:not(:first-child)').remove();
  });

  $('body').on('click', '.add-exp', function(e) {
    var highlight_group, highlight_group_clone;
    e.preventDefault();
    highlight_group = $(this).parent().closest('.custom-row');
    highlight_group_clone = highlight_group.clone();
    highlight_group_clone.find('.add-exp').remove();
    highlight_group_clone.find('.delete-exp').removeClass('hidden');
    highlight_group_clone.find('.exp-label').remove();
    return highlight_group_clone.insertAfter(highlight_group);
  });

  $('body').on('click', '.delete-exp', function(e) {
    e.preventDefault();
    return $(this).parent().closest('.custom-row').remove();
  });

  setTimeout((function() {
    $('.alert-success').addClass('active');
  }), 1000);

  setTimeout((function() {
    $('.alert-success').removeClass('active');
  }), 6000);

  $(document).on('click', '.verify-link', function(event) {
    $('.contact-container').removeClass('under-review');
    $(this).closest('.contact-container').addClass('under-review');
    return verifyContactDetail(true);
  });

  verifyContactDetail = function(showModal) {
    var contactType, contactValue, contactValueObj, objectId, objectType;
    contactValueObj = $('.under-review').find('.contact-input');
    contactValue = contactValueObj.val();
    contactType = $('.under-review').closest('.contact-info').attr('contact-type');
    objectType = $('input[name="object_type"]').val();
    objectId = $('input[name="object_id"]').val();
    if (showModal && contactValue !== '' && contactValueObj.parsley().validate()) {
      $('#' + contactType + '-modal').find('.contact-input-value').text(contactValue);
      $('#' + contactType + '-modal').modal('show');
      return $.ajax({
        type: 'post',
        url: '/user/verify-contact-details',
        data: {
          'id': '',
          'contact_value': contactValue,
          'contact_type': contactType,
          'object_id': objectId,
          'object_type': objectType
        },
        success: function(data) {},
        error: function(request, status, error) {
          throwError();
        },
        async: false
      });
    } else {
      return $('#' + contactType + '-modal').modal('hide');
    }
  };

  $('.contact-info').on('change', '.contact-input', function(event) {
    var contactObj, contactval;
    contactObj = $(this);
    contactval = contactObj.val();
    if (!checkDuplicateEntries(contactObj)) {
      contactObj.closest('div').find('.dupError').html(contactval + ' already added to list.');
      contactObj.val('');
    } else {
      contactObj.closest('div').find('.dupError').html('');
    }
  });

  checkDuplicateEntries = function(contactObj) {
    var contactval, result;
    contactval = contactObj.val();
    $('form').parsley().validate();
    result = true;
    contactObj.closest('.contact-info').find('.contact-input').each(function() {
      if (contactObj.get(0) !== $(this).get(0) && $(this).val() === contactval) {
        result = false;
        return false;
      }
    });
    return result;
  };

  $('.edit-number').click(function(event) {
    $('.value-enter').val('');
    $('.default-state').addClass('hidden');
    $('.add-number').removeClass('hidden');
    $('.verificationFooter').addClass('no-bg');
  });

  $('.step-back').click(function(event) {
    $('.default-state').removeClass('hidden');
    $('.add-number').addClass('hidden');
    $('.verificationFooter').removeClass('no-bg');
  });

  $('.verify-stuff').click(function(event) {
    var changedValue, newContactObj, oldContactObj, oldContactValue;
    newContactObj = $(this).closest('.modal').find('.change-contact-input');
    changedValue = newContactObj.val();
    oldContactValue = $(this).closest('.modal').find('.contact-input-value').text().trim();
    if (newContactObj.parsley().validate() === true) {
      oldContactObj = $('.under-review').find('.contact-input');
      oldContactObj.val(changedValue);
      if (!checkDuplicateEntries(oldContactObj)) {
        oldContactObj.val(oldCantactValue);
        $(this).closest('.verify-steps').find('.customError').text(changedValue + ' already added to list.');
      } else {
        $(this).closest('.verify-steps').find('.customError').text('');
        $(this).closest('.modal').find('.contact-input-value').text(changedValue);
        $('.default-state').removeClass('hidden');
        $('.add-number').addClass('hidden');
        $('.verificationFooter').removeClass('no-bg');
        verifyContactDetail(false);
      }
    }
  });

  $('.resend-link').click(function(event) {
    $(this).addClass('sending');
    setTimeout((function() {
      $('.resend-link').removeClass('sending');
    }), 2500);
  });

  $('.expSelect').multiselect({
    includeSelectAllOption: true,
    numberDisplayed: 5,
    delimiterText: ',',
    nonSelectedText: 'Select Experience'
  });

  if ($(window).width() > 769) {
    $('.comp-logo').dropify({
      messages: {
        'default': 'Add Logo',
        'replace': 'Change Logo',
        'remove': '<i class="">&#10005;</i>'
      }
    });
  }

  if ($(window).width() < 769) {
    $('.comp-logo').dropify({
      messages: {
        'default': 'Add Logo',
        'replace': 'Change Logo'
      }
    });
  }

  $(document).on('change', '.business-contact .toggle__check', function() {
    if ($(this).is(':checked')) {
      $(this).closest('.toggle').siblings('.toggle-state').text('Visible on the listing');
    } else {
      $(this).closest('.toggle').siblings('.toggle-state').text('Not visible on the listing');
    }
  });

}).call(this);
