(function() {
  var capitalize, checkForInput, getCity, getFilterContent, getFilters, getListContent, getTemplateHTML, getUrlSearchParams, initFlagDrop, isMobile, resetFilter, resetPagination, updateCityDropdown, updateTextLabels, updateUrlPushstate;

  getTemplateHTML = function(templateToRender, data) {
    var htmlToRender, list, theTemplate, theTemplateScript;
    list = {};
    list['list'] = data;
    theTemplateScript = $("#" + templateToRender).html();
    theTemplate = Handlebars.compile(theTemplateScript);
    htmlToRender = theTemplate(list);
    return htmlToRender;
  };


  /* --- Function to check if Device is mobile or Desktop --- */

  isMobile = function() {
    if ($(window).width() <= 768) {
      return true;
    }
    return false;
  };

  getUrlSearchParams = function() {
    if (window.location.search.split("?").length > 1) {
      return window.location.search.split("?")[1].split("&");
    } else {
      return [""];
    }
  };

  updateUrlPushstate = function(key, pushstate_url) {
    var i, old_url, params;
    if (window.location.search.length <= 0 && window.location.search.indexOf(key) <= -1 && pushstate_url.length > 0) {
      window.history.pushState("", "", "?" + pushstate_url);
    } else if (window.location.search.length > 0 && window.location.search.indexOf(key) <= -1 && pushstate_url.length > 0) {
      window.history.pushState("", "", window.location.search + "&" + pushstate_url);
    } else {
      params = getUrlSearchParams();
      old_url = "";
      i = 0;
      if (params.length > 0 && window.location.search.indexOf(key) > -1) {
        while (i < params.length) {

          /* --- remove the key from the URL --- */
          if (params[i].indexOf(key) <= -1) {
            old_url += (old_url.length <= 0 ? "?" : "&") + params[i];
          }
          i++;
        }
        if (pushstate_url.length > 0) {

          /* --- the key has value, then update the new Value in the URL --- */
          if (old_url.length > 0) {
            window.history.pushState("", "", old_url + "&" + pushstate_url);
          } else {
            window.history.pushState("", "", "?" + pushstate_url);
          }
        } else {

          /* --- the key has no value, so update the url with rest of the keys --- */
          if (old_url.length > 0) {
            window.history.pushState("", "", old_url);
          } else if (window.location.search.length > 0) {
            window.history.pushState("", "", "?");
          }
        }
      }
    }
  };


  /* --- get the filters & Update the URL using PushState --- */

  getFilters = function(update_url) {
    var filters;
    filters = {
      "category_search": $(document).find('input[name="category_search"]').val(),
      "business_search": $('input[name="business_search"]').val(),
      "areas_selected": [],
      "business_types": [],
      "listing_status": []
    };
    filters["categories"] = $(".results__body ul.contents #current_category").val();

    /* --- Get 'area' values --- */
    $("input[type='checkbox'][name='areas[]']:checked").each(function() {
      filters["areas_selected"].push($(this).val());
    });

    /* --- Get 'business_types' values --- */
    $("input[type='checkbox'][name='business_type[]']:checked").each(function() {
      filters["business_types"].push($(this).val());
    });

    /* --- Get 'listing_status' values --- */
    $("input[type='checkbox'][name='listing_status[]']:checked").each(function() {
      filters["listing_status"].push($(this).val());
    });
    if (update_url) {

      /* --- Update 'category_search' in URL --- */

      /* --- Update 'business_search' in URL --- */
      if (filters["business_search"].length > 0) {
        updateUrlPushstate("business_search", "business_search" + "=" + filters["business_search"]);
      } else {
        updateUrlPushstate("business_search", "");
      }

      /* --- Update 'categories' in URL --- */
      if ($(".results__body ul.contents #current_category").val().length > 0 && $(".results__body ul.contents #current_category").val().indexOf("|[]") < 0) {
        updateUrlPushstate("categories", "categories" + "=" + filters["categories"]);
      } else {
        updateUrlPushstate("categories", "");
      }

      /* --- Update 'areas_selected' in URL --- */
      if (filters["areas_selected"].length > 0) {
        updateUrlPushstate("areas_selected", "areas_selected" + "=" + JSON.stringify(filters["areas_selected"]));
      } else {
        updateUrlPushstate("areas_selected", "");
        updateUrlPushstate("location", "");
      }

      /* --- Update 'business_types' in URL --- */
      if (filters["business_types"].length > 0) {
        updateUrlPushstate("business_types", "business_types" + "=" + JSON.stringify(filters["business_types"]));
      } else {
        updateUrlPushstate("business_types", "");
      }

      /* --- Update 'listing_status' in URL --- */
      if (filters["listing_status"].length > 0) {
        updateUrlPushstate("listing_status", "listing_status" + "=" + JSON.stringify(filters["listing_status"]));
      } else {
        updateUrlPushstate("listing_status", "");
      }
    }
    return filters;
  };


  /* --- Clear the filters --- */

  resetFilter = function() {
    var checkbox_name_list, i;
    checkbox_name_list = ["areas[]", "business_type[]", "listing_status[]"];
    i = 0;

    /* --- Clear the Checkboxes --- */
    while (i < checkbox_name_list.length) {
      $("input[type='checkbox'][name='" + checkbox_name_list[i] + "']").prop("checked", "");
      i++;
    }
    $(".results__body ul.contents #current_category").val("");
  };

  resetPagination = function() {
    updateUrlPushstate("page", "page=1");
  };


  /* --- Capitalize 1st character of the string --- */

  capitalize = function(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  };


  /* --- Update the text labels on change of DOM / content --- */

  updateTextLabels = function() {

    /* --- Update the Category labels --- */
    if ($(".listings-page a.bolder").text().length > 0) {
      $(".listings-page .category_label").text($(".listings-page a.bolder").text());
    } else {
      $(".listings-page span.category_label").text("");
      $(".listings-page h5 span.category_label").text("All");
      $(".listings-page p.category_label").text("All");
    }

    /* --- Update the State labels --- */
    if ($('input[name="city"]').val().length > 0) {
      $(".listings-page .state_label").text(capitalize($('input[name="city"]').val()));
      $(".listings-page p.state_label").closest("a").prop("href", window.location.pathname + "?state=" + $('input[name="city"]').val());
    } else {
      $(".listings-page span.state_label").text("India");
      $(".listings-page p.state_label").text("India");
    }
  };


  /* --- Update the Filter's DOM --- */

  getFilterContent = function() {
    var data, limit, page;
    page = window.location.search.indexOf("page") > 0 ? window.location.search.split("page=")[1].split("&")[0] : 1;
    limit = window.location.search.indexOf("limit") > 0 ? window.location.search.split("limit=")[1].split("&")[0] : 10;
    data = {
      "page": page,
      "page_size": limit,
      "sort_by": "published",
      "sort_order": "desc",
      "city": $('input[name="city"]').val(),
      "area": $("input[type='hidden'][name='area_hidden']").val(),
      "filters": getFilters(false)
    };
    $.ajax({
      type: 'post',
      url: '/api/get-listview-data',
      data: data,
      dataType: 'json',
      success: function(data) {

        /* --- Load the filter template --- */
        $("#listing_filter_view").html(data["data"]["filter_view"]);

        /* --- Add the pagination to the HTML --- */
        updateTextLabels();

        /* --- Note: the function below is called again to update the URL post AJAX --- */
        getFilters(false);
        return $("input[type='hidden'][name='area_hidden']").val("");

        /* ---- HAndleBar template content load ---- */
      },
      error: function(request, status, error) {
        $("#listing_card_view").css("filter", "");
        return console.log(error);
      }
    });
  };


  /* --- Update the Filter & Content DOM --- */

  getListContent = function() {
    var data, limit, page;
    page = window.location.search.indexOf("page") > 0 ? window.location.search.split("page=")[1].split("&")[0] : 1;
    limit = window.location.search.indexOf("limit") > 0 ? window.location.search.split("limit=")[1].split("&")[0] : 10;
    data = {
      "page": page,
      "page_size": limit,
      "sort_by": "published",
      "sort_order": "desc",
      "city": $('input[name="city"]').val(),
      "area": $("input[type='hidden'][name='area_hidden']").val(),
      "filters": getFilters(true)
    };
    $(".listings-page .site-loader.section-loader").removeClass("hidden");
    $.ajax({
      type: 'post',
      url: '/api/get-listview-data',
      data: data,
      dataType: 'json',
      success: function(data) {
        var advAdd, businessListing, end, start;
        if (parseInt(data["count"]) > parseInt(data["page"] - 1) * parseInt(data["page_size"])) {
          start = (parseInt(data["page"]) - 1) * parseInt(data["page_size"]) + 1;
          end = start + parseInt(data["page_size"]) - 1;
          end = end > parseInt(data["count"]) ? parseInt(data["count"]) : end;
          if (isMobile()) {
            $(".container div.addShow p.search-actions__title label#listing_filter_count").text(data["count"]);
          } else {
            $(".container div.addShow p.search-actions__title label#listing_filter_count").text(start.toString() + " - " + end.toString() + " of " + data["count"]);
          }
        } else {
          start = 0;
          end = 0;
          $(".container div.addShow p.search-actions__title label#listing_filter_count").text(data["count"]);
        }

        /* --- Load the filter template --- */
        $("#listing_filter_view").html(data["data"]["filter_view"]);

        /* --- Load the Listing card template --- */
        $("#listing_card_view").html(data["data"]["list_view"]);
        $(".listings-page .site-loader.section-loader").addClass("hidden");

        /* --- For mobile Screen --- */
        if ($(window).width() <= 768) {
          businessListing = $('.businessListing').detach();
          $('.addShow').after(businessListing);
          $('.filter-data').each(function() {
            var detailbtn, detailrow, listlabel, power, powerseller, publishedAdd, publisherow, recentData, recentrow;
            detailrow = $(this).find('.recent-updates__content');
            detailbtn = $(this).find('.detail-move').detach();
            $(detailrow).append(detailbtn);
            recentrow = $(this).find('.updates-dropDown');
            recentData = $(this).find('.recent-data').detach();
            $(recentrow).append(recentData);
            publishedAdd = $(this).find('.stats');
            publisherow = $(this).find('.rat-pub').detach();
            $(publishedAdd).append(publisherow);
            power = $(this).find('.power-seller-container');
            powerseller = $(this).find('.power-seller').detach();
            $(power).append(powerseller);
            listlabel = $(this).find('.list-label').detach();
            $(this).find('.list-title-container').before(listlabel);
          });
          advAdd = $('.adv-row').detach();
          $('.adv-after').append(advAdd);
          $('.recent-updates__text').click(function() {
            $(this).parent('.recent-updates').siblings('.updates-dropDown').slideToggle('slow');
            $(this).toggleClass('active');
            return $(this).find('.arrowDown').toggleClass('fa-rotate-180');
          });
        }

        /* --- Add the pagination to the HTML --- */
        $(".listings-page #pagination").html(data["data"]["paginate"]);
        updateTextLabels();

        /* --- Note: the function below is called again to update the URL post AJAX --- */
        getFilters(true);
        $("input[type='hidden'][name='area_hidden']").val("");

        /* ---- HAndleBar template content load ---- */

        /* --- If enquiry card exist, then --- */
        if ($("#listing_card_view #listing_list_view_enquiry").length) {
          initFlagDrop("#listing_card_view #listing_list_view_enquiry input[name='contact']");
          return $(document).find('.float-input').each(function() {
            return checkForInput(this);
          });
        }
      },
      error: function(request, status, error) {
        $(".listings-page .site-loader.section-loader").addClass("hidden");
        return console.log(error);
      }
    });
  };


  /* --- Search the list of city & area on text type --- */

  getCity = function(data, populate_id) {
    $.ajax({
      type: 'post',
      url: '/api/search-city',
      data: data,
      dataType: 'json',
      success: function(data) {
        var html_content;
        html_content = "";
        return updateCityDropdown(data["data"], populate_id);
      },
      error: function(request, status, error) {
        return console.log(error);
      }
    });
  };


  /* --- Generate the City list dropdown --- */

  updateCityDropdown = function(data, populate_id) {
    var html_content;
    if (data.length) {
      data.forEach(function(value, index) {
        return html_content += "<option value=\"" + value.slug + "\">" + value.name + "</option>";
      });
    } else {
      html_content = "<option value=\"\"></option>";
    }
    $("#" + populate_id).html(html_content);
  };


  /* --- Initialize international flag --- */

  initFlagDrop = function(path) {
    $(document).find(path).intlTelInput({
      initialCountry: 'auto',
      separateDialCode: true,
      geoIpLookup: function(callback) {
        $.get('https://ipinfo.io', (function() {}), 'jsonp').always(function(resp) {
          var countryCode;
          countryCode = void 0;
          countryCode = resp && resp.country ? resp.country : '';
          callback(countryCode);
        });
      },
      preferredCountries: ['IN'],
      americaMode: false,
      formatOnDisplay: false
    });
  };


  /* --- For label slide out in <input> textareas --- */

  checkForInput = function(element) {
    var $label;
    $label = $(element).siblings('label');
    if ($(element).val().length > 0) {
      $label.addClass('filled lab-color');
    } else {
      $label.removeClass('filled lab-color');
    }
  };

  $(document).ready(function() {

    /* --- This object is used to store old values -> Mainly for search-boxes --- */
    var filter_listing_params, get_params, i, key, old_values, search_box_params, value_assigned;
    old_values = {};

    /* --- Load all the popular city on load --- */
    updateTextLabels();
    window.onpopstate = function(event) {
      console.log("back ");
      if (event && event.state) {
        window.location.reload();
      }
    };

    /* --- City filter dropdown --- */
    $('input[name="city"]').flexdatalist({
      url: '/api/search-city',
      requestType: 'post',
      minLength: 0,
      cache: false,
      selectionRequired: true,
      keywordParamName: 'search',
      resultsProperty: "data",
      searchIn: ['search_text'],
      valueProperty: 'search_value',
      visibleProperties: ["search_text"],
      searchContain: true,
      searchDelay: 200,
      searchByWord: true,
      allowDuplicateValues: false,
      debug: false,
      noResultsText: 'Sorry! No results found for "{keyword}"'
    });
    $('input[name="category_search"]').flexdatalist({
      url: '/api/search-category',
      requestType: 'post',
      minLength: 0,
      cache: false,
      keywordParamName: "search",
      resultsProperty: "data",
      searchIn: ['name'],
      valueProperty: 'node_children',
      visibleProperties: ["name", "search_name"],
      searchDelay: 200,
      allowDuplicateValues: false,
      debug: false,
      noResultsText: 'Sorry! No categories found for "{keyword}"'
    });
    $('input[name="business_search"]').flexdatalist({
      url: '/api/search-business',
      requestType: 'post',
      params: {
        "city": old_values["state"],
        "category": $('input[name="category_search"]').val()
      },
      minLength: 1,
      cache: false,
      keywordParamName: "search",
      resultsProperty: "data",
      searchIn: ['title'],
      valueProperty: 'slug',
      visibleProperties: ["title", "area"],
      searchContain: true,
      searchEqual: false,
      searchDisabled: false,
      searchDelay: 200,
      searchByWord: false,
      allowDuplicateValues: false,
      noResultsText: 'Sorry! No business names found for this search criteria'
    });

    /* --- Update the filters from the URL if any exist --- */
    if (window.location.search.length > 0) {
      search_box_params = {
        "category_search": "category_search",
        "business_search": "business_search"
      };
      filter_listing_params = {
        "categories": "current_category"
      };
      get_params = getUrlSearchParams();

      /* --- Update SearchBox values --- */
      for (key in search_box_params) {
        i = 0;
        while (i < get_params.length) {
          if (get_params[i].indexOf(key + "=") > -1) {
            value_assigned = get_params[i].split("=")[1];
            $('input[name="' + search_box_params[key] + '"]').flexdatalist('value', value_assigned);
          }
          i++;
        }
      }

      /* --- Update Filter values --- */
    }

    /* --- Triggered every time the value in input changes --- */
    $('input[name="city"], input[name="category_search"], input[name="business_search"]').on('change:flexdatalist', function(event, set, options) {

      /* -- make a request if any one the Searchbox is cleared -- */
      key = "";
      if ($(this).attr("name") === "city") {
        key = "state";
      } else {
        key = $(this).attr("name");
      }
      if ($(this).attr("name") === "business_search") {
        $('input[name="business_search"]').flexdatalist('params', {
          'city': $('input[name="city"]').val()
        });
      }
      if ($(this).val().length <= 0) {
        if ($(this).prop("name") === "category_search") {

          /* --- update the value to null on change --- */
          $(document).find(".results__body ul.contents #current_category").val($(this).val());
        } else {
          updateUrlPushstate(key, "");
        }
        if (key !== "state") {
          resetPagination();
          getListContent();
        }
      }
      event.preventDefault();
    });

    /* -- Triggered every time the user selects an option -- */
    $('input[name="city"], input[name="category_search"], input[name="business_search"]').on('select:flexdatalist', function(event, item, options) {
      var areas, location, pushstate_url;
      key = "";
      if ($(this).prop("name") === "category_search") {
        $(document).find(".results__body ul.contents #current_category").val($(this).val());
      }
      if ($(this).attr("name") === "city") {
        key = "state";
        location = $(this).val().split(',').length <= 1 ? $(this).val() : $(this).val().split(',')[1];
        areas = $(this).val().split(',').length > 1 ? $(this).val().split(',')[0] : '';
        $(this).flexdatalist('value', location);
        pushstate_url = key + "=" + location;
        old_values["state"] = location;

        /* --- Clear the Area selection section --- */
        $("input[type='checkbox'][name='areas[]']").prop("checked", "");
        if (areas.length > 0) {
          $("input[name='area_hidden']").val(areas);
          updateUrlPushstate("location", "location=" + areas);
          updateUrlPushstate("areas_selected", "areas_selected=" + JSON.stringify([areas]));
        } else {
          $("input[name='area_hidden']").val("");
          updateUrlPushstate("location", "");
        }
      } else {
        key = $(this).attr("name");
        pushstate_url = $(this).attr("name") + "=" + $(this).val();
      }
      if (key !== "category_search") {
        updateUrlPushstate(key, pushstate_url);
      }
      if (isMobile()) {
        setTimeout((function() {
          resetPagination();
          getListContent();
        }), 500);
        $('.searchBy.fly-out').removeClass('active');
      } else {
        setTimeout((function() {
          resetPagination();
          getListContent();
        }), 500);
      }
      event.preventDefault();
    });

    /* --- Detect <a> click for categories --- */
    $(document).on("click", ".results__body ul.contents a", function(e) {
      $(document).find(".results__body ul.contents #current_category").val($(this).attr("value"));
      if (!isMobile()) {
        setTimeout((function() {
          resetPagination();
          getListContent();
        }), 100);
      } else {
        getFilterContent();
      }
      return false;
    });

    /* --- On click of Pagination, load that page --- */
    $(document).on("click", "#pagination a.paginate.page", function(e) {
      updateUrlPushstate("page", "page=" + $(this).attr("page"));
      if (window.location.search.indexOf("limit") < 0) {
        updateUrlPushstate("limit", "limit=10");
      } else {
        '';
      }
      getListContent();
    });

    /* --- On City Searchbox focusIn, copy the value in the searchbox --- */
    $(document).on("focusin", 'input[type="text"][name="flexdatalist-city"], input[type="text"][name="flexdatalist-category_search"], input[type="text"][name="flexdatalist-business_search"]', function(event) {
      var e, key_name, searchbox_name_linking;
      searchbox_name_linking = {
        "flexdatalist-city": "state",
        "flexdatalist-category_search": "category_search",
        "flexdatalist-business_search": "business_search"
      };
      key_name = $(this).attr('name');
      key_name = key_name.split("-")[1];
      old_values[searchbox_name_linking['flexdatalist-' + key_name]] = $('input[name="' + key_name + '"]').val();
      $('input[name="' + key_name + '"]').flexdatalist('value', "");
      e = $.Event('keyup');
      e.which = 8;
      $(this).trigger(e);
    });

    /* --- On City Searchbox focusOut, if the textbox is NULL, then restore old value in the searchbox --- */
    $(document).on("focusout", 'input[type="text"][name="flexdatalist-city"], input[type="text"][name="flexdatalist-category_search"], input[type="text"][name="flexdatalist-business_search"]', function(event) {
      var key_name, searchbox_name_linking;
      searchbox_name_linking = {
        "flexdatalist-city": "state",
        "flexdatalist-category_search": "category_search",
        "flexdatalist-business_search": "business_search"
      };
      key_name = $(this).attr('name');
      key_name = key_name.split("-")[1];
      console.log(old_values);
      setTimeout((function() {
        if ($('input[name="' + key_name + '"]').val().length <= 0) {
          return $('input[name="' + key_name + '"]').flexdatalist('value', old_values[searchbox_name_linking["flexdatalist-" + key_name]]);
        }
      }), 200);
    });

    /* --- On filter checkbox select --- */
    $(document).on("change", "input[type='checkbox'][name='areas[]'], input[type='checkbox'][name='business_type[]'], input[type='checkbox'][name='listing_status[]']", function(e) {
      if (!isMobile()) {
        setTimeout((function() {
          resetPagination();
          getListContent();
        }), 100);
      } else {
        getFilterContent();
      }
    });

    /* --- Clear the Filter Area, Business-Type, Listing-Status checkbox --- */
    $(document).on("click", "div#section-area div.check-section label.sub-title.clear, div#section-business div.check-section label.sub-title.clear, div#section-list-status div.check-section label.sub-title.clear", function(e) {
      var checkbox_name_linking;
      e.preventDefault();
      checkbox_name_linking = {
        "section-area": "areas[]",
        "section-business": "business_type[]",
        "section-list-status": "listing_status[]"
      };
      $("input[type='checkbox'][name='" + checkbox_name_linking[$(this).parent().parent().attr("id")] + "']").prop("checked", "");
      resetPagination();
      getListContent();
    });

    /* --- On click of "Clear All" in filters --- */
    $(document).on("click", ".filterBy a#clear_all_filters", function(e) {
      if (isMobile()) {
        resetFilter();
        setTimeout((function() {
          getListContent();
        }), 100);
        $('.filterBy.fly-out').removeClass('active');
      }
    });

    /* --- Mobile => If User clicks on the clear-search link, then clear that searchbox --- */
    $(document).on("click", ".searchBy #clear_search", function(e) {
      if (isMobile()) {
        $(this).parent().find('input').val("");
        setTimeout((function() {
          resetPagination();
          getListContent();
        }), 100);
        $('.searchBy.fly-out').removeClass('active');
      }
    });

    /* --- Mobile => Apply the filter on 'Apply' button click --- */
    $(document).on("click", "#apply_listing_filter", function(e) {
      if (isMobile()) {
        setTimeout((function() {
          resetPagination();
          getListContent();
        }), 100);
        $('.filterBy.fly-out').removeClass('active');
      }
    });

    /* --- On click --- */
    $(document).on("click", "#section-area #moreAreaShow", function(event) {
      if ($(this).attr('aria-expanded') === "true") {
        $(this).text($(this).text().replace("more", "less"));
      } else {
        $(this).text($(this).text().replace("less", "more"));
      }
    });

    /* --- On Input / Change of area-search in Left filterbox, search the name --- */
    $(document).on("input change", ".filter-group.area #section-area input[type='text']#area_search", function(event) {
      var areas_found, search_key;
      search_key = $(this).val();
      areas_found = 0;
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
        $(this).closest("#section-area").find("#moreAreaShow").addClass('hidden');
      } else {
        if ($(this).closest("#section-area").find("#areas_hidden").val() > 0) {
          $(this).closest("#section-area").find("#moreDown").collapse('hide');
        }
        $(this).closest("#section-area").find("#moreAreaShow").removeClass('hidden');
        $("input[type='checkbox'][name='areas[]']").parent().removeClass('hidden');
      }
    });

    /* --- Working of "Back to Top" button --- */
    $(window).scroll(function() {
      if ($(this).scrollTop() > 500) {
        $('.listings-page #backToTop').fadeIn();
      } else {
        $('.listings-page #backToTop').fadeOut();
      }
    });
    $('.listings-page #backToTop').on("click", function() {
      $('body, html').animate({
        scrollTop: 0
      }, 1000);
    });

    /* --- 
    	 *	Timeout of 1 sec set as the values in search boxes are initially empty & are load from JS,
    	 *	hence a timelag is set so that value is assigned, then function call is made 
    	---
     */
    setTimeout((function() {
      getListContent();
    }), 1000);
    $(document).on('click', '.send-enquiry', function() {
      $('.enquiry-card').addClass('active');
    });
    return $(document).on('click', '.back-icon', function() {
      $('.fly-out').removeClass('active');
    });
  });

}).call(this);
