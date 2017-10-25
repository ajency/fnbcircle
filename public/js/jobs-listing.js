(function() {
  var displayCityText, filterJobs, strSlug;

  filterJobs = function(resetPage) {
    var append, areaSlugs, areaValues, category_id, category_slug, city, cityId, cityObj, experienceValues, jobTypeSlug, jobTypeValues, job_name, keywords, keywordslug, page, salary_lower, salary_type, salary_type_obj, salary_type_slug, salary_upper, urlParams;
    append = false;
    if (resetPage) {
      $('input[name="listing_page"]').val(1);
    }
    experienceValues = [];
    $('input[name="experience[]"]:checked').map(function() {
      return experienceValues.push($(this).val());
    });
    jobTypeValues = [];
    jobTypeSlug = [];
    $('input[name="job_type[]"]:checked').map(function() {
      jobTypeValues.push($(this).val());
      return jobTypeSlug.push($(this).attr('slug'));
    });
    areaValues = [];
    areaSlugs = [];
    $('input[name="areas[]"]:checked').map(function() {
      areaValues.push($(this).val());
      return areaSlugs.push($(this).attr('slug'));
    });
    keywords = [];
    keywordslug = [];
    $('input[name="keyword_id[]"]').map(function() {
      var keyword_slug_str;
      keywords.push($(this).val());
      keyword_slug_str = $(this).val() + '|' + strSlug($(this).attr('label'));
      return keywordslug.push(keyword_slug_str);
    });
    urlParams = '';
    job_name = $('#job_name').val();
    city = $('select[name="job_city"]').val();
    cityObj = $('select[name="job_city"]');
    cityId = $('option:selected', cityObj).attr('id');
    category_id = $('input[name="category_id"]').val();
    category_slug = $('input[name="category_id"]').attr('slug');
    salary_type_obj = $('select[name="salary_type"]');
    salary_type = salary_type_obj.val();
    salary_type_slug = $("option:selected", salary_type_obj).attr("slug");
    salary_lower = $('input[name="salary_lower"]').val();
    salary_upper = $('input[name="salary_upper"]').val();
    page = $('input[name="listing_page"]').val();
    if (page !== '') {
      urlParams += 'page=' + page;
    }
    if (city !== '') {
      urlParams += '&city=' + city;
    }
    if (salary_type !== '') {
      urlParams += '&salary_type=' + salary_type_slug;
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
      urlParams += '&category=' + category_slug;
    }
    if (jobTypeValues.length !== 0) {
      urlParams += '&job_type=' + JSON.stringify(jobTypeSlug);
    }
    if (areaValues.length !== 0) {
      urlParams += '&area=' + JSON.stringify(areaSlugs);
    }
    if (experienceValues.length !== 0) {
      urlParams += '&experience=' + JSON.stringify(experienceValues);
    }
    if (keywords.length !== 0) {
      urlParams += '&keywords=' + JSON.stringify(keywordslug);
    }
    window.history.pushState("", "", "?" + urlParams);
    return $.ajax({
      type: 'post',
      url: 'jobs/get-listing-jobs',
      data: {
        'page': page,
        'job_name': job_name,
        'company_name': '',
        'job_type': jobTypeValues,
        'city': cityId,
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
        $("#filtered_count").text(response.filtered_items);
        $("#total_count").text(response.total_items);
        $(".job-pagination").html(response.pagination);
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
    filterJobs(true);
  });

  $(document).on('change', '.search-checkbox', function() {
    if (($(this).closest('.filter-row').find('.search-checkbox:checked').length)) {
      return $(this).closest('.filter-row').find('.clear').removeClass('hidden');
    } else {
      return $(this).closest('.filter-row').find('.clear').addClass('hidden');
    }
  });

  $(document).on('click', '.apply-filters', function() {
    filterJobs(true);
    $('.back-icon').click();
  });

  strSlug = function(str) {
    var from, i, l, to;
    str = str.replace(/^\s+|\s+$/g, '');
    str = str.toLowerCase();
    from = 'àáäâèéëêìíïîòóöôùúüûñç·/_,:;';
    to = 'aaaaeeeeiiiioooouuuunc------';
    i = 0;
    l = from.length;
    while (i < l) {
      str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
      i++;
    }
    str = str.replace(/[^a-z0-9 -]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-');
    return str;
  };

  $('.clear-all-filters').click(function() {
    $('.clear-checkbox').click();
    $('.clear-keywords').click();
    $('.clear-checkbox').click();
    $('.clear-salary').click();
    $('input[name="category_id"]').val('');
    $('input[name="category_id"]').attr('slug', '');
    if ($(window).width() > 769) {
      $('input[name="job_name"]').val('');
      $('input[name="search_category"]').val('');
    } else {
      $('.back-icon').click();
    }
    return filterJobs(true);
  });

  $('.clear-checkbox').click(function() {
    $(this).closest('.filter-check').find('input[type="checkbox"]').prop('checked', false);
    return filterJobs(true);
  });

  $('.clear-keywords').click(function() {
    $('.flexdatalist-multiple').find('li[class="value"]').each(function() {
      return $(this).find('.fdl-remove').click();
    });
    return filterJobs(true);
  });

  $('.clear-salary').click(function() {
    $('select[name="salary_type"]').prop("selectedIndex", 0);
    $('input[name="salary_lower"]').val('');
    $('input[name="salary_upper"]').val('');
    return filterJobs(true);
  });

  $('select[name="salary_type"]').change(function() {
    var maxSalary, minSalary;
    if ($(this).val() !== '') {
      minSalary = $("option:selected", this).attr("min");
      maxSalary = $("option:selected", this).attr("max");
      $('input[name="salary_lower"]').val(minSalary);
      $('input[name="salary_upper"]').val(maxSalary);
      $('.salary-range').removeClass('hidden');
      $(this).closest('.filter-row').find('.clear').removeClass('hidden');
    } else {
      $('.salary-range').addClass('hidden');
      $('input[name="salary_lower"]').val('');
      $('input[name="salary_upper"]').val('');
      $(this).closest('.filter-row').find('.clear').addClass('hidden');
    }
  });

  $('.header_city').change(function() {
    var cityText;
    cityText = $('option:selected', this).text();
    window.location.href = '/' + cityText + '/job-listings';
  });

  $('select[name="job_city"]').change(function() {
    var cityText;
    cityText = $('option:selected', this).text();
    $(".fnb-breadcrums li:nth-child(3)").find('a').attr('href', '/' + cityText + '/job-listings?city=' + cityText);
    $(".fnb-breadcrums li:nth-child(3)").find('p').text(cityText);
    $(".serach_state_name").html(cityText);
    console.log(cityText);
    displayCityText();
  });

  $('input[name="area_search"]').change(function() {
    return displayCityText();
  });

  displayCityText = function() {
    var cityId, cityObj, cityText;
    cityObj = $('select[name="job_city"]');
    cityText = $('option:selected', cityObj).text();
    cityId = $('option:selected', cityObj).attr('id');
    $(".serach_state_name").html(cityText);
    console.log(cityText);
    return $.ajax({
      type: 'post',
      url: '/get_areas',
      data: {
        'city': cityId,
        'area_name': $('input[name="area_search"]').val()
      },
      success: function(data) {
        var area_html, key, serachClass;
        area_html = '';
        if ($(window).width() < 769) {
          serachClass = '';
        } else {
          serachClass = 'search-job';
        }
        for (key in data) {
          area_html += '<label class="sub-title flex-row text-color">';
          area_html += '<input type="checkbox" class="checkbox p-r-10  search-checkbox ' + serachClass + '" name="areas[]" value="' + data[key]['id'] + '" slug="' + data[key]['slug'] + '" class="checkbox p-r-10">';
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

  $('.job-pagination').on('click', '.paginate', function() {
    var page;
    page = $(this).attr('page');
    $('input[name="listing_page"]').val(page);
    return filterJobs(false);
  });

  $('.job-keywords').on('select:flexdatalist', function(event, set, options) {
    var inputTxt;
    inputTxt = '<input type="hidden" name="keyword_id[]" class="job-input-keywords" value="' + set.id + '" label="' + set.label + '">';
    $('#keyword-ids').append(inputTxt);
    $('.job-keywords').closest('.filter-row').find('.clear').removeClass('hidden');
    if ($(window).width() > 769) {
      return filterJobs(true);
    }
  });

  $('.job-keywords').on('before:flexdatalist.remove', function(event, set, options) {
    var keywordlabel;
    keywordlabel = set[0]['textContent'].slice(0, -1);
    $('input[label="' + keywordlabel + '"]').remove();
    if (!$('input[name="keyword_id[]"]').length) {
      $('.job-keywords').closest('.filter-row').find('.clear').addClass('hidden');
    }
    if ($(window).width() > 769) {
      return filterJobs(true);
    }
  });

  $(document).ready(function() {
    if ($(window).width() < 769) {
      $('.serach-sidebar').find('.search-job').removeClass('search-job');
    }
    $('.job-keywords').flexdatalist({
      removeOnBackspace: false,
      searchByWord: true,
      searchContain: true,
      minLength: 1,
      url: '/get-keywords',
      searchIn: ["label"]
    });
    $('.job-categories').flexdatalist({
      removeOnBackspace: false,
      searchByWord: true,
      searchContain: true,
      minLength: 0,
      url: '/job/get-category-types',
      searchIn: ["name"]
    });
    $('.job-categories').on('select:flexdatalist', function(event, set, options) {
      $('input[name="category_id"]').val(set.id);
      $('input[name="category_id"]').attr('slug', set.slug);
      $(".fnb-breadcrums li:nth-child(5)").find('p').text('Jobs for ' + set.name);
      return filterJobs(true);
    });
    $('.job-categories').on('change:flexdatalist', function(event, set, options) {
      if (set.value === '') {
        $('input[name="category_id"]').val('');
        $('input[name="category_id"]').attr('slug', '');
        return filterJobs(true);
      }
    });
    if ($('.area-list').attr('has-filter').trim() === 'no') {
      displayCityText();
    }
    return filterJobs(true);
  });

}).call(this);
