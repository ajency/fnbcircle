# Get Started form next/prev
$('body').on 'click', '.gs-next', ->
	$('.gs-steps > .active').next('li').find('a').trigger 'click'

$('body').on 'click', '.gs-prev', ->
	$('.gs-steps > .active').prev('li').find('a').trigger 'click'

# Upload file
$('.dropify').dropify messages: 'default': 'Add Photo'

# Add/Edit categories
$('body').on 'click', 'input:radio[name=\'categories\']', ->
	# Toggle wrappers
	# $('.main-category').addClass 'hidden'
	# $('.sub-category').addClass 'shown'
	# Update category name
	cat_name = $(this).data('name')
	$('.main-cat-name').html(cat_name)
	# Update icon
	cat_icon = $(this).closest('li').find('.cat-icon').clone().addClass 'm-r-15'
	$('.sub-category .cat-name').find('.cat-icon').remove()
	$('.sub-category .cat-name').prepend(cat_icon)

$('body').on 'click', '.sub-category-back', ->
	$('.main-category').removeClass 'hidden'
	$('.sub-category').removeClass 'shown'

# detaching sections
if $(window).width() <= 768
  $('.single-category').each ->
    branchAdd = $(this).find('.branch-row')
    branchrow = $(this).find('.branch').detach()
    $(branchAdd).append branchrow
    return

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
	contact_group_clone.insertBefore(contact_group)

$('body').on 'click', '.review-submit', (e)->
	e.preventDefault()
	$('.status-changer').text('Processing').removeClass('text-primary').addClass('text-secondary')
	$('.draft-status').attr('data-original-title','Listing is under process')
	$(this).addClass('hidden')





