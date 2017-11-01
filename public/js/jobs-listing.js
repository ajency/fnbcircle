(function() {
  var displayCityText, filterJobs, initSalaryBar, salaryRangeSlider, strSlug;

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
      console.log($(this).val());
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
    console.log(city);
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
      urlParams += '&state=' + city;
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
      urlParams += '&business_type=' + category_slug;
    }
    if (jobTypeValues.length !== 0) {
      urlParams += '&job_type=' + JSON.stringify(jobTypeSlug);
    }
    if (areaValues.length !== 0) {
      urlParams += '&city=' + JSON.stringify(areaSlugs);
    }
    if (experienceValues.length !== 0) {
      urlParams += '&experience=' + JSON.stringify(experienceValues);
    }
    if (keywords.length !== 0) {
      urlParams += '&job_roles=' + JSON.stringify(keywordslug);
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
        var filter_record_str;
        $('.section-loader').removeClass('hidden');
        if (response.total_items > 0) {
          filter_record_str = response.recordStarts + '-' + response.recordEnd;
        } else {
          filter_record_str = '0';
        }
        $("#filtered_count").text(filter_record_str);
        $(".total_count").text(response.total_items);
        $(".job-pagination").html(response.pagination);
        if (append) {
          $('.job-listings').append(response.data);
        } else {
          $('.job-listings').html('');
          $('.job-listings').html(response.data);
        }
        if ($('.job-list-desc').length) {
          $('.job-list-desc').readmore({
            speed: 25,
            collapsedHeight: 40,
            moreLink: '<a href="#" class="more-open more x-small secondary-link">View more</a>',
            lessLink: '<a href="#" class="more-open x-small less secondary-link">View less</a>'
          });
        }
        return $('.section-loader').addClass('hidden');
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

  $(document).on('change', '.salary-filter', function() {
    var maxSalary, minSalary, salFrom, salTo;
    minSalary = $("option:selected", $('select[name="salary_type"]')).attr("min");
    maxSalary = $("option:selected", $('select[name="salary_type"]')).attr("max");
    salFrom = $('input[name="salary_lower"]').val();
    salTo = $('input[name="salary_upper"]').val();
    return initSalaryBar(minSalary, maxSalary, salFrom, salTo);
  });

  $(document).on('click', '.job-pagination a.paginate:not(.active)', function() {
    return setTimeout((function() {
      $('html,body').animate({
        scrollTop: 0
      }, 1500);
    }), 500);
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
    $(this).closest('.filter-row').find('.clear').addClass('hidden');
    $(this).closest('.filter-check').find('input[type="checkbox"]').prop('checked', false);
    return filterJobs(true);
  });

  $('.clear-area').click(function() {
    if ($('.toggle-areas').attr('aria-expanded') === "true") {
      return $('.toggle-areas').click();
    }
  });

  $('.clear-keywords').click(function() {
    $(this).closest('.filter-row').find('.clear').addClass('hidden');
    $('.flexdatalist-multiple').find('li[class="value"]').each(function() {
      return $(this).find('.fdl-remove').click();
    });
    return filterJobs(true);
  });

  $('.clear-salary').click(function() {
    $(this).closest('.filter-row').find('.clear').addClass('hidden');
    $('select[name="salary_type"]').prop("selectedIndex", 0);
    $('input[name="salary_lower"]').val('');
    $('input[name="salary_upper"]').val('');
    $('.salary-range').addClass('hidden');
    return filterJobs(true);
  });

  $('select[name="salary_type"]').change(function() {
    var maxSalary, minSalary;
    if ($(this).val() !== '') {
      minSalary = $("option:selected", this).attr("min");
      maxSalary = $("option:selected", this).attr("max");
      initSalaryBar(minSalary, maxSalary, minSalary, maxSalary);
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

  $('#sal-input').ionRangeSlider({
    type: 'double',
    min: 0,
    max: 1000000,
    prefix: '<i class="fa fa-inr" aria-hidden="true"></i> ',
    onFinish: function(data) {
      $('input[name="salary_lower"]').val(data.from);
      $('input[name="salary_upper"]').val(data.to);
      return filterJobs(true);
    }
  });

  salaryRangeSlider = $("#sal-input").data("ionRangeSlider");

  initSalaryBar = function(minSal, maxSal, salFrom, salTo) {
    return salaryRangeSlider.update({
      type: 'double',
      min: minSal,
      max: maxSal,
      from: salFrom,
      to: salTo,
      prefix: '<i class="fa fa-inr" aria-hidden="true"></i> '
    });
  };

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
    if ($('input[name="category_id"]').val() === '') {
      $(".fnb-breadcrums li:nth-child(5)").find('p').text('All Jobs In ' + cityText);
    }
    $(".clear-area").click();
    displayCityText();
  });

  $('input[name="area_search"]').keyup(function() {
    var areas_found, search_key;
    search_key = $(this).val();
    areas_found = 0;
    $('.no-result-city').addClass('hidden');
    if (!($(this).closest("#section-area").find("#moreDown").attr('aria-expanded') === "true")) {
      $(this).closest("#section-area").find("#moreDown").collapse('show');
    }
    if (search_key.length > 0) {
      $("input[type='checkbox'][name='areas[]']").parent().addClass('hidden');
      $("input[type='checkbox'][name='areas[]']").each(function() {
        if ($(this).parent().text().toLowerCase().indexOf(search_key.toLowerCase()) > -1) {
          areas_found += 1;
          $(this).parent().removeClass("hidden");
        }
      });
      if ($("input[name='areas[]']").length === $('.area-list').find('label.hidden').length) {
        $('.no-result-city').removeClass('hidden').html('No results found for ' + search_key);
      }
      $(this).closest("#section-area").find("#moreAreaShow").addClass('hidden');
    } else {
      if ($('.area-list').find('label.hidden').length > 0) {
        $(this).closest("#section-area").find("#moreDown").collapse('hide');
      }
      if ($("input[type='checkbox'][name='areas[]']").length > 6) {
        $(this).closest("#section-area").find("#moreAreaShow").removeClass('hidden');
      }
      $("input[type='checkbox'][name='areas[]']").parent().removeClass('hidden');
    }
  });

  $('input[name="job_name"]').change(function() {
    return filterJobs(false);
  });

  displayCityText = function() {
    var areaSearchTxt, cityId, cityObj, cityText;
    cityObj = $('select[name="job_city"]');
    cityText = $('option:selected', cityObj).text();
    cityId = $('option:selected', cityObj).attr('id');
    $(".serach_state_name").html(cityText);
    areaSearchTxt = $('input[name="area_search"]').val();
    return $.ajax({
      type: 'post',
      url: '/get_areas',
      data: {
        'city': cityId,
        'area_name': areaSearchTxt
      },
      success: function(data) {
        var area_html, counter, key, morearea, searchClass, totalareafiltered;
        area_html = '';
        if ($(window).width() < 769) {
          searchClass = '';
        } else {
          searchClass = 'search-job';
        }
        $('.toggle-areas').addClass('hidden');
        totalareafiltered = parseInt(data.length);
        if (totalareafiltered) {
          for (key in data) {
            area_html += '<label class="sub-title flex-row text-color">';
            area_html += '<input type="checkbox" class="checkbox p-r-10  search-checkbox ' + searchClass + '" name="areas[]" value="' + data[key]['id'] + '" slug="' + data[key]['slug'] + '" class="checkbox p-r-10">';
            area_html += '<span>' + data[key]['name'] + '</span>';
            area_html += '</label>';
            counter = parseInt(key);
            if (counter === 5) {
              area_html += '<div class="more-section collapse" id="moreDown">';
            }
          }
          if (data.length > 6) {
            area_html += '</div>';
            morearea = totalareafiltered - 6;
            $('.toggle-areas').removeClass('hidden').text('+ ' + morearea + ' more');
          }
        } else {
          $('input[name="area_search"]').closest('.filter-row').find('.clear').addClass('hidden');
          area_html += 'No results found for ' + areaSearchTxt;
        }
        $(".area-list").html(area_html);
      },
      error: function(request, status, error) {
        throwError();
      }
    });
  };

  $('.title-search-btn').click(function() {
    return $('.back-icon').click();
  });

  $('.clear-input-text').click(function() {
    $(this).closest('div').find('input').val('');
    return filterJobs(false);
  });

  $('.job-pagination').on('click', '.paginate', function() {
    var page;
    page = $(this).attr('page');
    $('input[name="listing_page"]').val(page);
    return filterJobs(false);
  });

  $('.search-job-keywords').on('select:flexdatalist', function(event, set, options) {
    var inputTxt;
    inputTxt = '<input type="hidden" name="keyword_id[]" class="job-input-keywords" value="' + set.id + '" label="' + set.label + '">';
    $('#keyword-ids').append(inputTxt);
    $('.search-job-keywords').closest('.filter-row').find('.clear').removeClass('hidden');
    console.log($(window).width());
    if ($(window).width() > 769) {
      return filterJobs(true);
    }
  });

  $('.search-job-keywords').on('before:flexdatalist.remove', function(event, set, options) {
    var keywordlabel;
    keywordlabel = set[0]['textContent'].slice(0, -1);
    $('input[label="' + keywordlabel + '"]').remove();
    if (!$('input[name="keyword_id[]"]').length) {
      $('.search-job-keywords').closest('.filter-row').find('.clear').addClass('hidden');
    }
    if ($(window).width() > 769) {
      return filterJobs(true);
    }
  });

  $(document).on("click", "#section-area #moreAreaShow", function(event) {
    $(this).removeClass('hidden');
    if ($(this).attr('aria-expanded') === "true") {
      $(this).text($(this).text().replace("more", "less"));
    } else {
      $(this).text($(this).text().replace("less", "more"));
    }
  });

  $(document).ready(function() {
    var maxSalary, minSalary, salFrom, salTo;
    if ($('select[name="salary_type"]').val() !== '') {
      minSalary = $("option:selected", $('select[name="salary_type"]')).attr("min");
      maxSalary = $("option:selected", $('select[name="salary_type"]')).attr("max");
      salFrom = $('input[name="salary_lower"]').val();
      salTo = $('input[name="salary_upper"]').val();
      initSalaryBar(minSalary, maxSalary, salFrom, salTo);
    }
    if (($('.area-list').find('.show-all-list').length)) {
      $('.toggle-areas').click();
    }
    if ($(window).width() < 769) {
      $('.serach-sidebar').find('.search-job').removeClass('search-job');
    }
    $('.search-job-keywords').flexdatalist({
      removeOnBackspace: false,
      searchByWord: true,
      searchContain: true,
      minLength: 0,
      cache: false,
      maxShownResults: 5000,
      url: '/get-keywords',
      searchIn: ["label"]
    });
    $('.search-job-categories').flexdatalist({
      removeOnBackspace: false,
      searchByWord: true,
      searchContain: true,
      minLength: 0,
      cache: false,
      url: '/job/get-category-types',
      searchIn: ["name"]
    });
    $('.search-job-title').flexdatalist({
      params: {
        "state": $('option:selected', $('select[name="job_city"]')).attr('id'),
        "category": $('input[name="category_id"]').val()
      },
      removeOnBackspace: false,
      searchByWord: true,
      searchContain: true,
      minLength: 0,
      cache: false,
      searchDelay: 200,
      url: '/get-job-titles?id=' + $('input[name="category_id"]').val(),
      searchIn: ["title"]
    });
    if ($('.area-list').attr('has-filter').trim() === 'no') {
      displayCityText();
    }
    return filterJobs(true);
  });

  $('.search-job-categories').on('select:flexdatalist', function(event, set, options) {
    $('input[name="category_id"]').val(set.id);
    $('input[name="category_id"]').attr('slug', set.slug);
    $(".fnb-breadcrums li:nth-child(5)").find('p').text('Jobs for ' + set.name);
    $(".serach_category_name").html(set.name);
    filterJobs(true);
    if ($(window).width() < 769) {
      return $('.back-icon').click();
    }
  });

  $(document).on("focusin", '.search-job-title', function(event) {
    console.log($('input[name="category_id"]').val());
    $('.search-job-title').flexdatalist('params', {
      'state': $('option:selected', $('select[name="job_city"]')).attr('id'),
      "category": $('input[name="category_id"]').val()
    });
  });

  $('.search-job-categories').on('change:flexdatalist', function(event, set, options) {
    var cityObj, cityText;
    if (set.value === '') {
      $('input[name="category_id"]').val('');
      $('input[name="category_id"]').attr('slug', '');
      cityObj = $('select[name="job_city"]');
      cityText = $('option:selected', cityObj).text();
      $(".fnb-breadcrums li:nth-child(5)").find('p').text('All Jobs In ' + cityText);
      $(".serach_category_name").html('');
      console.log($('input[name="category_id"]').val());
      return filterJobs(true);
    }
  });

}).call(this);
