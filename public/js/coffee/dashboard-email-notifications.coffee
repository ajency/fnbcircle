emailRegex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/
# Email address
if typeof $.fn.tagsInput != 'undefined'
  $('.recipients').tagsInput
    width: 'auto'
    pattern: emailRegex
# if (typeof autosize !== 'undefined') {
#   autosize($('textarea'));
# }
$('.tagsinput').addClass 'no-edit'
$('.edit_email_type').on 'click', ->
  $(this).closest('tr').find('.tagsinput').removeClass 'no-edit'
  $(this).closest('td').find('.edit-actions').removeClass 'hidden'
  $('.edit_email_type').addClass 'hidden'
  # if (typeof autosize !== 'undefined') {
  #   var ta = $('textarea');
  #   autosize.update(ta);
  # }

$('.save_email_type, .cancel_email_type').on 'click', ->
  $(this).closest('tr').find('.tagsinput').addClass 'no-edit'
  $(this).closest('td').find('.edit-actions').addClass 'hidden'
  $('.edit_email_type').removeClass 'hidden'
