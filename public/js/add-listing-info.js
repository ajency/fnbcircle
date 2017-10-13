(function() {
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
