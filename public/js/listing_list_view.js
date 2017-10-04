(function() {
  var getCity, getListContent, getTemplateHTML, getUrlSearchParams, updateCityDropdown;

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

  getListContent = function() {
    var data;
    data = {
      "page": 1,
      "page_size": 10,
      "sort_by": "published",
      "sort_order": "desc",
      "city": $('input[type="hidden"][name="city"]').val(),
      "filters": {
        "category_search": $('input[type="hidden"][name="category_search"]').val(),
        "business_search": $('input[type="hidden"][name="business_search"]').val()
      }
    };
    $("#listing_card_view").css("filter", "blur(2px)");
    $.ajax({
      type: 'post',
      url: '/api/get-listview-data',
      data: data,
      dataType: 'json',
      success: function(data) {
        var end, start;
        if (parseInt(data["count"]) > 0) {
          start = (parseInt(data["page"]) - 1) * parseInt(data["page_size"]) + 1;
          end = start + parseInt(data["page_size"]) - 1;
          end = (end % parseInt(data["count"])) < parseInt(data["count"]) ? parseInt(data["count"]) : end;
          $(".container div.addShow p.search-actions__title label#listing_filter_count").text(start.toString() + " - " + end.toString() + " of " + data["count"]);
        } else {
          start = 0;
          end = 0;
          $(".container div.addShow p.search-actions__title label#listing_filter_count").text(data["count"]);
        }
        $("#listing_card_view").html(data["data"]["list_view"]);
        return $("#listing_card_view").css("filter", "");

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

    /* --- Load all the popular city on load --- */
    var get_params, i, key, search_box_params;
    getCity({
      "search": ""
    }, "states");

    /* --- City filter dropdown --- */
    $('input[type="hidden"][name="city"].flexdatalist').flexdatalist({
      url: '/api/search-city',
      params: {
        "search": $('input[type="hidden"][name="city"].flexdatalist').val()
      },
      requestType: 'post',
      keywordParamName: 'search',
      resultsProperty: "data",
      searchIn: ['name'],
      minLength: 0,
      cache: false,
      searchContain: true,
      searchEqual: false,
      searchDisabled: false,
      searchDelay: 200,
      searchByWord: false,
      allowDuplicateValues: false,
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
      searchIn: ['search_name'],
      valueProperty: 'id',
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
        "search": $('input[type="hidden"][name="business_search"].flexdatalist').val()
      },
      keywordParamName: "search",
      resultsProperty: "data",
      searchIn: ['title'],
      valueProperty: 'id',
      minLength: 1,
      cache: false,
      searchContain: true,
      searchEqual: false,
      searchDisabled: false,
      searchDelay: 200,
      searchByWord: false,
      allowDuplicateValues: false,
      noResultsText: 'Sorry! No business names found for "{keyword}"'
    });

    /* --- Update the filters from the URL if any exist --- */
    if (window.location.search.length > 0) {
      search_box_params = {
        "state": "city",
        "category_search": "category_search",
        "business_search": "business_search"
      };
      get_params = getUrlSearchParams();
      for (key in search_box_params) {
        i = 0;
        while (i < get_params.length) {
          if (get_params[i].indexOf(key + "=") > -1) {
            $('input[type="hidden"][name="' + search_box_params[key] + '"].flexdatalist').val(get_params[i].split("=")[1]);
          }
          i++;
        }
      }
    }

    /* --- Triggered every time before display of data --- */

    /* --- Triggered every time the value in input changes --- */
    $('input[type="hidden"][name="city"].flexdatalist, input[type="hidden"][name="category_search"].flexdatalist, input[type="hidden"][name="business_search"].flexdatalist').on('change:flexdatalist', function() {

      /* -- make a request if any one the Searchbox is cleared -- */
      var old_url, params;
      if ($(this).val().length <= 0) {
        key = "";
        if ($(this).attr("name") === "city") {
          key = "state";
        } else {
          key = $(this).attr("name");
        }
        if (window.location.search.length > 0 && window.location.search.indexOf(key) > -1) {
          params = window.location.search.split('?')[1].split("&");
          old_url = "";
          i = 0;
          while (i < params.length) {
            if (params[i].indexOf(key) <= -1) {
              old_url += (old_url.length <= 0 ? "?" : "&") + params[i];
            }
            i++;
          }
          window.history.pushState("", "", old_url);
        }
        getListContent();
      }
    });

    /* -- Triggered every time the user selects an option -- */
    $('input[type="hidden"][name="city"].flexdatalist, input[type="hidden"][name="category_search"].flexdatalist, input[type="hidden"][name="business_search"].flexdatalist').on('select:flexdatalist', function() {
      var old_url, params, pushstate_url;
      key = "";
      if ($(this).attr("name") === "city") {
        key = "state";
        pushstate_url = "state=" + $(this).val();
      } else {
        key = $(this).attr("name");
        pushstate_url = $(this).attr("name") + "=" + $(this).val();
      }
      if (window.location.search.length <= 0 && window.location.search.indexOf(key) <= -1) {
        window.history.pushState("", "", "?" + pushstate_url);
      } else if (window.location.search.length > 0 && window.location.search.indexOf(key) <= -1) {
        window.history.pushState("", "", window.location.search + "&" + pushstate_url);
      } else {
        params = window.location.search.split('?')[1].split("&");
        old_url = "";
        i = 0;
        while (i < params.length) {
          if (params[i].indexOf(key) <= -1) {
            old_url += (old_url.length <= 0 ? "?" : "&") + params[i];
          }
          i++;
        }
        window.history.pushState("", "", old_url + "&" + pushstate_url);
      }
      getListContent();
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
