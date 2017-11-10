$('#password_form input[type=\'password\'][name=\'new_password\']').on 'focus, input', ->
  $('#password_form input[type=\'password\'][name=\'new_password_confirmation\']').val('')
  $('#password_save').prop('disabled',true)
  # console.log(validatePassword($(this).val(), $("#password_form input[type='password'][name='password_confirmation']").val()));
  if !validatePassword($(this).val(), $('#password_form input[type=\'password\'][name=\'new_password_confirmation\']').val(), '#password_form', '#password_errors')
    false
  else
    $('#password_form #password_errors').addClass 'hidden'
    true
$('#password_form input[type=\'password\'][name=\'new_password_confirmation\']').on 'focus, input', ->
  # console.log(validatePassword($(this).val(), $("#password_form input[type='password'][name='password_confirmation']").val()));
  if !validatePassword($('#password_form input[type=\'password\'][name=\'new_password\']').val(), $(this).val(), '#password_form', '#password_confirm_errors') or $(this).val().length == 0
    # $("#password_form #password_confirm_errors").removeClass("hidden").text("Password and Confirm password are not matching");
    false
    $('#password_save').prop('disabled',true)
  else
    $('#password_form #password_confirm_errors').addClass 'hidden'
    true
    $('#password_save').prop('disabled',false)


validatePassword = (password, confirm_password, parent_path, child_path) ->
  # Password should have 8 or more characters with atleast 1 lowercase, 1 UPPERCASE, 1 No or Special Chaaracter
  expression = /^(?=.*[0-9!@#$%^&*])(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z])(?!.*\s).{8,}$/
  message = ''
  status = true
  if expression.test(password)
    if confirm_password != '' and confirm_password == password
      # Confirm_password isn't empty & is Same
      status = true
    else if confirm_password == ''
      # Just validate Password
      status = true
    else
      # confirm_password != '' && password != confirm_password
      message = 'Password & Confirm Password are not matching'
      status = false
  else
    # Else password not Satisfied the criteria
    message = 'Please enter a password of minimum 8 characters and has atleast 1 lowercase, 1 UPPERCASE, and 1 Number or Special character'
    status = false
  if !status and parent_path != ''
    $(parent_path + ' ' + child_path).removeClass('hidden').text message
  else if status and parent_path != ''
    #$(parent_path + " " + child_path).addClass('hidden');
    $(parent_path + ' ' + '#password_errors').addClass 'hidden'
    $(parent_path + ' ' + '#password_confirm_errors').addClass 'hidden'
  status