
offset = 0
order = 0
ef= 0
image_dropify = undefined

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
      order = 0
      offset = 0;
      $('.update-display-section').html ''
      loadUpdates()
      newPost()



$('body').on 'click', '.add-uploader', (e)->
  max_uploads = document.head.querySelector('[property="max-file-upload"]').content
  current_uploads =$(this).closest('.fileUpload').find('input[type="file"]').length 
  console.log max_uploads,current_uploads
  if current_uploads > max_uploads 
    $('#more-file-error').html('Cannot upload more than '+max_uploads+' files')
    # alert('You can upload maximum of '+max_uploads+' photos')
    return
  e.preventDefault()
  console.log 'bxbvbbz'
  contact_group = $(this).closest('.fileUpload').find('.uppend-uploader')
  contact_group_clone = contact_group.clone()
  contact_group_clone.removeClass 'uppend-uploader hidden'
  getTarget = $(this).closest('.fileUpload').find('.addCol')
  # getTarget.insertBefore(contact_group_clone)
  contact_group_clone.insertBefore(getTarget)
  console.log(contact_group_clone)
  newimg = contact_group_clone.find('.doc-upload').dropify messages:
    'default': 'Add photo'
    'replace': 'Replace photo'
    'remove': '<i class="">&#10005;</i>'
    'error': ''
  newimg.on 'dropify.errors', (event, element) ->
    ef = 1
    setTimeout (->
      ef = 0
      return
    ), 2000
    return
  newimg.on 'dropify.afterClear', (event, element) ->
    $(this).closest('.image-grid__cols').find('input[type="hidden"]').val ""
    $(this).closest('.image-grid__cols').find('input[type="file"]').removeAttr('title');
    console.log "file deleted"
    return


$('body').on 'click', '.removeCol', (e)->
  e.preventDefault()
  $('#more-file-error').html('')
  $(this).parent().remove()


# $('body').on 'click', '.edit-updates', (e)->
#   e.preventDefault()
#   $(this).closest('.update-space').find('.edit-section').attr('contenteditable','true').addClass('editable')




loadUpdates = () ->
  $.ajax
    url :  document.head.querySelector('[property="get-posts-url"]').content
    type : 'get'
    data :
      'type' : 'listing'
      'id': document.getElementById('listing_id').value
      'offset' : offset
      'order': order
    success: (data) ->
      if data['status'] == '200'
        $('.update-display-section').find('.view-more-updates').remove()
        $('.update-display-section').find('.no-updates').remove()
        if data['data']['updates'].length != 0 
          offset+=data['data']['updates'].length
          html = ''
          $.each data['data']['updates'], (i, element) ->
            html += '<div class="update-sec sidebar-article">
                      <div class="update-sec__body update-space">
                        <div class="flex-row space-between">
                            <p class="element-title update-sec__heading m-t-15 bolder">
                                '+element.title+'
                            </p>
                              <div class="update-actions flex-row">
                                <i class="fa fa-pencil editUpdates text-primary" aria-hidden="true" data-toggle="modal" data-target="#edit-updates" title="Edit" data-update-id="'+element.id+'"></i>
                                <i class="fa fa-trash-o deleteUpdates delete-post" aria-hidden="true" title="Delete" data-delete-id="'+element.id+'"></i>
                              </div>
                          </div>
                         
                          <p class="update-sec__caption text-lighter">
                              '+element.contents+'
                          </p>
                          <ul class="flex-row update-img align-top flex-wrap post-gallery">'
            $.each element.images, (j,item) ->
              # console.log item
              html+='<li><a href="'+item['400X300']+'"><img src="'+item['200x150']+'" alt="" width="80" class="no-height"><div class="updates-img-col" style="background-image: url('+item['200x150']+');">
                                        </div></a></li>'
              return
                              
            html +=      '</ul>
                          <p class="m-b-0 posted-date text-secondary flex-row"><i class="fa fa-clock-o sub-title p-r-5" aria-hidden="true"></i> Posted '+element.updated+'</p>
                      </div>
                  </div>'
          $('.update-display-section').append(html)
          if data['data']['more'] == true 
            button = '<div class="m-t-10 text-center view-more-updates">
                            <a href="#" class="btn fnb-btn secondary-btn full border-btn default-size">+ View More</a>
                        </div>'
            $('.update-display-section').append(button)
          if $('.post-gallery').length
            $('.post-gallery').each ->
              $(this).magnificPopup
                delegate: 'a'
                type: 'image'
                gallery: enabled: true
                zoom:
                  enabled: true
                  duration: 300
        else
          nothing = '<div class="m-t-10 text-center text-primary no-post-updates">
                      No updates as of now! <i class="fa fa-frown-o p-l-5" aria-hidden="true"></i>
                      </div>'
          $('.update-display-section').append(nothing)

