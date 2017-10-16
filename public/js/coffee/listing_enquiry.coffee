capitalize = (string) ->
	return string.charAt(0).toUpperCase() + string.slice(1)

getFilters = () ->
	return

getContent = () ->
	data = 
		"name": "asdads"#$("#enquiry-modal")
		"email": "asdasd"
	# console.log getFilters()

	$.ajax
		type: 'post'
		url: '/api/get-listview-data'
		data: data
		dataType: 'json'
		success: (data) ->
			
		error: (request, status, error) ->
			#$("div.single-view-head div.container #enquiry-modal").modal 'show'
			console.log error
	return

getTemplate = (modal_template, listing_slug = '') ->

	data = 
		'template': modal_template
		'listing_slug': listing_slug

	$.ajax
		type: 'post'
		url: '/api/get_enquiry_template'
		data: data
		dataType: 'json'
		success: (data)->
			$(document).find(".single-view-head #updateTemplate").html data["modal_template"]
			$(document).find("div.single-view-head div.container #enquiry-modal").modal 'show'
		error: (request, status, error) ->
			## -- Show the enquiry content -- ##
			$("div.single-view-head div.container #enquiry-modal").modal 'show'
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
					getTemplate('enquiry_template_one', $(".single-view-head #enquiry_slug").val())
					#$("div.single-view-head div.container #enquiry-modal").modal 'show'
			else
				# Else User is Enquiring 1st time, hence the Popup
				$("div.single-view-head div.container #enquiry-modal").modal 'show'
			return

		$(document).on "click", "#level-one-enquiry #level-one-form-btn", () ->
			if $(document).find("#level-one-enquiry").parsley().validate()
				console.log "true"
			else
				console.log "forms not complete"
			return

			console.log "exist"
		return

	return