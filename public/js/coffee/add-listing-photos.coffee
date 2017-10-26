
# Upload file
$('.dropify').dropify messages: 'default': 'Add Photo'


# Init dropify

image_dropify = $('.list-image').dropify messages:
  'default': 'Add photo'
  'replace': 'Replace photo'
  'remove': '<i class="">&#10005;</i>'
  'error': ''



file_dropify = $('.doc-upload').dropify messages:
  'default': 'Upload file'
  'replace': 'Replace file'
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
file_dropify.on 'dropify.errors', (event, element) ->
  ef = 1
  setTimeout (->
    ef = 0
    return
  ), 2000
  $(this).closest('.image-grid__cols').find('input[type="hidden"]').val ""
  $(this).closest('.image-grid__cols').find('.doc-name').val ""
  return

# ---
# add more files
# console.log $('.fileUpload input[type="file"]')
fileuploaders = $('.fileUpload input[type="file"]').length
fileuploaders -= 1
console.log fileuploaders

$('body').on 'click', '.add-uploader', (e)->
  e.preventDefault()
  max = parseInt document.head.querySelector('[property="max-file-upload"]').content
  if(fileuploaders< max)
    $('#more-file-error').html('')
    console.log fileuploaders+' < '+max
    fileuploaders++
    contact_group = $(this).closest('.fileUpload').find('.uppend-uploader')
    contact_group_clone = contact_group.clone()
    contact_group_clone.removeClass 'uppend-uploader hidden'
    getTarget = $(this).closest('.fileUpload').find('.addCol')
    # getTarget.insertBefore(contact_group_clone)
    contact_group_clone.insertBefore(getTarget)
    console.log(contact_group_clone)
    file_uploader = contact_group_clone.find('.doc-uploadd').dropify messages:
      'default': 'Upload file'
      'replace': 'Replace file'
      'remove': '<i class="">&#10005;</i>'
      'error': ''
    file_uploader.on 'dropify.afterClear', (event, element) ->
      $(this).closest('.image-grid__cols').find('input[type="hidden"]').val ""
      $(this).closest('.image-grid__cols').find('.doc-name').val ""
      $(this).closest('.image-grid__cols').find('input[type="file"]').removeAttr('title');
      console.log $(this).closest('.image-grid__cols').find('input[type="file"]').attr('data-size')
      window.current_file_total_size = parseInt(window.current_file_total_size) - parseInt($(this).closest('.image-grid__cols').find('input[type="file"]').attr('data-size'))
      $(this).closest('.image-grid__cols').find('input[type="file"]').removeAttr('data-size');
      $(this).closest('.image-grid__cols').find('.doc-name').removeAttr "required"
      $('#more-file-error').html('')
      console.log "file deleted"
      return
    # contact_group_clone.find('.doc-uploadd').prop('disabled',true)
    # contact_group_clone.find('.doc-uploadd').parent().addClass 'disable'    
    $('.dropify-wrapper.touch-fallback .dropify-clear i').text('Remove file');
  else
    console.log 'max '+max+' allowed'
    $('#more-file-error').html('Cannot upload more than 20 files')
    #throw error

# Remove file section

$('body').on 'click', '.removeCol', (e)->
  e.preventDefault()
  $('#more-file-error').html('')
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

uploadFile = (container,type)->
  if type == 0
    url = document.head.querySelector('[property="photo-upload-url"]').content
  else
    url = document.head.querySelector('[property="file-upload-url"]').content
  # e.preventDefault()
  # container = $(element).closest('.image-grid__cols') 
  file = container.find('input[type="file"]')
  # console.log file
  if file[0].files.length > 0
    # if container.find('input[type="hidden"]').val() != ""
    #   console.log "File already uploaded"
    #   return
    formData = new FormData
    container.find(".image-loader").removeClass('hidden')
    name = file[0].value.split('\\').reverse()[0]
    name = name.split('.')[0]
    formData.append 'file', file[0].files[0]
    if type == 0
      formData.append 'name', ''
    else
      if container.find('input.doc-name').val() != ''
        name = container.find('input.doc-name').val()
      formData.append 'name', name
      # formData.append 'name', ''
      container.find('input.doc-name').val('')
    formData.append 'listing_id', document.getElementById('listing_id').value
    xhr = new XMLHttpRequest
    xhr.open 'POST', url
    xhr.onreadystatechange = ->
      console.log @responseText
      if @readyState == 4 and @status == 200
        data = JSON.parse(@responseText)
        if(data['status'] == "200")
          container.find('input[type="hidden"]').val data['data']['id']
          container.find(".image-loader").addClass('hidden')
          if type == 1
            container.find('.doc-name').attr('required','required')
            container.find('.doc-name').val(name)
            container.find('input[type="hidden"]').attr 'title',name
        else
          #throw some error
          container.find('input[type="file"]').val ''
          container.find(".image-loader").addClass('hidden')
          container.find('.dropify-clear').click();
          $('.fnb-alert.alert-failure div.flex-row').html '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i><div>Oh snap! Some error occurred. Please check your internet connection and retry</div>'
          $('.alert-failure').addClass 'active'
          setTimeout (->
            $('.alert-failure').removeClass 'active'
            return
          ), 6000
      else
        if @status != 200
          console.log @status
          container.find('input[type="file"]').val ''
          container.find(".image-loader").addClass('hidden')
          container.find('.dropify-clear').click();
          $('.fnb-alert.alert-failure div.flex-row').html '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i><div>Oh snap! '+@status+' error occurred</div>'
          $('.alert-failure').addClass 'active'
          setTimeout (->
            $('.alert-failure').removeClass 'active'
            return
          ), 6000
      return
    xhr.send formData
  else
    console.log "Select a file"

