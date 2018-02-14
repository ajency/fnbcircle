modal_popup_id = ""

capitalize = (string) ->
	return string.charAt(0).toUpperCase() + string.slice(1)

### --- Get the value formatted to milliseconds --- ###
getMilliSeconds = (time = {}) ->
	if(time.hasOwnProperty('value') and time.hasOwnProperty('unit'))
		if time['unit'].indexOf('second') >= 0 # Second
			millisecond_value = (parseInt(time['value']) * 1000)
		else if time['unit'].indexOf('minute') >= 0 # Minute
			millisecond_value = (parseInt(time['value']) * 60 * 1000)
		else if time['unit'].indexOf('hour') >= 0 # Hour
			millisecond_value = (parseInt(time['value']) * 60 * 60 * 1000)
		else if time['unit'].indexOf('day') >= 0 # Day
			millisecond_value = (parseInt(time['value']) * 24 * 60 * 60 * 1000)
		else # Set Default
			millisecond_value = (24 * 60 * 60 * 1000) # Default, set the time to 24 hour
	else # Set Default
		millisecond_value = 0 # Default, get current time
	return millisecond_value

### --- Get filters for the Enquiry Modal --- ###
getFilters = (modal_id, enquiry_no = 'step_1', listing_slug) ->
	data = {}

	if enquiry_no == 'step_1'
		descr_values = []

		if $(modal_id + " .level-one #level-one-enquiry select[name='description']").length > 0
			descr_values = $(modal_id + " .level-one #level-one-enquiry select[name='description']").val()
		else	
			$.each $(modal_id + " .level-one #level-one-enquiry input[name='description[]']:checked"), ->
				descr_values.push $(this).val()
				return

		data =
			name: $(modal_id + " .level-one #level-one-enquiry input[name='name']").val()
			email: $(modal_id + " .level-one #level-one-enquiry input[name='email']").val()
			contact_locality: $(modal_id + " .level-one #level-one-enquiry input[name='contact']").intlTelInput("getSelectedCountryData").dialCode
			contact: $(modal_id + " .level-one #level-one-enquiry input[name='contact']").val()
			description: descr_values
			enquiry_message: $(modal_id + " .level-one #level-one-enquiry #lookingfor input[name='enquiry_message']").val()
			enquiry_level: enquiry_no
			listing_slug: listing_slug
			news_letter:  $(modal_id + " .level-one #level-one-enquiry input[name='news-letter-subscribe']").prop('checked')

	else if enquiry_no == 'step_2' or enquiry_no == 'step_3'
		descr_values = []
		areas = []
		cities = []
		
		$.each $(modal_id + " #level-three-enquiry input[name='categories_interested[]']:checked"), ->
			descr_values.push $(this).val()
			return

		# $.each $("#level-three-enquiry select[name='area[]']:checked"), ->
		# 	areas.push $(this).val()
		# 	return
		$(modal_id + " #level-three-enquiry select[name='city']").each ->
			cities.push $(this).val()
			return
		$(modal_id + " #level-three-enquiry select[name='area']").each ->
			areas = areas.concat $(this).val()
			return

		data =
			name: $(modal_id + " #level-three-enquiry #enquiry_name").text()
			email: $(modal_id + " #level-three-enquiry #enquiry_email").text()
			contact: $(modal_id + " #level-three-enquiry #enquiry_contact").text()
			categories_interested: descr_values
			city: cities
			area: areas
			enquiry_level: enquiry_no
			listing_slug: listing_slug

	if modal_id == "#multi-quote-enquiry-modal"
		data["multi-quote"] = true

	return data

### --- Send the data of an enquiry --- ###
getContent = (modal_id, enquiry_level, listing_slug, trigger_modal, target_modal_id) ->
	data = getFilters(modal_id, enquiry_level, listing_slug)

	if (modal_id == "#multi-quote-enquiry-modal") or (trigger_modal and target_modal_id == "#multi-quote-enquiry-modal")
		data["multi-quote"] = true
		if $("#listing_filter_view").length
			data['category'] = $(document).find("#listing_filter_view #current_category").val().split("|")[0]
			areas = []

			$(document).find("#listing_filter_view #section-area input[type='checkbox']:checked").each ->
				areas = areas.concat $(this).val()
				return
			
			data['areas'] = areas
			if $(document).find(".search-section .city.search-boxes input[name='city']") and $(document).find(".search-section .city.search-boxes input[name='city']").length > 0
				data['cities'] = $(document).find(".search-section .city.search-boxes input[name='city']").val()
	
	$.ajax
		type: 'post'
		url: '/api/send_enquiry'
		data: data
		dataType: 'json'
		async: false
		success: (data) ->
			if modal_id == "#enquiry-modal" and data.hasOwnProperty("display_full_screen") and data["display_full_screen"]
				$("#enquiry-modal .modal-content .modal-body .col-left.enquiry-details__intro").addClass "hidden"
			else
				$("#enquiry-modal .modal-content .modal-body .col-left.enquiry-details__intro").removeClass "hidden"

			if data["popup_template"].length > 0
				### --- if trigger_modal == true --- ###
				if trigger_modal
					if target_modal_id
						### --- If target_modal_id is passed, then ---###
						$(document).find(target_modal_id + " #listing_popup_fill").html data["popup_template"]
						$(document).find(target_modal_id).modal 'show'
						if $(target_modal_id + " #level-three-enquiry").length > 0
							# initCatSearchBox()
							multiSelectInit(target_modal_id + " #level-three-enquiry #area_section #area_operations", "", false)
					else
						### --- Else trigger default modal ID ---###
						$(document).find(modal_id).modal 'show'
				else
					$(document).find(modal_id + " #listing_popup_fill").html data["popup_template"]

				if modal_id == "#rhs-enquiry-form"
					if $("#enquiry-modal" + " #level-one-enquiry")
						initFlagDrop("#enquiry-modal" + " #level-one-enquiry input[name='contact']")
				else
					if $(modal_id + " #level-one-enquiry")
						initFlagDrop(modal_id + " #level-one-enquiry input[name='contact']")

				if $(modal_id + " #level-three-enquiry").length > 0
					# initCatSearchBox()
					multiSelectInit(modal_id + " #level-three-enquiry #area_section #area_operations", "", false)
					# multiSelectInit(modal_id + " #level-three-enquiry", "", false)
					return
		error: (request, status, error) ->
			if request.status == 403 # user account exist
				if getCookie('user_id').length > 0
					if getCookie('user_type') == "user"
						# If user has account on website
						$("#login-modal").modal 'show' # show login popup
						## -- Update the Email ID -- ##
						$("#login-modal #login_form_modal input[name='email']").val $(modal_id + " .level-one #level-one-enquiry input[name='email']").val()

						## -- Hide the Enquiry modal -- ##
						if trigger_modal
							$(document).find(target_modal_id).modal 'hide'
						else
							$(document).find(modal_id).modal 'hide'
			#$("#multi-quote-enquiry-modal").modal 'show'
			$(modal_id + " button").find("i.fa-circle-o-notch").addClass "hidden" # Hide all the circle (load button) if the AJAX failed
			$(modal_id + " button").removeAttr "disabled" # Enable the button if the AJAX failed
			console.log error
	return

