emailRegex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/
# Email address
if typeof $.fn.tagsInput != 'undefined'
  $('.recipients').tagsInput
    width: 'auto'
    pattern: emailRegex
# if (typeof autosize !== 'undefined') {
# 	autosize($('textarea'));
# }
$('.tagsinput').addClass 'no-edit'
$('.edit_email_type').on 'click', ->
  $(this).closest('tr').find('textarea').removeClass 'no-edit'
  $(this).closest('td').find('.edit-actions').removeClass 'hidden'
  $('.edit_email_type').addClass 'hidden'
  if typeof autosize != 'undefined'
    ta = $('textarea')
    autosize.update ta

$('.save_email_type, .cancel_email_type').on 'click', ->
  $(this).closest('tr').find('textarea').addClass 'no-edit'
  $(this).closest('td').find('.edit-actions').addClass 'hidden'
  $('.edit_email_type').removeClass 'hidden'

$('body').on 'click','.save-email-btn', () ->
	email_field = $(this).closest('.email-input-container').find('input.email-input-field')
	emails = email_field.val()
	type = email_field.attr('name')
	console.log emails, type