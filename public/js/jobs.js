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

  $('.job-keywords').flexdatalist({
    selectionRequired: true,
    minLength: 1,
    removeOnBackspace: false
  });

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

}).call(this);
