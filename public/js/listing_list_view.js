(function() {
  var capitalize, getCity, getFilters, getListContent, getTemplateHTML, getUrlSearchParams, updateCityDropdown, updateTextLabels, updateUrlPushstate;

  getTemplateHTML = function(templateToRender, data) {
    var htmlToRender, list, theTemplate, theTemplateScript;
    list = {};
    list['list'] = data;
    theTemplateScript = $("#" + templateToRender).html();
    theTemplate = Handlebars.compile(theTemplateScript);
    htmlToRender = theTemplate(list);
    return htmlToRender;
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
          }
        }
      }
    }
  };

  getFilters = function() {
    var filters;
    filters = {
      "category_search": $(document).find('input[type="hidden"][name="category_search"].flexdatalist').val(),
      "business_search": $('input[type="hidden"][name="business_search"]').val(),
      "areas_selected": [],
      "business_types": [],
      "listing_status": []
    };
    if (filters["category_search"].length > 0 && filters["category_search"].indexOf("|[]") < 0) {
      updateUrlPushstate("category_search", "category_search" + "=" + filters["category_search"]);
    } else {
      updateUrlPushstate("category_search", "");
    }
    if (filters["business_search"].length > 0) {
      updateUrlPushstate("business_search", "business_search" + "=" + filters["business_search"]);
    } else {
      updateUrlPushstate("business_search", "");
    }
    filters["categories"] = $(".results__body ul.contents #current_category").val();
    if ($(".results__body ul.contents #current_category").val().length > 0 && $(".results__body ul.contents #current_category").val().indexOf("|[]") < 0) {
      updateUrlPushstate("categories", "categories" + "=" + filters["categories"]);
    } else {
      updateUrlPushstate("categories", "");
    }

    /* --- Get 'area' values & update URL --- */
    $("input[type='checkbox'][name='areas[]']:checked").each(function() {
      filters["areas_selected"].push($(this).val());
    });
    if (filters["areas_selected"].length > 0) {
      updateUrlPushstate("areas_selected", "areas_selected" + "=" + JSON.stringify(filters["areas_selected"]));
    } else {
      updateUrlPushstate("areas_selected", "");
      updateUrlPushstate("location", "");
    }

    /* --- Get 'business_types' values & update URL --- */
    $("input[type='checkbox'][name='business_type[]']:checked").each(function() {
      filters["business_types"].push($(this).val());
    });
    if (filters["business_types"].length > 0) {
      updateUrlPushstate("business_types", "business_types" + "=" + JSON.stringify(filters["business_types"]));
    } else {
      updateUrlPushstate("business_types", "");
    }

    /* --- Get 'listing_status' values & update URL --- */
    $("input[type='checkbox'][name='listing_status[]']:checked").each(function() {
      filters["listing_status"].push($(this).val());
    });
    if (filters["listing_status"].length > 0) {
      updateUrlPushstate("listing_status", "listing_status" + "=" + JSON.stringify(filters["listing_status"]));
    } else {
      updateUrlPushstate("listing_status", "");
    }
    return filters;
  };

  capitalize = function(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  };

  updateTextLabels = function() {

    /* --- Update the Category labels --- */
    if ($(".listings-page a.bolder").text().length > 0) {
      $(".listings-page .category_label").text($(".listings-page a.bolder").text());
    } else {
      $(".listings-page span.category_label").text("All categories");
      $(".listings-page p.category_label").text("all");
    }

    /* --- Update the State labels --- */
    if ($('input[type="hidden"][name="city"]').val().length > 0) {
      $(".listings-page .state_label").text(capitalize($('input[type="hidden"][name="city"]').val()));
      $(".listings-page p.state_label").closest("a").prop("href", window.location.pathname + "?state=" + $('input[type="hidden"][name="city"]').val());
    } else {
      $(".listings-page span.state_label").text("India");
      $(".listings-page p.state_label").text("India");
    }
  };

  getListContent = function() {
    var data, limit, page;
    page = window.location.search.indexOf("page") > 0 ? window.location.search.split("page=")[1].split("&")[0] : 1;
    limit = window.location.search.indexOf("limit") > 0 ? window.location.search.split("limit=")[1].split("&")[0] : 10;
    data = {
      "page": page,
      "page_size": limit,
      "sort_by": "published",
      "sort_order": "desc",
      "city": $('input[type="hidden"][name="city"]').val(),
      "area": $("input[type='hidden'][name='area_hidden']").val(),
      "filters": getFilters()
    };
    $("#listing_card_view").css("filter", "blur(2px)");
    $.ajax({
      type: 'post',
      url: '/api/get-listview-data',
      data: data,
      dataType: 'json',
      success: function(data) {
        var end, start;
        if (parseInt(data["count"]) > parseInt(data["page"] - 1) * parseInt(data["page_size"])) {
          start = (parseInt(data["page"]) - 1) * parseInt(data["page_size"]) + 1;
          end = start + parseInt(data["page_size"]) - 1;
          end = end > parseInt(data["count"]) ? parseInt(data["count"]) : end;
          $(".container div.addShow p.search-actions__title label#listing_filter_count").text(start.toString() + " - " + end.toString() + " of " + data["count"]);
        } else {
          start = 0;
          end = 0;
          $(".container div.addShow p.search-actions__title label#listing_filter_count").text(data["count"]);
        }

        /* --- Load the filter template --- */
        $("#listing_filter_view").html(data["data"]["filter_view"]);

        /* --- Load the Listing card template --- */
        $("#listing_card_view").html(data["data"]["list_view"]);
        $("#listing_card_view").css("filter", "");

        /* --- Add the pagination to the HTML --- */
        $(".listings-page #pagination").html(data["data"]["paginate"]);
        updateTextLabels();

        /* --- Note: the function below is called again to update the URL post AJAX --- */
        getFilters();
        return $("input[type='hidden'][name='area_hidden']").val("");

        /* ---- HAndleBar template content load ---- */
      },
      error: function(request, status, error) {
        $("#listing_card_view").css("filter", "");
        return console.log(error);
      }
    });
  };

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

  $(document).ready(function() {

    /* --- This object is used to store old values -> Mainly for search-boxes --- */
    var filter_listing_params, get_params, i, key, old_values, search_box_params, value_assigned;
    old_values = {};

    /* --- Load all the popular city on load --- */
    updateTextLabels();

    /* --- City filter dropdown --- */
    $('input[type="hidden"][name="city"].flexdatalist').flexdatalist({
      url: '/api/search-city',
      requestType: 'post',
      focusFirstResult: true,
      minLength: 0,
      cache: false,
      selectionRequired: false,
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
    $('input[type="hidden"][name="category_search"].flexdatalist').flexdatalist({
      url: '/api/search-category',
      requestType: 'post',
      params: {
        "search": $('input[type="hidden"][name="category_search"].flexdatalist').val()
      },
      keywordParamName: "search",
      resultsProperty: "data",
      searchIn: ['name'],
      valueProperty: 'node_children',
      visibleProperties: ["name", "search_name"],
      minLength: 0,
      cache: false,
      searchContain: true,
      searchEqual: false,
      searchDisabled: false,
      searchDelay: 200,
      searchByWord: false,
      allowDuplicateValues: false,
      noResultsText: 'Sorry! No categories found for "{keyword}"'
    });
    $('input[type="hidden"][name="business_search"].flexdatalist').flexdatalist({
      url: '/api/search-business',
      requestType: 'post',
      params: {
        "city": $('input[type="hidden"][name="city"].flexdatalist').val(),
        "category": $('input[type="hidden"][name="category_search"].flexdatalist').val()
      },
      keywordParamName: "search",
      resultsProperty: "data",
      searchIn: ['title'],
      valueProperty: 'id',
      visibleProperties: ["title", "area"],
      minLength: 1,
      cache: false,
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
            $('input[type="hidden"][name="' + search_box_params[key] + '"].flexdatalist').val(value_assigned);
          }
          i++;
        }
      }

      /* --- Update Filter values --- */
    }

    /* --- Triggered every time the value in input changes --- */
    $('input[type="hidden"][name="city"].flexdatalist, input[type="hidden"][name="category_search"].flexdatalist, input[type="hidden"][name="business_search"].flexdatalist').on('change:flexdatalist', function() {

      /* -- make a request if any one the Searchbox is cleared -- */
      key = "";
      if ($(this).attr("name") === "city") {
        key = "state";
      } else {
        key = $(this).attr("name");
      }
      if ($(this).val().length <= 0) {
        updateUrlPushstate(key, "");
        if ($(this).prop("name") === "category_search") {

          /* --- update the value to null on change --- */
          $(document).find(".results__body ul.contents #current_category").val($(this).val());
        }
        if (key !== "state") {
          getListContent();
        } else {
          '';
        }
      }
    });

    /* -- Triggered every time the user selects an option -- */
    $('input[type="hidden"][name="city"].flexdatalist, input[type="hidden"][name="category_search"].flexdatalist, input[type="hidden"][name="business_search"].flexdatalist').on('select:flexdatalist', function() {
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
      updateUrlPushstate(key, pushstate_url);
      setTimeout((function() {
        return getListContent();
      }), 500);
    });

    /* --- Detect <a> click --- */
    $(document).on("click", ".results__body ul.contents a", function(e) {
      $(document).find(".results__body ul.contents #current_category").val($(this).attr("value"));
      updateUrlPushstate("categories", "categories=" + $(this).attr("value"));
      $('#category input[type="hidden"][name="category_search"].flexdatalist').prop('value', $(this).attr("value"));
      $('#category input[type="hidden"][name="category_search"].flexdatalist').flexdatalist('');
      setTimeout((function() {
        getListContent();
      }), 100);
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
    $(document).on("focusin", 'input[type="text"][name="flexdatalist-city"]', function(event) {
      old_values["state"] = $('input[type="hidden"][name="city"].flexdatalist').val();
    });

    /* --- On City Searchbox focusOut, if the textbox is NULL, then restore old value in the searchbox --- */
    $(document).on("focusout", 'input[type="text"][name="flexdatalist-city"]', function(event) {
      if ($('input[type="hidden"][name="city"].flexdatalist').val().length <= 0) {
        $('input[type="hidden"][name="city"].flexdatalist').flexdatalist('value', old_values["state"]);
      }
    });

    /* --- On filter checkbox select --- */
    $(document).on("change", "input[type='checkbox'][name='areas[]'], input[type='checkbox'][name='business_type[]'], input[type='checkbox'][name='listing_status[]']", function(e) {
      getListContent();
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
      getListContent();
    });

    /* --- On Input / Change of area-search in Left filterbox, search the name --- */
    $(document).on("input change", ".filter-group.area #section-area input[type='text']#area_search", function(event) {
      var search_key;
      search_key = $(this).val();
      if (search_key.length > 0) {
        $("input[type='checkbox'][name='areas[]']").parent().addClass('hidden');
        $("input[type='checkbox'][name='areas[]']").each(function() {
          if ($(this).parent().text().toLowerCase().indexOf(search_key.toLowerCase()) > -1) {
            $(this).parent().removeClass("hidden");
          }
        });
      } else {
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
  });

}).call(this);
