$(document).ready ()->
  #$('body').on 'click', '.add-another', (e)->
  $('.contact-info').on 'click', '.add-another', (e)->
    e.preventDefault()
    contact_group = $(this).closest('.business-contact').find('.contact-group')
    contact_group_clone = contact_group.clone()
    contact_group_clone.removeClass 'contact-group hidden'
    input = contact_group_clone.find('.fnb-input')
    # input.attr('data-parsley-required',true)
    contact_group_clone.insertBefore(contact_group)
     
    contact_group.prev().find('.contact-mobile-input').intlTelInput
      initialCountry: 'auto'
      separateDialCode: true
      geoIpLookup: (callback) ->
        $.get('https://ipinfo.io', (->
        ), 'jsonp').always (resp) ->
          countryCode = if resp and resp.country then resp.country else ''
          callback countryCode
          return
        return
      preferredCountries: [ 'IN' ]
      americaMode: false
      formatOnDisplay:false


  $('.contact-info').on 'countrychange', '.contact-mobile-input', (e, countryData)->
     
    if $(this).closest('.modal').length
      $('.under-review').find('.contact-country-code').val countryData.dialCode
      $('.under-review').find('.contact-mobile-input').intlTelInput("setNumber", "+"+countryData.dialCode)
      $('.under-review').find('.contact-mobile-input').val ''
    else
 
      $(this).closest('.contact-container').find('.contact-country-code').val countryData.dialCode
    return

  $('.contact-mobile-number').each ()->
    mobileNo  = $(this).val()
    country = $(this).attr('data-intl-country')
    $(this).intlTelInput
      # initialCountry: country
      separateDialCode: true
      geoIpLookup: (callback) ->
        $.get('https://ipinfo.io', (->
        ), 'jsonp').always (resp) ->
          countryCode = if resp and resp.country then resp.country else ''
          callback countryCode
          return
        return
      preferredCountries: [ 'IN' ]
      americaMode: false
      formatOnDisplay:false

    countryCode = $(this).closest('.contact-container').find('.contact-country-code').val()
    $(this).closest('.contact-container').find('.contact-mobile-input').intlTelInput("setNumber", "+"+countryCode).val mobileNo


  # $('body').on 'click', '.removeRow', ->
  #   if $(this).closest('.contact-info').find('.contact-container').length == 2
  #     $(this).closest('.contact-info').find('.add-another').click()

  #   $(this).closest('.get-val').parent().remove()

  $('.contact-info').on 'click', '.delete-contact', (event) ->
    deleteObj = $(this)
    contactId = deleteObj.closest('.contact-container').find('.contact-id').val()
    
    # console.log contactId
    # if contactId!= ""
    #   $.ajax
    #     type: 'post'
    #     url: '/user/delete-contact-details'
    #     data:
    #       'id': contactId
    #     success: (data) ->
           
    #       return
    #     error: (request, status, error) ->
    #       throwError()
    #       return
    #     async: false     
     
    if deleteObj.closest('.contact-info').find('.contact-container').length == 2
      deleteObj.closest('.contact-info').find('.add-another').click()

    if contactId == ''
      deleteObj.closest('.get-val').parent().remove()
    else
      deleteObj.closest('.contact-container').find('.contact-input').val('')
      deleteObj.closest('.contact-container').addClass 'hidden'
      deleteObj.closest('.contact-container').removeClass 'contact-container'


  $('.contact-info').on 'click', '.contact-verify-link', (event) ->
    $('.contact-container').removeClass('under-review')
    $(this).closest('.contact-container').addClass('under-review')
    verifyContactDetail(true)


  verifyContactDetail = (showModal) ->
    contactValueObj = $('.under-review').find('.contact-input')
    contactValue = contactValueObj.val()
    contactType = $('.under-review').closest('.contact-info').attr('contact-type')
    contactId = $('.under-review').find('.contact-id').val()
    countryCode = $('.under-review').find('.contact-country-code').val()
    objectType = $('input[name="object_type"]').val()
    objectId = $('input[name="object_id"]').val()
    isVisible = $('.under-review').find('.contact-visible').val()
    contactValueObj.closest('.contact-container').find('.dupError').html ''
    $('.validationError').html ''
    $('.otp-input').val ''

    if(!contactValueObj.parsley().isValid())
      contactValueObj.parsley().validate()
      
    # console.log contactValueObj.parsley().isValid()
    # console.log contactValue
    if contactValue != '' && contactValueObj.parsley().isValid()
      
      if(showModal)
        underreviewDialCode = $('.under-review').find('.contact-country-code').val()
        $('#'+contactType+'-modal').find('.change-contact-input').intlTelInput("setNumber", "+"+underreviewDialCode)
        $('#'+contactType+'-modal').modal 'show'

        
    
      $.ajax
        type: 'post'
        url: '/user/verify-contact-details'
        data:
          'id': contactId
          'contact_value': contactValue
          'contact_type': contactType
          'object_id': objectId
          'object_type': objectType
          'is_visible': isVisible
        success: (data) ->
          $('.under-review').find('.contact-id').val(data['id']) 
          return
        error: (request, status, error) ->
          throw Error(error)
          return
        async: false

      if contactType == 'mobile'
          $('.verification-step-modal .number').text '+'+countryCode+contactValue
        else
          $('.verification-step-modal .number').text contactValue
   
      $('.contact-verify-steps').addClass 'hidden'
      $('.default-state, .verificationFooter').removeClass 'hidden'

    else
      if contactValue == ''
        contactValueObj.closest('.contact-container').find('.dupError').html 'Please enter '+contactType 
      $('#'+contactType+'-modal').modal 'hide'

  $('.contact-info').on 'change', '.contact-input', (event) ->
    contactObj = $(this)
    contactval = contactObj.val()
    # console.log contactval
    if !checkDuplicateEntries(contactObj) && contactval!= ""
      # contactObj.closest('.contact-container').find('.dupError').html contactval+' already added to list.'
      contactObj.closest('.contact-container').find('.dupError').html 'Same contact detail has been added multiple times.'
      contactObj.val ''
    else 
      contactObj.closest('.contact-container').find('.dupError').html ''

    return

  checkDuplicateEntries = (contactObj) ->
    contactval = contactObj.val()

    contactObj.closest('form').parsley().validate()
    result = true
    contactObj.closest('.contact-info').find('.contact-input').each ->

      if contactObj.get(0) != $(this).get(0) and $(this).val() == contactval
        result = false
        return false

    return result 


  $('.contact-verification-modal').on 'click', '.edit-number', (e)->
    $('.value-enter').val('')
    $('.contact-verify-steps').find('.customError').html ''
    $(this).closest('.number-code').find('.validationError').html ''
    $('.default-state').addClass 'hidden'
    $('.add-number').removeClass 'hidden'
    $('.verificationFooter').addClass 'no-bg'
    return


  $('.contact-verification-modal').on 'click', '.step-back', (e)->
    $('.default-state').removeClass 'hidden'
    $('.add-number').addClass 'hidden'
    $('.verificationFooter').removeClass 'no-bg'
    return


  $('.contact-verification-modal').on 'click', '.contact-verify-stuff', (e)->
    newContactObj = $(this).closest('.modal').find('.change-contact-input')
    contactType = $(this).closest('.modal').attr('modal-type')
    changedValue = newContactObj.val()
    oldContactValue = $(this).closest('.modal').find('.contact-input-value').text().trim()

    if newContactObj.val() != '' && newContactObj.parsley().validate() == true
      # upadte parent conatiner input

      oldContactObj = $('.under-review').find('.contact-input')
      oldContactObj.val changedValue
      changedCountryCodeObj = newContactObj.intlTelInput("getSelectedCountryData");

      
      if !checkDuplicateEntries(oldContactObj)
   
        oldContactObj.val oldContactValue
        $(this).closest('.contact-verify-steps').find('.customError').text 'Same contact detail has been added multiple times.'
      else 
        $(this).closest('.contact-verify-steps').find('.customError').text ''
        $(this).closest('.modal').find('.contact-input-value').text(changedValue)

        $('.under-review').find('.contact-country-code').val changedCountryCodeObj.dialCode
        $('.under-review').find('.contact-mobile-input').intlTelInput("setNumber", "+"+changedCountryCodeObj.dialCode).val '' 
        $('.under-review').find('.contact-mobile-input').val changedValue 

        $('.default-state').removeClass 'hidden'
        $('.add-number').addClass 'hidden'
        $('.verificationFooter').removeClass 'no-bg'
        verifyContactDetail(false)
    else
      if(newContactObj.val() == '')
        $(this).closest('.contact-verify-steps').find('.customError').text 'Please enter '+contactType
      else
        $(this).closest('.contact-verify-steps').find('.customError').text 'Please enter valid '+contactType

    


  $('.contact-verification-modal').on 'click', '.code-send', (e)->
    # $('.processing').removeClass 'hidden'
    errordiv=$(this).closest('.number-code').find('.validationError')
    otpObj=$(this).closest('.code-submit').find('.fnb-input')
    otpObjType=$(this).closest('.modal').attr('modal-type')
    otpObj.attr('data-parsley-required','true')
    otpObj.attr('data-parsley-type','digits')
    otpObj.attr('data-parsley-length','[4,4]')
    errordiv.html ''
    validator=otpObj.parsley()
    if validator.isValid() != true
      # console.log 'gandu'
      if otpObj.val()==''
        if otpObjType == 'email'
          errordiv.html 'Please enter the OTP sent via email'
        else
          errordiv.html 'Please enter the OTP sent via sms'
      else
        errordiv.html('Sorry! The entered OTP is invalid. Please try again.');
      otpObj.val('')
      otpObj.removeAttr('data-parsley-required')
      otpObj.removeAttr('data-parsley-type')
      otpObj.removeAttr('data-parsley-length')
      return false
    otpObj.removeAttr('data-parsley-required')
    otpObj.removeAttr('data-parsley-type')
    otpObj.removeAttr('data-parsley-length')
    otpValue = otpObj.val()
    contactId = $('.under-review').find('.contact-id').val()
    $('.default-state').addClass('hidden')
    $('.processing').removeClass('hidden')
    $.ajax
      type: 'post'
      url: '/user/verify-contact-otp'
      data:
        'otp': otpValue
        'id': contactId
      success: (data) ->
        # console.log data
        $('.success-spinner').removeClass 'hidden'
        if data['success'] == "1"
          errordiv.html('');
          $('.default-state,.add-number,.verificationFooter').addClass 'hidden'
          $('.processing').addClass 'hidden'
          $('.step-success').removeClass 'hidden'
          $('.under-review').find('.verified').html '<span class="fnb-icons verified-icon"></span><p class="c-title">Verified</p>'
          $('.under-review').find('.contact-input').attr('readonly',true)
        else
          $('.processing').addClass('hidden')
          $('.default-state').removeClass('hidden')
          otpObj.val('')
          errordiv.html('Sorry! The entered OTP is invalid. Please try again.');
        return
      error: (request, status, error) ->
        $('.success-spinner').addClass 'hidden'
        $('.processing').addClass('hidden')
        $('.default-state').removeClass('hidden')
        otpObj.val('')
        errordiv.html('Sorry! The entered OTP is invalid. Please try again.');
        return
      async: false
    return

  $('.contact-verification-modal .verification-step-modal').on 'hidden.bs.modal', (e) ->
    $('.step-success,.add-number').addClass 'hidden'
    $('.verificationFooter').removeClass 'no-bg'
    $('.default-state,.verificationFooter').removeClass 'hidden'
    $('.default-state .fnb-input').val ''
    return

 
  $('.contact-verification-modal').on 'click', '.resend-link', (e)->
    $(this).addClass 'sending'
    setTimeout (->
      $('.resend-link').removeClass 'sending'
      return
    ), 2500
    return


  #$(document).on 'change', '.business-contact .toggle__check', ->
  $(".contact-info").on 'change', '.toggle__check', ->
  # $('.business-contact .toggle__check').change ->
    if $(this).is(':checked')
      $(this).closest('.toggle').siblings('.toggle-state').text('Visible on the listing')
      $(this).closest('.toggle').find('.contact-visible').val 1
    else
      $(this).closest('.toggle').siblings('.toggle-state').text('Not visible on the listing')
      $(this).closest('.toggle').find('.contact-visible').val 0
    return