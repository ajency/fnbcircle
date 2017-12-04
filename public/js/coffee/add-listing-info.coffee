userCheck = ->
  if $('#user-type').val() == 'external' or document.getElementsByName('primary_email_txt')[0].value == ""
    listingInformation()
    return
  $.ajax
    type: 'post'
    url: document.head.querySelector('[property="check-user-exist"]').content
    data:
      'email': document.getElementsByName('primary_email_txt')[0].value
    success: (data) ->
      $('.section-loader').addClass 'hidden'
      if data['result']
        text = 'Email id already exists with account status “'+data['user']['status'].charAt(0).toUpperCase() + data['user']['status'].slice(1)+'” , Created on '+data['user']['created_at'].slice(0,10)
      else
        text = 'Email id does not exist. New Account will be created';
      $('#user-exist-text').html text
      $('#user-exist-confirmation').modal 'show'
      $('#user-exist-confirmation').on 'click', '#save-listing', (e) ->
        event.preventDefault()
        $('.section-loader').removeClass 'hidden'
        listingInformation()
        return
  return

listingInformation = ->
  form = $('<form></form>')
  form.attr 'method', 'post'
  form.attr 'action', '/listing'
  contacts = {}
  value = document.getElementsByClassName('contact-input')
  i = 0
  while i < value.length
    if value[i].value != ''
      contact = {}
      if $(value[i]).closest('.business-contact').hasClass('business-email')
        type = 1
      if $(value[i]).closest('.business-contact').hasClass('business-phone')
        type = 2
      if $(value[i]).closest('.business-contact').hasClass('contact-info-landline')
        type = 3
      $.ajax
        type: 'post'
        url: '/contact_save'
        data:
          'value': value[i].value
          'country': $(value[i]).intlTelInput('getSelectedCountryData')['dialCode']
          'type': type
          'id': $(value[i]).closest('.contact-container').find('.contact-id').val()
        success: (data) ->
          $(value[i]).closest('.business-contact').find('.contact-id').val data['id']
          console.log data['id']
          return
        failure: ->
          $('.fnb-alert.alert-failure div.flex-row').html '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>Oh snap! Some error occurred. Please <a href="/login">login</a> or refresh your page'
          $('.alert-failure').addClass 'active'
          return
        async: false
      contact['id'] = $(value[i]).closest('.contact-container').find('.contact-id').val()
      contact['country'] = $(value[i]).intlTelInput('getSelectedCountryData')['dialCode']
      contact['visible'] = if $(value[i]).closest('.contact-container').find('.toggle__check').prop('checked') then '1' else '0'
      # contact['visible'] = $(value[i]).closest('.contact-container').find('.contact-visible').prop('checked');
      contact['value'] = $(value[i]).val()
      contacts[i] = contact
      console.log contact
    i++
  parameters = {}
  parameters['listing_id'] = document.getElementById('listing_id').value
  parameters['step'] = 'business-information'
  parameters['change'] = change
  parameters['title'] = document.getElementsByName('listing_title')[0].value
  type = document.getElementsByName('business_type')
  i = 0
  while i < type.length
    if type[i].checked
      parameters['type'] = type[i].value
    i++
  user = {}
  user['email'] = document.getElementsByName('primary_email_txt')[0].value
  phone = document.getElementsByName('primary_phone_txt')[0]
  user['locality'] = $(phone).intlTelInput('getSelectedCountryData')['dialCode']
  user['phone'] = phone.value
  parameters['user'] = JSON.stringify(user)
  parameters['primary_email'] = if document.getElementsByName('primary_email')[0].checked then '1' else '0'
  parameters['primary_phone'] = if document.getElementsByName('primary_phone')[0].checked then '1' else '0'
  parameters['area'] = $('.area select').val()
  parameters['contacts'] = JSON.stringify(contacts)
  if submit == 1
    parameters['submitReview'] = 'yes'
  if archive == 1
    parameters['archive'] = 'yes'
  if publish == 1
    parameters['publish'] = 'yes'
  $.each parameters, (key, value) ->
    field = $('<input></input>')
    field.attr 'type', 'hidden'
    field.attr 'name', key
    field.attr 'value', value
    form.append field
    console.log key + '=>' + value
    return
  $(document.body).append form
  form.submit()
  return

