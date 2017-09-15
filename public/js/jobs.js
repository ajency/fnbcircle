(function() {
  $(document).on('change', 'select[name="job_city[]"]', function() {
    var city, html, jobCityObj;
    jobCityObj = $(this);
    html = '';
    jobCityObj.closest('.location-select').find('.job-areas').html(html);
    city = $(this).val();
    if (city === '') {
      return;
    }
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
          numberDisplayed: 1,
          nonSelectedText: 'Select Area(s)'
        });
        jobCityObj.closest('.location-select').find('.job-areas').attr('name', 'job_area[' + city + '][]');
      },
      error: function(request, status, error) {
        throwError();
      }
    });
  });

  $('.years-experience').flexdatalist({
    selectionRequired: true,
    minLength: 1,
    removeOnBackspace: false
  });

  setTimeout((function() {
    $('.job-keywords').flexdatalist({
      removeOnBackspace: false,
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
    var salaryLower;
    salaryLower = $(this).val();
    $('#salary_upper').attr('data-parsley-min', salaryLower);
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
    var contactType, contactValue, objectId, objectType;
    contactValue = $(this).closest('.contact-container').find('.contact-input').val;
    contactType = $(this).closest('.contact-container').attr('contact-type');
    objectType = $('input[name="object_type"]').val;
    return objectId = $('input[name="object_id"]').val;
  });

  $('.contact-info').on('change', '.contact-input', function(event) {
    var contactObj, val;
    contactObj = $(this);
    val = contactObj.val;
    contactObj.closest('.contact-info').find('.contact-input').each(function() {
      console.log(contactObj.get(0));
      if (contactObj.get(0) !== $(this).get(0) && $(this).val() === val) {
        console.log($(this).val());
        console.log(val);
        contactObj.closest('div').find('.dupError').html(contactObj.val + ' already added to list.');
        contactObj.val('');
        return false;
      }
    });
  });

}).call(this);
