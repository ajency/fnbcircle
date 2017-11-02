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

# window.checkDuplicates = ->
#   contacts = document.getElementsByClassName('contact-input')
#   index = 0
#   while index < contacts.length
#     others = document.getElementsByClassName('contact-input')
#     value = contacts[index].value
#     # console.log 'value=' + value
#     if value != ''
#       index1 = 0
#       while index1 < others.length
#         if value == others[index1].value and index != index1
#           # console.log 'DupValue=' + others[index1].value
#           # console.log 'duplicate found'
#           $(others[index1]).closest('.get-val').find('.dupError').html 'Same contact detail has been added multiple times.'
#           return true
#         else
#           $(others[index1]).closest('.get-val').find('.dupError').html ''
#         ++index1
#     ++index
#   return

$(document).on 'blur', '.fnb-input', ->
  # checkDuplicates()
  $('#info-form').parsley()
  return



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
		$(this).closest('.toggle').siblings('.toggle-state').text('Visible on the listing')
	else
		$(this).closest('.toggle').siblings('.toggle-state').text('Not visible on the listing')
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
