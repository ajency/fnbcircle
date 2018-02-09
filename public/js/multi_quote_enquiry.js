(function() {
  var anyInputTextFocusCheck, anyModalOpenCheck, autoPopupTrigger, capitalize, checkForInput, eraseCookie, getArea, getContent, getCookie, getFilters, getMilliSeconds, getTemplate, getVerification, initCatSearchBox, initFlagDrop, modal_popup_id, multiSelectInit, resetPlugins, resetTemplate, setCookie, validateContact;

  modal_popup_id = "";

  capitalize = function(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  };


  /* --- Get the value formatted to milliseconds --- */

  getMilliSeconds = function(time) {
    var millisecond_value;
    if (time == null) {
      time = {};
    }
    if (time.hasOwnProperty('value') && time.hasOwnProperty('unit')) {
      if (time['unit'].indexOf('second') >= 0) {
        millisecond_value = parseInt(time['value']) * 1000;
      } else if (time['unit'].indexOf('minute') >= 0) {
        millisecond_value = parseInt(time['value']) * 60 * 1000;
      } else if (time['unit'].indexOf('hour') >= 0) {
        millisecond_value = parseInt(time['value']) * 60 * 60 * 1000;
      } else if (time['unit'].indexOf('day') >= 0) {
        millisecond_value = parseInt(time['value']) * 24 * 60 * 60 * 1000;
      } else {
        millisecond_value = 24 * 60 * 60 * 1000;
      }
    } else {
      millisecond_value = 0;
    }
    return millisecond_value;
  };


  /* --- Get filters for the Enquiry Modal --- */

  getFilters = function(modal_id, enquiry_no, listing_slug) {
    var areas, cities, data, descr_values;
    if (enquiry_no == null) {
      enquiry_no = 'step_1';
    }
    data = {};
    if (enquiry_no === 'step_1') {
      descr_values = [];
      if ($(modal_id + " .level-one #level-one-enquiry select[name='description']").length > 0) {
        descr_values = $(modal_id + " .level-one #level-one-enquiry select[name='description']").val();
      } else {
        $.each($(modal_id + " .level-one #level-one-enquiry input[name='description[]']:checked"), function() {
          descr_values.push($(this).val());
        });
      }
      data = {
        name: $(modal_id + " .level-one #level-one-enquiry input[name='name']").val(),
        email: $(modal_id + " .level-one #level-one-enquiry input[name='email']").val(),
        contact_locality: $(modal_id + " .level-one #level-one-enquiry input[name='contact']").intlTelInput("getSelectedCountryData").dialCode,
        contact: $(modal_id + " .level-one #level-one-enquiry input[name='contact']").val(),
        description: descr_values,
        enquiry_message: $(modal_id + " .level-one #level-one-enquiry #lookingfor input[name='enquiry_message']").val(),
        enquiry_level: enquiry_no,
        listing_slug: listing_slug
      };
    } else if (enquiry_no === 'step_2' || enquiry_no === 'step_3') {
      descr_values = [];
      areas = [];
      cities = [];
      $.each($(modal_id + " #level-three-enquiry input[name='categories_interested[]']:checked"), function() {
        descr_values.push($(this).val());
      });
      $(modal_id + " #level-three-enquiry select[name='city']").each(function() {
        cities.push($(this).val());
      });
      $(modal_id + " #level-three-enquiry select[name='area']").each(function() {
        areas = areas.concat($(this).val());
      });
      data = {
        name: $(modal_id + " #level-three-enquiry #enquiry_name").text(),
        email: $(modal_id + " #level-three-enquiry #enquiry_email").text(),
        contact: $(modal_id + " #level-three-enquiry #enquiry_contact").text(),
        categories_interested: descr_values,
        city: cities,
        area: areas,
        enquiry_level: enquiry_no,
        listing_slug: listing_slug
      };
    }
    if (modal_id === "#multi-quote-enquiry-modal") {
      data["multi-quote"] = true;
    }
    return data;
  };


  /* --- Send the data of an enquiry --- */

  getContent = function(modal_id, enquiry_level, listing_slug, trigger_modal, target_modal_id) {
    var areas, data;
    data = getFilters(modal_id, enquiry_level, listing_slug);
    if ((modal_id === "#multi-quote-enquiry-modal") || (trigger_modal && target_modal_id === "#multi-quote-enquiry-modal")) {
      data["multi-quote"] = true;
      if ($("#listing_filter_view").length) {
        data['category'] = $(document).find("#listing_filter_view #current_category").val().split("|")[0];
        areas = [];
        $(document).find("#listing_filter_view #section-area input[type='checkbox']:checked").each(function() {
          areas = areas.concat($(this).val());
        });
        data['areas'] = areas;
      }
    }
    $.ajax({
      type: 'post',
      url: '/api/send_enquiry',
      data: data,
      dataType: 'json',
      async: false,
      success: function(data) {
        if (modal_id === "#enquiry-modal" && data.hasOwnProperty("display_full_screen") && data["display_full_screen"]) {
          $("#enquiry-modal .modal-content .modal-body .col-left.enquiry-details__intro").addClass("hidden");
        } else {
          $("#enquiry-modal .modal-content .modal-body .col-left.enquiry-details__intro").removeClass("hidden");
        }
        if (data["popup_template"].length > 0) {

          /* --- if trigger_modal == true --- */
          if (trigger_modal) {
            if (target_modal_id) {

              /* --- If target_modal_id is passed, then --- */
              $(document).find(target_modal_id + " #listing_popup_fill").html(data["popup_template"]);
              $(document).find(target_modal_id).modal('show');
              if ($(target_modal_id + " #level-three-enquiry").length > 0) {
                multiSelectInit(target_modal_id + " #level-three-enquiry #area_section #area_operations", "", false);
              }
            } else {

              /* --- Else trigger default modal ID --- */
              $(document).find(modal_id).modal('show');
            }
          } else {
            $(document).find(modal_id + " #listing_popup_fill").html(data["popup_template"]);
          }
          if (modal_id === "#rhs-enquiry-form") {
            if ($("#enquiry-modal" + " #level-one-enquiry")) {
              initFlagDrop("#enquiry-modal" + " #level-one-enquiry input[name='contact']");
            }
          } else {
            if ($(modal_id + " #level-one-enquiry")) {
              initFlagDrop(modal_id + " #level-one-enquiry input[name='contact']");
            }
          }
          if ($(modal_id + " #level-three-enquiry").length > 0) {
            multiSelectInit(modal_id + " #level-three-enquiry #area_section #area_operations", "", false);
          }
        }
      },
      error: function(request, status, error) {
        if (request.status === 403) {
          if (getCookie('user_id').length > 0) {
            if (getCookie('user_type') === "user") {
              $("#login-modal").modal('show');
              $("#login-modal #login_form_modal input[name='email']").val($(modal_id + " .level-one #level-one-enquiry input[name='email']").val());
              if (trigger_modal) {
                $(document).find(target_modal_id).modal('hide');
              } else {
                $(document).find(modal_id).modal('hide');
              }
            }
          }
        }
        $(modal_id + " button").find("i.fa-circle-o-notch").addClass("hidden");
        $(modal_id + " button").removeAttr("disabled");
        return console.log(error);
      }
    });
  };


  /* --- Validate contact number --- */

  validateContact = function(contact, error_path, region_code) {
    var contact_sub;
    contact = contact.replace(/\s/g, '').replace(/-/g, '');
    if ((contact.indexOf("+") === 0 || !region_code) && (!isNaN(contact.substring(1, contact.length)))) {
      if (region_code) {
        contact_sub = contact.substring(1, contact.length);
      } else {
        contact_sub = contact;
      }
      if ((!region_code && contact_sub.length <= 0) || (region_code && contact_sub.length <= 2)) {
        $(error_path).removeClass("hidden").text("Please enter your contact number");
      } else if (contact_sub.length < 10) {
        $(error_path).removeClass("hidden").text("Contact number too short");
      } else if ((region_code && contact_sub.length > 13) || ((!region_code) && contact_sub.length > 10)) {
        $(error_path).removeClass("hidden").text("Contact number too long");
      } else {
        $(error_path).addClass("hidden");
        return true;
      }
    } else {
      $(error_path).removeClass("hidden").text("Please enter a valid Contact number");
    }
    return false;
  };


  /* --- Request template for a modal --- */

  getTemplate = function(modal_id, modal_template, listing_slug) {
    var data;
    if (listing_slug == null) {
      listing_slug = '';
    }
    data = {
      'enquiry_level': modal_template
    };
    if (listing_slug) {
      data['listing_slug'] = listing_slug;
    }
    if (modal_id === "#multi-quote-enquiry-modal") {
      data['multi-quote'] = true;
    }
    $.ajax({
      type: 'post',
      url: '/api/get_enquiry_template',
      data: data,
      async: false,
      dataType: 'json',
      success: function(data) {
        if (modal_id === "#enquiry-modal" && data.hasOwnProperty("display_full_screen") && data["display_full_screen"]) {
          $("#enquiry-modal .modal-content .modal-body .col-left.enquiry-details__intro").addClass("hidden");
        } else {
          $("#enquiry-modal .modal-content .modal-body .col-left.enquiry-details__intro").removeClass("hidden");
        }
        if (data["modal_template"].length > 0) {
          $(document).find(modal_id + " #listing_popup_fill").html(data["modal_template"]);
          if ($(modal_id + " #level-one-enquiry").length > 0) {
            if ($(document).find(modal_id).hasClass('in') || $(document).find(modal_id).is('visible')) {
              initFlagDrop(modal_id + " #level-one-enquiry input[name='contact']");
            }
          }
        }
      },
      error: function(request, status, error) {
        console.log(error);
      }
    });
  };


  /* ---  --- */

  getVerification = function(modal_id, enquiry_level, listing_slug, regenerate, new_contact, contact_no) {
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
      'contact': contact_no.length > 0 ? contact_no : $(modal_id + " #listing_popup_fill div.verification__row span.mobile").text().replace(/ /g, ""),
      'otp': $(modal_id + " #listing_popup_fill div.verification__row #code_otp").val(),
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
      async: false,
      success: function(data) {
        if (modal_id === "#enquiry-modal" && data.hasOwnProperty("display_full_screen") && data["display_full_screen"]) {
          $("#enquiry-modal .modal-content .modal-body .col-left.enquiry-details__intro").addClass("hidden");
        } else {
          $("#enquiry-modal .modal-content .modal-body .col-left.enquiry-details__intro").removeClass("hidden");
        }
        if (data["popup_template"].length > 0) {
          $(document).find(modal_id + " #listing_popup_fill").html(data["popup_template"]);
        }
        if ($(modal_id + " #level-three-enquiry").length > 0) {
          multiSelectInit(modal_id + " #level-three-enquiry #area_section #area_operations", "", false);
        }
      },
      error: function(request, status, error) {
        if (request.status === 410) {
          console.log("Sorry, the OTP has expired");
          $(modal_id + " #otp-error").text("Sorry, the OTP has expired.");
        } else if (request.status === 400) {
          $(modal_id + " #otp-error").text("Incorrect OTP. Please enter valid one.");
          console.log("Please enter the Valid OTP");
        } else if (request.status === 404) {
          $(modal_id + " #otp-error").text("Please enter the OTP.");
          console.log("Please enter OTP");
        } else {
          $(modal_id + " #otp-error").text("We have met with an error. Please try after sometime.");
          console.log("Some error in OTP verification");
        }
        console.log(error);
      }
    });
  };


  /* --- Read the cookie & get the value of that KEY --- */

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


  /* --- Create / update the cookie --- */

  setCookie = function(key, value, time) {
    var date, expires, millisecond_value;
    if (time == null) {
      time = {};
    }
    date = new Date();
    if (time.hasOwnProperty('value') && time.hasOwnProperty('unit')) {
      millisecond_value = getMilliSeconds(time);
    } else {
      millisecond_value = getMilliSeconds({
        'value': 30,
        'unit': 'second'
      });
    }
    date.setTime(date.getTime() + millisecond_value);
    expires = "; expires=" + date.toGMTString();
    document.cookie = key + "=" + value + expires + "; path=/";
  };


  /* --- Erase the key-value from Cookie list --- */

  eraseCookie = function(key) {
    setCookie(key, "", {
      'unit': 'second',
      'value': -1
    });
  };

  getArea = function(modal_id, city, path) {
    var html;
    html = '';
    $.ajax({
      type: 'post',
      url: '/get_areas',
      data: {
        'city': city
      },
      async: false,
      success: function(data) {
        var key;
        key = void 0;
        $(path).addClass("default-area-select");
        for (key in data) {
          key = key;
          html += '<option value="' + data[key]['id'] + '" name="area_multiple[]" >' + data[key]['name'] + '</option>';
        }
        $(path).html(html);
        $(document).find(path).multiselect('rebuild');
        multiSelectInit(modal_id + " #level-three-enquiry #area_section", path, false);
      },
      error: function(request, status, error) {
        throw Error();
      }
    });
  };

  initCatSearchBox = function(modal_id) {

    /* --- Initialize categories search  --- */
    $(document).find(modal_id + ' #level-three-enquiry input[name="get_categories"]').flexdatalist({
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
    $(document).on('change:flexdatalist', modal_id + ' #level-three-enquiry input[name="get_categories"]', function(event, item, options) {
      var categories_found, key;
      key = "";
      categories_found = [];
      $(modal_id + " #level-three-enquiry #enquiry_core_categories li input").each(function() {
        categories_found.push($(this).val());
      });
      $(this).flexdatalist('params', {
        "category_level": 3,
        "ignore_categories": categories_found
      });
      event.preventDefault();
    });

    /* --- On select of search box add new core categories  --- */
    $(document).on('select:flexdatalist', modal_id + ' #level-three-enquiry input[name="get_categories"]', function(event, item, options) {
      var html, key;
      key = "";
      html = "<li><label class=\"flex-row\"><input type=\"checkbox\" class=\"checkbox\" for=\" " + item["slug"] + " \" name=\"categories_interested[]\" value=\"" + item["slug"] + "\" data-parsley-trigger=\"change\" data-parsley-mincheck=\"1\" data-required=\"true\" required=\"true\" checked=\"checked\"> <p class=\"text-medium categories__text flex-points__text text-color\" id=\"\">" + item["name"] + "</p></label> </li>";
      $(modal_id + " #level-three-enquiry #enquiry_core_categories").append(html);
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

  multiSelectInit = function(general_path, specific_path, reinit) {
    var path;
    if (reinit == null) {
      reinit = false;
    }
    path = specific_path && specific_path.length ? $(specific_path) : $(document).find(general_path + ' .default-area-select');
    if (reinit) {
      $(document).find(path).multiselect();
    } else {
      $(document).find(path).multiselect({
        includeSelectAllOption: true,
        numberDisplayed: 2,
        delimiterText: ',',
        nonSelectedText: 'Select City'
      });
    }
  };

  resetTemplate = function(modal_id, enquiry_level, listing_slug) {
    if (listing_slug && listing_slug.length > 0 && modal_id === "#enquiry-modal") {
      getTemplate(modal_id, enquiry_level, listing_slug);
    } else {
      getTemplate(modal_id, enquiry_level, "");
    }
  };

  resetPlugins = function(modal_id) {
    if ($(modal_id + " #level-one-enquiry input[name='contact']").length > 0) {
      $(modal_id + " #level-one-enquiry input[name='contact']").intlTelInput("destroy");
    }
    if ($(modal_id + " .default-area-select").length > 0) {
      $(modal_id + " .default-area-select").multiselect("destroy");
    }
  };

  checkForInput = function(element) {
    var $label;
    $label = $(element).siblings('label');
    if ($(element).val().length > 0) {
      $label.addClass('filled lab-color');
    } else {
      $label.removeClass('filled lab-color');
    }
  };


  /* --- This function checks if any modal is Open in a document/window --- */

  anyModalOpenCheck = function(id) {
    if (id == null) {
      id = '';
    }
    if (id.length > 0) {
      return $(document).find(id).data('bs.modal') && ($(document).find(id).data('bs.modal').isShown);
    } else {
      return ($('.modal.in').length > 0 ? true : false);
    }
  };


  /* --- This function checks if any Input/TextArea is on Focus in a document/window --- */

  anyInputTextFocusCheck = function(id) {
    if (id.length > 0) {
      return $(id).find('input:focus, textarea:focus').length > 0;
    } else {
      return $(document).find('input:focus, textarea:focus').length > 0;
    }
  };


  /* --- This function is called for auto-popup trigger --- */

  autoPopupTrigger = function() {

    /* --- Auto popup function starts --- */
    var millisecond_value;
    if (parseInt(getCookie('enquiry_modal_display_count')) > 0 && (!anyModalOpenCheck(""))) {
      if (parseInt(getCookie('enquiry_modal_first_time_value')) > 0 && getCookie('enquiry_modal_first_time_unit').length > 0) {
        millisecond_value = getMilliSeconds({
          'value': parseInt(getCookie('enquiry_modal_first_time_value')),
          'unit': getCookie('enquiry_modal_first_time_unit')
        });
        console.log("modal timeout initiated opens in " + millisecond_value.toString());
        return setTimeout((function() {
          var display_counter;
          console.log("Timed out");
          if ((!anyModalOpenCheck("")) && (!anyInputTextFocusCheck(""))) {
            $(document).find('#bs-example-navbar-collapse-1 .enquiry-modal-btn').trigger('click');
            console.log("trigger modal timer");
            display_counter = parseInt(getCookie('enquiry_modal_display_count')) - 1;
            if (display_counter > 0) {
              setCookie('enquiry_modal_display_count', display_counter, {
                'unit': 'day',
                'value': 30
              });
            } else {
              eraseCookie('enquiry_modal_display_count');
              eraseCookie('enquiry_modal_first_time_value');
              eraseCookie('enquiry_modal_first_time_unit');
            }
          }
        }), millisecond_value);
      }
    }

    /* --- Auto popup function ends --- */
  };

  $(document).ready(function() {

    /* --- This object is used to store old values -> Mainly for search-boxes --- */
    var old_values;
    old_values = {};
    autoPopupTrigger();

    /* --- If RHS Enquiry form exist, then --- */
    if ($("#rhs-enquiry-form .level-one #level-one-enquiry").length > 0) {
      initFlagDrop("#rhs-enquiry-form .level-one #level-one-enquiry input[name='contact']");
      $(document).find("#rhs-enquiry-form .level-one #level-one-enquiry select[name='description']").multiselect({
        includeSelectAllOption: true,
        numberDisplayed: 1,
        delimiterText: ',',
        nonSelectedText: 'Select that describes you best'
      });
      $(document).find('.float-input').each(function() {
        checkForInput(this);
      });
    }

    /* --- Display respective Popups on "Send Enquiry" click --- */
    $(document).on("click", ".enquiry-modal-btn", function(e) {
      var enq_form_id, is_user_status, listing_slug, modal_id, page_level;
      modal_id = $(this).data("target");
      modal_popup_id = modal_id;
      is_user_status = false;
      if ($(modal_id).length > 0 && (!is_user_status)) {
        if ($(this).closest("#rhs-enquiry-form").length && $(this).closest("#rhs-enquiry-form").find("select[name='description']").length) {
          $(this).closest("#rhs-enquiry-form").find('button.multiselect').attr('data-parsley-errors-container', '#describes-best-dropdown-error');
        }
        if ($(this).closest("#rhs-enquiry-form").length <= 0 || ($(this).closest("#rhs-enquiry-form").length && $(this).closest("#level-one-enquiry").parsley().validate())) {
          if ($(this).closest("#rhs-enquiry-form").length > 0) {
            $(modal_id).modal('show');
          }
          if ($(this).data("value")) {
            enq_form_id = "#" + $(this).closest("div.send-enquiry-section").prop("id");
            page_level = $(this).data('value') && $(this).data('value').length > 0 ? $(this).data('value') : 'step_1';
            if (modal_id === "#enquiry-modal") {
              listing_slug = $("#enquiry_slug").val();
            } else {
              listing_slug = "";
            }
            getContent(enq_form_id, page_level, listing_slug, true, modal_id);
          } else {

            /* --- Reset to Modal 1 on enquiry button Click --- */
            resetTemplate(modal_id, 'step_1', $("#enquiry_slug").val());
            resetPlugins(modal_id);
          }
        } else {
          if ($(this).closest("#rhs-enquiry-form").length > 0) {
            $(modal_id).modal('hide');
          }
        }
        $(modal_id).on('shown.bs.modal', function(e) {
          checkForInput = function(element) {
            var $label;
            $label = $(element).siblings('label');
            if ($(element).val().length > 0) {
              $label.addClass('filled lab-color');
            } else {
              $label.removeClass('filled lab-color');
            }
          };
          $('.float-input').on('focus', function() {
            $(this).siblings('.float-label').addClass('filled focused');
          });
          $('.float-input').on('blur', function() {
            $(this).siblings('.float-label').removeClass('focused');
            if (this.value === '') {
              $(this).siblings('.float-label').removeClass('filled');
            }
          });
          $('.floatInput').on('focus', function() {
            $(this).parent().closest('.form-group').find('.float-label').addClass('filled focused');
          });
          $('.floatInput').on('blur', function() {
            $(this).parent().closest('.form-group').find('.float-label').removeClass('focused');
            if (this.value === '') {
              $(this).parent().closest('.form-group').find('.float-label').removeClass('filled');
            }
          });
          $('.float-input').each(function() {
            checkForInput(this);
          });

          /* --- For mobile Screen --- */
          if ($(window).width() <= 768) {
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
              return $(this).find('.list-title-container').before(listlabel);
            });
          }
        });
        if ($(document).find(modal_id + " #level-one-enquiry").length > 0) {
          initFlagDrop(modal_id + " #level-one-enquiry input[name='contact']");
          if ($(modal_id + " #level-one-enquiry input[name='contact']").length <= 1 && $(modal_id + " #level-one-enquiry input[name='contact']").val().indexOf('+') > -1) {
            $(modal_id + " #level-one-enquiry input[name='contact']").val("");
          }
        }
        if ($(document).find(modal_id + " #level-one-enquiry").length > 0) {
          $(document).on("countrychange", modal_id + " #level-one-enquiry input[name='contact']", function() {
            if ($(this).val() > 0) {
              $(this).val($(this).intlTelInput("getNumber"));
            }
          });
        }

        /* --- On click of "Send Enquiry 1" button --- */
        $(document).on("click", modal_id + " #level-one-enquiry #level-one-form-btn", function(event) {
          page_level = $(this).data('value') && $(this).data('value').length > 0 ? $(this).data('value') : 'step_1';
          $(this).find("i.fa-circle-o-notch").removeClass("hidden");
          $(this).attr("disabled", "disabled");
          if ($(document).find(modal_id + " #level-one-enquiry").parsley().validate()) {
            getContent(modal_id, page_level, $("#enquiry_slug").val(), false, modal_id);
            event.stopImmediatePropagation();
          } else {
            $(this).find("i.fa-circle-o-notch").addClass("hidden");
            $(this).removeAttr("disabled");
            console.log("forms not complete");
          }
        });

        /* --- On click of OTP submit button --- */
        $(document).on("click", modal_id + " #level-two-enquiry #level-two-form-btn", function(event) {
          getVerification(modal_id, $(this).data('value'), $("#enquiry_slug").val(), false, false, '');
          event.stopImmediatePropagation();
        });

        /* --- On click of OTP regenerate button --- */
        $(document).on("click", modal_id + " #level-two-enquiry #level-two-resend-btn", function(event) {
          getVerification(modal_id, $(this).data('value'), $("#enquiry_slug").val(), true, true, '');
          event.stopImmediatePropagation();
        });

        /* --- initialize the Flag in Popup 2 --- */
        $(document).on("click", modal_id + " #level-two-enquiry", function() {
          initFlagDrop(modal_id + " #level-two-enquiry #new-mobile-modal input[name='contact']");
        });

        /* --- On click of 'x', close the Popup 2 modal --- */
        $(document).on("click", modal_id + " #level-two-enquiry #close-new-mobile-modal", function() {
          $(document).find(modal_id + " #new-mobile-modal").modal("hide");
        });
        $(document).on("change", modal_id + " #level-three-enquiry #area_section select[name='city']", function(event) {
          var city_vals, i;
          city_vals = [];
          i = 0;
          $(modal_id + " #level-three-enquiry #area_section select[name='city'] option").removeClass('hidden');
          $(modal_id + " #level-three-enquiry #area_section select[name='city']").each(function() {
            city_vals.push($(this).val());
          });
          while (i < city_vals.length) {
            $(modal_id + " #level-three-enquiry #area_section select[name='city'] option[value='" + city_vals[i] + "']").addClass('hidden');
            i++;
          }
          $(modal_id + " #level-three-enquiry #area_section select[name='city']").each(function() {
            if ($.inArray($(this).val(), city_vals) > -1) {
              $(this).find("option[value='" + $(this).val() + "']").removeClass('hidden');
            }
          });
          getArea(modal_id, $(this).val(), $(this).closest('ul').find('select[name="area"]'));
          event.stopImmediatePropagation();
        });

        /* --- On click of close, remove the City-Area DOM --- */
        $(document).on("click", modal_id + " #level-three-enquiry #close_areas", function() {
          $(modal_id + " #level-three-enquiry #area_section select[name='city'] option[value='" + $(this).val() + "']").addClass('hidden');
          $(modal_id + " #level-three-enquiry #area_section select[name='city'] option[value='" + $(this).closest('ul').find("select[name='city']").val() + "']").removeClass('hidden');
          $(this).closest("ul").remove();
        });

        /* --- On click of Popup 3 'Save / Send' --- */
        $(document).on("click", modal_id + " #level-three-enquiry #level-three-form-btn", function(event) {
          page_level = $(this).data('value') && $(this).data('value').length > 0 ? $(this).data('value') : 'step_1';
          $(this).find("i.fa-circle-o-notch").removeClass("hidden");
          $(this).attr("disabled", "disabled");
          if ($(document).find(modal_id + " #level-three-enquiry #other_details_container").parsley().validate()) {
            getContent(modal_id, page_level, $("#enquiry_slug").val(), false, modal_id);
            event.stopImmediatePropagation();
          } else {
            $(this).find("i.fa-circle-o-notch").addClass("hidden");
            $(this).removeAttr("disabled");
            console.log("forms not complete");
          }
        });

        /* --- On click of "Add More" categories --- */
        $(document).on("click", modal_id + " #level-three-enquiry #select-more-categories", function() {
          var main_page_categories;
          main_page_categories = [];
          $.each($(modal_id + " #level-three-enquiry input[name='categories_interested[]']:checked"), function() {
            main_page_categories.push($(this).val());
          });
          $(modal_id).modal("hide");

          /* --- Category select modal on show --- */
          $(document).on("shown.bs.modal", "#category-select", function(event) {
            var branch_list;
            branch_list = JSON.parse($(modal_id + " #level-three-enquiry #branch_category_selected_ids").val());
            main_page_categories = main_page_categories.concat(branch_list);
            $("#category-select #previously_available_categories").val(JSON.stringify(main_page_categories));
          });
        });

        /* --- On Categories Modal close, update the Level 3 with checkboxes --- */
        $(document).on("hidden.bs.modal", "#category-select", function(event) {
          var checked_categories, html, index;
          $(modal_id).modal("show");
          checked_categories = [];
          index = 0;
          html = "";
          if ($(modal_id + " #level-three-enquiry #modal_categories_chosen").val().length > 2 && JSON.parse($(modal_id + " #level-three-enquiry #modal_categories_chosen").val()).length > 0) {
            checked_categories = JSON.parse($(modal_id + " #level-three-enquiry #modal_categories_chosen").val());
          }
          $(modal_id + " #level-three-enquiry input[name='categories_interested[]']").prop("checked", false);
          if (checked_categories.length > 0 && $(document).find(modal_id + " #level-three-enquiry  #category_hidden_checkbox").length > 0) {
            $(document).find(modal_id + " #level-three-enquiry li#category_hidden_checkbox").remove();
            $(document).find(modal_id + " #level-three-enquiry #category-checkbox-error").html("");
          }
          console.log("Categories chosen: " + checked_categories.length.toString());
          while (index < checked_categories.length) {
            if ($(modal_id + " #level-three-enquiry input[name='categories_interested[]'][value='" + checked_categories[index]["slug"] + "']").length > 0) {
              $(modal_id + " #level-three-enquiry input[name='categories_interested[]'][value='" + checked_categories[index]["slug"] + "']").prop("checked", true);
            } else if (checked_categories[index].hasOwnProperty("name")) {
              html += "<li><label class=\"flex-row\"><input type=\"checkbox\" class=\"checkbox\" for=\" " + checked_categories[index]["slug"] + " \" name=\"categories_interested[]\" value=\"" + checked_categories[index]["slug"] + "\" data-parsley-trigger=\"change\" data-parsley-required-message=\"Please select a category\" data-parsley-mincheck=\"1\" data-required=\"true\" required=\"true\" checked=\"checked\" data-parsley-errors-container=\"#category-checkbox-error\"> <p class=\"text-medium categories__text flex-points__text text-color\" id=\"\">" + checked_categories[index]["name"] + "</p></label> </li>";
            }
            index++;
          }
          if (html.length > 0) {
            $(modal_id + " #level-three-enquiry #enquiry_core_categories").append(html);
          }
        });
      }
    });

    /* --- On click of "+ Add more" on Enquiry 3 Popup "Areas", new set will be added --- */
    $(document).on("click", "#level-three-enquiry #add-city-areas", function(event) {
      var city_area_selection_length, html_area_dom;
      if (modal_popup_id && modal_popup_id.length > 0) {
        html_area_dom = $(modal_popup_id + " #area_dom_skeleton").clone("true").removeAttr('id').removeClass('hidden');
        city_area_selection_length = $(modal_popup_id + " #area_section #area_operations ul.areas-select__selection").length;
        html_area_dom.find('li.city-select select[name="city"]').attr('data-parsley-trigger', 'change');
        html_area_dom.find('li.city-select select[name="city"]').attr('required', 'true');
        html_area_dom.find('li.city-select select[name="city"]').attr('data-parsley-errors-container', "#" + (html_area_dom.find("li.city-select #city-select-error").attr('id') + '-' + (city_area_selection_length + 1).toString()));
        html_area_dom.find("li.city-select #city-select-error").attr('id', html_area_dom.find("li.city-select #city-select-error").attr('id') + '-' + (city_area_selection_length + 1).toString());
        html_area_dom.find('li.area-select select[name="area"]').attr('required', 'true');
        html_area_dom.find('li.area-select select[name="area"]').attr('data-parsley-errors-container', "#" + (html_area_dom.find("li.area-select #area-select-error").attr('id') + '-' + (city_area_selection_length + 1).toString()));
        html_area_dom.find("li.area-select #area-select-error").attr('id', html_area_dom.find("li.area-select #area-select-error").attr('id') + '-' + (city_area_selection_length + 1).toString());
        html_area_dom.appendTo(modal_popup_id + " #area_section #area_operations");
        multiSelectInit(modal_popup_id + " #level-three-enquiry #area_section #area_operations", "", false);
      }
    });

    /* --- Show the Edit contact Popup --- */
    $(document).on("click", "#level-two-enquiry #edit-contact-number-btn", function(event) {
      $(document).find("#enquiry-mobile-verification #new-mobile-modal input[type='tel']").attr('data-parsley-errors-container', '#phoneErrorCustom');
      $(document).find("#enquiry-mobile-verification #new-mobile-modal #phoneError").attr('id', "phoneErrorCustom");
      $(document).find("#enquiry-mobile-verification #new-mobile-modal").modal('show');
    });

    /* --- Change the Contact No & Regenarate OTP --- */
    $(document).on("click", "#enquiry-mobile-verification #new-mobile-modal #new-mobile-verify-btn", function(event) {
      $(this).closest("#change-contact-form");
      $("#enquiry-mobile-verification #phoneErrorCustom").html("");
      if ($(this).closest("#change-contact-form").parsley().validate()) {
        if (modal_popup_id && modal_popup_id.length > 0) {
          $(modal_popup_id + " #listing_popup_fill div.verification__row span.mobile").text("+" + $(this).closest('#change-contact-form').find("input[type='tel'][name='contact']").intlTelInput("getSelectedCountryData").dialCode + " " + $(this).closest('#change-contact-form').find("input[type='tel'][name='contact']").val());
          $(document).find(modal_popup_id + " #new-mobile-modal").modal("hide");
          getVerification(modal_popup_id, $(modal_popup_id + " #level-two-enquiry #level-two-resend-btn").data('value'), $("#enquiry_slug").val(), false, true, $(this).parent().find("div.new-verify-number input[type='tel'][name='contact']").intlTelInput("getSelectedCountryData").dialCode + '-' + $(this).parent().find("div.new-verify-number input[type='tel'][name='contact']").val());
          console.log($(this));
          $(this).closest('#new-mobile-modal').modal('hide');
          event.stopImmediatePropagation();
        }
      }
    });

    /* --- Validate Mobile No --- */
    $(document).on('keyup change', modal_popup_id + " #level-one-enquiry input[type='tel'][name='contact']", function() {
      var id;
      id = $(this).closest('form').prop('id');
      validateContact($(this).val(), "#" + id + " #contactfield", false);
    });
  });

}).call(this);
