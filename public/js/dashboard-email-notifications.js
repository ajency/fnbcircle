(function() {
  var emailRegex;

  emailRegex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

  if (typeof $.fn.tagsInput !== 'undefined') {
    $('.recipients').tagsInput({
      width: 'auto',
      pattern: emailRegex
    });
  }

  $('.tagsinput').addClass('no-edit');

  $('.edit_email_type').on('click', function() {
    var ta;
    $(this).closest('tr').find('textarea').removeClass('no-edit');
    $(this).closest('td').find('.edit-actions').removeClass('hidden');
    $('.edit_email_type').addClass('hidden');
    if (typeof autosize !== 'undefined') {
      ta = $('textarea');
      return autosize.update(ta);
    }
  });

  $('.save_email_type, .cancel_email_type').on('click', function() {
    $(this).closest('tr').find('textarea').addClass('no-edit');
    $(this).closest('td').find('.edit-actions').addClass('hidden');
    return $('.edit_email_type').removeClass('hidden');
  });

}).call(this);