### --- Validate contact number --- ###
validateContact = (contact, error_path, region_code) -> # Check if Contact Number entered is Valid
	contact = contact.replace(/\s/g, '').replace(/-/g,'') # Remove all the <spaces> & '-' 

	if((contact.indexOf("+") == 0 or not region_code) and (not isNaN(contact.substring(1, contact.length))))
		if (region_code)
			contact_sub = contact.substring(1, contact.length) # Exclude the +
		else
			contact_sub = contact # only the contact no

		if((not region_code and contact_sub.length <= 0) or (region_code and contact_sub.length <= 2)) # if contact no is defined
			$(error_path).removeClass("hidden").text("Please enter your contact number")
		else if(contact_sub.length < 10) # Number too short
			$(error_path).removeClass("hidden").text("Contact number too short")
		else if((region_code and contact_sub.length > 13) or ((not region_code) and contact_sub.length > 10)) # If excluding <region_code> & length is greater than 10, then
			$(error_path).removeClass("hidden").text("Contact number too long")
		else # Valid contact
			$(error_path).addClass("hidden") # hide the error message
			return true
	else # Invalid contact number
		$(error_path).removeClass("hidden").text("Please enter a valid Contact number")
	return false

### --- Request template for a modal --- ###
getTemplate = (modal_id, modal_template, listing_slug = '') ->
	data = 
		'enquiry_level': modal_template
	if listing_slug
		data['listing_slug'] = listing_slug

	if modal_id == "#multi-quote-enquiry-modal"
		data['multi-quote'] = true

	$.ajax
		type: 'post'
		url: '/api/get_enquiry_template'
		data: data
		async: false
		dataType: 'json'
		success: (data)->
			if modal_id == "#enquiry-modal" and data.hasOwnProperty("display_full_screen") and data["display_full_screen"]
				$("#enquiry-modal .modal-content .modal-body .col-left.enquiry-details__intro").addClass "hidden"
			else
				$("#enquiry-modal .modal-content .modal-body .col-left.enquiry-details__intro").removeClass "hidden"

			if data["modal_template"].length > 0
				$(document).find(modal_id + " #listing_popup_fill").html data["modal_template"]
				# $(document).find(modal_id).modal 'show'
				if $(modal_id + " #level-one-enquiry").length > 0 # initialize the Flag
					if $(document).find(modal_id).hasClass('in') or $(document).find(modal_id).is('visible') # if the Modal is already Open, then initialize the flag
						initFlagDrop(modal_id + " #level-one-enquiry input[name='contact']")
				return
		error: (request, status, error) ->
			## -- Show the enquiry content -- ##
			# $(modal_id).modal 'show'
			console.log error
			return
	return

### ---  --- ###
# getVerification = (enquiry_level, listing_slug, regenerate = false, enquiry_fail_level = '') ->
getVerification = (modal_id, enquiry_level, listing_slug = '', regenerate = false, new_contact = false, contact_no = '') ->
	data = 
		'enquiry_level': enquiry_level
		# 'enquiry_fail_level': enquiry_fail_level
		'listing_slug': listing_slug
		'contact': if contact_no.length > 0 then contact_no else $(modal_id + " #listing_popup_fill div.verification__row span.mobile").text().replace(/ /g,"")
		'otp': $(modal_id + " #listing_popup_fill div.verification__row #code_otp").val()
		'regenerate': regenerate
		'new_contact':
			'country_code': if contact_no.indexOf('-') > -1 then contact_no.split('-')[0] else ''
			'contact': if contact_no.indexOf('-') > -1 then contact_no.split('-')[1] else contact_no

	$.ajax
		type: 'post'
		url: '/api/verify_enquiry_otp'
		data: 
			data
		dataType: 'json'
		async: false
		success: (data) ->
			if modal_id == "#enquiry-modal" and data.hasOwnProperty("display_full_screen") and data["display_full_screen"]
				$("#enquiry-modal .modal-content .modal-body .col-left.enquiry-details__intro").addClass "hidden"
			else
				$("#enquiry-modal .modal-content .modal-body .col-left.enquiry-details__intro").removeClass "hidden"

			if data["popup_template"].length > 0
				$(document).find(modal_id + " #listing_popup_fill").html data["popup_template"]
				# $(document).find(modal_id).modal 'show'
				# return

			if $(modal_id + " #level-three-enquiry").length > 0
				# initCatSearchBox()
				multiSelectInit(modal_id + " #level-three-enquiry #area_section #area_operations", "", false)
				# multiSelectInit(modal_id + " #level-three-enquiry", "", false)
				return
		error: (request, status, error) ->
			#$(modal_id + "").modal 'show'
			if request.status == 410
				console.log "Sorry, the OTP has expired"
				$(modal_id + " #otp-error").text("Sorry, the OTP has expired.")
			else if request.status == 400
				$(modal_id + " #otp-error").text("Incorrect OTP. Please enter valid one.")
				console.log "Please enter the Valid OTP"
			else if request.status == 404
				$(modal_id + " #otp-error").text("Please enter the OTP.")
				console.log "Please enter OTP"
			else
				$(modal_id + " #otp-error").text("We have met with an error. Please try after sometime.")
				console.log "Some error in OTP verification"
			console.log error
			return
	return

