$(document).ready () ->
	# $("#register_form #contact").intlTelInput
	$("#register_form input[name='contact'], #requirement_form input[name='contact']").intlTelInput
		### --- Register form flag dropdown initialize --- ###
		initialCountry: 'auto'
		# autoPlaceholder: "polite"
		separateDialCode: true ## Display the region code
		geoIpLookup: (callback) ->
			$.get('https://ipinfo.io', (->
			), 'jsonp').always (resp) ->
				countryCode = if resp and resp.country then resp.country else ''
				callback countryCode
				return
			return
		preferredCountries: [ 'IN' ]
		americaMode: false
		autoFormat: false
		formatOnDisplay:false

	$("#requirement_form .verify-container .contact-verify-link").on 'click', () ->
		parent = "#requirement_form"
		
		if(!$(parent + " input[type='tel'][name='contact']").val())
			$(parent + " #contact-error").removeClass('hidden').text "Please enter a 10 digit contact number"
		return
		
	$('#register_form').on 'countrychange', 'input[name="contact"]', (e, countryData)->
		### --- Assign the flag code to the hidden input --- ###
		$("#register_form input[type='hidden'][name='contact_locality']").val countryData.dialCode
		return
	return
