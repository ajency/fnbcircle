(function() {
  var displayCityText, filterJobs;

  filterJobs = function(append) {
    if (append === void 0) {
      append = false;
    }
    return $.ajax({
      type: 'post',
      url: 'jobs/get-listing-jobs',
      data: {
        'job_name': $('#job_name').val(),
        'company_name': '',
        'job_status': '',
        'city': $('select[name="job_city"]').val(),
        'category': '',
        'keywords': '',
        'append': append
      },
      success: function(response) {
        $("#total_count").text(response.total_items);
        if (append) {
          return $('.job-listings').append(response.data);
        } else {
          $('.job-listings').html('');
          return $('.job-listings').html(response.data);
        }
      },
      error: function(request, status, error) {
        throwError();
      }
    });
  };

  $('.search-job').change(function() {
    filterJobs();
  });

  $('.header_city').change(function() {
    var cityText;
    cityText = $('option:selected', this).text();
    window.location.href = '/' + cityText + '/job-listings';
  });

  $('select[name="job_city"]').change(function() {
    displayCityText($(this));
  });

  displayCityText = function(cityObj) {
    var cityText;
    cityText = $('option:selected', cityObj).text();
    $("#state_name").text(cityText);
    return $.ajax({
      type: 'post',
      url: '/get_areas',
      data: {
        'city': cityObj.val()
      },
      success: function(data) {
        var area_html, key;
        area_html = '';
        for (key in data) {
          area_html += '<label class="sub-title flex-row text-color">';
          area_html += '<input type="checkbox" name="areas[]" value="' + data[key]['id'] + '" class="checkbox p-r-10">';
          area_html += '<span>' + data[key]['name'] + '</span>';
          area_html += '</label>';
        }
        $(".area-list").html(area_html);
      },
      error: function(request, status, error) {
        throwError();
      }
    });
  };

  $(document).ready(function() {
    displayCityText($('select[name="job_city"]'));
    return filterJobs();
  });

}).call(this);
