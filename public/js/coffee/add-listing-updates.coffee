
# Upload file
$('.dropify').dropify messages: 'default': 'Add Photo'


# Init dropify

image_dropify = $('.list-image').dropify messages:
  'default': 'Add photo'
  'replace': 'Replace photo'
  'remove': '<i class="">&#10005;</i>'
  'error': ''


ef= 0

image_dropify.on 'dropify.errors', (event, element) ->
  ef = 1
  setTimeout (->
    ef = 0
    return
  ), 2000
  return

uploadFile = (container) ->
	url = document.head.querySelector('[property="photo-upload-url"]').content
	file = container.find('input[type="file"]')
	if file[0].files.length > 0
		formData = new FormData
		container.find(".image-loader").removeClass('hidden')
		formData.append 'file', file[0].files[0]
		formData.append 'name', ''
		formData.append 'listing_id', document.getElementById('listing_id').value
		xhr = new XMLHttpRequest
		xhr.open 'POST', url
		xhr.onreadystatechange = ->
			if @readyState == 4 and @status == 200
				data = JSON.parse(@responseText)
				if(data['status'] == "200")
					container.find('input[type="hidden"]').val data['data']['id']
					container.find(".image-loader").addClass('hidden')
				else
				  #throw some error
					$container.find('input[type="file"]').val ''
					container.find(".image-loader").addClass('hidden')
					$('.fnb-alert.alert-failure div.flex-row').html '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i><div>Oh snap! Some error occurred. Please check your internet connection and retry</div>'
					$('.alert-failure').addClass 'active'
					setTimeout (->
						$('.alert-failure').removeClass 'active'
						return
					), 6000
			else
			#throw some error
			return
		xhr.send formData
	else
	console.log "Select a file"

image_dropify.on 'dropify.afterClear', (event, element) ->
  $(this).closest('.image-grid__cols').find('input[type="hidden"]').val ""
  $(this).closest('.image-grid__cols').find('input[type="file"]').removeAttr('title');
  console.log "file deleted"
  return


$('body').on 'change','.imageUpload input[type="file"]', (e) ->
  console.log 'abcx'
  container =$(this).closest('.image-grid__cols')
  setTimeout (->
    if ef == 0
      uploadFile(container)
    return
  ), 250

$('.dropify-wrapper.touch-fallback .dropify-clear i').text('Remove photo');

$('body').on 'click', '#post-update-button', ->
  instance = $('#info-form').parsley()
  if !instance.validate()
    return false
  title = $('input[type="text"][name="title"]').val()
  description = $('textarea[name="description"]').val()
  images = []
  $('.imageUpload input[type="hidden"]').each ->
    if $(this).val() != ''
      return images.push($(this).val())
    return
  console.log title, description, images
  url = document.head.querySelector('[property="post-upload-url"]').content
  $.ajax
    type: 'post'
    url: url
    data: 
      'photos' : images
      'title': title
      'description': description
      'type':'listing'
      'id': document.getElementById('listing_id').value
    success: () ->
      console.log "success"



$('body').on 'click', '.add-uploader', (e)->
  e.preventDefault()
  contact_group = $(this).closest('.fileUpload').find('.uppend-uploader')
  contact_group_clone = contact_group.clone()
  contact_group_clone.removeClass 'uppend-uploader hidden'
  getTarget = $(this).closest('.fileUpload').find('.addCol')
  # getTarget.insertBefore(contact_group_clone)
  contact_group_clone.insertBefore(getTarget)
  console.log(contact_group_clone)
  contact_group_clone.find('.doc-uploadd').dropify messages:
    'default': 'Add photo'
    'replace': 'Replace photo'
    'remove': '<i class="">&#10005;</i>'
    'error': ''

$('body').on 'click', '.removeCol', (e)->
  e.preventDefault()
  $(this).parent().remove()