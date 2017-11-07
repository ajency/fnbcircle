emailRegex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/
# Email address
if typeof $.fn.tagsInput != 'undefined'
  $('.recipients').tagsInput
    width: 'auto'
    pattern: emailRegex
# if (typeof autosize !== 'undefined') {
#   autosize($('textarea'));
# }

prev_value = ''

$('.tagsinput').addClass 'no-edit'
$('.edit_email_type').on 'click', ->
  $(this).closest('tr').find('.tagsinput').removeClass 'no-edit'
  $(this).closest('td').find('.edit-actions').removeClass 'hidden'
  $('.edit_email_type').addClass 'hidden'
  prev_value = $(this).closest('tr').find('.email-input-field').val()
  # if (typeof autosize !== 'undefined') {
  #   var ta = $('textarea');
  #   autosize.update(ta);
  # }

$('.cancel_email_type').on 'click', ->
  $(this).closest('tr').find('.email-input-field').val(prev_value)
  $(this).closest('tr').find('.recipients').importTags(prev_value)


$('.save_email_type, .cancel_email_type').on 'click', ->
  $(this).closest('tr').find('.tagsinput').addClass 'no-edit'
  $(this).closest('td').find('.edit-actions').addClass 'hidden'
  $('.edit_email_type').removeClass 'hidden'


$('body').on 'click','.save-email-btn', () ->
  email_field = $(this).closest('.email-input-container').find('input.email-input-field')
  emails = email_field.val()
  type = email_field.attr('name')
  console.log emails, type
  if emails != prev_value
    $.ajax
      type:'post'
      url: url = document.head.querySelector('[property="notification-change-url"]').content
      data:
        type : type
        value : emails
      success: (data) ->
        # console.log data
        if data['status'] == '200'
          $('.alert-success #message').html "Recipients edited successfully."
          $('.alert-success').addClass 'active'
          setTimeout (->
            $('.alert-success').removeClass 'active'
            return
          ), 5000
        else
          $('.alert-failure #message').html "Some Error Occured. Please Reload"
          $('.alert-failure').addClass 'active'