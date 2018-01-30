(function() {
  var browsecat, catlabel, contactrow, equalcol, getheight, handleResponse, loadUpdates, moveelement, offset, order, status;

  $('.shareRoundIcons').jsSocials({
    showLabel: false,
    showCount: false,
    shareIn: "popup",
    text: "",
    shares: ['twitter', 'facebook', 'googleplus', 'linkedin', 'whatsapp']
  });

  offset = 0;

  order = 0;

  loadUpdates = function() {
    return $.ajax({
      url: document.head.querySelector('[property="get-posts-url"]').content,
      type: 'get',
      data: {
        'type': 'listing',
        'id': document.getElementById('listing_id').value,
        'offset': offset,
        'order': order
      },
      success: function(data) {
        var button, html;
        if (data['status'] === '200') {
          $('.update-display-section').find('.view-more-updates').remove();
          if (data['data']['updates'].length !== 0) {
            offset += data['data']['updates'].length;
            html = '';
            $.each(data['data']['updates'], function(i, element) {
              html += '<div class="update-sec sidebar-article"> <div class="update-sec__body update-space"> <p class="element-title update-sec__heading m-t-15 bolder">' + element.title + '</p> <p class="update-sec__caption text-lighter">' + element.contents + '</p> <ul class="flex-row update-img post-gallery flex-wrap">';
              $.each(element.images, function(j, item) {
                html += '<li><a href="' + item['400X300'] + '"><img src="' + item['200x150'] + '" alt="" width="80" class="no-height"><div class="updates-img-col" style="background-image: url(' + item['200x150'] + ');"> </div></a></li>';
              });
              return html += '</ul> <p class="m-b-0 posted-date text-secondary flex-row"><i class="fa fa-clock-o sub-title p-r-5" aria-hidden="true"></i> Posted ' + element.updated + '</p> </div> </div>';
            });
            $('.update-display-section').append(html);
            if (data['data']['more'] === true) {
              button = '<div class="m-t-10 text-center view-more-updates"> <a href="#" class="btn fnb-btn secondary-btn full border-btn default-size">+ View More</a> </div>';
              $('.update-display-section').append(button);
            }
            if ($('.post-gallery').length) {
              return $('.post-gallery').each(function() {
                return $(this).magnificPopup({
                  delegate: 'a',
                  type: 'image',
                  gallery: {
                    enabled: true
                  },
                  zoom: {
                    enabled: true,
                    duration: 300
                  }
                });
              });
            }
          }
        }
      }
    });
  };

  $('body').on('click', '.view-updates', function() {
    offset = 0;
    order = 0;
    $('select[name="update-sort"]').val('0');
    $('.update-display-section').html('');
    return loadUpdates();
  });

  $('body').on('change', 'select[name="update-sort"]', function() {
    order = this.value;
    offset = 0;
    $('.update-display-section').html('');
    return loadUpdates();
  });

  $('body').on('click', '.view-more-updates a', function() {
    return loadUpdates();
  });

  if ($('.operation__hours').length) {
    $('.operation__hours').readmore({
      speed: 25,
      collapsedHeight: 18,
      moreLink: '<a href="#" class="more default-size secondary-link">View more</a>',
      lessLink: '<a href="#" class="default-size less secondary-link">View less</a>'
    });
  }

  if ($('.similar-card-operation').length) {
    $('.similar-card-operation').readmore({
      speed: 25,
      collapsedHeight: 26,
      moreLink: '<a href="#" class="more x-small secondary-link">More</a>',
      lessLink: '<a href="#" class="x-small less secondary-link">Less</a>'
    });
  }

  if ($('.catShow').length) {
    $('.catShow').readmore({
      speed: 25,
      collapsedHeight: 35,
      moreLink: '<a href="#" class="more x-small secondary-link">View more</a>',
      lessLink: '<a href="#" class="x-small less secondary-link">View less</a>'
    });
  }

  if ($('.description').length) {
    $('.description').readmore({
      speed: 25,
      collapsedHeight: 170,
      moreLink: '<a href="#" class="more default-size secondary-link">View more</a>',
      lessLink: '<a href="#" class="default-size less secondary-link">View less</a>'
    });
  }

  if ($('.post-gallery').length) {
    $('.post-gallery').magnificPopup({
      delegate: 'a',
      type: 'image',
      gallery: {
        enabled: true
      },
      zoom: {
        enabled: true,
        duration: 300
      }
    });
  }

  if ($(window).width() > 769) {
    equalcol = $('.equal-col').outerHeight();
    $('.design-2-card').css('min-height', equalcol);
    getheight = $('.design-2-card').outerHeight();
    $('.equal-col').css('min-height', getheight);
  }

  if ($(window).width() < 769) {
    browsecat = $('.browse-cat').detach();
    $('.similar-business').after(browsecat);
    moveelement = $('.move-element').detach();
    $('.nav-info').before(moveelement);
    catlabel = $('.single-cate').detach();
    $('.singleV-title').before(catlabel);
    contactrow = $('.single-contact-section').detach();
    $('.card-body').append(contactrow);
    status = $('.contact__enquiry').detach();
    $('.card-body').append(status);
    $('.back-icon').click(function() {
      $('.fly-out').removeClass('active');
    });
    $('.send-enquiry').click(function() {
      $('.enquiry-form-slide').addClass('active');
    });
  }

  $('.similar-card').click(function() {
    var gethref;
    gethref = $(this).attr("data-href");
    window.location.href = gethref;
  });

  handleResponse = function(step, html) {
    $('#contact-modal .modal-body').html(html);
    if (step === 'get-details') {
      return $('#contact-modal #contact_number').intlTelInput({
        initialCountry: 'auto',
        separateDialCode: true,
        geoIpLookup: function(callback) {
          $.get('https://ipinfo.io', (function() {}), 'jsonp').always(function(resp) {
            var countryCode;
            countryCode = resp && resp.country ? resp.country : '';
            callback(countryCode);
          });
        },
        preferredCountries: ['IN'],
        americaMode: false,
        formatOnDisplay: false
      });
    }
  };

  $('body').on('click', '#contact-info', function() {
    $('#contact-modal').modal('show');
    return $.ajax({
      url: '/contact-request',
      type: 'post',
      data: {
        'id': document.getElementById('listing_id').value
      },
      success: function(data) {
        return handleResponse(data['step'], data['html']);
      }
    });
  });

  $('#contact-modal').on('click', '#cr-get-details-form-submit', function() {
    var description, email, mobile, name, region, url;
    if (!$('#contact-modal #get-crdetails-form').parsley().validate()) {
      return;
    }
    if ($('#get-crdetails-form').parsley().isValid()) {
      $('.contact-sub-spin').removeClass('hidden');
    }
    name = $('#contact-modal #get-crdetails-form #contact_name').val();
    email = $('#contact-modal #get-crdetails-form #contact_email').val();
    mobile = $('#contact-modal #get-crdetails-form #contact_number').val();
    region = $('#contact-modal #get-crdetails-form #contact_number').intlTelInput('getSelectedCountryData')['dialCode'];
    description = $('#contact-modal #get-crdetails-form #contact_description').val();
    url = $('#contact-modal #cr-details-form-submit-link').val();
    return $.ajax({
      url: url,
      type: 'post',
      data: {
        id: document.getElementById('listing_id').value,
        name: name,
        email: email,
        mobile: mobile,
        mobile_region: region,
        description: JSON.stringify(description)
      },
      success: function(data) {
        handleResponse(data['step'], data['html']);
        return $('.contact-sub-spin').addClass('hidden');
      }
    });
  });

  $('#contact-modal').on('click', '#edit-cr-number', function() {
    console.log('enters');
    $('#new-mobile-modal #new-mobile-verify-btn').prop('disabled', false);
    return $('#new-mobile-modal').modal('show');
  });

  $('#CR').on('click', '#new-mobile-verify-btn', function() {
    var country, force, number, url;
    $('#CR #new-mobile-modal input').attr('required', 'required');
    console.log($('#new-mobile-modal input').parsley().validate()[0]);
    if (!$('#new-mobile-modal input').parsley().validate(force = true)[0]) {
      $('#CR #new-mobile-modal input').removeAttr('required');
      $(this).prop('disabled', true);
      number = $('#new-mobile-modal input').val();
      country = $('#new-mobile-modal input').intlTelInput('getSelectedCountryData')['dialCode'];
      console.log(number, country);
      url = $('#contact-modal #cr-number-change-link').val();
      return $.ajax({
        url: url,
        type: 'post',
        data: {
          id: document.getElementById('listing_id').value,
          contact: number,
          contact_region: country
        },
        success: function(data) {
          handleResponse(data['step'], data['html']);
          $('#new-mobile-modal input').intlTelInput("setCountry", "in");
          $('#new-mobile-modal input').val('');
          return $('#new-mobile-modal').modal('hide');
        }
      });
    } else {
      $('#CR #new-mobile-modal input').removeAttr('required');
      return false;
    }
  });

  $('#contact-modal').on('click', '#cr-resend-sms', function() {
    var url;
    url = $('#contact-modal #cr-otp-resend-link').val();
    return $.ajax({
      url: url,
      type: 'post',
      data: {
        id: document.getElementById('listing_id').value
      },
      success: function(data) {
        return handleResponse(data['step'], data['html']);
      }
    });
  });

  $('#contact-modal').on('click', '#submit-cr-otp', function() {
    var url;
    if (!$('#contact-modal #input-cr-otp').parsley().validate()) {
      return;
    }
    url = $('#contact-modal #cr-otp-submit-link').val();
    return $.ajax({
      url: url,
      type: 'post',
      data: {
        id: document.getElementById('listing_id').value,
        otp: $('#contact-modal #input-cr-otp').val()
      },
      success: function(data) {
        return handleResponse(data['step'], data['html']);
      }
    });
  });

  $(".contact-modal").on('shown.bs.modal', function(e) {
    return setTimeout((function() {
      if ($('.entry-describe-best').length) {
        return $('.entry-describe-best').multiselect({
          includeSelectAllOption: true,
          numberDisplayed: 2,
          delimiterText: ',',
          nonSelectedText: 'Select description'
        });
      }
    }), 800);
  });

}).call(this);
