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
		console.log "clicking"
		if(!$(parent + " input[type='tel'][name='contact']").val())
			$(parent + " #contact-error").removeClass('hidden').text "Please enter a 10 digit contact number"
		return
		
	$('#register_form').on 'countrychange', 'input[name="contact"]', (e, countryData)->
		### --- Assign the flag code to the hidden input --- ###
		$("#register_form input[type='hidden'][name='contact_locality']").val countryData.dialCode
		return

	$(document).on 'countrychange', '#require-modal #requirement_form input[name="contact"]', (e, countryData)->
		### --- Assign the flag code to the hidden input --- ###
		#if $("#register_form input[type='hidden'][name='contact_country_code[]']").val().length <= 0
		### --- If the country code is not defined i.e. if User has not entered his/her contact number, then by default the requirement's Hidden calue has to be the flag value --- ###
		#	$("#register_form input[type='hidden'][name='contact_locality']").val countryData.dialCode
		$(document).find("#require-modal #requirement_form input[type='hidden'].contact-country-code").val countryData.dialCode
		return

	return