### --- Read the cookie & get the value of that KEY --- ###
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

### --- Create / update the cookie --- ###
setCookie = (key, value, time = {}) ->
	date = new Date()
	if(time.hasOwnProperty('value') and time.hasOwnProperty('unit'))
		millisecond_value = getMilliSeconds(time)
	else # Set Default
		millisecond_value = getMilliSeconds({'value': 30, 'unit': 'second'}) # Default, get current time

	date.setTime(date.getTime() + millisecond_value)

	expires = "; expires=" + date.toGMTString() # update the expiry time
	document.cookie = key + "=" + value + expires + "; path=/" # Set the cookie
	return

### --- Erase the key-value from Cookie list --- ###
eraseCookie = (key) ->
	setCookie(key, "", {'unit': 'second', 'value': -1})
	return

## -- Get areas based on City -- ##
getArea = (modal_id, city, path) ->
	html = ''#'<option value="">Area</option>'

	$.ajax
		type: 'post'
		url: '/get_areas'
		data: 
			'city': city
		async: false
		success: (data) ->
			key = undefined
			$(path).addClass "default-area-select"
			for key of data
				key = key
				html += '<option value="' + data[key]['id'] + '" name="area_multiple[]" >' + data[key]['name'] + '</option>'

			#$('#' + path + ' select[name="area"]').html html
			$(path).html html
			
			# $(modal_id + " #level-three-enquiry" + ' .default-area-select').multiselect('rebuild')
			$(document).find(path).multiselect('rebuild')
			
			# multiSelectInit(modal_id + " #level-three-enquiry #area_section", "", false)
			multiSelectInit(modal_id + " #level-three-enquiry #area_section", path, false)
			
			# dom_html = $(path).clone("true") ## clone <select>...</select>
			# new_dom_path = $(path).closest('div.flex-row')
			# $(path).closest('div.flex-row').html dom_html
			# multiSelectInit(new_dom_path, "", false)
			return
		error: (request, status, error) ->
			throw Error()
			return
	return

## -- Category Flexdatalist Init function -- ##
initCatSearchBox = (modal_id) ->
	### --- Initialize categories search  --- ###
	$(document).find(modal_id + ' #level-three-enquiry input[name="get_categories"]').flexdatalist
		url: '/api/search-category'
		requestType: 'post'
		params: {"category_level" : 3, "ignore_categories" : []}

		minLength: 1
		cache: false
		# selectionRequired: false

		keywordParamName: "search"
		resultsProperty: "data"
		searchIn: ['name']
		valueProperty: 'slug' # 'id'
		visibleProperties: ["name"] ## Order of display & dropdown contents to display
		
		# searchContain: true
		# searchEqual: false
		# searchDisabled: false

		searchDelay: 200

		# searchByWord: true
		allowDuplicateValues: false
		debug: false
		noResultsText: 'Sorry! No categories found for "{keyword}"'

	### --- On select of search box add new core categories  --- ###
	$(document).on 'change:flexdatalist', modal_id + ' #level-three-enquiry input[name="get_categories"]', (event, item, options) ->
		key = ""
		categories_found = []

		$(modal_id + " #level-three-enquiry #enquiry_core_categories li input").each ()->
			categories_found.push $(this).val()
			return

		$(this).flexdatalist('params', {"category_level": 3, "ignore_categories": categories_found})
		event.preventDefault()
		return

	### --- On select of search box add new core categories  --- ###
	$(document).on 'select:flexdatalist', modal_id + ' #level-three-enquiry input[name="get_categories"]', (event, item, options) ->
		key = ""

		html = "<li><label class=\"flex-row\"><input type=\"checkbox\" class=\"checkbox\" for=\" " + item["slug"] + " \" name=\"categories_interested[]\" value=\"" + item["slug"] + "\" data-parsley-trigger=\"change\" data-parsley-mincheck=\"1\" data-required=\"true\" required=\"true\" checked=\"checked\">
			<p class=\"text-medium categories__text flex-points__text text-color\" id=\"\">" + item["name"] + "</p></label>
				</li>"

		$(modal_id + " #level-three-enquiry #enquiry_core_categories").append html

		$(this).val ""

		event.preventDefault()
		return
	return

## -- intlTel plugin Initialization function -- ##
initFlagDrop = (path) ->
	$(document).find(path).intlTelInput
		initialCountry: 'auto'
		separateDialCode: true
		geoIpLookup: (callback) ->
			$.get('https://ipinfo.io', (->
			), 'jsonp').always (resp) ->
				countryCode = undefined
				countryCode = if resp and resp.country then resp.country else ''
				callback countryCode
				return
			return
		preferredCountries: [ 'IN' ]
		americaMode: false
		formatOnDisplay: false

	# $(document).find(path).on "countrychange", () ->
	# 	$(this).val($(this).intlTelInput("getNumber"))
	# 	return
	return

