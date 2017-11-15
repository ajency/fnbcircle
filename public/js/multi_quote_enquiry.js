(function() {
  var capitalize, getArea, getContent, getCookie, getFilters, getTemplate, getVerification, initCatSearchBox, initFlagDrop, multiSelectInit, resetPlugins, resetTemplate;

  capitalize = function(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  };

  getFilters = function(modal_id, enquiry_no, listing_slug) {
    var areas, cities, data, descr_values;
    if (enquiry_no == null) {
      enquiry_no = 'step_1';
    }
    data = {};
    if (enquiry_no === 'step_1') {
      descr_values = [];
      $.each($(modal_id + " .level-one #level-one-enquiry input[name='description[]']:checked"), function() {
        descr_values.push($(this).val());
      });
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
    if (trigger_modal && target_modal_id === "#multi-quote-enquiry-modal") {
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
                multiSelectInit(target_modal_id + " #level-three-enquiry #area_section #area_operations", false);
              }
            } else {

              /* --- Else trigger default modal ID --- */
              $(document).find(modal_id).modal('show');
            }
          } else {
            $(document).find(modal_id + " #listing_popup_fill").html(data["popup_template"]);
          }
          if ($(modal_id + " #level-one-enquiry")) {
            initFlagDrop(modal_id + " #level-one-enquiry input[name='contact']");
          }
          if ($(modal_id + " #level-three-enquiry").length > 0) {
            multiSelectInit(modal_id + " #level-three-enquiry #area_section #area_operations", false);
          }
        }
      },
      error: function(request, status, error) {
        return console.log(error);
      }
    });
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
            initFlagDrop(modal_id + " #level-one-enquiry input[name='contact']");
          }
        }
      },
      error: function(request, status, error) {
        console.log(error);
      }
    });
  };

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
      success: function(data) {
        if (data["popup_template"].length > 0) {
          $(document).find(modal_id + " #listing_popup_fill").html(data["popup_template"]);
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

  getArea = function(modal_id, city, path) {
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
        $(path).addClass("default-area-select");
        for (key in data) {
          key = key;
          html += '<option value="' + data[key]['id'] + '" name="area_multiple[]" >' + data[key]['name'] + '</option>';
        }
        $(path).html(html);
        $(modal_id + " #level-three-enquiry" + ' .default-area-select').multiselect('rebuild');
        multiSelectInit(modal_id + " #level-three-enquiry #area_section", false);
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

  multiSelectInit = function(path, reinit) {
    if (reinit == null) {
      reinit = false;
    }
    if (reinit) {
      $(document).find(path + ' .default-area-select').multiselect();
    } else {
      $(document).find(path + ' .default-area-select').multiselect({
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

  $(document).ready(function() {

    /* --- This object is used to store old values -> Mainly for search-boxes --- */
    var old_values;
    old_values = {};

    /* --- Display respective Popups on "Send Enquiry click" --- */
    $(document).on("click", ".enquiry-modal-btn", function(e) {
      var enq_form_id, modal_id, page_level;
      modal_id = $(this).data("target");
      if ($(modal_id).length > 0) {
        if ($(this).data("value")) {
          enq_form_id = "#" + $(this).closest("div.send-enquiry-section").prop("id");
          page_level = $(this).data('value') && $(this).data('value').length > 0 ? $(this).data('value') : 'step_1';
          getContent(enq_form_id, page_level, '', true, modal_id);
        } else {

          /* --- Reset to Modal 1 on enquiry button Click --- */
          resetTemplate(modal_id, 'step_1', $("#enquiry_slug").val());
          resetPlugins(modal_id);
        }
        $(modal_id).on('shown.bs.modal', function(e) {
          var checkForInput;
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
          if ($(document).find(modal_id + " #level-one-enquiry").parsley().validate()) {
            getContent(modal_id, page_level, $("#enquiry_slug").val(), false, modal_id);
            event.stopImmediatePropagation();
          } else {
            $(this).find("i.fa-circle-o-notch").addClass("hidden");
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

        /* --- Change the Contact No & Regenarate OTP --- */
        $(document).on("click", modal_id + " #level-two-enquiry #new-mobile-verify-btn", function(event) {
          $(modal_id + " #listing_popup_fill div.verification__row span.mobile").text("+" + $(this).closest('div.new-verify-number').find("input[type='tel'][name='contact']").intlTelInput("getSelectedCountryData").dialCode + " " + $(this).closest('div.new-verify-number').find("input[type='tel'][name='contact']").val());
          $(document).find(modal_id + " #new-mobile-modal").modal("hide");
          getVerification(modal_id, $(modal_id + " #level-two-enquiry #level-two-resend-btn").data('value'), $("#enquiry_slug").val(), false, true, $(this).closest('div.new-verify-number').find("input[type='tel'][name='contact']").intlTelInput("getSelectedCountryData").dialCode + '-' + $(this).closest('div.new-verify-number').find("input[type='tel'][name='contact']").val());
          event.stopImmediatePropagation();
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

        /* --- On click of "+ Add more" on Enquiry 3 Popup "Areas", new set will be added --- */
        $(document).on("click", modal_id + " #level-three-enquiry #add-city-areas", function(event) {
          $(modal_id + " #area_dom_skeleton").clone("true").removeAttr('id').removeClass('hidden').appendTo(modal_id + " #area_section #area_operations");
          multiSelectInit(modal_id + " #level-three-enquiry #area_section #area_operations", false);
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
          if ($(document).find(modal_id + " #level-three-enquiry #enquiry_core_categories").parsley().validate() && $(document).find(modal_id + " #level-three-enquiry #area_operations").parsley().validate()) {
            getContent(modal_id, page_level, $("#enquiry_slug").val(), false, modal_id);
            event.stopImmediatePropagation();
          } else {
            $(this).find("i.fa-circle-o-notch").addClass("hidden");
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
          while (index < checked_categories.length) {
            if ($(modal_id + " #level-three-enquiry input[name='categories_interested[]'][value='" + checked_categories[index]["slug"] + "']").length > 0) {
              $(modal_id + " #level-three-enquiry input[name='categories_interested[]'][value='" + checked_categories[index]["slug"] + "']").prop("checked", true);
            } else {
              html += "<li><label class=\"flex-row\"><input type=\"checkbox\" class=\"checkbox\" for=\" " + checked_categories[index]["slug"] + " \" name=\"categories_interested[]\" value=\"" + checked_categories[index]["slug"] + "\" data-parsley-trigger=\"change\" data-parsley-mincheck=\"1\" data-required=\"true\" required=\"true\" checked=\"checked\"> <p class=\"text-medium categories__text flex-points__text text-color\" id=\"\">" + checked_categories[index]["name"] + "</p></label> </li>";
            }
            index++;
          }
          if (html.length > 0) {
            $(modal_id + " #level-three-enquiry #enquiry_core_categories").append(html);
          }
        });
      }
    });
  });

}).call(this);
