# Get Started form next/prev
$('body').on 'click', '.gs-next', ->
	$('.gs-steps > .active').next('li').find('a').trigger 'click'

$('body').on 'click', '.gs-prev', ->
	$('.gs-steps > .active').prev('li').find('a').trigger 'click'

# Upload file
$('.dropify').dropify messages: 'default': 'Add Photo'

# Add/Edit categories
$('body').on 'click', 'input:radio[name=\'categories\']', ->
  cat_name = $(this).data('name')
  $('.main-cat-name').html(cat_name)
  # Update icon
  cat_icon = $(this).closest('li').find('.cat-icon').clone().addClass 'm-r-15'
  $('.sub-category .cat-name').find('.cat-icon').remove()
  $('.sub-category .cat-name').prepend(cat_icon)
  $('.categ-list').html ''
  $('.mobile-categories').html ''
  id = $(this).val()
  obj={}
  obj[0] = {"id":id}
  $.ajax
    type: 'post'
    url: '/get_categories'
    data: {
      'parent' : JSON.stringify(obj)
    }
    success: (data) ->
      console.log data
      html = ''
      html_mob = ''
      i = 0
      for key of data[0]
        html_mob += '<div class="toggle-collapse desk-hide" data-toggle="collapse" data-target="#' + data[0][key] + '"  name="' + key + '" aria-expanded="false" aria-controls="' + data[0][key] + '">' + data[0][key] + ' <i class="fa fa-angle-down" aria-hidden="true"></i></div><div role="tabpanel" class="tab-pane collapse';
        if i == 0
          html_mob += ' active' 
        html_mob += '" id="' + data[0][key] + '" name="' + key + '">' + data[0][key] + '</div>'
        html += '<li role="presentation"'
        if i == 0
          html += ' class="active"'
        html += '><a href="#' + data[0][key] + '"  name="' + key + '" aria-controls="' + data[0][key] + '" role="tab" data-toggle="tab">' + data[0][key] + '</a></li>'
        i++
      $('.categ-list').html html
      $('.mobile-categories').html html_mob
      return
  return


$('body').on 'click', '.sub-category-back', ->
  $('.main-category').removeClass 'hidden'
  $('.sub-category').removeClass 'shown'


$('body').on 'click', '.category-back', ->
  $('.main-category').removeClass 'hidden'
  $('.sub-category').removeClass 'shown'


# detaching sections
if $(window).width() <= 768
  $('.single-category').each ->
    branchAdd = $(this).find('.branch-row')
    branchrow = $(this).find('.branch').detach()
    $(branchAdd).append branchrow
    return
  $('.get-val').each ->
  	removeRow = $(this).find('.fnb-input')
  	addRow = $(this).find('.removeRow').detach()
  	$(removeRow).after addRow




#jQuery flexdatalist

$('.flexdatalist').flexdatalist()

# Tips Toggle
$('body').on 'click', '.tips', ->
	$(this).toggleClass 'open'
	$('.tips__steps.collapse').collapse('toggle')

$('.sample-img').magnificPopup
	items:
		src: 'img/sample_listing.png'
	type: 'image'
	mainClass: 'mfp-fade'

# All cities select
$('body').on 'change', 'input:checkbox.all-cities', ->
	if $(this).is(':checked')
		$(this).closest('.tab-pane').find('input:checkbox').prop('checked', true)
	else
		$(this).closest('.tab-pane').find('input:checkbox').prop('checked', false)

$('[data-toggle="tooltip"]').tooltip()

# Add/Delete Highlights
$('body').on 'click', '.add-highlight', ->
	highlight_group = $(this).closest('.highlight-input-group')
	highlight_group_clone = highlight_group.clone()
	highlight_group_clone.find('.add-highlight').remove()
	highlight_group_clone.find('.delete-highlight').removeClass('hidden')
	highlight_group_clone.insertBefore(highlight_group)
	highlight_group.find('.highlight-input').val('')

$('body').on 'click', '.delete-highlight', ->
	$(this).closest('.highlight-input-group').remove()

$('body').on 'click', '.add-another', (e)->
	e.preventDefault()
	contact_group = $(this).closest('.business-contact').find('.contact-group')
	contact_group_clone = contact_group.clone()
	contact_group_clone.removeClass 'contact-group hidden'
	input = contact_group_clone.find('.fnb-input')
	input.attr('data-parsley-required',true)
	contact_group_clone.insertBefore(contact_group)


