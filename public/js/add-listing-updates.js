(function() {
  var ef, image_dropify, loadUpdates, newPost, offset, order, uploadFile;

  offset = 0;

  order = 0;

  ef = 0;

  image_dropify = void 0;

  uploadFile = function(container) {
    var file, formData, url, xhr;
    url = document.head.querySelector('[property="photo-upload-url"]').content;
    file = container.find('input[type="file"]');
    if (file[0].files.length > 0) {
      formData = new FormData;
      container.find(".image-loader").removeClass('hidden');
      formData.append('file', file[0].files[0]);
      formData.append('name', '');
      formData.append('listing_id', document.getElementById('listing_id').value);
      xhr = new XMLHttpRequest;
      xhr.open('POST', url);
      xhr.onreadystatechange = function() {
        var data;
        if (this.readyState === 4 && this.status === 200) {
          data = JSON.parse(this.responseText);
          if (data['status'] === "200") {
            container.find('input[type="hidden"]').val(data['data']['id']);
            container.find(".image-loader").addClass('hidden');
          } else {
            $container.find('input[type="file"]').val('');
            container.find(".image-loader").addClass('hidden');
            $('.fnb-alert.alert-failure div.flex-row').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i><div>Oh snap! Some error occurred. Please check your internet connection and retry</div>');
            $('.alert-failure').addClass('active');
            setTimeout((function() {
              $('.alert-failure').removeClass('active');
            }), 6000);
          }
        } else {

        }
      };
      xhr.send(formData);
    } else {

    }
    return console.log("Select a file");
  };

  $('body').on('change', '.imageUpload input[type="file"]', function(e) {
    var container;
    console.log('abcx');
    container = $(this).closest('.image-grid__cols');
    return setTimeout((function() {
      if (ef === 0) {
        uploadFile(container);
      }
    }), 250);
  });

  $('.dropify-wrapper.touch-fallback .dropify-clear i').text('Remove photo');

  $('body').on('click', '#post-update-button', function() {
    var description, images, instance, title, url;
    instance = $('#info-form').parsley();
    if (!instance.validate()) {
      return false;
    }
    title = $('input[type="text"][name="title"]').val();
    description = $('textarea[name="description"]').val();
    images = [];
    $('.imageUpload input[type="hidden"]').each(function() {
      if ($(this).val() !== '') {
        return images.push($(this).val());
      }
    });
    console.log(title, description, images);
    url = document.head.querySelector('[property="post-upload-url"]').content;
    return $.ajax({
      type: 'post',
      url: url,
      data: {
        'photos': images,
        'title': title,
        'description': description,
        'type': 'listing',
        'id': document.getElementById('listing_id').value
      },
      success: function() {
        order = 0;
        offset = 0;
        $('.update-display-section').html('');
        loadUpdates();
        return newPost();
      }
    });
  });

  $('body').on('click', '.add-uploader', function(e) {
    var contact_group, contact_group_clone, getTarget, newimg;
    e.preventDefault();
    contact_group = $(this).closest('.fileUpload').find('.uppend-uploader');
    contact_group_clone = contact_group.clone();
    contact_group_clone.removeClass('uppend-uploader hidden');
    getTarget = $(this).closest('.fileUpload').find('.addCol');
    contact_group_clone.insertBefore(getTarget);
    console.log(contact_group_clone);
    newimg = contact_group_clone.find('.doc-upload').dropify({
      messages: {
        'default': 'Add photo',
        'replace': 'Replace photo',
        'remove': '<i class="">&#10005;</i>',
        'error': ''
      }
    });
    newimg.on('dropify.errors', function(event, element) {
      ef = 1;
      setTimeout((function() {
        ef = 0;
      }), 2000);
    });
    return newimg.on('dropify.afterClear', function(event, element) {
      $(this).closest('.image-grid__cols').find('input[type="hidden"]').val("");
      $(this).closest('.image-grid__cols').find('input[type="file"]').removeAttr('title');
      console.log("file deleted");
    });
  });

  $('body').on('click', '.removeCol', function(e) {
    e.preventDefault();
    return $(this).parent().remove();
  });

  $('body').on('click', '.edit-updates', function(e) {
    e.preventDefault();
    return $(this).closest('.update-space').find('.edit-section').attr('contenteditable', 'true').addClass('editable');
  });

  loadUpdates = function() {
    return $.ajax({
      url: document.head.querySelector('[property="get-posts-url"]').content,
      type: 'get',
      data: {
        'type': 'listing',
        'id': document.getElementById('listing_id').value,
        'offset': offset,
        'order': order
      },
      success: function(data) {
        var button, html;
        if (data['status'] === '200') {
          $('.update-display-section').find('.view-more-updates').remove();
          if (data['data']['updates'].length !== 0) {
            offset += data['data']['updates'].length;
            html = '';
            $.each(data['data']['updates'], function(i, element) {
              html += '<div class="update-sec sidebar-article"> <div class="update-sec__body update-space"> <div class="flex-row space-between"> <p class="element-title update-sec__heading m-t-15 bolder">' + element.title + '</p> <div class="update-actions"> <i class="fa fa-pencil editUpdates text-primary" aria-hidden="true" data-toggle="modal" data-target="#edit-updates" edit="Edit"></i> <i class="fa fa-trash-o deleteUpdates text-danger" aria-hidden="true" title="Delete"></i> </div> </div> <p class="update-sec__caption text-lighter">' + element.contents + '</p> <ul class="flex-row update-img">';
              $.each(element.images, function(j, item) {
                html += '<li><img src="' + item['200x150'] + '" alt="" width="80"></li>';
              });
              return html += '</ul> <p class="m-b-0 posted-date text-secondary flex-row"><i class="fa fa-clock-o sub-title p-r-5" aria-hidden="true"></i> Posted on ' + element.updated + '</p> </div> </div>';
            });
            $('.update-display-section').append(html);
            if (data['data']['updates'].length === 5) {
              button = '<div class="m-t-10 text-center view-more-updates"> <a href="#" class="btn fnb-btn secondary-btn full border-btn default-size">+ View More</a> </div>';
              return $('.update-display-section').append(button);
            }
          }
        }
      }
    });
  };

  $('body').on('change', 'select[name="update-sort"]', function() {
    order = this.value;
    offset = 0;
    $('.update-display-section').html('');
    return loadUpdates();
  });

  $('body').on('click', '.view-more-updates a', function(e) {
    e.preventDefault();
    return loadUpdates();
  });

  loadUpdates();

  newPost = function() {
    var html;
    html = '<div class="row"> <div class="col-sm-12 form-group"> <div class="flex-row space-between title-flex-row"> <div class="title-icon"> <label class="required">Title</label> <input type="text" class="form-control fnb-input" placeholder="Give a title to your post" name="title" data-parsley-required> </div> <img src="/img/post-title-icon.png" class="img-responsive"> </div> </div> <div class="col-sm-12 form-group c-gap"> <label class="required">Give us some more details about your listing</label> <textarea type="text" rows="2" name="description" class="form-control fnb-textarea no-m-t allow-newline" placeholder="Describe the post here" data-parsley-required></textarea> </div> <div class="col-sm-12"> <div class="image-grid imageUpload fileUpload post-uploads"> <div class="image-grid__cols post-img-col" > <input type="file" class="list-image img-upload" data-height="100" data-max-file-size="3M" data-allowed-file-extensions="jpg png gif jpeg" /> <input type="hidden" name="image-id" value=""> <div class="image-loader hidden"> <div class="site-loader section-loader"> <div id="floatingBarsG"> <div class="blockG" id="rotateG_01"></div> <div class="blockG" id="rotateG_02"></div> <div class="blockG" id="rotateG_03"></div> <div class="blockG" id="rotateG_04"></div> <div class="blockG" id="rotateG_05"></div> <div class="blockG" id="rotateG_06"></div> <div class="blockG" id="rotateG_07"></div> <div class="blockG" id="rotateG_08"></div> </div> </div> </div> </div> <div class="image-grid__cols addCol"> <a href="#" class="add-uploader secondary-link text-decor">+Add more files</a> </div> <div class="image-grid__cols uppend-uploader hidden"> <input type="file" class="list-image doc-upload" data-height="100" data-max-file-size="3M" data-allowed-file-extensions="jpg png gif jpeg" /> <input type="hidden" name="image-id" value=""> <div type="button" class="removeCol"><i class="">✕</i></div> <div class="image-loader hidden"> <div class="site-loader section-loader"> <div id="floatingBarsG"> <div class="blockG" id="rotateG_01"></div> <div class="blockG" id="rotateG_02"></div> <div class="blockG" id="rotateG_03"></div> <div class="blockG" id="rotateG_04"></div> <div class="blockG" id="rotateG_05"></div> <div class="blockG" id="rotateG_06"></div> <div class="blockG" id="rotateG_07"></div> <div class="blockG" id="rotateG_08"></div> </div> </div> </div> </div> </div> </div> <div class="col-sm-12"> <div class="text-right mobile-center post-action"> <button class="btn fnb-btn primary-btn full border-btn post-btn" id="post-update-button" type="button">Post</button> </div> </div> </div>';
    $('.update-card').html(html);
    $('.dropify').dropify({
      messages: {
        'default': 'Add Photo'
      }
    });
    image_dropify = $('.img-upload').dropify({
      messages: {
        'default': 'Add photo',
        'replace': 'Replace photo',
        'remove': '<i class="">&#10005;</i>',
        'error': ''
      }
    });
    image_dropify.on('dropify.errors', function(event, element) {
      ef = 1;
      setTimeout((function() {
        ef = 0;
      }), 2000);
    });
    return image_dropify.on('dropify.afterClear', function(event, element) {
      $(this).closest('.image-grid__cols').find('input[type="hidden"]').val("");
      $(this).closest('.image-grid__cols').find('input[type="file"]').removeAttr('title');
      console.log("file deleted");
    });
  };

  newPost();

}).call(this);
