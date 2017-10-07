(function() {
  var displayCityText, filterJobs;

  filterJobs = function(append) {
    var areaValues, category_id, city, experienceValues, jobTypeValues, job_name, keywords, salary_lower, salary_type, salary_upper, urlParams;
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
    urlParams = '';
    job_name = $('#job_name').val();
    city = $('select[name="job_city"]').val();
    category_id = $('input[name="category_id"]').val();
    salary_type = $('select[name="salary_type"]').val();
    salary_lower = $('input[name="salary_lower"]').val();
    salary_upper = $('input[name="salary_upper"]').val();
    if (city !== '') {
      urlParams += 'city=' + city;
    }
    if (salary_type !== '') {
      urlParams += '&salary_type=' + salary_type;
    }
    if (salary_lower !== '') {
      urlParams += '&salary_lower=' + salary_lower;
    }
    if (salary_upper !== '') {
      urlParams += '&salary_upper=' + salary_upper;
    }
    if (job_name.trim() !== '') {
      urlParams += '&job_name=' + job_name;
    }
    if (category_id !== '') {
      urlParams += '&category=' + category_id;
    }
    if (jobTypeValues.length !== 0) {
      urlParams += '&job_type=' + JSON.stringify(jobTypeValues);
    }
    if (areaValues.length !== 0) {
      urlParams += '&area=' + JSON.stringify(areaValues);
    }
    if (experienceValues.length !== 0) {
      urlParams += '&experience=' + JSON.stringify(experienceValues);
    }
    if (keywords.length !== 0) {
      urlParams += '&keywords=' + JSON.stringify(keywords);
    }
    window.history.pushState("", "", "?" + urlParams);
    return $.ajax({
      type: 'post',
      url: 'jobs/get-listing-jobs',
      data: {
        'job_name': job_name,
        'company_name': '',
        'job_type': jobTypeValues,
        'city': city,
        'area': areaValues,
        'experience': experienceValues,
        'category': category_id,
        'keywords': keywords,
        'salary_type': salary_type,
        'salary_lower': salary_lower,
        'salary_upper': salary_upper,
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
    displayCityText();
  });

  $('input[name="area_search"]').change(function() {
    return displayCityText();
  });

  displayCityText = function() {
    var cityObj, cityText;
    cityObj = $('select[name="job_city"]');
    cityText = $('option:selected', cityObj).text();
    $("#state_name").text(cityText);
    return $.ajax({
      type: 'post',
      url: '/get_areas',
      data: {
        'city': cityObj.val(),
        'area_name': $('input[name="area_search"]').val()
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
    console.log(36);
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
    $('.job-categories').flexdatalist({
      removeOnBackspace: false,
      searchByWord: true,
      searchContain: true,
      selectionRequired: true,
      minLength: 1,
      url: '/job/get-category-types',
      searchIn: ["name"]
    });
    $('.job-categories').on('select:flexdatalist', function(event, set, options) {
      $('input[name="category_id"]').val(set.id);
      return filterJobs();
    });
    displayCityText();
    return filterJobs();
  });

}).call(this);
