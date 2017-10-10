(function() {
  var ef, image_dropify, uploadFile;

  $('.dropify').dropify({
    messages: {
      'default': 'Add Photo'
    }
  });

  image_dropify = $('.list-image').dropify({
    messages: {
      'default': 'Add photo',
      'replace': 'Replace photo',
      'remove': '<i class="">&#10005;</i>',
      'error': ''
    }
  });

  ef = 0;

  image_dropify.on('dropify.errors', function(event, element) {
    ef = 1;
    setTimeout((function() {
      ef = 0;
    }), 2000);
  });

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

  image_dropify.on('dropify.afterClear', function(event, element) {
    $(this).closest('.image-grid__cols').find('input[type="hidden"]').val("");
    $(this).closest('.image-grid__cols').find('input[type="file"]').removeAttr('title');
    console.log("file deleted");
  });

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

}).call(this);
