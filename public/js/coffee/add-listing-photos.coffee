
# Upload file
$('.dropify').dropify messages: 'default': 'Add Photo'


# Init dropify

image_dropify = $('.list-image').dropify messages:
  'default': 'Add photo'
  'replace': 'Replace photo'
  'remove': '<i class="">&#10005;</i>'
  'error': 'Ooops, something wrong happended.'


file_dropify = $('.doc-upload').dropify messages:
  'default': 'Upload file'
  'replace': 'Replace file'
  'remove': '<i class="">&#10005;</i>'
  'error': 'Ooops, something wrong happended.'


# add more files

fileuploaders = 1

$('body').on 'click', '.add-uploader', (e)->
  e.preventDefault()
  max = parseInt document.head.querySelector('[property="max-file-upload"]').content
  if(fileuploaders< max)
    fileuploaders++
    contact_group = $(this).closest('.fileUpload').find('.uppend-uploader')
    contact_group_clone = contact_group.clone()
    contact_group_clone.removeClass 'uppend-uploader hidden'
    getTarget = $(this).closest('.fileUpload').find('.addCol')
    # getTarget.insertBefore(contact_group_clone)
    contact_group_clone.insertBefore(getTarget)
    console.log(contact_group_clone)
    contact_group_clone.find('.doc-uploadd').dropify messages:
      'default': 'Upload file'
      'replace': 'Replace file'
      'remove': '<i class="">&#10005;</i>'
      'error': 'Ooops, something wrong happended.'
  else
    console.log 'max '+max+' allowed'
    #throw error

# Remove file section

$('body').on 'click', '.removeCol', (e)->
  e.preventDefault()
  fileuploaders--
  $(this).parent().remove()

# uploader = new (plupload.Uploader)(
#   runtimes: 'html5'
#   browse_button: 'browse-photos'
#   multipart_params: 
#     listing_id: document.getElementById('listing_id').value
#   url: '/storagetest'
#   filters:
#     max_file_size: '3mb'
#     mime_types: [ {
#       title: 'Image files'
#       extensions: 'jpg,png'
#     } ]
#   views:
#     list: true
#     thumbs: true
#     active: 'thumbs'
#   init: PostInit: ->

#     document.getElementById('upload-main-photo').onclick = ->
#       uploader.start()
#       false

#     return
# )
# uploader.init()

uploadFile = (element)->
  url = document.head.querySelector('[property="photo-upload-url"]').content
  # e.preventDefault()
  container = $(element).closest('.image-grid__cols') 
  file = container.find('input[type="file"]')
  if file[0].files.length > 0
    # if container.find('input[type="hidden"]').val() != ""
    #   console.log "File already uploaded"
    #   return
    formData = new FormData
    container.find(".image-loader").removeClass('hidden')
    formData.append 'file', file[0].files[0]
    formData.append 'name', file[0].value
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
          $(element).val ''
      else
        #throw some error
      return
    xhr.send formData
  else
    console.log "Select a file"

image_dropify.on 'dropify.afterClear', (event, element) ->
  $(this).closest('.image-grid__cols').find('input[type="hidden"]').val ""
  console.log "file deleted"
  return

$('input[type="file"]').on 'change', (e) ->
  uploadFile(this)
  