window.validateListing = (event) ->
  instance = $('#info-form').parsley()
  # if (checkDuplicates()) return false;
  console.log true
  if !instance.validate()
    return false
  $('.section-loader').removeClass 'hidden'
  # console.log($('#listing_id').val());
  if $('#listing_id').val() == ''
    # console.log(true);
    title = document.getElementsByName('listing_title')[0].value
    value = document.getElementsByName('contacts')
    cont = []
    i = 0
    while i < value.length
      type = undefined
      if value[i].value == ''
        i++
        i++
        continue
      if $(value[i]).closest('.business-contact').hasClass('business-email')
        type = 'email'
      if $(value[i]).closest('.business-contact').hasClass('business-phone')
        type = 'mobile'
      if $(value[i]).closest('.business-contact').hasClass('contact-info-landline')
        type = 'landline'
      cont.push
        'value': value[i].value
        'country': $(value[i]).intlTelInput('getSelectedCountryData')['dialCode']
        'type': type
      i++
    json = JSON.stringify(cont)
    # console.log(json);
    $.ajax
      type: 'post'
      url: '/duplicates'
      data:
        'title': title
        'contacts': json
      success: (data) ->
        console.log data
        myvar = ''
        for k of data['similar']
          myvar += '<div class="list-row flex-row">' + '<div class="left">' + '<h5 class="sub-title text-medium text-capitalise list-title">' + data['similar'][k]['name'] + '</h5>'
          for j of data['similar'][k]['messages']
            myvar += '<p class="m-b-0 text-color text-left default-size">' + '<i class="fa fa-exclamation-circle p-r-5 text-primary" aria-hidden="true"></i> <span class="lighter">' + data['similar'][k]['messages'][j] + '</span>' + '</p>'
          myvar += '</div>' + '<div class="right">'
          if data['type'] == 'external'
            myvar += '<div class="capsule-btn flex-row">' + '<a href="claim/" class="btn fnb-btn outline full border-btn no-border claim text-danger">Claim</a>' + '<a href="claim/" class="btn fnb-btn outline full border-btn no-border delete">Delete</a>' + '</div>'
          myvar += '</div>' + '</div>'
        $('.list-entries').html myvar
        if myvar != ''
          $('.section-loader').addClass 'hidden'
          $('#duplicate-listing').modal 'show'
          $('#duplicate-listing').on 'click', '#skip-duplicates', (e) ->
            event.preventDefault()
            $('.section-loader').removeClass 'hidden'
            userCheck()
            return
        else
          event.preventDefault()
          $('.section-loader').removeClass 'hidden'
          userCheck()
        return
      error: (request, status, error) ->
        $('.fnb-alert.alert-failure div.flex-row').html '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i><div>Oh snap! Some error occurred. Please <a href="/login" class="secondary-link">login</a> or refresh your page</div>'
        $('.alert-failure').addClass 'active'
        return
  else
    # console.log(true);
    event.preventDefault()
    userCheck()
  event.preventDefault()
  return

# parent = undefined
# input = undefined
# id = undefined

# verify = ->
#   $('.validationError').html ''
#   if id.val() == ''
#     id_val = null
#   else
#     id_val = id.val()
#   validator = input.parsley()
#   valid = validator.validate()
#   if valid == true and input.val() != ''
#     get_val = input.val()
#     # console.log get_val
#     # console.log id_val
#     if parent.hasClass('business-email')
#       $('#email-modal').modal 'show'
#       type = '1'
#     if parent.hasClass('business-phone')
#       $('#phone-modal').modal 'show'
#       type = '2'
#     $.ajax
#       type: 'post'
#       url: '/create_OTP'
#       data:
#         'value': get_val
#         'type': type
#         'id': id_val
#       success: (data) ->
#         id.val data['id']
#         input.val data['value']
#         get_val = data['value']
#         # console.log id.val()
#         return
#       error: (request, status, error) ->
#         throwError()
#         return
#       async: false
#     $('.verification-step-modal .number').text get_val
#     $('.verify-steps').addClass 'hidden'
#     $('.default-state, .verificationFooter').removeClass 'hidden'