$('body').on 'change','select[name="update-sort"]',()->
  order = @value
  offset = 0;
  $('.update-display-section').html ''
  loadUpdates()

$('body').on 'click', '.view-more-updates a', (e) ->
  e.preventDefault()
  loadUpdates()

loadUpdates()


newPost = () ->
  html = '
  <div class="row">
        <div class="col-sm-12 form-group">
          <div class="flex-row space-between title-flex-row">
            <div class="title-icon">
              <label class="required">Title</label>
                    <input type="text" class="form-control fnb-input" placeholder="Give a title to your post" name="title" data-parsley-required>
                  </div>
                  <img src="/img/post-title-icon.png" class="img-responsive">
          </div>
        </div>
        <div class="col-sm-12 form-group c-gap">
          <label class="required">Give us some more details about your listing</label>
               <textarea type="text" rows="3" name="description" class="form-control fnb-textarea no-m-t allow-newline" placeholder="Describe the post here" data-parsley-required></textarea>
        </div>
        <div class="col-sm-12">
          <div class="image-grid imageUpload fileUpload post-uploads">
          <div class="image-grid__cols post-img-col" >
             <input type="file" class="list-image img-upload" data-height="100" data-max-file-size="3M" data-allowed-file-extensions="jpg png gif jpeg" />
             <input type="hidden" name="image-id" value="">
             <div class="image-loader hidden">
                        <div class="site-loader section-loader">
                              <div id="floatingBarsG">
                                  <div class="blockG" id="rotateG_01"></div>
                                  <div class="blockG" id="rotateG_02"></div>
                                  <div class="blockG" id="rotateG_03"></div>
                                  <div class="blockG" id="rotateG_04"></div>
                                  <div class="blockG" id="rotateG_05"></div>
                                  <div class="blockG" id="rotateG_06"></div>
                                  <div class="blockG" id="rotateG_07"></div>
                                  <div class="blockG" id="rotateG_08"></div>
                              </div>
                          </div>
                    </div>
          </div>
          <div class="image-grid__cols addCol">
                    <a href="#" class="add-uploader secondary-link text-decor">+Add more photos</a>
                </div>
                <div class="image-grid__cols uppend-uploader hidden">
                    <input type="file" class="list-image doc-upload" data-height="100" data-max-file-size="3M" data-allowed-file-extensions="jpg png gif jpeg" />
                        <input type="hidden" name="image-id" value="">
                    <div type="button" class="removeCol"><i class="">✕</i></div>
                    <div class="image-loader hidden">
                        <div class="site-loader section-loader">
                              <div id="floatingBarsG">
                                  <div class="blockG" id="rotateG_01"></div>
                                  <div class="blockG" id="rotateG_02"></div>
                                  <div class="blockG" id="rotateG_03"></div>
                                  <div class="blockG" id="rotateG_04"></div>
                                  <div class="blockG" id="rotateG_05"></div>
                                  <div class="blockG" id="rotateG_06"></div>
                                  <div class="blockG" id="rotateG_07"></div>
                                  <div class="blockG" id="rotateG_08"></div>
                              </div>
                          </div>
                    </div>
                </div>
        </div>
        <div id="more-file-error" class="text-danger"></div>
        </div>
        <div class="col-sm-12">
          <div class="text-right mobile-center post-action">
            <button class="btn fnb-btn primary-btn full border-btn post-btn" id="post-update-button" type="button">Post</button>
          </div>
        </div>
      </div>'
  $('.update-card').html html
  $('.dropify').dropify messages: 'default': 'Add Photo'
  image_dropify = $('.img-upload').dropify messages:
    'default': 'Add photo'
    'replace': 'Replace photo'
    'remove': '<i class="">&#10005;</i>'
    'error': ''
  image_dropify.on 'dropify.errors', (event, element) ->
    ef = 1
    setTimeout (->
      ef = 0
      return
    ), 2000
    return
  image_dropify.on 'dropify.afterClear', (event, element) ->
    $(this).closest('.image-grid__cols').find('input[type="hidden"]').val ""
    $(this).closest('.image-grid__cols').find('input[type="file"]').removeAttr('title');
    console.log "file deleted"
    return

