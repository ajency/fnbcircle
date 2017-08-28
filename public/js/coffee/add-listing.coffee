# Get Started form next/prev
$('body').on 'click', '.gs-next', ->
	$('.gs-steps > .active').next('li').find('a').trigger 'click'

$('body').on 'click', '.gs-prev', ->
	$('.gs-steps > .active').prev('li').find('a').trigger 'click'

# Upload file
$('.dropify').dropify messages: 'default': 'Add Photo'

# BS collapse others 

# $myGroup = $('.cat-dataHolder')
# $myGroup.on 'show.bs.collapse', '.collapse', ->
#   $myGroup.find('.collapse.in').collapse 'hide'
#   return

# $('.cat-dataHolder .toggle-collapse').click (e) ->
#   console.log('res')
#   $('.collapse').collapse 'hide'
#   return  


window.slugify = (string) ->
  string.toString().trim().toLowerCase().replace(/\s+/g, '-').replace(/[^\w\-]+/g, '').replace(/\-\-+/g, '-').replace(/^-+/, '').replace /-+$/, ''





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



# All payment modes select

$('body').on 'change', 'input:checkbox#selectall', ->
  if $(this).is(':checked')
    $(this).closest('.select-all').siblings('.payment-modes').find('input:checkbox').prop('checked', true)
  else
    $(this).closest('.select-all').siblings('.payment-modes').find('input:checkbox').prop('checked', false)


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



# 	catAdd = $(this).closest('.business-cats').find('.add-more-cat')
# 	catAdd_group = catAdd.clone()
# 	catAdd_group.removeClass 'add-more-cat hidden'
# 	catAdd_group.insertBefore(catAdd)


# $('.verify-link').click ->
# 	get_val = $(this).closest('.get-val').find('.fnb-input').val()
# 	$('.verification-step-modal .number').text get_val



$(document).on 'click', 'a.review-submit-link', (e) ->
  window.submit = 1;
  # $('#listing-review').modal 'show'
  submitForm(e)

$(document).on 'click', '.full.save-btn.gs-next', (e) ->
  submitForm(e)

submitForm = (e) ->
  step = $('input#step-name').val()
  e.preventDefault()
  if step == 'business-information'
    window.validateListing(e)
  if step == 'business-categories'
    validateCategories()
  if step == 'business-location-hours'
    validateLocationHours()



# console.log categories

$_GET = []
window.location.href.replace /[?&]+([^=&]+)=([^&]*)/gi, (a, name, value) ->
  $_GET[name] = value
  return
if $_GET['review'] != undefined
  console.log $_GET['review']
  $('#listing-review').modal('show')
if $_GET['success'] != undefined
  setTimeout (->
  	$('.alert-success').addClass 'active'
  	return
  ), 1000
  setTimeout (->
  	$('.alert-success').removeClass 'active'
  	return
  ), 6000
if $('.alert.alert-failure.server-error').length != 0
  setTimeout (->
  	$('.alert-failure').addClass 'active'
  	return
  ), 1000
  setTimeout (->
  	$('.alert-failure').removeClass 'active'
  	return
  ), 6000


if $(window).width() > 769
  getID = $('.gs-form .tab-pane').attr('id')
  $('.gs-steps .form-toggle').each ->
    if $(this).attr('id') == getID
      $(this).parent().addClass 'active'
    return


$('body').on 'click', '.review-submit', (e)->
  e.preventDefault()
  $('.status-changer').text('Processing').removeClass('text-primary').addClass('text-secondary')
  $('.draft-status').attr('data-original-title','Listing is under process')
  $(this).addClass('hidden')



# mondayValue = $('.monday').prop('selectedIndex')

# $('body').on 'click', '.copy-timing', ->
# 	event.preventDefault
# 	$('.operation-hours .fnb-select').prop('selectedIndex',mondayValue)

window.throwError = () ->
    $('.fnb-alert.alert-failure div.flex-row').html '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i><div>Oh snap! Some error occurred. Please <a href="/login" class="secondary-link">login</a> or refresh your page</div>'
    $('.alert-failure').addClass 'active'
  return







