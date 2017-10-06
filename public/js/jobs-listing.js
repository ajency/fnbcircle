(function() {
  var displayCityText, filterJobs;

  filterJobs = function(append) {
    var areaValues, experienceValues, jobTypeValues, keywords;
    if (append === void 0) {
      append = false;
    }
    experienceValues = [];
    $('input[name="experience[]"]:checked').map(function() {
      return experienceValues.push($(this).val());
    });
    jobTypeValues = [];
    $('input[name="job_type[]"]:checked').map(function() {
      return jobTypeValues.push($(this).val());
    });
    areaValues = [];
    $('input[name="areas[]"]:checked').map(function() {
      return areaValues.push($(this).val());
    });
    keywords = [];
    $('input[name="keyword_id[]"]').map(function() {
      return keywords.push($(this).val());
    });
    return $.ajax({
      type: 'post',
      url: 'jobs/get-listing-jobs',
      data: {
        'job_name': $('#job_name').val(),
        'company_name': '',
        'job_type': jobTypeValues,
        'city': $('select[name="job_city"]').val(),
        'area': areaValues,
        'experience': experienceValues,
        'category': '',
        'keywords': keywords,
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

  $(document).on('change', '.search-job', function() {
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
          area_html += '<input type="checkbox" class="checkbox p-r-10 search-job" name="areas[]" value="' + data[key]['id'] + '" class="checkbox p-r-10">';
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

  $('.job-keywords').on('select:flexdatalist', function(event, set, options) {
    var inputTxt;
    inputTxt = '<input type="hidden" name="keyword_id[]" value="' + set.id + '" label="' + set.label + '">';
    $('#keyword-ids').append(inputTxt);
    return filterJobs();
  });

  $('.job-keywords').on('change:flexdatalist', function(event, set, options) {
    if (set.length && $('input[label="' + set[0]['text'] + '"]').length) {
      $('input[label="' + set[0]['text'] + '"]').remove();
      return filterJobs();
    }
  });

  $(document).ready(function() {
    $('.job-keywords').flexdatalist({
      removeOnBackspace: false,
      searchByWord: true,
      searchContain: true,
      selectionRequired: true,
      minLength: 1,
      url: '/get-keywords',
      searchIn: ["label"]
    });
    displayCityText($('select[name="job_city"]'));
    return filterJobs();
  });

}).call(this);