newPost()

$('#edit-updates').on 'show.bs.modal', (e) ->
  id = $(e.relatedTarget).attr('data-update-id')
  $.ajax
    url :  document.head.querySelector('[property="get-single-post-url"]').content
    type : 'get'
    data :
      'type' : 'listing'
      'id': document.getElementById('listing_id').value
      'postID' : id
    success: (data)->
      console.log data['data']
      if data['status'] == '200'
        post = data['data']
        html =  '
          <div class="row ">
                    <input type="hidden" name="postID" value="'+post['id']+'">
                    <div class="col-sm-12 form-group">
                      <div class="flex-row space-between title-flex-row">
                        <div class="title-icon">
                          <label class="">Title</label>
                           <input type="text" class="form-control fnb-input form-update-data1" placeholder="" name="title" data-parsley-required>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-12 form-group c-gap">
                      <label class="">Give us some more details about your listing</label>
                        <textarea type="text" rows="3" name="description" class="form-control fnb-textarea form-update-data no-m-t allow-newline" placeholder="" data-parsley-required></textarea>
                    </div>
                    <div class="col-sm-12">
                      <div class="image-grid imageUpload fileUpload post-uploads modal-uploads">'
        # console.log Object.keys(post['images']).length
        if Object.keys(post['images']).length > 0
          for i of post['images']
            html+=      '<div class="image-grid__cols post-img-col" >
                         <input type="file" class="list-image img-modal-upload" data-height="100" data-max-file-size="3M" data-allowed-file-extensions="jpg png gif jpeg" data-default-file="'+post['images'][i]['200x150']+'" />
                         <input type="hidden" name="image-id" value="'+i+'">
                         <div class="image-loader hidden">
                            <div class="site-loader section-loader">
                                  <div id="floatingBarsG">
                                      <div class="blockG" id="rotateG_01"></div>
                                      <div class="blockG" id="rotateG_02"></div>
                                      <div class="blockG" id="rotateG_03"></div>
                                      <div class="blockG" id="rotateG_04"></div>
                                      <div class="blockG" id="rotateG_05"></div>
                                      <div class="blockG" id="rotateG_06"></div>
                                      <div class="blockG" id="rotateG_07"></div>
                                      <div class="blockG" id="rotateG_08"></div>
                                  </div>
                              </div>
                        </div>
                      </div>'
        else
          html+= '<div class="image-grid__cols post-img-col" >
                         <input type="file" class="list-image img-modal-upload" data-height="100" data-max-file-size="3M" data-allowed-file-extensions="jpg png gif jpeg"  />
                         <input type="hidden" name="image-id" value="">
                         <div class="image-loader hidden">
                            <div class="site-loader section-loader">
                                  <div id="floatingBarsG">
                                      <div class="blockG" id="rotateG_01"></div>
                                      <div class="blockG" id="rotateG_02"></div>
                                      <div class="blockG" id="rotateG_03"></div>
                                      <div class="blockG" id="rotateG_04"></div>
                                      <div class="blockG" id="rotateG_05"></div>
                                      <div class="blockG" id="rotateG_06"></div>
                                      <div class="blockG" id="rotateG_07"></div>
                                      <div class="blockG" id="rotateG_08"></div>
                                  </div>
                              </div>
                        </div>
                      </div>'
        html+=       '<div class="image-grid__cols addCol">
                                <a href="#" class="add-uploader secondary-link text-decor">+Add more photos</a>
                            </div>
                            <div class="image-grid__cols uppend-uploader hidden">
                                <input type="file" class="list-image doc-upload" data-height="100" data-max-file-size="3M" data-allowed-file-extensions="jpg png gif jpeg" />
                                    <input type="hidden" name="image-id" value="">
                                <div type="button" class="removeCol"><i class="">✕</i></div>
                                <div class="image-loader hidden">
                                    <div class="site-loader section-loader">
                                          <div id="floatingBarsG">
                                              <div class="blockG" id="rotateG_01"></div>
                                              <div class="blockG" id="rotateG_02"></div>
                                              <div class="blockG" id="rotateG_03"></div>
                                              <div class="blockG" id="rotateG_04"></div>
                                              <div class="blockG" id="rotateG_05"></div>
                                              <div class="blockG" id="rotateG_06"></div>
                                              <div class="blockG" id="rotateG_07"></div>
                                              <div class="blockG" id="rotateG_08"></div>
                                          </div>
                                      </div>
                                </div>
                            </div>
                    </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="text-center post-action m-t-20">
                        <button class="btn fnb-btn primary-btn full border-btn post-btn" id="edit-update-button" type="button">Update</button>
                      </div>
                    </div>
                    
                  </div>
        '
        $('#edit-updates .update-edit-modal').html html
        $('#edit-updates').find('input[name="title"]').val(post['title'])
        $('#edit-updates').find('textarea[name="description"]').val(post['content'])


        
        # if post['images'].length == 0
        newmodalimg = $('#edit-updates .img-modal-upload').dropify messages:
          'default': 'Add photo'
          'replace': 'Replace photo'
          'remove': '<i class="">&#10005;</i>'
          'error': ''
        newmodalimg.on 'dropify.errors', (event, element) ->
          ef = 1
          setTimeout (->
            ef = 0
            return
          ), 2000
          return
        newmodalimg.on 'dropify.afterClear', (event, element) ->
          $(this).closest('.image-grid__cols').find('input[type="hidden"]').val ""
          $(this).closest('.image-grid__cols').find('input[type="file"]').removeAttr('title');
          console.log "file deleted"
          return

  return

