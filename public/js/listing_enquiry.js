(function() {
  var capitalize, getArea, getContent, getCookie, getFilters, getTemplate, getVerification;

  capitalize = function(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  };

  getFilters = function(enquiry_no, listing_slug) {
    var data, descr_values;
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
        contact: $(".level-one #level-one-enquiry input[name='contact']").val(),
        description: descr_values,
        enquiry_message: $(".level-one #level-one-enquiry #lookingfor input[name='enquiry_message']").val(),
        enquiry_level: enquiry_no,
        listing_slug: listing_slug
      };
    }

    /* --- Step -2 & 3 are not added under this as the flow is different for Premium & Non-Premium --- */
    return data;
  };

  getContent = function(enquiry_level, listing_slug) {
    $.ajax({
      type: 'post',
      url: '/api/send_enquiry',
      data: getFilters(enquiry_level, listing_slug),
      dataType: 'json',
      success: function(data) {
        if (data["popup_template"].length > 0) {
          $(document).find(".single-view-head #updateTemplate #enquiry-modal #listing_popup_fill").html(data["popup_template"]);
          return $(document).find("div.single-view-head div.container #enquiry-modal").modal('show');
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
          $(document).find(".single-view-head #updateTemplate #enquiry-modal #listing_popup_fill").html(data["modal_template"]);
          return $(document).find("div.single-view-head div.container #enquiry-modal").modal('show');
        }
      },
      error: function(request, status, error) {
        $("div.single-view-head div.container #enquiry-modal").modal('show');
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
          $(document).find(".single-view-head #updateTemplate #enquiry-modal #listing_popup_fill").html(data["popup_template"]);
          return $(document).find("div.single-view-head div.container #enquiry-modal").modal('show');
        }
      },
      error: function(request, status, error) {
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
      $(document).on("click", ".single-view-head div.col-sm-4 div.equal-col div.contact__enquiry button.fnb-btn.primary-btn", function() {
        if (getCookie('user_id').length > 0) {
          if (getCookie('user_type') === "user") {
            $("#login-modal").modal('show');
          } else {
            getTemplate('step_1', $(".single-view-head #enquiry_slug").val());
          }
        } else {
          $("div.single-view-head div.container #enquiry-modal").modal('show');
        }
      });

      /* --- On click of "Send Enquiry 1" button --- */
      $(document).on("click", "#level-one-enquiry #level-one-form-btn", function() {
        var page_level;
        page_level = $(this).data('value') && $(this).data('value').length > 0 ? $(this).data('value') : 'step_1';
        if ($(document).find("#level-one-enquiry").parsley().validate()) {
          getContent(page_level, $(".single-view-head #enquiry_slug").val());
          console.log("true");
        } else {
          console.log("forms not complete");
        }
        console.log("exist");
      });

      /* --- On click of OTP submit button --- */
      $(document).on("click", "#level-two-enquiry #level-two-form-btn", function() {
        console.log("OTP submit");
        getVerification($(this).data('value'), $(".single-view-head #enquiry_slug").val(), false);
      });

      /* --- On click of OTP regenerate button --- */
      $(document).on("click", "#level-two-enquiry #level-two-resend-btn", function() {
        getVerification($(this).data('value'), $(".single-view-head #enquiry_slug").val(), true);
      });
      $(document).on("change", "#level-three-enquiry #area_section select[name='city']", function() {
        console.log($(this).val());
        getArea($(this).val(), "area_section");
      });
    }
  });

}).call(this);
