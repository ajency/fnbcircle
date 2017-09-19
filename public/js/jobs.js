(function() {
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
          numberDisplayed: 2,
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
    if ($('.flex-data-row .flexdatalist-multiple li').hasClass('value')) {
      $('.job-keywords').removeAttr('data-parsley-required');
    } else {
      $('.job-keywords').attr('data-parsley-required', '');
    }
    console.log($('input[name="step"]').val());
    if ($('input[name="step"]').val() === 'step-one' || $('input[name="step"]').val() === 'step-two') {
      CKEDITOR.instances.editor.updateElement();
    }
    $('form').submit();
  });

  $('#salary_lower').on('change', function() {
    var salaryLower, salaryUpper;
    if ($(this).val() !== '') {
      salaryLower = parseInt($(this).val());
      salaryUpper = parseInt($('#salary_upper').val());
      $('#salary_upper').attr('data-parsley-min', salaryLower);
      $('#salary_upper').attr('data-parsley-required', true);
      if (salaryUpper === '' && salaryUpper < salaryLower) {
        $('#salary_upper').val(parseInt(salaryLower + 1));
        $('#salary_upper').attr('min', salaryLower);
      }
    } else {
      console.log(1212);
      $('#salary_upper').removeAttr('data-parsley-min');
      $('#salary_upper').removeAttr('data-parsley-required');
      $('#salary_upper').val('');
      $('#salary_upper').removeAttr('min');
    }
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

  $('.expSelect').multiselect({
    includeSelectAllOption: true,
    numberDisplayed: 2,
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

  if ($('.flex-data-row .flexdatalist-multiple li').hasClass('value')) {

  } else {
    $('.job-keywords').attr('data-parsley-required', '');
  }

  $('body').on('keyup', '.job-keywords', function(e) {
    if ($('.flex-data-row .flexdatalist-multiple li').hasClass('value')) {
      $('.job-keywords').removeAttr('data-parsley-required');
    } else {
      $('.job-keywords').attr('data-parsley-required', '');
    }
  });

  $('body').on('blur', '.job-keywords', function(e) {
    if ($('.flex-data-row .flexdatalist-multiple li').hasClass('value')) {
      $('.job-keywords').removeAttr('data-parsley-required');
      console.log('removed');
    } else {
      $('.job-keywords').attr('data-parsley-required', '');
      console.log('added');
    }
  });

}).call(this);
