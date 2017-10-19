capitalize = (string) ->
	return string.charAt(0).toUpperCase() + string.slice(1)

getFilters = (enquiry_no = 'step_1', listing_slug) ->
	data = {}

	if enquiry_no == 'step_1'
		descr_values = []
		$.each $(".level-one #level-one-enquiry input[name='description[]']:checked"), ->
			descr_values.push $(this).val()
			return

		data =
			name: $(".level-one #level-one-enquiry input[name='name']").val()
			email: $(".level-one #level-one-enquiry input[name='email']").val()
			contact: $(".level-one #level-one-enquiry input[name='contact']").val()
			description: descr_values
			enquiry_message: $(".level-one #level-one-enquiry #lookingfor input[name='enquiry_message']").val()
			enquiry_level: enquiry_no
			listing_slug: listing_slug

	### --- Step -2 & 3 are not added under this as the flow is different for Premium & Non-Premium --- ###
	
	return data

getContent = (enquiry_level, listing_slug) ->
	$.ajax
		type: 'post'
		url: '/api/send_enquiry'
		data: getFilters(enquiry_level, listing_slug)
		dataType: 'json'
		success: (data) ->
			# console.log data["popup_template"]
			if data["popup_template"].length > 0
				$(document).find(".single-view-head #updateTemplate #enquiry-modal #listing_popup_fill").html data["popup_template"]
				$(document).find("div.single-view-head div.container #enquiry-modal").modal 'show'
		error: (request, status, error) ->
			#$("div.single-view-head div.container #enquiry-modal").modal 'show'
			console.log error
	return

getTemplate = (modal_template, listing_slug = '') ->

	data = 
		'enquiry_level': modal_template
		'listing_slug': listing_slug

	$.ajax
		type: 'post'
		url: '/api/get_enquiry_template'
		data: data
		dataType: 'json'
		success: (data)->
			if data["modal_template"].length > 0
				$(document).find(".single-view-head #updateTemplate #enquiry-modal #listing_popup_fill").html data["modal_template"]
				$(document).find("div.single-view-head div.container #enquiry-modal").modal 'show'
		error: (request, status, error) ->
			## -- Show the enquiry content -- ##
			$("div.single-view-head div.container #enquiry-modal").modal 'show'
			console.log error
	return

getVerification = (enquiry_level, listing_slug = '', regenerate = false) ->
# getVerification = (enquiry_level, listing_slug, regenerate = false, enquiry_fail_level = '') ->
	console.log "get verified"
	data = 
		'enquiry_level': enquiry_level
		# 'enquiry_fail_level': enquiry_fail_level
		'listing_slug': listing_slug
		'contact': $("#enquiry-modal #listing_popup_fill div.verification__row span.mobile").text().replace(/ /g,"")
		'otp': $("#enquiry-modal #listing_popup_fill div.verification__row #code_otp").val()
		'regenerate': regenerate

	$.ajax
		type: 'post'
		url: '/api/verify_enquiry_otp'
		data: 
			data
		dataType: 'json'
		success: (data) ->
			if data["popup_template"].length > 0
				$(document).find(".single-view-head #updateTemplate #enquiry-modal #listing_popup_fill").html data["popup_template"]
				$(document).find("div.single-view-head div.container #enquiry-modal").modal 'show'
		error: (request, status, error) ->
			#$("div.single-view-head div.container #enquiry-modal").modal 'show'
			console.log error
	return

getCookie = (key) ->
	value = ''
	if document.cookie.length > 0 and document.cookie.indexOf(key) > -1
		cookies = document.cookie.split('; ')
		i = 0
		while i < cookies.length
			if cookies[i].indexOf(key) > -1
				value = cookies[i].split('=')[1]
				break
			i++
	return value

getArea = (city, parent) ->
	html = ''#'<option value="">Area</option>'

	$.ajax
		type: 'post'
		url: '/get_areas'
		data: 'city': city
		success: (data) ->
			key = undefined
			for key of data
				key = key
				html += '<option value="' + data[key]['id'] + '">' + data[key]['name'] + '</option>'

			$('#' + parent + ' select[name="area"]').html html
			return
		error: (request, status, error) ->
			throw Error()
			return
	return


$(document).ready () ->
	### --- This object is used to store old values -> Mainly for search-boxes --- ###
	old_values = {}

	### --- Display respective Popups on "Send Enquiry click" --- ###
	if $("#enquiry-modal").length > 0
		$(document).on "click", ".single-view-head div.col-sm-4 div.equal-col div.contact__enquiry button.fnb-btn.primary-btn", () ->
			if getCookie('user_id').length > 0
				if getCookie('user_type') == "user"
					# If user has account on website
					$("#login-modal").modal 'show' # show login popup
				else
					# If type exist & is not "user", then Show Popup
					getTemplate('step_1', $(".single-view-head #enquiry_slug").val())
					#$("div.single-view-head div.container #enquiry-modal").modal 'show'
			else
				# Else User is Enquiring 1st time, hence the Popup
				$("div.single-view-head div.container #enquiry-modal").modal 'show'
			return

		### --- On click of "Send Enquiry 1" button --- ###
		$(document).on "click", "#level-one-enquiry #level-one-form-btn", () ->
			page_level = if ($(this).data('value') and $(this).data('value').length > 0) then $(this).data('value') else 'step_1'
			if $(document).find("#level-one-enquiry").parsley().validate()
				getContent(page_level, $(".single-view-head #enquiry_slug").val())
				console.log "true"
			else
				console.log "forms not complete"
			
			console.log "exist"
			return


		### --- On click of OTP submit button --- ###
		$(document).on "click", "#level-two-enquiry #level-two-form-btn", () ->
			console.log "OTP submit"
			getVerification($(this).data('value'), $(".single-view-head #enquiry_slug").val(), false)
			return

		### --- On click of OTP regenerate button --- ###
		$(document).on "click", "#level-two-enquiry #level-two-resend-btn", () ->
			getVerification($(this).data('value'), $(".single-view-head #enquiry_slug").val(), true)
			return

		$(document).on "change", "#level-three-enquiry #area_section select[name='city']", () ->
			console.log $(this).val()
			getArea($(this).val(), "area_section")
			return

	return