## -- MultiSelect dropdown Initialization function -- ##
multiSelectInit = (general_path, specific_path, reinit = false) ->
	path = if (specific_path and specific_path.length) then $(specific_path) else $(document).find(general_path + ' .default-area-select')
	# console.log if (specific_path and specific_path.length) then "specific_path" else "general_path"
	if reinit
		# $(document).find($(path)).find('.default-area-select').multiselect()
		# $(document).find(general_path + ' .default-area-select').multiselect()
		$(document).find(path).multiselect()
	else
		# $(document).find($(path)).find('.default-area-select').multiselect
		# $(document).find(general_path + ' .default-area-select').multiselect
		$(document).find(path).multiselect
			includeSelectAllOption: true
			numberDisplayed: 2
			delimiterText: ','
			nonSelectedText: 'Select City'
			# onInitialized: (select, container) ->
			# 	console.log 'multiselect Initialized'

	return

## -- Reset Template to that Popup content Step -- ##
resetTemplate = (modal_id, enquiry_level, listing_slug) ->
	if(listing_slug and listing_slug.length > 0 and modal_id == "#enquiry-modal")
		getTemplate(modal_id, enquiry_level, listing_slug)
	else
		getTemplate(modal_id, enquiry_level, "")
	return

## -- Destroy all the plugins in that popup -- ##
resetPlugins = (modal_id) ->
	## -- Destroy flag plugin -- ##
	if $(modal_id + " #level-one-enquiry input[name='contact']").length > 0
		$(modal_id + " #level-one-enquiry input[name='contact']").intlTelInput "destroy"

	## -- Destroy MultiSelect Plugin -- ##
	if $(modal_id + " .default-area-select").length > 0
		$(modal_id + " .default-area-select").multiselect "destroy"

	return

checkForInput = (element) ->
	# element is passed to the function ^
	$label = $(element).siblings('label')
	if $(element).val().length > 0
		$label.addClass 'filled lab-color'
	else
		$label.removeClass 'filled lab-color'
	return

### --- This function checks if any modal is Open in a document/window --- ###
anyModalOpenCheck = (id='') ->
	if id.length > 0
		return $(document).find(id).data('bs.modal') and ($(document).find(id).data('bs.modal').isShown)
	else
		return (if ($('.modal.in').length > 0) then true else false)
	return

### --- This function checks if any Input/TextArea is on Focus in a document/window --- ###
anyInputTextFocusCheck = (id) ->
	if id.length > 0
		return $(id).find('input:focus, textarea:focus').length > 0
	else
		return $(document).find('input:focus, textarea:focus').length > 0
	return

### --- This function is called for auto-popup trigger --- ###
autoPopupTrigger = () ->
	### --- Auto popup function starts --- ###
	if parseInt(getCookie('enquiry_modal_display_count')) > 0 and (not anyModalOpenCheck("")) # if display count is > 0 and no modal is open, then display auto-popup
		if parseInt(getCookie('enquiry_modal_first_time_value')) > 0 and getCookie('enquiry_modal_first_time_unit').length > 0
			millisecond_value = getMilliSeconds({'value': parseInt(getCookie('enquiry_modal_first_time_value')), 'unit': getCookie('enquiry_modal_first_time_unit')})
				
			console.log "modal timeout initiated opens in " + millisecond_value.toString()
			setTimeout (->
				console.log "Timed out"
				# $('#multi-quote-enquiry-modal').modal 'show'
				# if (getCookie('is_modal_open').length <= 0 or (getCookie('is_modal_open').length > 0 and getCookie('is_modal_open') != "true")) and (not anyModalOpenCheck("")) and (not anyInputTextFocusCheck("")) # if any modal is open, then don't trigger Auto popup
				if (not anyModalOpenCheck("")) and (not anyInputTextFocusCheck("")) # if any modal is open OR textbox on Focus, then don't trigger Auto popup
					$(document).find('#bs-example-navbar-collapse-1 .enquiry-modal-btn').trigger('click') # Trigger enquiry modal button
					console.log "trigger modal timer"
					display_counter = parseInt(getCookie('enquiry_modal_display_count')) - 1
					if display_counter > 0
						setCookie('enquiry_modal_display_count', display_counter, {'unit': 'day', 'value': 30})
					else
						eraseCookie('enquiry_modal_display_count')
						eraseCookie('enquiry_modal_first_time_value')
						eraseCookie('enquiry_modal_first_time_unit')
				# else
				# 	console.log "Reset the Auto Popup"
				# 	autoPopupTrigger() # reinitiate the Auto-Popup
				return
			), millisecond_value
	# else if parseInt(getCookie('enquiry_modal_display_count')) < 0
	#	eraseCookie('enquiry_modal_display_count') # Delete the count tracer from cookie
	### --- Auto popup function ends --- ###

