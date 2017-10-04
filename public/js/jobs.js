(function() {
  var Applybtn, Articles, companyLogo, coreCat;

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

  $('input[name="salary_type"]').change(function(e) {
    $('.salary-amt').attr('data-parsley-required', true);
    console.log($('input[name="salary_lower"]').attr('salary_type_checked'));
    if ($('input[name="salary_lower"]').attr('salary-type-checked') === "true") {
      return $('.salary-amt').val('');
    }
  });

  $('#job-form').bind('input select textarea iframe', function() {
    $('input[name="has_changes"]').val(1);
  });

  $('.clear-salary').on('click', function() {
    $('input[name="salary_type"]').prop('checked', false).removeAttr('data-parsley-required');
    $('input[name="salary_lower"]').removeAttr('data-parsley-required').val('');
    return $('input[name="salary_upper"]').removeAttr('data-parsley-required').val('');
  });

  if ($('.years-experience').length) {
    $('.years-experience').flexdatalist({
      selectionRequired: true,
      minLength: 1,
      removeOnBackspace: false
    });
  }

  $(document).ready(function() {
    if ($('.job-keywords').length) {
      $('.job-keywords').flexdatalist({
        removeOnBackspace: false,
        searchByWord: true,
        searchContain: true,
        selectionRequired: true,
        minLength: 1,
        url: '/get-keywords',
        searchIn: ["label"]
      });
      return;
    }
    if ($('.auto-company').length) {
      $('.auto-company').flexdatalist({
        removeOnBackspace: false,
        searchByWord: true,
        searchContain: true,
        selectionRequired: true,
        minLength: 1,
        url: '/get-company',
        searchIn: ["title"]
      });
    }
  });

  $('.job-keywords').on('select:flexdatalist', function(event, set, options) {
    var inputTxt;
    inputTxt = '<input type="hidden" name="keyword_id[' + set.id + ']" value="' + set.label + '" label="">';
    $('#keyword-ids').append(inputTxt);
  });

  $('.auto-company').on('select:flexdatalist', function(event, set, options) {
    $('input[name="company_id"]').val(set.id);
    if (set.logo === '') {
      $('input[name="company_logo"]').removeAttr('data-default-file');
      $('.dropify-preview').css('display', 'none');
      $('.dropify-wrapper').removeClass('has-preview');
      $('.dropify-render').html('');
    } else {
      $('input[name="company_logo"]').attr('data-default-file', set.logo);
      $('.dropify-preview').css('display', 'block');
      $('.dropify-wrapper').addClass('has-preview');
      $('.dropify-render').html('<img src="' + set.logo + '">');
    }
    $('textarea[name="company_description"]').text(set.description);
    CKEDITOR.instances['editor'].setData(set.description);
    $('input[name="company_website"]').val(set.website);
  });

  $('.job-save-btn').click(function(e) {
    var editorStr;
    e.preventDefault();
    if ($('.flex-data-row .flexdatalist-multiple li').hasClass('value')) {
      $('.job-keywords').removeAttr('data-parsley-required');
    } else {
      $('.job-keywords').attr('data-parsley-required', '');
    }
    if ($('input[name="step"]').val() === 'job-details' || $('input[name="step"]').val() === 'company-details') {
      CKEDITOR.instances.editor.updateElement();
      editorStr = CKEDITOR.instances.editor.getData();
      editorStr = editorStr.replace(/&nbsp;/g, '');
      editorStr = editorStr.replace("<p>", "");
      editorStr = editorStr.replace("</p>", "");
      if (editorStr === "") {
        CKEDITOR.instances.editor.setData('');
      }
    }
    $(this).closest('form').submit();
  });

  $('#salary_lower').on('change', function() {
    var salaryLower, salaryUpper;
    if ($(this).val() !== '') {
      $(this).attr('salary-type-checked', $('input[name="salary_type"]').is(':checked'));
      salaryLower = parseInt($(this).val());
      salaryUpper = parseInt($('#salary_upper').val());
      $('#salary_upper').attr('data-parsley-min', salaryLower);
      $('#salary_upper').attr('data-parsley-required', true);
      $('input[name="salary_type"]').attr('data-parsley-required', true);
      if (salaryUpper === '' && salaryUpper < salaryLower) {
        $('#salary_upper').val(parseInt(salaryLower + 1));
        $('#salary_upper').attr('min', salaryLower);
      }
    } else {
      $('#salary_upper').removeAttr('data-parsley-min');
      $('#salary_upper').removeAttr('data-parsley-required');
      $('input[name="salary_type"]').removeAttr('data-parsley-required');
      $('#salary_upper').val('');
      $('#salary_upper').attr('min', 0);
    }
  });

  $('#salary_upper').on('change', function() {
    if ($(this).val() !== '') {
      $('#salary_lower').attr('salary-type-checked', $('input[name="salary_type"]').is(':checked'));
      $('#salary_lower').attr('data-parsley-required', true);
    } else {
      $('#salary_lower').removeAttr('data-parsley-required');
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

  $('#job-form').on('keyup keypress', function(e) {
    var keyCode;
    keyCode = e.keyCode || e.which;
    if (keyCode === 13) {
      e.preventDefault();
      return false;
    }
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

  if ($('.expSelect').length) {
    $('.expSelect').multiselect({
      includeSelectAllOption: true,
      numberDisplayed: 2,
      delimiterText: ',',
      nonSelectedText: 'Select Experience'
    });
  }

  if ($(window).width() > 769) {
    if ($('.comp-logo').length) {
      companyLogo = $('.comp-logo').dropify({
        messages: {
          'default': 'Add Logo',
          'replace': 'Change Logo',
          'remove': '<i class="">&#10005;</i>'
        }
      });
    }
  }

  if ($(window).width() < 769) {
    if ($('.comp-logo').length) {
      companyLogo = $('.comp-logo').dropify({
        messages: {
          'default': 'Add Logo',
          'replace': 'Change Logo'
        }
      });
    }
  }

  if ($('.comp-logo').length) {
    companyLogo.on('dropify.afterClear', function(event, element) {
      $("input[name='delete_logo']").val(1);
      return $("input[type='file']").attr('title', '');
    });
  }

  if ($('.flex-data-row .flexdatalist-multiple li').hasClass('value')) {

  } else {
    $('.job-keywords').attr('data-parsley-required', '');
  }

  $('body').on('keyup', '.job-keywords', function(e) {
    if ($('.flex-data-row .flexdatalist-multiple li').hasClass('value')) {
      return $('.job-keywords').removeAttr('data-parsley-required');
    } else {
      return $('.job-keywords').attr('data-parsley-required', '');
    }
  });

  $('body').on('blur', '.job-keywords', function(e) {
    if ($('.flex-data-row .flexdatalist-multiple li').hasClass('value')) {
      return $('.job-keywords').removeAttr('data-parsley-required');
    } else {
      return $('.job-keywords').attr('data-parsley-required', '');
    }
  });

  if ($('#editor').length) {
    CKEDITOR.replace('editor');
    CKEDITOR.instances.editor.on('change', function() {
      $('input[name="has_changes"]').val(1);
    });
  }

  $("html").easeScroll();

  if ($(window).width() > 769) {
    setTimeout((function() {
      var getheight;
      getheight = $('.design-2-card').outerHeight();
      $('.equal-col').css('height', getheight);
    }), 500);
  }

  $('.check-detail').click(function() {
    $('html, body').animate({
      scrollTop: $('#about-company').offset().top - 20
    }, 2000);
  });

  $('.scroll-to-location').click(function() {
    $('html, body').animate({
      scrollTop: $('#map').offset().top - 35
    }, 2000);
  });

  $('.more-show').click(function(event) {
    event.preventDefault();
    $(this).addClass('hidden');
    $('.line').addClass('hidden');
    $(this).parent().addClass('expand-more');
  });

  if ($(window).width() <= 768) {
    coreCat = $('.detach-col-1').detach();
    $('.sell-re').after(coreCat);
    Applybtn = $('.applyJob').detach();
    $('.role-selection').after(Applybtn);
    Articles = $('.related-article').detach();
    $('.list-of-business').after(Articles);
  }

  $('[data-toggle="tooltip"]').tooltip();

  $('.add-job-areas').click(function(e) {
    var area_group, area_group_clone;
    area_group = void 0;
    area_group_clone = void 0;
    e.preventDefault();
    area_group = $(this).closest('.areas-select').find('.area-append');
    area_group_clone = area_group.clone();
    area_group_clone.removeClass('area-append hidden');
    area_group_clone.find('.areas-appended').addClass('newly-created');
    area_group_clone.find('.selectCity').attr('data-parsley-required', '');
    area_group_clone.find('.selectCity').attr('data-parsley-required-message', 'Select a city where the job is located.');
    area_group_clone.find('.newly-created').attr('data-parsley-required', '');
    area_group_clone.find('.newly-created').attr('data-parsley-required-message', 'Select an area where the job is located.');
    area_group_clone.find('.newly-created').multiselect({
      includeSelectAllOption: true,
      numberDisplayed: 1,
      nonSelectedText: 'Select Area(s)'
    });
    area_group_clone.insertBefore(area_group);
  });

}).call(this);
