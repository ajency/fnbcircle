(function() {
  var listingInformation, userCheck;

  userCheck = function() {
    var email;
    if ($('#user-type').val() === 'external' || document.getElementsByName('primary_email_txt')[0].value === "") {
      listingInformation();
      return;
    }
    email = document.getElementsByName('primary_email_txt')[0].value;
    $.ajax({
      type: 'post',
      url: document.head.querySelector('[property="check-user-exist"]').content,
      data: {
        'email': document.getElementsByName('primary_email_txt')[0].value
      },
      success: function(data) {
        var check, text;
        $('.section-loader').addClass('hidden');
        if (data['result']) {
          text = 'Email id "' + email + '" already exists with account status “' + data['user']['status'].charAt(0).toUpperCase() + data['user']['status'].slice(1) + '” , Created on ' + data['user']['created_at'].slice(0, 10);
        } else {
          text = 'Email id does not exist. New Account will be created';
        }
        check = email;
        $('#user-exist-text').html(text);
        $('#status-address').html(check);
        $('#user-exist-confirmation').modal('show');
        return $('#user-exist-confirmation').on('click', '#save-listing', function(e) {
          var sendmail;
          event.preventDefault();
          $('.section-loader').removeClass('hidden');
          sendmail = $('#send-email-checkbox').prop('checked');
          listingInformation(sendmail);
        });
      }
    });
  };

  listingInformation = function(sendmail) {
    var contact, contacts, form, i, id, parameters, phone, type, user, value;
    if (sendmail == null) {
      sendmail = false;
    }
    form = $('<form></form>');
    form.attr('method', 'post');
    form.attr('action', '/listing');
    contacts = {};
    value = document.getElementsByClassName('contact-input');
    i = 0;
    while (i < value.length) {
      if (value[i].value !== '') {
        contact = {};
        id = "";
        if ($(value[i]).closest('.business-contact').hasClass('business-email')) {
          type = 1;
        }
        if ($(value[i]).closest('.business-contact').hasClass('business-phone')) {
          type = 2;
        }
        if ($(value[i]).closest('.business-contact').hasClass('contact-info-landline')) {
          type = 3;
        }
        id = $(value[i]).closest('.contact-container').find('.contact-id').val();
        console.log(value[i].value, '=>', id);
        $.ajax({
          type: 'post',
          url: '/contact_save',
          data: {
            'value': value[i].value,
            'country': $(value[i]).intlTelInput('getSelectedCountryData')['dialCode'],
            'type': type,
            'id': id
          },
          success: function(data) {
            $(value[i]).closest('.contact-container').find('.contact-id').val(data['id']);
            id = data['id'];
          },
          failure: function() {
            $('.fnb-alert.alert-failure div.flex-row').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>Oh snap! Some error occurred. Please <a href="/login">login</a> or refresh your page');
            $('.alert-failure').addClass('active');
          },
          async: false
        });
        contact['id'] = id;
        contact['country'] = $(value[i]).intlTelInput('getSelectedCountryData')['dialCode'];
        contact['visible'] = $(value[i]).closest('.contact-container').find('.toggle__check').prop('checked') ? '1' : '0';
        contact['value'] = $(value[i]).val();
        contacts[i] = contact;
        console.log(contact);
      }
      i++;
    }
    parameters = {};
    parameters['listing_id'] = document.getElementById('listing_id').value;
    parameters['step'] = 'business-information';
    parameters['change'] = change;
    parameters['title'] = document.getElementsByName('listing_title')[0].value;
    type = document.getElementsByName('business_type');
    i = 0;
    while (i < type.length) {
      if (type[i].checked) {
        parameters['type'] = type[i].value;
      }
      i++;
    }
    user = {};
    user['email'] = document.getElementsByName('primary_email_txt')[0].value;
    phone = document.getElementsByName('primary_phone_txt')[0];
    user['locality'] = $(phone).intlTelInput('getSelectedCountryData')['dialCode'];
    user['phone'] = phone.value;
    user['sendmail'] = sendmail;
    parameters['user'] = JSON.stringify(user);
    parameters['primary_email'] = document.getElementsByName('primary_email')[0].checked ? '1' : '0';
    parameters['primary_phone'] = document.getElementsByName('primary_phone')[0].checked ? '1' : '0';
    parameters['area'] = $('.area select').val();
    parameters['contacts'] = JSON.stringify(contacts);
    if (submit === 1) {
      parameters['submitReview'] = 'yes';
    }
    if (archive === 1) {
      parameters['archive'] = 'yes';
    }
    if (publish === 1) {
      parameters['publish'] = 'yes';
    }
    $.each(parameters, function(key, value) {
      var field;
      field = $('<input></input>');
      field.attr('type', 'hidden');
      field.attr('name', key);
      field.attr('value', value);
      form.append(field);
      console.log(key + '=>' + value);
    });
    $(document.body).append(form);
    form.submit();
  };

  window.validateListing = function(event) {
    var cont, i, instance, json, title, type, value;
    instance = $('#info-form').parsley();
    console.log(true);
    if (!instance.validate()) {
      return false;
    }
    $('.section-loader').removeClass('hidden');
    if ($('#listing_id').val() === '') {
      title = document.getElementsByName('listing_title')[0].value;
      value = document.getElementsByClassName('contact-input');
      cont = [];
      i = 0;
      while (i < value.length) {
        type = void 0;
        if (value[i].value === '') {
          i++;
          continue;
        }
        if ($(value[i]).closest('.business-contact').hasClass('business-email')) {
          type = 'email';
        }
        if ($(value[i]).closest('.business-contact').hasClass('business-phone')) {
          type = 'mobile';
        }
        if ($(value[i]).closest('.business-contact').hasClass('contact-info-landline')) {
          type = 'landline';
        }
        cont.push({
          'value': value[i].value,
          'country': $(value[i]).intlTelInput('getSelectedCountryData')['dialCode'],
          'type': type
        });
        i++;
      }
      if ($('input[name="primary_email_txt"]').val() !== "") {
        cont.push({
          'value': $('input[name="primary_email_txt"]').val(),
          'type': "email"
        });
      }
      if ($('input[name="primary_phone_txt"]').val() !== "") {
        cont.push({
          'value': $('input[name="primary_phone_txt"]').val(),
          'country': $('input[name="primary_phone_txt"]').intlTelInput('getSelectedCountryData')['dialCode'],
          'type': "mobile"
        });
      }
      json = JSON.stringify(cont);
      $.ajax({
        type: 'post',
        url: '/duplicates',
        data: {
          'title': title,
          'contacts': json
        },
        success: function(data) {
          var j, k, myvar;
          console.log(data);
          myvar = '';
          for (k in data['similar']) {
            myvar += '<div class="list-row flex-row">' + '<div class="left">' + '<h5 class="sub-title text-medium text-capitalise list-title">' + data['similar'][k]['name'] + '</h5>';
            for (j in data['similar'][k]['messages']) {
              myvar += '<p class="m-b-0 text-color text-left default-size">' + '<i class="fa fa-exclamation-circle p-r-5 text-primary" aria-hidden="true"></i> <span class="lighter">' + data['similar'][k]['messages'][j] + '</span>' + '</p>';
            }
            myvar += '</div>' + '<div class="right">';
            if (data['type'] === 'external') {
              myvar += '<div class="capsule-btn flex-row">' + '<a href="claim/" class="btn fnb-btn outline full border-btn no-border claim text-danger">Claim</a>' + '<a href="claim/" class="btn fnb-btn outline full border-btn no-border delete">Delete</a>' + '</div>';
            }
            myvar += '</div>' + '</div>';
          }
          $('.list-entries').html(myvar);
          if (myvar !== '') {
            $('.section-loader').addClass('hidden');
            $('#duplicate-listing').modal('show');
            $('#duplicate-listing').on('click', '#skip-duplicates', function(e) {
              event.preventDefault();
              $('.section-loader').removeClass('hidden');
              userCheck();
            });
          } else {
            event.preventDefault();
            $('.section-loader').removeClass('hidden');
            userCheck();
          }
        },
        error: function(request, status, error) {
          $('.fnb-alert.alert-failure div.flex-row').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i><div>Oh snap! Some error occurred. Please <a href="/login" class="secondary-link">login</a> or refresh your page</div>');
          $('.alert-failure').addClass('active');
        }
      });
    } else {
      event.preventDefault();
      userCheck();
    }
    event.preventDefault();
  };

  $('.contact-info').on('change', '.contact-input', function(event) {
    var contacts, email, index, phone, value;
    contacts = document.getElementsByClassName('contact-input');
    email = $('input[name="primary_email_txt"]').val();
    phone = $('input[name="primary_phone_txt"]').val();
    index = 0;
    while (index < contacts.length) {
      value = contacts[index].value;
      if (value === email || value === phone) {
        $(this).closest('.contact-container').find('.dupError').html('Same contact detail has been added multiple times.');
        contacts[index].value = "";
      }
      ++index;
    }
  });

  $(document).on('blur', '.fnb-input', function() {
    $('#info-form').parsley();
  });

  $('.user-details-container').on('keyup', 'input[name="user-email"]', function(event) {
    return $('input[name="primary_email_txt"]').val(this.value);
  });

  $('.user-details-container').on('keyup', 'input[name="user-phone"]', function(event) {
    return $('input[name="primary_phone_txt"]').val(this.value);
  });

  $('.user-details-container input[name="user-phone"]').on('countrychange', function(e, countryData) {
    $('input[name="primary_phone_txt"]').intlTelInput("setCountry", countryData.iso2);
  });

  $('.contact-info').on('change', 'input.toggle__check', function(event) {
    console.log($(this).closest('.contact-container').find('.contact-input').val());
    if (this.checked) {
      if ($(this).closest('.contact-container').find('.contact-input').val() === '') {
        return $(this).prop('checked', false);
      }
    }
  });

  $('body').on('click', '.removeRow', function() {
    return $(this).closest('.get-val').parent().remove();
  });

  $(document).on('click', '.business-type .radio', function() {
    if ($(this).is(':checked')) {
      $(this).parent().addClass('active');
      $(this).parent().siblings().removeClass('active');
    }
  });

  $(document).on('change', '.business-contact .toggle__check', function() {
    if ($(this).is(':checked')) {
      $(this).closest('.toggle').siblings('.toggle-state').text('Visible ');
    } else {
      $(this).closest('.toggle').siblings('.toggle-state').text('Not visible ');
    }
  });

  $(document).on('change', '.city select', function() {
    var city, html;
    html = '<option value="" selected>Select City </option>';
    $('.area select').html(html);
    city = $(this).val();
    if (city === '') {
      return;
    }
    return $.ajax({
      type: 'post',
      url: '/get_areas',
      data: {
        'city': city
      },
      success: function(data) {
        var key;
        for (key in data) {
          html += '<option value="' + data[key]['id'] + '">' + data[key]['name'] + '</option>';
        }
        $('.area select').html(html);
      },
      error: function(request, status, error) {
        throwError();
      }
    });
  });

}).call(this);
