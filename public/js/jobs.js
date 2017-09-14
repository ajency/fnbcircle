(function() {
  $(document).on('change', 'select[name="job_city[]"]', function() {
    var city, html, jobCityObj;
    jobCityObj = $(this);
    html = '';
    jobCityObj.closest('.location-select').find('select[name="job_area[]"]').html(html);
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
        jobCityObj.closest('.location-select').find('select[name="job_area[]"]').html(html);
        jobCityObj.closest('.location-select').find('select[name="job_area[]"]').multiselect('destroy');
        jobCityObj.closest('.location-select').find('select[name="job_area[]"]').multiselect({
          includeSelectAllOption: true,
          numberDisplayed: 1,
          nonSelectedText: 'Select Area(s)'
        });
      },
      error: function(request, status, error) {
        throwError();
      }
    });
  });

  setTimeout((function() {
    $('.years-experience').flexdatalist({
      valueProperty: 'id',
      selectionRequired: true,
      removeOnBackspace: false
    });
  }), 500);

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

}).call(this);