#   else
#     $('#email-modal').modal 'hide'
#     $('#phone-modal').modal 'hide'
#   return

$('.contact-info').on 'change', '.contact-input', (event) ->
  contacts = document.getElementsByClassName('contact-input')
  email = $('input[name="primary_email_txt"]').val();
  phone = $('input[name="primary_phone_txt"]').val();
  index = 0
  while index < contacts.length
    value = contacts[index].value
    if value == email or value == phone
      # setTimeout ->
      $(this).closest('.contact-container').find('.dupError').html 'Same contact detail has been added multiple times.'
      # , 1000
      contacts[index].value = ""
    ++index
  return

$(document).on 'blur', '.fnb-input', ->
  # checkDuplicates()
  $('#info-form').parsley()
  return


$('.user-details-container').on 'keyup', 'input[name="user-email"]', (event) ->
  $('input[name="primary_email_txt"]').val @value

$('.user-details-container').on 'keyup', 'input[name="user-phone"]', (event) ->
  $('input[name="primary_phone_txt"]').val @value

$('.contact-info').on 'change','input.toggle__check', (event) ->
  console.log  $(this).closest('.contact-container').find('.contact-input').val()
  if @checked
    if $(this).closest('.contact-container').find('.contact-input').val() == ''
      $(this).prop('checked',false)

# $(document).on 'click', '.verify-link', (event) ->
# 	event.preventDefault()
# 	parent = $(this).closest('.business-contact')
# 	input = $(this).closest('.get-val').find('.fnb-input')
# 	id = $(this).closest('.get-val').find('.comm-id')
# 	if(checkDuplicates())
# 		return false
# 	verify();
# 	return

# $('.edit-number').click (event)->
#   event.preventDefault()
#   $('.value-enter').val('')
#   $('.default-state').addClass 'hidden'
#   $('.add-number').removeClass 'hidden'
#   $('.verificationFooter').addClass 'no-bg'
#   return


# $('.step-back').click (event)->
# 	event.preventDefault();
# 	$('.default-state').removeClass 'hidden'
# 	$('.add-number').addClass 'hidden'
# 	$('.verificationFooter').removeClass 'no-bg'
# 	return

# $('.verify-stuff').click (event)->
#   event.preventDefault();
#   inp = $(this).siblings '.value-enter'
#   inp.attr('data-parsley-required','true')
#   if parent.hasClass('business-email')
#     inp.attr('data-parsley-type','email')
#   else
#     inp.attr('data-parsley-type','digits')
#     inp.attr('data-parsley-length','[10,10]')
#     inp.attr('data-parsley-length-message','Mobile number should be 10 digits')
#   validator=inp.parsley()
#   if validator.validate() != true
#     # console.log 'gandu'
#     inp.removeAttr('data-parsley-required')
#     inp.removeAttr('data-parsley-type')
#     inp.removeAttr('data-parsley-length')
#     inp.removeAttr('data-parsley-length-message')
#     return false
#   inp.removeAttr('data-parsley-required')
#   inp.removeAttr('data-parsley-type')
#   inp.removeAttr('data-parsley-length')
#   inp.removeAttr('data-parsley-length-message')
#   $('.default-state').removeClass 'hidden'
#   $('.add-number').addClass 'hidden'
#   $('.verificationFooter').removeClass 'no-bg'
#   get_value = $(this).siblings('.value-enter').val();
#   $('.show-number .number').text(get_value);
#   $(input).val(get_value);
#   $(inp).val('');
#   $('.validationError').html ''
#   verify();
#   return

