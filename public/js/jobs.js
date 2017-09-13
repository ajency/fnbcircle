(function() {
  $(document).on('change', 'select[name="job_city[]"]', function() {
    var city, html, jobCityObj;
    jobCityObj = $(this);
    html = '<option value="" selected>Select Area </option>';
    jobCityObj.closest('.location-select').find('.area select').html(html);
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
        jobCityObj.closest('.location-select').find('.area select').html(html);
      },
      error: function(request, status, error) {
        throwError();
      }
    });
  });

  $('.years-experience').flexdatalist({
    valueProperty: 'id',
    selectionRequired: true,
    removeOnBackspace: false
  });

}).call(this);