$(document).ready () ->
	### --- This object is used to store old values -> Mainly for search-boxes --- ###
	old_values = {}
	# eraseCookie("is_modal_open") # once page is loaded, delete the "Enquiry Modal Open" key from cookie

	autoPopupTrigger()

	### --- If RHS Enquiry form exist, then --- ###
	if $("#rhs-enquiry-form .level-one #level-one-enquiry").length > 0
		initFlagDrop("#rhs-enquiry-form .level-one #level-one-enquiry input[name='contact']")
		
		$(document).find("#rhs-enquiry-form .level-one #level-one-enquiry select[name='description']").multiselect
			includeSelectAllOption: true
			numberDisplayed: 1
			delimiterText: ','
			nonSelectedText: 'Select that describes you best'

		$(document).find('.float-input').each ->
			checkForInput this
			return

	### --- Display respective Popups on "Send Enquiry" click --- ###
	$(document).on "click", ".enquiry-modal-btn", (e) ->
		modal_id = $(this).data("target")
		modal_popup_id = modal_id

		is_user_status = false
		modal_display_status = true
		
		# if getCookie('user_id').length > 0
		# 	if getCookie('user_type') == "user"
		# 		# If user has account on website
		# 		$("#login-modal").modal 'show' # show login popup
		# 		is_user_status = true

		# 		## -- Hide the Enquiry modal -- ##
		#		$(document).find(modal_id).modal 'hide'

		if $(modal_id).length > 0 and (not is_user_status)
			### --- Validate Non Modal forms i.e. RHS & List view forms --- ###
			if ($(this).closest("#rhs-enquiry-form").length and $(this).closest("#rhs-enquiry-form").find("select[name='description']").length) # if the RHS single enquiry form exist & has description Dropdown
				### --- For RHS form - Single Listing page Enquiry --- ###
				$(this).closest("#rhs-enquiry-form").find('button.multiselect').attr('data-parsley-errors-container', '#describes-best-dropdown-error') # Add the error-container
			else if ($(this).closest("#listing_list_view_enquiry").length and $(this).closest("#listing_list_view_enquiry").find("select[name='description']").length)
				### --- For List View form - List View page Enquiry --- ###
				$(this).closest("#listing_list_view_enquiry").find('button.multiselect').attr('data-parsley-errors-container', '#describes-best-dropdown-error') # Add the error-container

			# if ($(this).closest("#rhs-enquiry-form").length <= 0 or ($(this).closest("#rhs-enquiry-form").length and $(this).closest("#level-one-enquiry").parsley().validate()))
			if ($(this).closest("#rhs-enquiry-form").length and $(this).closest("#level-one-enquiry").parsley().validate())
				if $(this).closest("#rhs-enquiry-form").length > 0
					console.log "RHS modal show"
					$(modal_id).modal 'show'
			else if ($(this).closest("#listing_list_view_enquiry").length and $(this).closest("#level-one-enquiry").parsley().validate())
				if $(this).closest("#listing_list_view_enquiry").length > 0
					console.log "List view modal show"
					$(modal_id).modal 'show'
			else # else fail the response
				if $(this).closest("#rhs-enquiry-form").length > 0 or $(this).closest("#listing_list_view_enquiry").length > 0
					console.log "Hide the modal"
					modal_display_status = false
					$(modal_id).modal 'hide'
			

			if $(this).data("value") and modal_display_status
				enq_form_id = "#" + $(this).closest("div.send-enquiry-section").prop("id")
				page_level = if ($(this).data('value') and $(this).data('value').length > 0) then $(this).data('value') else 'step_1'

				if modal_id == "#enquiry-modal"
					listing_slug = $("#enquiry_slug").val()
				else
					listing_slug = ""

				console.log "Get"
				getContent(enq_form_id, page_level, listing_slug, true, modal_id)
			else
				### --- Reset to Modal 1 on enquiry button Click --- ###
				console.log "Reset"
				resetTemplate(modal_id, 'step_1', $("#enquiry_slug").val())
				resetPlugins(modal_id)

			# $(document).on "click", "div.col-sm-4 div.equal-col div.contact__enquiry button.fnb-btn.primary-btn", () ->
			# 	if modal_id == "#enquiry-modal"
			# 		if getCookie('user_id').length > 0
			# 			if getCookie('user_type') == "user"
			# 				# If user has account on website
			# 				$("#login-modal").modal 'show' # show login po0pup
			# 			else
			# 				# If type exist & is not "user", then Show Popup
			# 				getTemplate(modal_id, 'step_1', $("#enquiry_slug").val())
			# 				#$("#multi-quote-enquiry-modal").modal 'show'
			# 		else
			# 			# Else User is Enquiring 1st time, hence the Popup
			# 			$(modal_id).modal 'show'
			# 		return
			
			$(modal_id).on 'shown.bs.modal', (e) ->
				# resetTemplate(modal_id, 'step_1', $("#enquiry_slug").val())
				# value checking floating label
				# setCookie("is_modal_open", $(document).find(modal_id).data('bs.modal').isShown, {'value': 7, 'unit': 'day'})

				checkForInput = (element) ->
				  # element is passed to the function ^
				  $label = $(element).siblings('label')
				  if $(element).val().length > 0
				    $label.addClass 'filled lab-color'
				  else
				    $label.removeClass 'filled lab-color'
				  return

				$('.float-input').on 'focus', ->
				  $(this).siblings('.float-label').addClass 'filled focused'
				  return
				$('.float-input').on 'blur', ->
				  $(this).siblings('.float-label').removeClass 'focused'
				  if @value == ''
				    $(this).siblings('.float-label').removeClass 'filled'
				  return
				$('.floatInput').on 'focus', ->
				  $(this).parent().closest('.form-group').find('.float-label').addClass 'filled focused'
				  return
				$('.floatInput').on 'blur', ->
				  $(this).parent().closest('.form-group').find('.float-label').removeClass 'focused'
				  if @value == ''
				    $(this).parent().closest('.form-group').find('.float-label').removeClass 'filled'
				  return
				# The lines below are executed on page load
				$('.float-input').each ->
				  checkForInput this
				  return
				### --- For mobile Screen --- ###
				if $(window).width() <= 768
				  $('.filter-data').each ->
				    detailrow = $(this).find('.recent-updates__content')
				    detailbtn = $(this).find('.detail-move').detach()
				    $(detailrow).append detailbtn
				    recentrow = $(this).find('.updates-dropDown')
				    recentData = $(this).find('.recent-data').detach()
				    $(recentrow).append recentData
				    publishedAdd = $(this).find('.stats')
				    publisherow = $(this).find('.rat-pub').detach()
				    $(publishedAdd).append publisherow
				    power = $(this).find('.power-seller-container')
				    powerseller = $(this).find('.power-seller').detach()
				    $(power).append powerseller
				    listlabel = $(this).find('.list-label').detach()
				    $(this).find('.list-title-container').before listlabel
			     

				return

			# $(document).on 'hidden.bs.modal', modal_id, (e) ->
			# 	### --- Erase Modal open key from cookie  --- ###
			# 	eraseCookie("is_modal_open")
			# 	return

			if $(document).find(modal_id + " #level-one-enquiry").length > 0
				initFlagDrop(modal_id + " #level-one-enquiry input[name='contact']")

				if $(modal_id + " #level-one-enquiry input[name='contact']").length <= 1 and $(modal_id + " #level-one-enquiry input[name='contact']").val().indexOf('+') > -1
					$(modal_id + " #level-one-enquiry input[name='contact']").val ""
				
				# resetTemplate(modal_id, 'step_1', $("#enquiry_slug").val())
			if $(document).find(modal_id + " #level-one-enquiry").length > 0
				$(document).on "countrychange", modal_id + " #level-one-enquiry input[name='contact']", () ->
					if $(this).val() > 0
						$(this).val($(this).intlTelInput("getNumber"))
					return

			### --- On click of "Send Enquiry 1" button --- ###
			$(document).on "click", modal_id + " #level-one-enquiry #level-one-form-btn", (event) ->
				page_level = if ($(this).data('value') and $(this).data('value').length > 0) then $(this).data('value') else 'step_1'
				$(this).find("i.fa-circle-o-notch").removeClass "hidden"
				$(this).attr("disabled", "disabled")
				if $(document).find(modal_id + " #level-one-enquiry").parsley().validate()
					getContent(modal_id, page_level, $("#enquiry_slug").val(), false, modal_id)
					event.stopImmediatePropagation() # Prevent making multiple AJAX calls
				else
					$(this).find("i.fa-circle-o-notch").addClass "hidden"
					$(this).removeAttr "disabled"
					console.log "forms not complete"
				return


			### --- On click of OTP submit button --- ###
			$(document).on "click", modal_id + " #level-two-enquiry #level-two-form-btn", (event) ->
				getVerification(modal_id, $(this).data('value'), $("#enquiry_slug").val(), false, false, '')
				event.stopImmediatePropagation() # Prevent making multiple AJAX calls
				return

			### --- On click of OTP regenerate button --- ###
			$(document).on "click", modal_id + " #level-two-enquiry #level-two-resend-btn", (event) ->
				getVerification(modal_id, $(this).data('value'), $("#enquiry_slug").val(), true, true, '')
				event.stopImmediatePropagation() # Prevent making multiple AJAX calls
				return

			### --- initialize the Flag in Popup 2 --- ###
			$(document).on "click", modal_id + " #level-two-enquiry", () ->
				initFlagDrop(modal_id + " #level-two-enquiry #new-mobile-modal input[name='contact']")
				return

			### --- On click of 'x', close the Popup 2 modal --- ###
			$(document).on "click", modal_id + " #level-two-enquiry #close-new-mobile-modal", () ->
				$(document).find(modal_id + " #new-mobile-modal").modal "hide"
				return

			# ### --- Change the Contact No & Regenarate OTP --- ###
			# $(document).on "click", modal_id + " # #new-mobile-verify-btn", (event) ->
			# 	if $(this).closest("#change-contact-form").parsley().validate()#$(this).closest('div.new-verify-number').find("input[type='tel'][name='contact']").val()
			# 		# $(modal_id + " #listing_popup_fill div.verification__row span.mobile").text("+" + $(this).closest('div.new-verify-number').find("input[type='tel'][name='contact']").intlTelInput("getSelectedCountryData").dialCode + " " + $(this).closest('div.new-verify-number').find("input[type='tel'][name='contact']").val())
			# 		$(modal_id + " #listing_popup_fill div.verification__row span.mobile").text("+" + $(this).closest('#change-contact-form').find("input[type='tel'][name='contact']").intlTelInput("getSelectedCountryData").dialCode + " " + $(this).closest('#change-contact-form').find("input[type='tel'][name='contact']").val())
			# 		$(document).find(modal_id + " #new-mobile-modal").modal "hide"
			# 		getVerification(modal_id, $(modal_id + " #level-two-enquiry #level-two-resend-btn").data('value'), $("#enquiry_slug").val(), false, true, $(this).parent().find("div.new-verify-number input[type='tel'][name='contact']").intlTelInput("getSelectedCountryData").dialCode + '-' + $(this).parent().find("div.new-verify-number input[type='tel'][name='contact']").val())
			# 		event.stopImmediatePropagation() # Prevent making multiple AJAX calls
			# 	# else
			# 	# 	$("#new-mobile-modal .modal-body .verifySection #phoneError").html ""
			# 	return

			$(document).on "change", modal_id + " #level-three-enquiry #area_section select[name='city']", (event) ->
				city_vals = []
				i = 0
				$(modal_id + " #level-three-enquiry #area_section select[name='city'] option").removeClass 'hidden' # Remove all hidden class
				$(modal_id + " #level-three-enquiry #area_section select[name='city']").each -> # get the selected ID values
					city_vals.push $(this).val()
					return

				while i < city_vals.length
					$(modal_id + " #level-three-enquiry #area_section select[name='city'] option[value='" + city_vals[i] + "']").addClass 'hidden' # hide the selected ID values
					i++

				$(modal_id + " #level-three-enquiry #area_section select[name='city']").each ->
					if $.inArray($(this).val(), city_vals) > -1
						$(this).find("option[value='" + $(this).val() + "']").removeClass 'hidden'
					return

				#$(this).find("option[value='" + $(this).val() + "']").removeClass 'hidden' # remove hidden class for that "select"
				# console.log $(this).closest('ul').find('select[name="area"]')
				getArea(modal_id, $(this).val(), $(this).closest('ul').find('select[name="area"]'))
				event.stopImmediatePropagation() # Prevent making multiple AJAX calls
				return
			
			# ### --- On click of "+ Add more" on Enquiry 3 Popup "Areas", new set will be added --- ###
			# ## -- This function is defined below -- ##
			# $(document).on "click", modal_id + " #level-three-enquiry #add-city-areas", (event) ->
			# 	$(modal_id + " #area_dom_skeleton").clone("true").removeAttr('id').removeClass('hidden').appendTo(modal_id + " #area_section #area_operations")
			# 	console.log "on add Area Click"
			# 	multiSelectInit(modal_id + " #level-three-enquiry #area_section #area_operations", "", false)
			# 	# event.stopImmediatePropagation() # Prevent making multiple AJAX calls
			# 	return

			### --- On click of close, remove the City-Area DOM --- ###
			$(document).on "click", modal_id + " #level-three-enquiry #close_areas", () ->
				$(modal_id + " #level-three-enquiry #area_section select[name='city'] option[value='" + $(this).val() + "']").addClass('hidden')
				$(modal_id + " #level-three-enquiry #area_section select[name='city'] option[value='" + $(this).closest('ul').find("select[name='city']").val() + "']").removeClass 'hidden'
				$(this).closest("ul").remove()
				return

			### --- On click of Popup 3 'Save / Send' --- ###
			$(document).on "click", modal_id + " #level-three-enquiry #level-three-form-btn", (event) ->
				page_level = if ($(this).data('value') and $(this).data('value').length > 0) then $(this).data('value') else 'step_1'
				$(this).find("i.fa-circle-o-notch").removeClass "hidden"
				$(this).attr("disabled", "disabled")

				# if $(document).find(modal_id + " #level-three-enquiry #enquiry_core_categories").parsley().validate() and $(document).find(modal_id + " #level-three-enquiry #area_operations").parsley().validate()
				if $(document).find(modal_id + " #level-three-enquiry #other_details_container").parsley().validate()
					getContent(modal_id, page_level, $("#enquiry_slug").val(), false, modal_id)
					event.stopImmediatePropagation() # Prevent making multiple AJAX calls
				else
					$(this).find("i.fa-circle-o-notch").addClass "hidden"
					$(this).removeAttr "disabled"
					console.log "forms not complete"
				return

			### --- On click of "Add More" categories --- ###
			$(document).on "click", modal_id + " #level-three-enquiry #select-more-categories", () ->
				main_page_categories = []
				$.each $(modal_id + " #level-three-enquiry input[name='categories_interested[]']:checked"), ->
					main_page_categories.push $(this).val()
					return
				$(modal_id).modal "hide"

				### --- Category select modal on show --- ###
				$(document).on "shown.bs.modal", "#category-select", (event) ->
					branch_list = JSON.parse($(modal_id + " #level-three-enquiry #branch_category_selected_ids").val())
					main_page_categories = main_page_categories.concat(branch_list)
					$("#category-select #previously_available_categories").val(JSON.stringify(main_page_categories))
					return
				return

			### --- On Categories Modal close, update the Level 3 with checkboxes --- ###
			$(document).on "hidden.bs.modal", "#category-select", (event) ->
				# $(modal_id).modal "show"
				
				### --- Note: ---
					A timeout of 1 sec is kept so that the hidden value is updated and the checkbox can be populated.
					The reason is sometimes the 'category_selected' values are received with a delay, due to which checkboxes are not populated at that instant i.e. the below code ends up referring old value.
				###
				setTimeout (->
					checked_categories = []
					index = 0
					html = ""

					if $(modal_id + " #level-three-enquiry #modal_categories_chosen").val().length > 2 and JSON.parse($(modal_id + " #level-three-enquiry #modal_categories_chosen").val()).length > 0
						checked_categories = JSON.parse($(modal_id + " #level-three-enquiry #modal_categories_chosen").val())

					$(modal_id + " #level-three-enquiry input[name='categories_interested[]']").prop "checked", false
					
					if checked_categories.length > 0 and $(document).find(modal_id + " #level-three-enquiry  #category_hidden_checkbox").length > 0
						$(document).find(modal_id + " #level-three-enquiry li#category_hidden_checkbox").remove() # Removes the li
						$(document).find(modal_id + " #level-three-enquiry #category-checkbox-error").html ""

					console.log "Categories chosen: " + checked_categories.length.toString()
					while index < checked_categories.length
						if $(modal_id + " #level-three-enquiry input[name='categories_interested[]'][value='" + checked_categories[index]["slug"] + "']").length > 0 # if a checkbox with that ID exist, then Select that checkbox
							$(modal_id + " #level-three-enquiry input[name='categories_interested[]'][value='" + checked_categories[index]["slug"] + "']").prop "checked", true
						else if checked_categories[index].hasOwnProperty("name") # if the name object exist in the data, then generate a checkbox, & inject to DOM
							html += "<li><label class=\"flex-row\"><input type=\"checkbox\" class=\"checkbox\" for=\" " + checked_categories[index]["slug"] + " \" name=\"categories_interested[]\" value=\"" + checked_categories[index]["slug"] + "\" data-parsley-trigger=\"change\" data-parsley-required-message=\"Please select a category\" data-parsley-mincheck=\"1\" data-required=\"true\" required=\"true\" checked=\"checked\" data-parsley-errors-container=\"#category-checkbox-error\">
								<p class=\"text-medium categories__text flex-points__text text-color\" id=\"\">" + checked_categories[index]["name"] + "</p></label>
									</li>"
						index++

					if html.length > 0
						$(modal_id + " #level-three-enquiry #enquiry_core_categories").append html
				), 1000, modal_id

				$(modal_id).modal "show"
				
				return
			#return

			#e.stopimmediatepropagation()
			return
	
	### --- On click of "+ Add more" on Enquiry 3 Popup "Areas", new set will be added --- ###
	$(document).on "click", "#level-three-enquiry #add-city-areas", (event) ->
		if modal_popup_id and modal_popup_id.length > 0
			html_area_dom = $(modal_popup_id + " #area_dom_skeleton").clone("true").removeAttr('id').removeClass('hidden')
			
			city_area_selection_length = $(modal_popup_id + " #area_section #area_operations ul.areas-select__selection").length

			## -- Add new City with attributes -- ##
			html_area_dom.find('li.city-select select[name="city"]').attr('data-parsley-trigger', 'change')
			html_area_dom.find('li.city-select select[name="city"]').attr('required', 'true')
			html_area_dom.find('li.city-select select[name="city"]').attr('data-parsley-errors-container', "#" + (html_area_dom.find("li.city-select #city-select-error").attr('id') + '-' + (city_area_selection_length + 1).toString())) # error-container label
			html_area_dom.find("li.city-select #city-select-error").attr('id', html_area_dom.find("li.city-select #city-select-error").attr('id') + '-' + (city_area_selection_length + 1).toString()) # error-container label ID

			## -- Add new Area with attributes -- ##
			# html_area_dom.find('li.area-select select[name="area"]').attr('data-parsley-trigger', 'change')
			html_area_dom.find('li.area-select select[name="area"]').attr('required', 'true')
			html_area_dom.find('li.area-select select[name="area"]').attr('data-parsley-errors-container', "#" + (html_area_dom.find("li.area-select #area-select-error").attr('id') + '-' + (city_area_selection_length + 1).toString())) # error-container label
			html_area_dom.find("li.area-select #area-select-error").attr('id', html_area_dom.find("li.area-select #area-select-error").attr('id') + '-' + (city_area_selection_length + 1).toString()) # error-container label ID

			html_area_dom.appendTo(modal_popup_id + " #area_section #area_operations")
			# console.log "on add Area Click"
			multiSelectInit(modal_popup_id + " #level-three-enquiry #area_section #area_operations", "", false)
			# event.stopImmediatePropagation() # Prevent making multiple AJAX calls
		return

	### --- Show the Edit contact Popup --- ###
	$(document).on "click", "#level-two-enquiry #edit-contact-number-btn", (event) ->
		$(document).find("#enquiry-mobile-verification #new-mobile-modal input[type='tel']").attr('data-parsley-errors-container', '#phoneErrorCustom')
		$(document).find("#enquiry-mobile-verification #new-mobile-modal #phoneError").attr('id', "phoneErrorCustom")
		$(document).find("#enquiry-mobile-verification #new-mobile-modal").modal 'show'
		return

	### --- Change the Contact No & Regenarate OTP --- ###
	$(document).on "click", "#enquiry-mobile-verification #new-mobile-modal #new-mobile-verify-btn", (event) ->
		$(this).closest("#change-contact-form")
		
		$("#enquiry-mobile-verification #phoneErrorCustom").html "" # this empty text is added to trigger the parsley message DISPLAY
		if $(this).closest("#change-contact-form").parsley().validate()#$(this).closest('div.new-verify-number').find("input[type='tel'][name='contact']").val()
			# $(modal_id + " #listing_popup_fill div.verification__row span.mobile").text("+" + $(this).closest('div.new-verify-number').find("input[type='tel'][name='contact']").intlTelInput("getSelectedCountryData").dialCode + " " + $(this).closest('div.new-verify-number').find("input[type='tel'][name='contact']").val())
			if modal_popup_id and modal_popup_id.length > 0
				$(modal_popup_id + " #listing_popup_fill div.verification__row span.mobile").text("+" + $(this).closest('#change-contact-form').find("input[type='tel'][name='contact']").intlTelInput("getSelectedCountryData").dialCode + " " + $(this).closest('#change-contact-form').find("input[type='tel'][name='contact']").val())
				$(document).find(modal_popup_id + " #new-mobile-modal").modal "hide"
				getVerification(modal_popup_id, $(modal_popup_id + " #level-two-enquiry #level-two-resend-btn").data('value'), $("#enquiry_slug").val(), false, true, $(this).parent().find("div.new-verify-number input[type='tel'][name='contact']").intlTelInput("getSelectedCountryData").dialCode + '-' + $(this).parent().find("div.new-verify-number input[type='tel'][name='contact']").val())
				console.log $(this)
				$(this).closest('#new-mobile-modal').modal 'hide'
				event.stopImmediatePropagation() # Prevent making multiple AJAX calls
		# else
		# 	$("#new-mobile-modal .modal-body .verifySection #phoneError").html ""
		return

	### --- Validate Mobile No --- ###
	$(document).on 'keyup change', modal_popup_id + " #level-one-enquiry input[type='tel'][name='contact']", () -> # Check Contact
		id = $(this).closest('form').prop('id')
		validateContact($(this).val(), "#" + id + " #contactfield", false)
		return
	return