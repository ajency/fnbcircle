(function() {
  var capitalize, getArea, getContent, getCookie, getFilters, getTemplate, getVerification;

  capitalize = function(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  };

  getFilters = function(enquiry_no, listing_slug) {
    var areas, data, descr_values;
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
      console.log(enquiry_no);
      descr_values = [];
      areas = [];
      $.each($("#level-three-enquiry input[name='categories_interested']:checked"), function() {
        descr_values.push($(this).val());
      });
      areas = $("#level-three-enquiry select[name='area']").val();
      data = {
        name: $("#level-three-enquiry #enquiry_name").text(),
        email: $("#level-three-enquiry #enquiry_email").text(),
        contact: $("#level-three-enquiry #enquiry_contact").text(),
        categories_interested: descr_values,
        city: $("#level-three-enquiry select[name='city']").val(),
        area: areas,
        enquiry_level: enquiry_no,
        listing_slug: listing_slug
      };
    }
    return data;
  };

  getContent = function(enquiry_level, listing_slug) {
    var data;
    console.log("calling .....");
    data = getFilters(enquiry_level, listing_slug);
    console.log(data);
    $.ajax({
      type: 'post',
      url: '/api/send_enquiry',
      data: data,
      dataType: 'json',
      success: function(data) {
        if (data["popup_template"].length > 0) {
          $(document).find("#updateTemplate #enquiry-modal #listing_popup_fill").html(data["popup_template"]);
          return $(document).find("div.container #enquiry-modal").modal('show');
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

  getVerification = function(enquiry_level, listing_slug, regenerate) {
    var data;
    if (listing_slug == null) {
      listing_slug = '';
    }
    if (regenerate == null) {
      regenerate = false;
    }
    console.log("get verified");
    data = {
      'enquiry_level': enquiry_level,
      'listing_slug': listing_slug,
      'contact': $("#enquiry-modal #listing_popup_fill div.verification__row span.mobile").text().replace(/ /g, ""),
      'otp': $("#enquiry-modal #listing_popup_fill div.verification__row #code_otp").val(),
      'regenerate': regenerate
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
        if (status === 410) {
          console.log("Sorry, the OTP has expired");
        } else if (status === 400) {
          console.log("Please enter the Valid OTP");
        } else if (status === 404) {
          console.log("Please enter OTP");
        } else {
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

  getArea = function(city, parent) {
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
        $('#' + parent + ' select[name="area"]').html(html);
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
        $(document).find("#level-one-enquiry input[name='contact']").intlTelInput({
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
          console.log("true");
        } else {
          console.log("forms not complete");
        }
        console.log("exist");
      });

      /* --- On click of OTP submit button --- */
      $(document).on("click", "#level-two-enquiry #level-two-form-btn", function() {
        console.log("OTP submit");
        getVerification($(this).data('value'), $("#enquiry_slug").val(), false);
      });

      /* --- On click of OTP regenerate button --- */
      $(document).on("click", "#level-two-enquiry #level-two-resend-btn", function() {
        getVerification($(this).data('value'), $("#enquiry_slug").val(), true);
      });
      $(document).on("change", "#level-three-enquiry #area_section select[name='city']", function() {
        console.log($(this).val());
        getArea($(this).val(), "area_section");
      });
      $(document).on("click", "#level-three-enquiry #level-three-form-btn", function() {
        var page_level;
        page_level = $(this).data('value') && $(this).data('value').length > 0 ? $(this).data('value') : 'step_1';
        if ($(document).find("#level-three-enquiry").parsley().validate()) {
          getContent(page_level, $("#enquiry_slug").val());
          console.log("true");
        } else {
          console.log("forms not complete");
        }
      });
    }
  });

}).call(this);
