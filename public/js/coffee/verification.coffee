$(document).ready ()->
  $('body').on 'click', '.add-another', (e)->
    e.preventDefault()
    contact_group = $(this).closest('.business-contact').find('.contact-group')
    contact_group_clone = contact_group.clone()
    contact_group_clone.removeClass 'contact-group hidden'
    input = contact_group_clone.find('.fnb-input')
    # input.attr('data-parsley-required',true)
    contact_group_clone.insertBefore(contact_group)

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


  $(document).on 'click', '.verify-link', (event) ->
    $('.contact-container').removeClass('under-review')
    $(this).closest('.contact-container').addClass('under-review')
    verifyContactDetail(true)


  verifyContactDetail = (showModal) ->
    contactValueObj = $('.under-review').find('.contact-input')
    contactValue = contactValueObj.val()
    contactType = $('.under-review').closest('.contact-info').attr('contact-type')
    contactId = $('.under-review').find('.contact-id').val()
    objectType = $('input[name="object_type"]').val()
    objectId = $('input[name="object_id"]').val()
    isVisible = $('.under-review').find('.contact-visible').val()

   
    if contactValue != '' && contactValueObj.parsley().validate()
      
      if(showModal)
        $('#'+contactType+'-modal').find('.contact-input-value').text contactValue
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
          throwError()
          return
        async: false
      $('.verification-step-modal .number').text contactValue
      $('.verify-steps').addClass 'hidden'
      $('.default-state, .verificationFooter').removeClass 'hidden'

    else 
      $('#'+contactType+'-modal').modal 'hide'

  $('.contact-info').on 'change', '.contact-input', (event) ->
    contactObj = $(this)
    contactval = contactObj.val()
    console.log contactval
    if !checkDuplicateEntries(contactObj) && contactval!= ""
      contactObj.closest('div').find('.dupError').html contactval+' already added to list.'
      contactObj.val ''
    else 
      contactObj.closest('div').find('.dupError').html ''

    return

  checkDuplicateEntries = (contactObj) ->
    contactval = contactObj.val()
    $('form').parsley().validate()
    result = true
    contactObj.closest('.contact-info').find('.contact-input').each ->

      if contactObj.get(0) != $(this).get(0) and $(this).val() == contactval
        result = false
        return false

    return result 


  $('.edit-number').click (event)->
    $('.value-enter').val('')
    $('.default-state').addClass 'hidden'
    $('.add-number').removeClass 'hidden'
    $('.verificationFooter').addClass 'no-bg'
    return


  $('.step-back').click (event)->
    $('.default-state').removeClass 'hidden'
    $('.add-number').addClass 'hidden'
    $('.verificationFooter').removeClass 'no-bg'
    return


  $('.verify-stuff').click (event)->
    newContactObj = $(this).closest('.modal').find('.change-contact-input')
    changedValue = newContactObj.val()
    oldContactValue = $(this).closest('.modal').find('.contact-input-value').text().trim()

    if newContactObj.parsley().validate() == true
      # upadte parent conatiner input

      oldContactObj = $('.under-review').find('.contact-input')
      oldContactObj.val changedValue
      
      if !checkDuplicateEntries(oldContactObj)
   
        oldContactObj.val oldContactValue
        $(this).closest('.verify-steps').find('.customError').text changedValue+' already added to list.'
      else 
        $(this).closest('.verify-steps').find('.customError').text ''
        $(this).closest('.modal').find('.contact-input-value').text(changedValue)
        $('.default-state').removeClass 'hidden'
        $('.add-number').addClass 'hidden'
        $('.verificationFooter').removeClass 'no-bg'
        verifyContactDetail(false)

    return

  $('.code-send').click ->
    # $('.processing').removeClass 'hidden'
    errordiv=$(this).closest('.number-code').find('.validationError')
    otpObj=$(this).closest('.code-submit').find('.fnb-input')
    otpObj.attr('data-parsley-required','true')
    otpObj.attr('data-parsley-type','digits')
    otpObj.attr('data-parsley-length','[4,4]')
    validator=otpObj.parsley()
    if validator.isValid() != true
      # console.log 'gandu'
      if otpObj.val()==''
        errordiv.html 'Please enter OTP sent'
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

  $('.verification-step-modal').on 'hidden.bs.modal', (e) ->
    $('.step-success,.add-number').addClass 'hidden'
    $('.verificationFooter').removeClass 'no-bg'
    $('.default-state,.verificationFooter').removeClass 'hidden'
    $('.default-state .fnb-input').val ''
    return

  $('.resend-link').click (event)->
    $(this).addClass 'sending'
    setTimeout (->
      $('.resend-link').removeClass 'sending'
      return
    ), 2500
    return


  $(document).on 'change', '.business-contact .toggle__check', ->
  # $('.business-contact .toggle__check').change ->
    if $(this).is(':checked')
      $(this).closest('.toggle').siblings('.toggle-state').text('Visible on the listing')
      $(this).closest('.toggle').find('input').val 1
    else
      $(this).closest('.toggle').siblings('.toggle-state').text('Not visible on the listing')
      $(this).closest('.toggle').find('input').val 0
    return
