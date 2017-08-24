(function() {
  var id, input, parent, verify;

  parent = void 0;

  input = void 0;

  id = void 0;

  verify = function() {
    var get_val, id_val, type, valid, validator;
    $('.validationError').html('');
    if (id.val() === '') {
      id_val = null;
    } else {
      id_val = id.val();
    }
    validator = input.parsley();
    valid = validator.validate();
    if (valid === true && input.val() !== '') {
      get_val = input.val();
      if (parent.hasClass('business-email')) {
        $('#email-modal').modal('show');
        type = '1';
      }
      if (parent.hasClass('business-phone')) {
        $('#phone-modal').modal('show');
        type = '2';
      }
      $.ajax({
        type: 'post',
        url: '/create_OTP',
        data: {
          'value': get_val,
          'type': type,
          'id': id_val
        },
        success: function(data) {
          id.val(data['id']);
          input.val(data['value']);
          get_val = data['value'];
        },
        error: function(request, status, error) {
          throwError();
        },
        async: false
      });
      $('.verification-step-modal .number').text(get_val);
      $('.verify-steps').addClass('hidden');
      $('.default-state, .verificationFooter').removeClass('hidden');
    } else {
      $('#email-modal').modal('hide');
      $('#phone-modal').modal('hide');
    }
  };

  window.checkDuplicates = function() {
    var contacts, index, index1, others, value;
    contacts = document.getElementsByClassName('fnb-input');
    index = 0;
    while (index < contacts.length) {
      others = document.getElementsByClassName('fnb-input');
      value = contacts[index].value;
      if (value !== '') {
        index1 = 0;
        while (index1 < others.length) {
          if (value === others[index1].value && index !== index1) {
            $(others[index1]).closest('.get-val').find('.dupError').html('Same contact detail has been added multiple times.');
            return true;
          } else {
            $(others[index1]).closest('.get-val').find('.dupError').html('');
          }
          ++index1;
        }
      }
      ++index;
    }
  };

  $(document).on('blur', '.fnb-input', function() {
    checkDuplicates();
    $('#info-form').parsley();
  });

  $(document).on('click', '.verify-link', function(event) {
    event.preventDefault();
    parent = $(this).closest('.business-contact');
    input = $(this).closest('.get-val').find('.fnb-input');
    id = $(this).closest('.get-val').find('.comm-id');
    if (checkDuplicates()) {
      return false;
    }
    verify();
  });

  $('.edit-number').click(function(event) {
    event.preventDefault();
    $('.value-enter').val('');
    $('.default-state').addClass('hidden');
    $('.add-number').removeClass('hidden');
    $('.verificationFooter').addClass('no-bg');
  });

  $('.step-back').click(function(event) {
    event.preventDefault();
    $('.default-state').removeClass('hidden');
    $('.add-number').addClass('hidden');
    $('.verificationFooter').removeClass('no-bg');
  });

  $('.verify-stuff').click(function(event) {
    var get_value, inp, validator;
    event.preventDefault();
    inp = $(this).siblings('.value-enter');
    inp.attr('data-parsley-required', 'true');
    if (parent.hasClass('business-email')) {
      inp.attr('data-parsley-type', 'email');
    } else {
      inp.attr('data-parsley-type', 'digits');
      inp.attr('data-parsley-length', '[10,10]');
      inp.attr('data-parsley-length-message', 'Mobile number should be 10 digits');
    }
    validator = inp.parsley();
    if (validator.validate() !== true) {
      inp.removeAttr('data-parsley-required');
      inp.removeAttr('data-parsley-type');
      inp.removeAttr('data-parsley-length');
      inp.removeAttr('data-parsley-length-message');
      return false;
    }
    inp.removeAttr('data-parsley-required');
    inp.removeAttr('data-parsley-type');
    inp.removeAttr('data-parsley-length');
    inp.removeAttr('data-parsley-length-message');
    $('.default-state').removeClass('hidden');
    $('.add-number').addClass('hidden');
    $('.verificationFooter').removeClass('no-bg');
    get_value = $(this).siblings('.value-enter').val();
    $('.show-number .number').text(get_value);
    $(input).val(get_value);
    $(inp).val('');
    $('.validationError').html('');
    verify();
  });

  $('.code-send').click(function() {
    var OTP, errordiv, inp, validator;
    errordiv = $(this).closest('.number-code').find('.validationError');
    inp = $(this).closest('.code-submit').find('.fnb-input');
    inp.attr('data-parsley-required', 'true');
    inp.attr('data-parsley-type', 'digits');
    inp.attr('data-parsley-length', '[4,4]');
    validator = inp.parsley();
    if (validator.isValid() !== true) {
      if (inp.val() === '') {
        errordiv.html('Please enter OTP sent');
      } else {
        errordiv.html('Sorry! The entered OTP is invalid. Please try again.');
      }
      inp.val('');
      inp.removeAttr('data-parsley-required');
      inp.removeAttr('data-parsley-type');
      inp.removeAttr('data-parsley-length');
      return false;
    }
    inp.removeAttr('data-parsley-required');
    inp.removeAttr('data-parsley-type');
    inp.removeAttr('data-parsley-length');
    OTP = inp.val();
    $('.default-state').addClass('hidden');
    $('.processing').removeClass('hidden');
    $.ajax({
      type: 'post',
      url: '/validate_OTP',
      data: {
        'OTP': OTP,
        'id': id.val()
      },
      success: function(data) {
        if (data['success'] === "1") {
          errordiv.html('');
          $('.default-state,.add-number,.verificationFooter').addClass('hidden');
          $('.processing').addClass('hidden');
          $('.step-success').removeClass('hidden');
          $(input).closest('.get-val').find('.verified').html('<span class="fnb-icons verified-icon"></span><p class="c-title">Verified</p>');
          $(input).attr('readonly', true);
        } else {
          $('.processing').addClass('hidden');
          $('.default-state').removeClass('hidden');
          inp.val('');
          errordiv.html('Sorry! The entered OTP is invalid. Please try again.');
        }
      },
      error: function(request, status, error) {
        $('.processing').addClass('hidden');
        $('.default-state').removeClass('hidden');
        inp.val('');
        errordiv.html('Sorry! The entered OTP is invalid. Please try again.');
      },
      async: false
    });
  });

  $('.verification-step-modal').on('hidden.bs.modal', function(e) {
    $('.step-success,.add-number').addClass('hidden');
    $('.verificationFooter').removeClass('no-bg');
    $('.default-state,.verificationFooter').removeClass('hidden');
    $('.default-state .fnb-input').val('');
  });

  $('.resend-link').click(function(event) {
    event.preventDefault();
    $(this).addClass('sending');
    setTimeout((function() {
      $('.resend-link').removeClass('sending');
    }), 2500);
  });

  $('body').on('click', '.removeRow', function() {
    return $(this).closest('.get-val').parent().remove();
  });

  $(document).on('change', '.business-contact .toggle__check', function() {
    if ($(this).is(':checked')) {
      $(this).closest('.toggle').siblings('.toggle-state').text('Visible on the listing');
    } else {
      $(this).closest('.toggle').siblings('.toggle-state').text('Not visible on the listing');
    }
  });

  $(document).on('change', '.city select', function() {
    var city;
    city = $(this).val();
    return $.ajax({
      type: 'post',
      url: '/get_areas',
      data: {
        'city': city
      },
      success: function(data) {
        var html, key;
        html = '<option value="" selected>Select Area </option>';
        for (key in data) {
          html += '<option value="' + key + '">' + data[key] + '</option>';
        }
        $('.area select').html(html);
      },
      error: function(request, status, error) {
        throwError();
      }
    });
  });

  $('body').on('click', '.add-another', function(e) {
    var contact_group, contact_group_clone;
    e.preventDefault();
    contact_group = $(this).closest('.business-contact').find('.contact-group');
    contact_group_clone = contact_group.clone();
    contact_group_clone.removeClass('contact-group hidden');
    input = contact_group_clone.find('.fnb-input');
    input.attr('data-parsley-required', true);
    return contact_group_clone.insertBefore(contact_group);
  });

}).call(this);