# 	catAdd = $(this).closest('.business-cats').find('.add-more-cat')
# 	catAdd_group = catAdd.clone()
# 	catAdd_group.removeClass 'add-more-cat hidden'
# 	catAdd_group.insertBefore(catAdd)

# Remove Category

$('body').on 'click', '.delete-cat', ->
	$(this).closest('.single-category').remove()

$('body').on 'click', '.fnb-cat .remove', ->
	$(this).closest('.fnb-cat__title').parent().remove()


$('body').on 'click', '.review-submit', (e)->
	e.preventDefault()
	$('.status-changer').text('Processing').removeClass('text-primary').addClass('text-secondary')
	$('.draft-status').attr('data-original-title','Listing is under process')
	$(this).addClass('hidden')



if $(window).width() > 768
	getID = $('.gs-form .tab-pane').attr('id')
	$('.gs-steps .form-toggle').each ->
	  if $(this).attr('id') == getID
	    $(this).parent().addClass 'active'
	  return
 

# $('.verify-link').click ->
# 	get_val = $(this).closest('.get-val').find('.fnb-input').val()
# 	$('.verification-step-modal .number').text get_val

parent = undefined
input = undefined
id = undefined

verify = ->
  $('.validationError').html ''
  if id.val() == ''
    id_val = null
  else
    id_val = id.val()
  validator = input.parsley()
  valid = validator.validate()
  if valid == true and input.val() != ''
    get_val = input.val()
    console.log get_val
    console.log id_val
    if parent.hasClass('business-email')
      $('#email-modal').modal 'show'
      type = '1'
    if parent.hasClass('business-phone')
      $('#phone-modal').modal 'show'
      type = '2'
    $.ajax
      type: 'post'
      url: '/create_OTP'
      data:
        'value': get_val
        'type': type
        'id': id_val
      success: (data) ->
        id.val data['id']
        input.val data['value']
        get_val = data['value']
        console.log id.val()
        return
      error: (request, status, error) ->
        id.val ""
        alert("OTP failed. Try Again")
        return
      async: false
    $('.verification-step-modal .number').text get_val
    $('.verify-steps').addClass 'hidden'
    $('.default-state, .verificationFooter').removeClass 'hidden'

  else
    $('#email-modal').modal 'hide'
    $('#phone-modal').modal 'hide'
  return

window.checkDuplicates = ->
  contacts = document.getElementsByClassName('fnb-input')
  index = 0
  while index < contacts.length
    others = document.getElementsByClassName('fnb-input')
    value = contacts[index].value
    # console.log 'value=' + value
    if value != ''
      index1 = 0
      while index1 < others.length
        if value == others[index1].value and index != index1
          # console.log 'DupValue=' + others[index1].value
          # console.log 'duplicate found'
          $(others[index1]).closest('.get-val').find('.dupError').html 'Same contact detail added multiple times.'
          return true
        else
          $(others[index1]).closest('.get-val').find('.dupError').html ''
        ++index1
    ++index
  return

$(document).on 'blur', '.fnb-input', ->
	checkDuplicates()
	$('#info-form').parsley()
	return



$(document).on 'click', '.verify-link', ->
	event.preventDefault()
	parent = $(this).closest('.business-contact')
	input = $(this).closest('.get-val').find('.fnb-input')
	id = $(this).closest('.get-val').find('.comm-id')
	if(checkDuplicates()) 
		return false
	verify();
	return

$('.edit-number').click ->
  event.preventDefault()
  $('.value-enter').val('')
  $('.default-state').addClass 'hidden'
  $('.add-number').removeClass 'hidden'
  $('.verificationFooter').addClass 'no-bg'
  return


$('.step-back').click ->
	event.preventDefault();
	$('.default-state').removeClass 'hidden'
	$('.add-number').addClass 'hidden'
	$('.verificationFooter').removeClass 'no-bg'
	return

