(function() {
  var capitalize, getArea, getContent, getCookie, getFilters, getNodeCategories, getTemplate, getVerification, initCatSearchBox, initFlagDrop;

  capitalize = function(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  };

  getFilters = function(enquiry_no, listing_slug) {
    var areas, cities, data, descr_values;
    if (enquiry_no == null) {
      enquiry_no = 'step_1';
    }
    data = {};
    if (enquiry_no === 'step_1') {
      descr_values = [];
      $.each($(".level-one #level-one-enquiry input[name='description[]']:checked"), function() {
        descr_values.push($(this).val());
      });
      data = {
        name: $(".level-one #level-one-enquiry input[name='name']").val(),
        email: $(".level-one #level-one-enquiry input[name='email']").val(),
        contact_locality: $(".level-one #level-one-enquiry input[name='contact']").intlTelInput("getSelectedCountryData").dialCode,
        contact: $(".level-one #level-one-enquiry input[name='contact']").val(),
        description: descr_values,
        enquiry_message: $(".level-one #level-one-enquiry #lookingfor input[name='enquiry_message']").val(),
        enquiry_level: enquiry_no,
        listing_slug: listing_slug
      };
    } else if (enquiry_no === 'step_2' || enquiry_no === 'step_3') {
      descr_values = [];
      areas = [];
      cities = [];
      $.each($("#level-three-enquiry input[name='categories_interested[]']:checked"), function() {
        descr_values.push($(this).val());
      });
      $("#level-three-enquiry select[name='city']").each(function() {
        cities.push($(this).val());
      });
      $("#level-three-enquiry select[name='area']").each(function() {
        areas = areas.concat($(this).val());
      });
      data = {
        name: $("#level-three-enquiry #enquiry_name").text(),
        email: $("#level-three-enquiry #enquiry_email").text(),
        contact: $("#level-three-enquiry #enquiry_contact").text(),
        categories_interested: descr_values,
        city: cities,
        area: areas,
        enquiry_level: enquiry_no,
        listing_slug: listing_slug
      };
    }
    return data;
  };

  getContent = function(enquiry_level, listing_slug) {
    var data;
    data = getFilters(enquiry_level, listing_slug);
    $.ajax({
      type: 'post',
      url: '/api/send_enquiry',
      data: data,
      dataType: 'json',
      success: function(data) {
        if (data["popup_template"].length > 0) {
          $(document).find("#updateTemplate #enquiry-modal #listing_popup_fill").html(data["popup_template"]);
          $(document).find("div.container #enquiry-modal").modal('show');
          if ($("#level-three-enquiry").length > 0) {
            initCatSearchBox();
          }
        }
      },
      error: function(request, status, error) {
        return console.log(error);
      }
    });
  };

  getTemplate = function(modal_template, listing_slug) {
    var data;
    if (listing_slug == null) {
      listing_slug = '';
    }
    data = {
      'enquiry_level': modal_template,
      'listing_slug': listing_slug
    };
    $.ajax({
      type: 'post',
      url: '/api/get_enquiry_template',
      data: data,
      dataType: 'json',
      success: function(data) {
        if (data["modal_template"].length > 0) {
          $(document).find("#updateTemplate #enquiry-modal #listing_popup_fill").html(data["modal_template"]);
          return $(document).find("div.container #enquiry-modal").modal('show');
        }
      },
      error: function(request, status, error) {
        $("div.container #enquiry-modal").modal('show');
        return console.log(error);
      }
    });
  };

  getVerification = function(enquiry_level, listing_slug, regenerate, new_contact, contact_no) {
    var data;
    if (listing_slug == null) {
      listing_slug = '';
    }
    if (regenerate == null) {
      regenerate = false;
    }
    if (new_contact == null) {
      new_contact = false;
    }
    if (contact_no == null) {
      contact_no = '';
    }
    data = {
      'enquiry_level': enquiry_level,
      'listing_slug': listing_slug,
      'contact': contact_no.length > 0 ? contact_no : $("#enquiry-modal #listing_popup_fill div.verification__row span.mobile").text().replace(/ /g, ""),
      'otp': $("#enquiry-modal #listing_popup_fill div.verification__row #code_otp").val(),
      'regenerate': regenerate,
      'new_contact': {
        'country_code': contact_no.indexOf('-') > -1 ? contact_no.split('-')[0] : '',
        'contact': contact_no.indexOf('-') > -1 ? contact_no.split('-')[1] : contact_no
      }
    };
    $.ajax({
      type: 'post',
      url: '/api/verify_enquiry_otp',
      data: data,
      dataType: 'json',
      success: function(data) {
        if (data["popup_template"].length > 0) {
          $(document).find("#updateTemplate #enquiry-modal #listing_popup_fill").html(data["popup_template"]);
          return $(document).find("div.container #enquiry-modal").modal('show');
        }
      },
      error: function(request, status, error) {
        if (request.status === 410) {
          console.log("Sorry, the OTP has expired");
          $("#enquiry-modal #otp-error").text("Sorry, the OTP has expired.");
        } else if (request.status === 400) {
          $("#enquiry-modal #otp-error").text("Incorrect OTP. Please enter valid one.");
          console.log("Please enter the Valid OTP");
        } else if (request.status === 404) {
          $("#enquiry-modal #otp-error").text("Please enter the OTP.");
          console.log("Please enter OTP");
        } else {
          $("#enquiry-modal #otp-error").text("We have met with an error. Please try after sometime.");
          console.log("Some error in OTP verification");
        }
        return console.log(error);
      }
    });
  };

  getCookie = function(key) {
    var cookies, i, value;
    value = '';
    if (document.cookie.length > 0 && document.cookie.indexOf(key) > -1) {
      cookies = document.cookie.split('; ');
      i = 0;
      while (i < cookies.length) {
        if (cookies[i].indexOf(key) > -1) {
          value = cookies[i].split('=')[1];
          break;
        }
        i++;
      }
    }
    return value;
  };

  getArea = function(city, path) {
    var html;
    html = '';
    $.ajax({
      type: 'post',
      url: '/get_areas',
      data: {
        'city': city
      },
      success: function(data) {
        var key;
        key = void 0;
        for (key in data) {
          key = key;
          html += '<option value="' + data[key]['id'] + '">' + data[key]['name'] + '</option>';
        }
        $(path).html(html);
      },
      error: function(request, status, error) {
        throw Error();
      }
    });
  };

  initCatSearchBox = function() {

    /* --- Initialize categories search  --- */
    $(document).find('#level-three-enquiry input[name="get_categories"]').flexdatalist({
      url: '/api/search-category',
      requestType: 'post',
      params: {
        "category_level": 3,
        "ignore_categories": []
      },
      minLength: 1,
      cache: false,
      keywordParamName: "search",
      resultsProperty: "data",
      searchIn: ['name'],
      valueProperty: 'slug',
      visibleProperties: ["name"],
      searchDelay: 200,
      allowDuplicateValues: false,
      debug: false,
      noResultsText: 'Sorry! No categories found for "{keyword}"'
    });

    /* --- On select of search box add new core categories  --- */
    $(document).on('change:flexdatalist', '#level-three-enquiry input[name="get_categories"]', function(event, item, options) {
      var categories_found, key;
      key = "";
      categories_found = [];
      $("#level-three-enquiry #enquiry_core_categories li input").each(function() {
        categories_found.push($(this).val());
      });
      $(this).flexdatalist('params', {
        "category_level": 3,
        "ignore_categories": categories_found
      });
      event.preventDefault();
    });

    /* --- On select of search box add new core categories  --- */
    $(document).on('select:flexdatalist', '#level-three-enquiry input[name="get_categories"]', function(event, item, options) {
      var html, key;
      key = "";
      html = "<li><label class=\"flex-row\"><input type=\"checkbox\" class=\"checkbox\" for=\" " + item["slug"] + " \" name=\"categories_interested[]\" value=\"" + item["slug"] + "\" data-parsley-trigger=\"change\" data-parsley-mincheck=\"1\" data-required=\"true\" required=\"true\" checked=\"checked\"> <p class=\"text-medium categories__text flex-points__text text-color\" id=\"\">" + item["name"] + "</p></label> </li>";
      $("#level-three-enquiry #enquiry_core_categories").append(html);
      $(this).val("");
      event.preventDefault();
    });
  };

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

  getNodeCategories = function(path, parent_id) {
    var html;
    html = '';
    $.ajax({
      type: 'post',
      url: '/api/get_listing_categories',
      data: {
        'parent': [parent_id]
      },
      success: function(data) {
        var key;
        key = void 0;
        console.log(data["modal_template"]);
        $(path).html(data["modal_template"]);
      },
      error: function(request, status, error) {
        throw Error();
      }
    });
  };

  $(document).ready(function() {

    /* --- This object is used to store old values -> Mainly for search-boxes --- */
    var old_values;
    old_values = {};

    /* --- Display respective Popups on "Send Enquiry click" --- */
    if ($("#enquiry-modal").length > 0) {
      if ($(document).find("#level-one-enquiry").length > 0) {
        $('#enquiry-modal').on('shown.bs.modal', function() {
          initFlagDrop("#level-one-enquiry input[name='contact']");
          return $(document).on("countrychange", "#level-one-enquiry input[name='contact']", function() {
            $(this).val($(this).intlTelInput("getNumber"));
          });
        });
        if ($("#level-one-enquiry input[name='contact']").length <= 1 && $("#level-one-enquiry input[name='contact']").val().indexOf('+') > -1) {
          $("#level-one-enquiry input[name='contact']").val("");
        }
      }
      $(document).on("click", "div.col-sm-4 div.equal-col div.contact__enquiry button.fnb-btn.primary-btn", function() {
        if (getCookie('user_id').length > 0) {
          if (getCookie('user_type') === "user") {
            $("#login-modal").modal('show');
          } else {
            getTemplate('step_1', $("#enquiry_slug").val());
          }
        } else {
          $("div.container #enquiry-modal").modal('show');
        }
      });

      /* --- On click of "Send Enquiry 1" button --- */
      $(document).on("click", "#level-one-enquiry #level-one-form-btn", function() {
        var page_level;
        page_level = $(this).data('value') && $(this).data('value').length > 0 ? $(this).data('value') : 'step_1';
        if ($(document).find("#level-one-enquiry").parsley().validate()) {
          getContent(page_level, $("#enquiry_slug").val());
        } else {
          console.log("forms not complete");
        }
      });

      /* --- On click of OTP submit button --- */
      $(document).on("click", "#level-two-enquiry #level-two-form-btn", function() {
        getVerification($(this).data('value'), $("#enquiry_slug").val(), false, false, '');
      });

      /* --- On click of OTP regenerate button --- */
      $(document).on("click", "#level-two-enquiry #level-two-resend-btn", function() {
        getVerification($(this).data('value'), $("#enquiry_slug").val(), true, true, '');
      });

      /* --- initialize the Flag in Popup 2 --- */
      $(document).on("click", "#level-two-enquiry", function() {
        initFlagDrop("#level-two-enquiry #new-mobile-modal input[name='contact']");
      });

      /* --- On click of 'x', close the Popup 2 modal --- */
      $(document).on("click", "#level-two-enquiry #close-new-mobile-modal", function() {
        $(document).find("#new-mobile-modal").modal("hide");
      });

      /* --- Change the Contact No & Regenarate OTP --- */
      $(document).on("click", "#level-two-enquiry #new-mobile-verify-btn", function() {
        $("#enquiry-modal #listing_popup_fill div.verification__row span.mobile").text("+" + $(this).closest('div.new-verify-number').find("input[type='tel'][name='contact']").intlTelInput("getSelectedCountryData").dialCode + " " + $(this).closest('div.new-verify-number').find("input[type='tel'][name='contact']").val());
        $(document).find("#new-mobile-modal").modal("hide");
        getVerification($("#level-two-enquiry #level-two-resend-btn").data('value'), $("#enquiry_slug").val(), false, true, $(this).closest('div.new-verify-number').find("input[type='tel'][name='contact']").intlTelInput("getSelectedCountryData").dialCode + '-' + $(this).closest('div.new-verify-number').find("input[type='tel'][name='contact']").val());
      });
      $(document).on("change", "#level-three-enquiry #area_section select[name='city']", function() {
        var city_vals, i;
        city_vals = [];
        i = 0;
        $("#level-three-enquiry #area_section select[name='city'] option").removeClass('hidden');
        $("#level-three-enquiry #area_section select[name='city']").each(function() {
          city_vals.push($(this).val());
        });
        while (i < city_vals.length) {
          $("#level-three-enquiry #area_section select[name='city'] option[value='" + city_vals[i] + "']").addClass('hidden');
          i++;
        }
        $("#level-three-enquiry #area_section select[name='city']").each(function() {
          if ($.inArray($(this).val(), city_vals) > -1) {
            $(this).find("option[value='" + $(this).val() + "']").removeClass('hidden');
          }
        });
        getArea($(this).val(), $(this).closest('ul').find('select[name="area"]'));
      });

      /* --- On click of "+ Add more" on Enquiry 3 Popup "Areas", new set will be added --- */
      $(document).on("click", "#level-three-enquiry #add-city-areas", function() {
        $("#area_dom_skeleton").clone("true").removeAttr('id').removeClass('hidden').appendTo("#area_section #area_operations");
      });

      /* --- On click of close, remove the City-Area DOM --- */
      $(document).on("click", "#level-three-enquiry #close_areas", function() {
        $("#level-three-enquiry #area_section select[name='city'] option[value='" + $(this).val() + "']").addClass('hidden');
        $("#level-three-enquiry #area_section select[name='city'] option[value='" + $(this).closest('ul').find("select[name='city']").val() + "']").removeClass('hidden');
        $(this).closest("ul").remove();
      });

      /* --- On click of Popup 3 'Save / Send' --- */
      $(document).on("click", "#level-three-enquiry #level-three-form-btn", function() {
        var page_level;
        page_level = $(this).data('value') && $(this).data('value').length > 0 ? $(this).data('value') : 'step_1';
        if ($(document).find("#level-three-enquiry #enquiry_core_categories").parsley().validate() && $(document).find("#level-three-enquiry #area_operations").parsley().validate()) {
          getContent(page_level, $("#enquiry_slug").val());
        } else {
          console.log("forms not complete");
        }
      });

      /* --- On click of "Add More" categories --- */
      $(document).on("click", "#level-three-enquiry #select-more-categories", function() {
        $("#level-three-enquiry #category-select #level-two-category").addClass("hidden");
        $("#level-three-enquiry #category-select #level-one-category").removeClass("hidden");
        $("#level-three-enquiry #category-select #level-one-category input[type='radio']").prop("checked", false);
      });
      $(document).on("click", "#level-three-enquiry #category-select #level-one-category input[name='categories']", function() {
        $("#level-three-enquiry #category-select #level-two-category").addClass("hidden");
        $("#level-three-enquiry #category-select #level-one-category").removeClass("hidden");
      });
      $(document).on("click", "#level-three-enquiry #category-select #back_to_categories", function() {
        $("#level-three-enquiry #category-select #level-two-category").addClass("hidden");
        $("#level-three-enquiry #category-select #level-one-category").removeClass("hidden");
      });
      $(document).on("click", "#level-three-enquiry #category-select #category-select-close", function() {
        $(this).closest("div#category-select").modal('hide');
      });
      $(document).on("change", "#level-three-enquiry #category-select #level-one-category input[name='select-categories']", function() {
        if ($(this).prop('checked')) {
          $("#level-three-enquiry #category-select #level-one-category input[type='radio'][value='" + $(this).val() + "']").attr('disabled', 'true');
        } else {
          $("#level-three-enquiry #category-select #level-one-category input[type='radio'][value='" + $(this).val() + "']").removeAttr('disabled');
        }
      });
      $(document).on("change", "#level-three-enquiry #category-select #level-one-category input[type='radio'][name='parent-categories']", function() {
        getNodeCategories("#level-three-enquiry #category-select #level-two-category-dom", $(this).val());
        $(this).closest("div#level-one-category").addClass("hidden");
      });
      $(document).on("click", "#level-three-enquiry #category-select #level-two-category ul#branch_categories li.presentation", function() {
        console.log($(this).find('a').attr("aria-controls"));
      });
    }
  });

}).call(this);
