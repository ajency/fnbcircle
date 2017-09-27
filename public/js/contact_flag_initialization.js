(function() {
  $(document).ready(function() {
    $("#register_form input[name='contact'], #requirement_form input[name='contact']").intlTelInput({

      /* --- Register form flag dropdown initialize --- */
      initialCountry: 'auto',
      separateDialCode: true,
      geoIpLookup: function(callback) {
        $.get('https://ipinfo.io', (function() {}), 'jsonp').always(function(resp) {
          var countryCode;
          countryCode = resp && resp.country ? resp.country : '';
          callback(countryCode);
        });
      },
      preferredCountries: ['IN'],
      americaMode: false,
      formatOnDisplay: false
    });
    $("#requirement_form .verify-container .contact-verify-link").on('click', function() {
      var parent;
      parent = "#requirement_form";
      if (!$(parent + " input[type='tel'][name='contact']").val()) {
        $(parent + " #contact-error").removeClass('hidden').text("Please enter a 10 digit contact number");
      }
    });
  });

}).call(this);
