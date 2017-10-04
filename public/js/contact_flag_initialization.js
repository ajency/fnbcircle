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
      autoFormat: false,
      formatOnDisplay: false
    });
    $("#requirement_form .verify-container .contact-verify-link").on('click', function() {
      var parent;
      parent = "#requirement_form";
      if (!$(parent + " input[type='tel'][name='contact']").val()) {
        $(parent + " #contact-error").removeClass('hidden').text("Please enter a 10 digit contact number");
      }
    });
    $('#register_form').on('countrychange', 'input[name="contact"]', function(e, countryData) {

      /* --- Assign the flag code to the hidden input --- */
      $("#register_form input[type='hidden'][name='contact_locality']").val(countryData.dialCode);
    });
    $('#require-modal #requirement_form').on('countrychange', 'input[name="contact"]', function(e, countryData) {

      /* --- Assign the flag code to the hidden input --- */

      /* --- If the country code is not defined i.e. if User has not entered his/her contact number, then by default the requirement's Hidden calue has to be the flag value --- */
      $("#register_form input[type='hidden'][name='contact_locality']").val(countryData.dialCode);
    });
  });

}).call(this);