$('.verify-stuff').click ->
  event.preventDefault();
  inp = $(this).siblings '.value-enter'
  inp.attr('data-parsley-required','true')
  if parent.hasClass('business-email')
    inp.attr('data-parsley-type','email')
  else
    inp.attr('data-parsley-type','digits')
    inp.attr('data-parsley-length','[10,10]')
    inp.attr('data-parsley-length-message','Mobile number should be 10 digits')
  validator=inp.parsley()
  if validator.validate() != true 
    # console.log 'gandu'
    inp.removeAttr('data-parsley-required')
    inp.removeAttr('data-parsley-type')
    inp.removeAttr('data-parsley-length')
    inp.removeAttr('data-parsley-length-message')
    return false
  inp.removeAttr('data-parsley-required')
  inp.removeAttr('data-parsley-type')
  inp.removeAttr('data-parsley-length')
  inp.removeAttr('data-parsley-length-message')
  $('.default-state').removeClass 'hidden'
  $('.add-number').addClass 'hidden'
  $('.verificationFooter').removeClass 'no-bg'
  get_value = $(this).siblings('.value-enter').val();
  $('.show-number .number').text(get_value);
  $(input).val(get_value);
  $(inp).val('');
  $('.validationError').html ''
  verify();
  return

$('.code-send').click ->
  # $('.processing').removeClass 'hidden'
  errordiv=$(this).closest('.number-code').find('.validationError')
  inp=$(this).closest('.code-submit').find('.fnb-input')
  inp.attr('data-parsley-required','true')
  inp.attr('data-parsley-type','digits')
  inp.attr('data-parsley-length','[4,4]')
  validator=inp.parsley()
  if validator.isValid() != true 
    # console.log 'gandu'
    if inp.val()==''
      errordiv.html 'Please enter OTP'
    else
      errordiv.html('OTP is Invalid');
    inp.val('')
    inp.removeAttr('data-parsley-required')
    inp.removeAttr('data-parsley-type')
    inp.removeAttr('data-parsley-length')
    return false
  inp.removeAttr('data-parsley-required')
  inp.removeAttr('data-parsley-type')
  inp.removeAttr('data-parsley-length')
  OTP = inp.val()
  $('.default-state').addClass('hidden')
  $('.processing').removeClass('hidden')
  $.ajax
    type: 'post'
    url: '/validate_OTP'
    data:
      'OTP': OTP
      'id': id.val()
    success: (data) ->
      # console.log data
      if data['success'] == "1"
        errordiv.html('');
        $('.default-state,.add-number,.verificationFooter').addClass 'hidden'
        $('.processing').addClass 'hidden'
        $('.step-success').removeClass 'hidden'
        $(input).closest('.get-val').find('.verified').html '<span class="fnb-icons verified-icon"></span><p class="c-title">Verified</p>'
        $(input).attr('readonly',true)
      else
        $('.processing').addClass('hidden')
        $('.default-state').removeClass('hidden')
        inp.val('')
        errordiv.html('OTP is Invalid');
      return
    error: (request, status, error) ->
      $('.processing').addClass('hidden')
      ('.default-state').removeClass('hidden')
      inp.val('')
      errordiv.html('OTP is Invalid');
      return
    async: false
  return

$('.verification-step-modal').on 'hidden.bs.modal', (e) ->
  $('.step-success,.add-number').addClass 'hidden'
  $('.verificationFooter').removeClass 'no-bg'
  $('.default-state,.verificationFooter').removeClass 'hidden'
  $('.default-state .fnb-input').val ''
  return

$('.resend-link').click ->
	event.preventDefault();
	$(this).addClass 'sending'
	console.log id.val()
	setTimeout (->
		$('.resend-link').removeClass 'sending'
		return
	), 2500
	return

$('body').on 'click', '.removeRow', ->
	$(this).closest('.get-val').remove()	

# setTimeout (->
#   $('.listing-sections').addClass 'active'
#   return
# ), 1500


$(document).on 'change', '.business-contact .toggle__check', ->
# $('.business-contact .toggle__check').change ->
	if $(this).is(':checked')
		$(this).closest('.toggle').siblings('.toggle-state').text('Visible on the listing')
	else
		$(this).closest('.toggle').siblings('.toggle-state').text('Not visible on the listing')
	return

$(document).on 'change', '.city select', ->
  city = $(this).val()
  $.ajax
    type: 'post'
    url: '/get_areas'
    data: 
      'city': city
    success: (data) ->
      # console.log data
      html='<option value="" selected>Select Area </option>'
      for key of data
        html += '<option value="' + key + '">' + data[key] + '</option>'
      $('.area select').html html
      return
