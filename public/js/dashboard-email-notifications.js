(function() {
  var emailRegex, prev_value;

  emailRegex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

  if (typeof $.fn.tagsInput !== 'undefined') {
    $('.recipients').tagsInput({
      width: 'auto',
      pattern: emailRegex
    });
  }

  prev_value = '';

  $('.tagsinput').addClass('no-edit');

  $('.edit_email_type').on('click', function() {
    $(this).closest('tr').find('.tagsinput').removeClass('no-edit');
    $(this).closest('td').find('.edit-actions').removeClass('hidden');
    $('.edit_email_type').addClass('hidden');
    return prev_value = $(this).closest('tr').find('.email-input-field').val();
  });

  $('.cancel_email_type').on('click', function() {
    $(this).closest('tr').find('.email-input-field').val(prev_value);
    return $(this).closest('tr').find('.recipients').importTags(prev_value);
  });

  $('.save_email_type, .cancel_email_type').on('click', function() {
    $(this).closest('tr').find('.tagsinput').addClass('no-edit');
    $(this).closest('td').find('.edit-actions').addClass('hidden');
    return $('.edit_email_type').removeClass('hidden');
  });

  $('body').on('click', '.save-email-btn', function() {
    var email_field, emails, type, url;
    email_field = $(this).closest('.email-input-container').find('input.email-input-field');
    emails = email_field.val();
    type = email_field.attr('name');
    console.log(emails, type);
    if (emails !== prev_value) {
      return $.ajax({
        type: 'post',
        url: url = document.head.querySelector('[property="notification-change-url"]').content,
        data: {
          type: type,
          value: emails
        },
        success: function(data) {
          if (data['status'] === '200') {
            $('.alert-success #message').html("Recipients edited successfully.");
            $('.alert-success').addClass('active');
            return setTimeout((function() {
              $('.alert-success').removeClass('active');
            }), 5000);
          } else {
            $('.alert-failure #message').html("Some Error Occured. Please Reload");
            return $('.alert-failure').addClass('active');
          }
        }
      });
    }
  });

}).call(this);