# $('.code-send').click ->
#   # $('.processing').removeClass 'hidden'
#   errordiv=$(this).closest('.number-code').find('.validationError')
#   inp=$(this).closest('.code-submit').find('.fnb-input')
#   inp.attr('data-parsley-required','true')
#   inp.attr('data-parsley-type','digits')
#   inp.attr('data-parsley-length','[4,4]')
#   validator=inp.parsley()
#   if validator.isValid() != true
#     # console.log 'gandu'
#     if inp.val()==''
#       errordiv.html 'Please enter OTP sent'
#     else
#       errordiv.html('Sorry! The entered OTP is invalid. Please try again.');
#     inp.val('')
#     inp.removeAttr('data-parsley-required')
#     inp.removeAttr('data-parsley-type')
#     inp.removeAttr('data-parsley-length')
#     return false
#   inp.removeAttr('data-parsley-required')
#   inp.removeAttr('data-parsley-type')
#   inp.removeAttr('data-parsley-length')
#   OTP = inp.val()
#   $('.default-state').addClass('hidden')
#   $('.processing').removeClass('hidden')
#   $.ajax
#     type: 'post'
#     url: '/validate_OTP'
#     data:
#       'OTP': OTP
#       'id': id.val()
#     success: (data) ->
#       # console.log data
#       $('.success-spinner').removeClass 'hidden'
#       if data['success'] == "1"
#         errordiv.html('');
#         $('.default-state,.add-number,.verificationFooter').addClass 'hidden'
#         $('.processing').addClass 'hidden'
#         $('.step-success').removeClass 'hidden'
#         $(input).closest('.get-val').find('.verified').html '<span class="fnb-icons verified-icon"></span><p class="c-title">Verified</p>'
#         $(input).attr('readonly',true)
#       else
#         $('.processing').addClass('hidden')
#         $('.default-state').removeClass('hidden')
#         inp.val('')
#         errordiv.html('Sorry! The entered OTP is invalid. Please try again.');
#       return
#     error: (request, status, error) ->
#       $('.success-spinner').addClass 'hidden'
#       $('.processing').addClass('hidden')
#       $('.default-state').removeClass('hidden')
#       inp.val('')
#       errordiv.html('Sorry! The entered OTP is invalid. Please try again.');
#       return
#     async: false
#   return

# $('.verification-step-modal').on 'hidden.bs.modal', (e) ->
#   $('.step-success,.add-number').addClass 'hidden'
#   $('.verificationFooter').removeClass 'no-bg'
#   $('.default-state,.verificationFooter').removeClass 'hidden'
#   $('.default-state .fnb-input').val ''
#   return

# $('.resend-link').click (event)->
# 	event.preventDefault();
# 	$(this).addClass 'sending'
# 	# console.log id.val()
# 	setTimeout (->
# 		$('.resend-link').removeClass 'sending'
# 		return
# 	), 2500
# 	return

$('body').on 'click', '.removeRow', ->
	$(this).closest('.get-val').parent().remove()

# setTimeout (->
#   $('.listing-sections').addClass 'active'
#   return
# ), 1500


$(document).on 'click', '.business-type .radio', ->
  if $(this).is(':checked')
    $(this).parent().addClass 'active'
    $(this).parent().siblings().removeClass 'active'
  return


$(document).on 'change', '.business-contact .toggle__check', ->
# $('.business-contact .toggle__check').change ->
	if $(this).is(':checked')
		$(this).closest('.toggle').siblings('.toggle-state').text('Visible ')
	else
		$(this).closest('.toggle').siblings('.toggle-state').text('Not visible ')
	return

$(document).on 'change', '.city select', ->
  html='<option value="" selected>Select City </option>'
  $('.area select').html html
  city = $(this).val()
  if city == ''
    return
  $.ajax
    type: 'post'
    url: '/get_areas'
    data:
      'city': city
    success: (data) ->
      # console.log data
      for key of data
        html += '<option value="' + data[key]['id'] + '">' + data[key]['name'] + '</option>'
      $('.area select').html html
      return
    error: (request, status, error) ->
      throwError()
      return

# $('body').on 'click', '.add-another', (e)->
#   e.preventDefault()
#   contact_group = $(this).closest('.business-contact').find('.contact-group')
#   contact_group_clone = contact_group.clone()
#   contact_group_clone.removeClass 'contact-group hidden'
#   input = contact_group_clone.find('.fnb-input')
#   input.attr('data-parsley-required',true)
#   contact_group_clone.insertBefore(contact_group)
