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
      contact_group_clone.find('.doc-uploadd').dropify({
        messages: {
          'default': 'Upload file',
          'replace': 'Replace file',
          'remove': '<i class="">&#10005;</i>',
          'error': 'Ooops, something wrong happended.'
        }
      });
      return contact_group_clone.find('.doc-uploadd').prop('disabled', true);
    } else {
      return console.log('max ' + max + ' allowed');
    }
  });

  $('body').on('click', '.removeCol', function(e) {
    e.preventDefault();
    fileuploaders--;
    return $(this).parent().remove();
  });

  uploadFile = function(element, type) {
    var container, file, formData, url, xhr;
    if (type === 0) {
      url = document.head.querySelector('[property="photo-upload-url"]').content;
    } else {
      url = document.head.querySelector('[property="file-upload-url"]').content;
    }
    container = $(element).closest('.image-grid__cols');
    file = container.find('input[type="file"]');
    if (file[0].files.length > 0) {
      formData = new FormData;
      container.find(".image-loader").removeClass('hidden');
      formData.append('file', file[0].files[0]);
      if (type === 0) {
        formData.append('name', '');
      } else {
        formData.append('name', container.find('input.doc-name').val());
      }
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
            if (type === 1) {
              container.find('.doc-name').prop('disabled', true);
            }
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

  file_dropify.on('dropify.afterClear', function(event, element) {
    $(this).closest('.image-grid__cols').find('input[type="hidden"]').val("");
    $(this).closest('.image-grid__cols').find('.doc-name').val("");
    $(this).closest('.image-grid__cols').find('.doc-name').prop("disabled", false);
    console.log("file deleted");
  });

  $('body').on('change', '.imageUpload input[type="file"]', function(e) {
    return uploadFile(this, 0);
  });

  $('body').on('change', '.fileUpload input[type="file"]', function(e) {
    return uploadFile(this, 1);
  });

  $('input[type="file"].doc-upload').prop('disabled', true);

  $('body').on('keyup', '.doc-name', function() {
    if ($(this).val() === "") {
      $(this).closest('.image-grid__cols').find('input[type="file"]').prop('disabled', true);
      return $(this).closest('.image-grid__cols').find('input[type="file"]').attr('title', 'You cannot upload a file till you write a name');
    } else {
      $(this).closest('.image-grid__cols').find('input[type="file"]').prop('disabled', false);
      return $(this).closest('.image-grid__cols').find('input[type="file"]').removeAttr('title');
    }
  });

  window.validatePhotosDocuments = function() {
    var files, form, images, parameters;
    $('.section-loader').removeClass('hidden');
    images = [];
    files = {};
    $('.imageUpload input[type="hidden"]').each(function() {
      if ($(this).val() !== "") {
        return images.push($(this).val());
      }
    });
    $('.fileUpload input[type="hidden"]').each(function() {
      if ($(this).val() !== "") {
        return files[$(this).val()] = {
          "id": $(this).val(),
          "name": $(this).closest('.image-grid__cols').find('.doc-name').val()
        };
      }
    });
    parameters = {};
    parameters['listing_id'] = document.getElementById('listing_id').value;
    parameters['step'] = 'business-photos-documents';
    parameters['change'] = window.change;
    if (window.submit === 1) {
      parameters['submitReview'] = 'yes';
    }
    if (window.archive === 1) {
      parameters['archive'] = 'yes';
    }
    if (window.publish === 1) {
      parameters['publish'] = 'yes';
    }
    parameters['images'] = images;
    parameters['files'] = JSON.stringify(files);
    form = $('<form></form>');
    form.attr("method", "post");
    form.attr("action", "/listing");
    $.each(parameters, function(key, value) {
      var field;
      field = $('<input></input>');
      field.attr("type", "hidden");
      field.attr("name", key);
      field.attr("value", value);
      form.append(field);
      console.log(key + '=>' + value);
    });
    $(document.body).append(form);
    form.submit();
  };

}).call(this);
