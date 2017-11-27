(function() {
  $('.contact-info').on('change', '.contact-input', function(event) {
    var contacts, email, index, phone, value;
    contacts = document.getElementsByClassName('contact-input');
    email = $('input[name="primary_email_txt"]').val();
    phone = $('input[name="primary_phone_txt"]').val();
    index = 0;
    while (index < contacts.length) {
      value = contacts[index].value;
      console.log(value, email);
      if (value === email || value === phone) {
        $(this).closest('.contact-container').find('.dupError').html('Same contact detail has been added multiple times.');
        contacts[index].value = "";
      }
      ++index;
    }
  });

  $(document).on('blur', '.fnb-input', function() {
    $('#info-form').parsley();
  });

  $('body').on('click', '.removeRow', function() {
    return $(this).closest('.get-val').parent().remove();
  });

  $(document).on('click', '.business-type .radio', function() {
    if ($(this).is(':checked')) {
      $(this).parent().addClass('active');
      $(this).parent().siblings().removeClass('active');
    }
  });

  $(document).on('change', '.business-contact .toggle__check', function() {
    if ($(this).is(':checked')) {
      $(this).closest('.toggle').siblings('.toggle-state').text('Visible ');
    } else {
      $(this).closest('.toggle').siblings('.toggle-state').text('Not visible ');
    }
  });

  $(document).on('change', '.city select', function() {
    var city, html;
    html = '<option value="" selected>Select City </option>';
    $('.area select').html(html);
    city = $(this).val();
    if (city === '') {
      return;
    }
    return $.ajax({
      type: 'post',
      url: '/get_areas',
      data: {
        'city': city
      },
      success: function(data) {
        var key;
        for (key in data) {
          html += '<option value="' + data[key]['id'] + '">' + data[key]['name'] + '</option>';
        }
        $('.area select').html(html);
      },
      error: function(request, status, error) {
        throwError();
      }
    });
  });

}).call(this);
