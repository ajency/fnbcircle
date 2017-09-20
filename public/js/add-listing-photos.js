(function() {
  var file_dropify, fileuploaders, image_dropify, uploadFile;

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
      'error': 'Ooops, something wrong happended.'
    }
  });

  file_dropify = $('.doc-upload').dropify({
    messages: {
      'default': 'Upload file',
      'replace': 'Replace file',
      'remove': '<i class="">&#10005;</i>',
      'error': 'Ooops, something wrong happended.'
    }
  });

  fileuploaders = 1;

  $('body').on('click', '.add-uploader', function(e) {
    var contact_group, contact_group_clone, getTarget, max;
    e.preventDefault();
    max = parseInt(document.head.querySelector('[property="max-file-upload"]').content);
    if (fileuploaders < max) {
      fileuploaders++;
      contact_group = $(this).closest('.fileUpload').find('.uppend-uploader');
      contact_group_clone = contact_group.clone();
      contact_group_clone.removeClass('uppend-uploader hidden');
      getTarget = $(this).closest('.fileUpload').find('.addCol');
      contact_group_clone.insertBefore(getTarget);
      console.log(contact_group_clone);
      return contact_group_clone.find('.doc-uploadd').dropify({
        messages: {
          'default': 'Upload file',
          'replace': 'Replace file',
          'remove': '<i class="">&#10005;</i>',
          'error': 'Ooops, something wrong happended.'
        }
      });
    } else {
      return console.log('max ' + max + ' allowed');
    }
  });

  $('body').on('click', '.removeCol', function(e) {
    e.preventDefault();
    fileuploaders--;
    return $(this).parent().remove();
  });

  uploadFile = function(element) {
    var container, file, formData, url, xhr;
    url = document.head.querySelector('[property="photo-upload-url"]').content;
    container = $(element).closest('.image-grid__cols');
    file = container.find('input[type="file"]');
    if (file[0].files.length > 0) {
      formData = new FormData;
      container.find(".image-loader").removeClass('hidden');
      formData.append('file', file[0].files[0]);
      formData.append('name', file[0].value);
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
            $(element).val('');
          }
        } else {

        }
      };
      return xhr.send(formData);
    } else {
      return console.log("Select a file");
    }
  };

  image_dropify.on('dropify.afterClear', function(event, element) {
    $(this).closest('.image-grid__cols').find('input[type="hidden"]').val("");
    console.log("file deleted");
  });

  $('input[type="file"]').on('change', function(e) {
    return uploadFile(this);
  });

}).call(this);
