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

}).call(this);