image_dropify.on 'dropify.afterClear', (event, element) ->
  $(this).closest('.image-grid__cols').find('input[type="hidden"]').val ""
  $(this).closest('.image-grid__cols').find('input[type="file"]').removeAttr('title');
  console.log "file deleted"
  return
file_dropify.on 'dropify.afterClear', (event, element) ->
  $(this).closest('.image-grid__cols').find('input[type="hidden"]').val ""
  $(this).closest('.image-grid__cols').find('.doc-name').val ""
  $(this).closest('.image-grid__cols').find('input[type="file"]').removeAttr('title');
  window.current_file_total_size = parseInt(window.current_file_total_size) - parseInt($(this).closest('.image-grid__cols').find('input[type="file"]').attr('data-size'))
  $(this).closest('.image-grid__cols').find('input[type="file"]').removeAttr('data-size');
  $(this).closest('.image-grid__cols').find('.doc-name').removeAttr "required"
  console.log "file deleted"
  return

$('body').on 'change','.imageUpload input[type="file"]', (e) ->
  container =$(this).closest('.image-grid__cols')
  setTimeout (->
    if ef == 0
      uploadFile(container,0)
    return
  ), 250
  

$('body').on 'change', '.fileUpload input[type="file"]', (e) ->
  container =$(this).closest('.image-grid__cols')
  size = this.files[0].size
  prev_size = container.find('input[type="file"]').attr('data-size')
  console.log prev_size
  maxsize = document.head.querySelector('[property="max-file-size"]').content
  console.log maxsize
  if parseInt(window.current_file_total_size) + parseInt(size) < parseInt(maxsize)
    setTimeout (->
      if ef == 0
        uploadFile(container,1)
        window.current_file_total_size = parseInt(window.current_file_total_size) - parseInt(prev_size) + parseInt(size)
        container.find('input[type="file"]').attr('data-size',size)
      return
    ), 250
  else
    container.find('.dropify-clear').click();
    # alert('Total file size cannot be more than 25 MB')
    $('#more-file-error').html('Total file size cannot be more than 25 MB')
    container.find('input[type="file"]').val ''
    container.find(".image-loader").addClass('hidden')
    setTimeout (->
      container.find('.dropify-clear').click();
      $('#more-file-error').html('Total file size cannot be more than 25 MB')
      return
    ), 750
    


$('.dropify-wrapper.touch-fallback .dropify-clear i').text('Remove photo');



# $('input[type="file"].doc-upload').prop('disabled',true)

# $('input[type="file"].doc-upload').parent().addClass 'disable'

# $('body').on 'keyup', '.doc-name', () ->
#   if $(this).val() == ""
#     $(this).closest('.image-grid__cols').find('input[type="file"]').prop('disabled',true)
#     $(this).closest('.image-grid__cols').find('input[type="file"]').parent().addClass 'disable'
#     $(this).closest('.image-grid__cols').find('input[type="file"]').attr('title','You cannot upload a file till you write a name')
#   else
#     $(this).closest('.image-grid__cols').find('input[type="file"]').prop('disabled',false)
#     $(this).closest('.image-grid__cols').find('input[type="file"]').parent().removeClass 'disable'
#     $(this).closest('.image-grid__cols').find('input[type="file"]').removeAttr('title')

window.validatePhotosDocuments = () ->
  instance = $('#info-form').parsley()
  if !instance.validate()
    return false;
  $('.section-loader').removeClass('hidden');
  images = []
  files = {}
  main = $('.main-image input[type="hidden"]').val()
  $('.imageUpload input[type="hidden"]').each () ->
    if $(this).val() != ""
      images.push $(this).val()
  if main == "" and images.length > 0
    $('.fnb-alert.alert-failure div.flex-row').html '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i><div>Please Upload main image</div>'
    $('.alert-failure').removeClass 'hidden'
    $('.alert-failure').addClass 'active'
    setTimeout (->
      $('.alert-failure').removeClass 'active'
      return
    ), 6000
    $('.section-loader').addClass('hidden');
    return
  $('.fileUpload input[type="hidden"]').each () ->
    if $(this).val() != ""
      files[$(this).val()] = {"id" : $(this).val(), "name" : $(this).closest('.image-grid__cols').find('.doc-name').val()}
  parameters = {}
  parameters['listing_id'] = document.getElementById('listing_id').value
  parameters['step'] = 'business-photos-documents'
  parameters['change'] = window.change
  if window.submit ==1
    parameters['submitReview'] = 'yes'
  if window.archive ==1
    parameters['archive'] = 'yes'
  if window.publish ==1
    parameters['publish'] = 'yes'
  parameters['images'] = images
  parameters['files'] = JSON.stringify files
  parameters['main'] = main
  form = $('<form></form>')
  form.attr("method", "post")
  form.attr("action", "/listing")
  $.each parameters, (key, value) ->
    field = $('<input></input>');
    field.attr("type", "hidden");
    field.attr("name", key);
    field.attr("value", value);
    form.append(field);
    console.log key + '=>' + value
    return
  $(document.body).append form
  form.submit()
  return