$('#edit-updates').on 'click','#edit-update-button',()->
  instance1 = $('#edit-updates .form-update-data1').parsley()
  instance = $('#edit-updates .form-update-data').parsley()
  if !instance1.validate()
    return false
  if !instance.validate()
    return false
  title = $('#edit-updates .form-update-data1').val()
  description = $('#edit-updates .form-update-data').val()
  id = $('#edit-updates input[type="hidden"]').val()
  images = []
  $('#edit-updates .imageUpload input[type="hidden"]').each ->
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
      'postID' : id
    success: () ->
      order = 0
      offset = 0;
      $('#edit-updates').modal('hide')
      $('#edit-updates .update-edit-modal').html ''
      $('.update-display-section').html ''
      loadUpdates()
      newPost()

$('body').on 'click','.delete-post', () ->
  if !confirm('Are you sure you want to delete this post?')
    return
  console.log "lllal"
  id = $(this).attr('data-delete-id')
  url = document.head.querySelector('[property="delete-post-url"]').content
  $.ajax
    type: 'post'
    url: url
    data: 
      'type':'listing'
      'id': document.getElementById('listing_id').value
      'postID' : id
    success: () ->
      offset = 0
      $('.update-display-section').html ''
      loadUpdates()

window.updateActions = () ->
  parameters = {}
  parameters['listing_id'] = document.getElementById('listing_id').value
  parameters['step'] = 'business-premium'
  if window.submit ==1
    parameters['submitReview'] = 'yes'
  if window.archive ==1
    parameters['archive'] = 'yes'
  if window.publish ==1
    parameters['publish'] = 'yes'
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

# Gallery magnify for individual group

# setTimeout (->
#   if $('.post-gallery').length
#     $('.post-gallery').each ->
#       $(this).magnificPopup
#         delegate: 'a'
#         type: 'image'
#         gallery: enabled: true
#         zoom:
#           enabled: true
#           duration: 300
#       return
# ), 500