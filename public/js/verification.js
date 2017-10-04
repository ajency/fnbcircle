(function() {
  $(document).ready(function() {
    var checkDuplicateEntries, verifyContactDetail;
    $('.contact-info').on('click', '.add-another', function(e) {
      var contact_group, contact_group_clone, input;
      e.preventDefault();
      contact_group = $(this).closest('.business-contact').find('.contact-group');
      contact_group_clone = contact_group.clone();
      contact_group_clone.removeClass('contact-group hidden');
      input = contact_group_clone.find('.fnb-input');
      contact_group_clone.insertBefore(contact_group);
      return contact_group.prev().find('.contact-mobile-input').intlTelInput({
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
    });
    $('.contact-info').on('countrychange', '.contact-mobile-input', function(e, countryData) {
      if ($(this).closest('.modal').length) {
        $('.under-review').find('.contact-country-code').val(countryData.dialCode);
        $('.under-review').find('.contact-mobile-input').intlTelInput("setNumber", "+" + countryData.dialCode);
        $('.under-review').find('.contact-mobile-input').val('');
      } else {
        $(this).closest('.contact-container').find('.contact-country-code').val(countryData.dialCode);
      }
    });
    $('.contact-mobile-number').each(function() {
      var country, countryCode, mobileNo;
      mobileNo = $(this).val();
      country = $(this).attr('data-intl-country');
      $(this).intlTelInput({
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
      countryCode = $(this).closest('.contact-container').find('.contact-country-code').val();
      return $(this).closest('.contact-container').find('.contact-mobile-input').intlTelInput("setNumber", "+" + countryCode).val(mobileNo);
    });
    $('.contact-info').on('click', '.delete-contact', function(event) {
      var contactId, deleteObj;
      deleteObj = $(this);
      contactId = deleteObj.closest('.contact-container').find('.contact-id').val();
      if (deleteObj.closest('.contact-info').find('.contact-container').length === 2) {
        deleteObj.closest('.contact-info').find('.add-another').click();
      }
      if (contactId === '') {
        return deleteObj.closest('.get-val').parent().remove();
      } else {
        deleteObj.closest('.contact-container').find('.contact-input').val('');
        deleteObj.closest('.contact-container').addClass('hidden');
        return deleteObj.closest('.contact-container').removeClass('contact-container');
      }
    });
    $('.contact-info').on('click', '.contact-verify-link', function(event) {
      $('.contact-container').removeClass('under-review');
      $(this).closest('.contact-container').addClass('under-review');
      return verifyContactDetail(true);
    });
    verifyContactDetail = function(showModal) {
      var contactId, contactType, contactValue, contactValueObj, countryCode, isVisible, objectId, objectType, underreviewDialCode;
      contactValueObj = $('.under-review').find('.contact-input');
      contactValue = contactValueObj.val();
      contactType = $('.under-review').closest('.contact-info').attr('contact-type');
      contactId = $('.under-review').find('.contact-id').val();
      countryCode = $('.under-review').find('.contact-country-code').val();
      objectType = $('input[name="object_type"]').val();
      objectId = $('input[name="object_id"]').val();
      isVisible = $('.under-review').find('.contact-visible').val();
      contactValueObj.closest('.contact-container').find('.dupError').html('');
      $('.validationError').html('');
      $('.otp-input').val('');
      if (!contactValueObj.parsley().isValid()) {
        contactValueObj.parsley().validate();
      }
      if (contactValue !== '' && contactValueObj.parsley().isValid()) {
        if (showModal) {
          underreviewDialCode = $('.under-review').find('.contact-country-code').val();
          $('#' + contactType + '-modal').find('.change-contact-input').intlTelInput("setNumber", "+" + underreviewDialCode);
          $('#' + contactType + '-modal').modal('show');
        }
        $.ajax({
          type: 'post',
          url: '/user/verify-contact-details',
          data: {
            'id': contactId,
            'contact_value': contactValue,
            'contact_type': contactType,
            'object_id': objectId,
            'object_type': objectType,
            'is_visible': isVisible
          },
          success: function(data) {
            $('.under-review').find('.contact-id').val(data['id']);
          },
          error: function(request, status, error) {
            throw Error(error);
          },
          async: false
        });
        if (contactType === 'mobile') {
          $('.verification-step-modal .number').text('+' + countryCode + contactValue);
        } else {
          $('.verification-step-modal .number').text(contactValue);
        }
        $('.contact-verify-steps').addClass('hidden');
        return $('.default-state, .verificationFooter').removeClass('hidden');
      } else {
        if (contactValue === '') {
          contactValueObj.closest('.contact-container').find('.dupError').html('Please enter ' + contactType);
        }
        return $('#' + contactType + '-modal').modal('hide');
      }
    };
    $('.contact-info').on('change', '.contact-input', function(event) {
      var contactObj, contactval;
      contactObj = $(this);
      contactval = contactObj.val();
      if (!checkDuplicateEntries(contactObj) && contactval !== "") {
        contactObj.closest('.contact-container').find('.dupError').html('Same contact detail has been added multiple times.');
        contactObj.val('');
      } else {
        contactObj.closest('.contact-container').find('.dupError').html('');
      }
    });
    checkDuplicateEntries = function(contactObj) {
      var contactval, result;
      contactval = contactObj.val();
      contactObj.closest('form').parsley().validate();
      result = true;
      contactObj.closest('.contact-info').find('.contact-input').each(function() {
        if (contactObj.get(0) !== $(this).get(0) && $(this).val() === contactval) {
          result = false;
          return false;
        }
      });
      return result;
    };
    $('.contact-verification-modal').on('click', '.edit-number', function(e) {
      $('.value-enter').val('');
      $('.contact-verify-steps').find('.customError').html('');
      $(this).closest('.number-code').find('.validationError').html('');
      $('.default-state').addClass('hidden');
      $('.add-number').removeClass('hidden');
      $('.verificationFooter').addClass('no-bg');
    });
    $('.contact-verification-modal').on('click', '.step-back', function(e) {
      $('.default-state').removeClass('hidden');
      $('.add-number').addClass('hidden');
      $('.verificationFooter').removeClass('no-bg');
    });
    $('.contact-verification-modal').on('click', '.contact-verify-stuff', function(e) {
      var changedCountryCodeObj, changedValue, contactType, newContactObj, oldContactObj, oldContactValue;
      newContactObj = $(this).closest('.modal').find('.change-contact-input');
      contactType = $(this).closest('.modal').attr('modal-type');
      changedValue = newContactObj.val();
      oldContactValue = $(this).closest('.modal').find('.contact-input-value').text().trim();
      if (newContactObj.val() !== '' && newContactObj.parsley().validate() === true) {
        oldContactObj = $('.under-review').find('.contact-input');
        oldContactObj.val(changedValue);
        changedCountryCodeObj = newContactObj.intlTelInput("getSelectedCountryData");
        if (!checkDuplicateEntries(oldContactObj)) {
          oldContactObj.val(oldContactValue);
          return $(this).closest('.contact-verify-steps').find('.customError').text('Same contact detail has been added multiple times.');
        } else {
          $(this).closest('.contact-verify-steps').find('.customError').text('');
          $(this).closest('.modal').find('.contact-input-value').text(changedValue);
          $('.under-review').find('.contact-country-code').val(changedCountryCodeObj.dialCode);
          $('.under-review').find('.contact-mobile-input').intlTelInput("setNumber", "+" + changedCountryCodeObj.dialCode).val('');
          $('.under-review').find('.contact-mobile-input').val(changedValue);
          $('.default-state').removeClass('hidden');
          $('.add-number').addClass('hidden');
          $('.verificationFooter').removeClass('no-bg');
          return verifyContactDetail(false);
        }
      } else {
        if (newContactObj.val() === '') {
          return $(this).closest('.contact-verify-steps').find('.customError').text('Please enter ' + contactType);
        } else {
          return $(this).closest('.contact-verify-steps').find('.customError').text('Please enter valid ' + contactType);
        }
      }
    });
    $('.contact-verification-modal').on('click', '.code-send', function(e) {
      var contactId, errordiv, otpObj, otpObjType, otpValue, validator;
      errordiv = $(this).closest('.number-code').find('.validationError');
      otpObj = $(this).closest('.code-submit').find('.fnb-input');
      otpObjType = $(this).closest('.modal').attr('modal-type');
      otpObj.attr('data-parsley-required', 'true');
      otpObj.attr('data-parsley-type', 'digits');
      otpObj.attr('data-parsley-length', '[4,4]');
      errordiv.html('');
      validator = otpObj.parsley();
      if (validator.isValid() !== true) {
        if (otpObj.val() === '') {
          if (otpObjType === 'email') {
            errordiv.html('Please enter the OTP sent via email');
          } else {
            errordiv.html('Please enter the OTP sent via sms');
          }
        } else {
          errordiv.html('Sorry! The entered OTP is invalid. Please try again.');
        }
        otpObj.val('');
        otpObj.removeAttr('data-parsley-required');
        otpObj.removeAttr('data-parsley-type');
        otpObj.removeAttr('data-parsley-length');
        return false;
      }
      otpObj.removeAttr('data-parsley-required');
      otpObj.removeAttr('data-parsley-type');
      otpObj.removeAttr('data-parsley-length');
      otpValue = otpObj.val();
      contactId = $('.under-review').find('.contact-id').val();
      $('.default-state').addClass('hidden');
      $('.processing').removeClass('hidden');
      $.ajax({
        type: 'post',
        url: '/user/verify-contact-otp',
        data: {
          'otp': otpValue,
          'id': contactId
        },
        success: function(data) {
          $('.success-spinner').removeClass('hidden');
          if (data['success'] === "1") {
            errordiv.html('');
            $('.default-state,.add-number,.verificationFooter').addClass('hidden');
            $('.processing').addClass('hidden');
            $('.step-success').removeClass('hidden');
            $('.under-review').find('.verified').html('<span class="fnb-icons verified-icon ver-icon"></span><p class="c-title">Verified</p>');
            $('.under-review').find('.contact-input').attr('readonly', true);
          } else {
            $('.processing').addClass('hidden');
            $('.default-state').removeClass('hidden');
            otpObj.val('');
            errordiv.html('Sorry! The entered OTP is invalid. Please try again.');
          }
        },
        error: function(request, status, error) {
          $('.success-spinner').addClass('hidden');
          $('.processing').addClass('hidden');
          $('.default-state').removeClass('hidden');
          otpObj.val('');
          errordiv.html('Sorry! The entered OTP is invalid. Please try again.');
        },
        async: false
      });
    });
    $('.contact-verification-modal .verification-step-modal').on('hidden.bs.modal', function(e) {
      $('.step-success,.add-number').addClass('hidden');
      $('.verificationFooter').removeClass('no-bg');
      $('.default-state,.verificationFooter').removeClass('hidden');
      $('.default-state .fnb-input').val('');
    });
    $('.contact-verification-modal').on('click', '.resend-link', function(e) {
      $(this).addClass('sending');
      setTimeout((function() {
        $('.resend-link').removeClass('sending');
      }), 2500);
    });
    return $(".contact-info").on('change', '.toggle__check', function() {
      if ($(this).is(':checked')) {
        $(this).closest('.toggle').siblings('.toggle-state').text('Visible on the listing');
        $(this).closest('.toggle').find('.contact-visible').val(1);
      } else {
        $(this).closest('.toggle').siblings('.toggle-state').text('Not visible on the listing');
        $(this).closest('.toggle').find('.contact-visible').val(0);
      }
    });
  });

}).call(this);
