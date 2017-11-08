(function() {
  var validatePassword;

  $('#password_form input[type=\'password\'][name=\'new_password\']').on('focus, input', function() {
    $('#password_form input[type=\'password\'][name=\'new_password_confirmation\']').val('');
    $('#password_save').prop('disabled', true);
    if (!validatePassword($(this).val(), $('#password_form input[type=\'password\'][name=\'new_password_confirmation\']').val(), '#password_form', '#password_errors')) {
      return false;
    } else {
      $('#password_form #password_errors').addClass('hidden');
      return true;
    }
  });

  $('#password_form input[type=\'password\'][name=\'new_password_confirmation\']').on('focus, input', function() {
    if (!validatePassword($('#password_form input[type=\'password\'][name=\'new_password\']').val(), $(this).val(), '#password_form', '#password_confirm_errors')) {
      false;
      return $('#password_save').prop('disabled', true);
    } else {
      $('#password_form #password_confirm_errors').addClass('hidden');
      true;
      return $('#password_save').prop('disabled', false);
    }
  });

  validatePassword = function(password, confirm_password, parent_path, child_path) {
    var expression, message, status;
    expression = /^(?=.*[0-9!@#$%^&*])(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z])(?!.*\s).{8,}$/;
    message = '';
    status = true;
    if (expression.test(password)) {
      if (confirm_password !== '' && confirm_password === password) {
        status = true;
      } else if (confirm_password === '') {
        status = true;
      } else {
        message = 'Password & Confirm Password are not matching';
        status = false;
      }
    } else {
      message = 'Please enter a password of minimum 8 characters and has atleast 1 lowercase, 1 UPPERCASE, and 1 Number or Special character';
      status = false;
    }
    if (!status && parent_path !== '') {
      $(parent_path + ' ' + child_path).removeClass('hidden').text(message);
    } else if (status && parent_path !== '') {
      $(parent_path + ' ' + '#password_errors').addClass('hidden');
      $(parent_path + ' ' + '#password_confirm_errors').addClass('hidden');
    }
    return status;
  };

}).call(this);
