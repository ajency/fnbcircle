(function() {
  var capitalize, getContent, getCookie, getFilters, getTemplate;

  capitalize = function(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  };

  getFilters = function() {};

  getContent = function() {
    var data;
    data = {
      "name": "asdads",
      "email": "asdasd"
    };
    $.ajax({
      type: 'post',
      url: '/api/get-listview-data',
      data: data,
      dataType: 'json',
      success: function(data) {},
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
      'template': modal_template,
      'listing_slug': listing_slug
    };
    $.ajax({
      type: 'post',
      url: '/api/get_enquiry_template',
      data: data,
      dataType: 'json',
      success: function(data) {
        $(document).find(".single-view-head #updateTemplate").html(data["modal_template"]);
        return $(document).find("div.single-view-head div.container #enquiry-modal").modal('show');
      },
      error: function(request, status, error) {
        $("div.single-view-head div.container #enquiry-modal").modal('show');
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
            getTemplate('enquiry_template_one', $(".single-view-head #enquiry_slug").val());
          }
        } else {
          $("div.single-view-head div.container #enquiry-modal").modal('show');
        }
      });
      $(document).on("click", "#level-one-enquiry #level-one-form-btn", function() {
        if ($(document).find("#level-one-enquiry").parsley().validate()) {
          console.log("true");
        } else {
          console.log("forms not complete");
        }
        return;
        return console.log("exist");
      });
      return;
    }
  });

}).call(this);
