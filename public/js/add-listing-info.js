(function() {
  window.checkDuplicates = function() {
    var contacts, index, index1, others, value;
    contacts = document.getElementsByClassName('contact-input');
    index = 0;
    while (index < contacts.length) {
      others = document.getElementsByClassName('contact-input');
      value = contacts[index].value;
      if (value !== '') {
        index1 = 0;
        while (index1 < others.length) {
          if (value === others[index1].value && index !== index1) {
            $(others[index1]).closest('.get-val').find('.dupError').html('Same contact detail has been added multiple times.');
            return true;
          } else {
            $(others[index1]).closest('.get-val').find('.dupError').html('');
          }
          ++index1;
        }
      }
      ++index;
    }
  };

  $(document).on('blur', '.fnb-input', function() {
    checkDuplicates();
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
      $(this).closest('.toggle').siblings('.toggle-state').text('Visible on the listing');
    } else {
      $(this).closest('.toggle').siblings('.toggle-state').text('Not visible on the listing');
    }
  });

  $(document).on('change', '.city select', function() {
    var city, html;
    html = '<option value="" selected>Select Area </option>';
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
