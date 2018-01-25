capitalize = (string) ->
	return string.charAt(0).toUpperCase() + string.slice(1)

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

	if trigger_modal and target_modal_id == "#multi-quote-enquiry-modal"
		data["multi-quote"] = true
		if $("#listing_filter_view").length
			data['category'] = $(document).find("#listing_filter_view #current_category").val().split("|")[0]
			areas = []

			$(document).find("#listing_filter_view #section-area input[type='checkbox']:checked").each ->
				areas = areas.concat $(this).val()
				return
			
			data['areas'] = areas
	
	$.ajax
		type: 'post'
		url: '/api/send_enquiry'
		data: data
		dataType: 'json'
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
							multiSelectInit(target_modal_id + " #level-three-enquiry #area_section #area_operations", false)
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
					multiSelectInit(modal_id + " #level-three-enquiry #area_section #area_operations", false)
					# multiSelectInit(modal_id + " #level-three-enquiry", false)
					return
		error: (request, status, error) ->
			#$("#multi-quote-enquiry-modal").modal 'show'
			$(modal_id + " button").find("i.fa-circle-o-notch").addClass "hidden" # Hide all the circle (load button) if the AJAX failed
			$(modal_id + " button").removeAttr "disabled" # Enable the button if the AJAX failed
			console.log error
	return

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
					initFlagDrop(modal_id + " #level-one-enquiry input[name='contact']")
				return
		error: (request, status, error) ->
			## -- Show the enquiry content -- ##
			# $(modal_id).modal 'show'
			console.log error
			return
	return

getVerification = (modal_id, enquiry_level, listing_slug = '', regenerate = false, new_contact = false, contact_no = '') ->
# getVerification = (enquiry_level, listing_slug, regenerate = false, enquiry_fail_level = '') ->
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
		success: (data) ->
			if modal_id == "#enquiry-modal" and data.hasOwnProperty("display_full_screen") and data["display_full_screen"]
				$("#enquiry-modal .modal-content .modal-body .col-left.enquiry-details__intro").addClass "hidden"
			else
				$("#enquiry-modal .modal-content .modal-body .col-left.enquiry-details__intro").removeClass "hidden"

			if data["popup_template"].length > 0
				$(document).find(modal_id + " #listing_popup_fill").html data["popup_template"]
				# $(document).find(modal_id).modal 'show'
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

## -- Get areas based on City -- ##
getArea = (modal_id, city, path) ->
	html = ''#'<option value="">Area</option>'

	$.ajax
		type: 'post'
		url: '/get_areas'
		data: 'city': city
		success: (data) ->
			key = undefined
			$(path).addClass "default-area-select"
			for key of data
				key = key
				html += '<option value="' + data[key]['id'] + '" name="area_multiple[]" >' + data[key]['name'] + '</option>'

			#$('#' + path + ' select[name="area"]').html html
			$(path).html html
			
			$(modal_id + " #level-three-enquiry" + ' .default-area-select').multiselect('rebuild')
			multiSelectInit(modal_id + " #level-three-enquiry #area_section", false)
			
			# dom_html = $(path).clone("true") ## clone <select>...</select>
			# new_dom_path = $(path).closest('div.flex-row')
			# $(path).closest('div.flex-row').html dom_html
			# multiSelectInit(new_dom_path, false)
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
multiSelectInit = (path, reinit = false) ->
	if reinit
		$(document).find(path + ' .default-area-select').multiselect()
		# $(document).find($(path)).find('.default-area-select').multiselect()
	else
		$(document).find(path + ' .default-area-select').multiselect
		# $(document).find($(path)).find('.default-area-select').multiselect
			includeSelectAllOption: true
			numberDisplayed: 2
			delimiterText: ','
			nonSelectedText: 'Select City'

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

$(document).ready () ->
	### --- This object is used to store old values -> Mainly for search-boxes --- ###
	old_values = {}

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
		
		if $(modal_id).length > 0
			if ($(this).closest("#rhs-enquiry-form").length and $(this).closest("#rhs-enquiry-form").find("select[name='description']").length) # if the RHS single enquiry form exist & has description Dropdown
				$(this).closest("#rhs-enquiry-form").find('button.multiselect').attr('data-parsley-errors-container', '#describes-best-dropdown-error') # Add the error-container

			if ($(this).closest("#rhs-enquiry-form").length <= 0 or ($(this).closest("#rhs-enquiry-form").length and $(this).closest("#level-one-enquiry").parsley().validate()))
				if $(this).closest("#rhs-enquiry-form").length > 0
					$(modal_id).modal 'show'

				if $(this).data("value")
					enq_form_id = "#" + $(this).closest("div.send-enquiry-section").prop("id")
					page_level = if ($(this).data('value') and $(this).data('value').length > 0) then $(this).data('value') else 'step_1'

					if modal_id == "#enquiry-modal"
						listing_slug = $("#enquiry_slug").val()
					else
						listing_slug = ""

					getContent(enq_form_id, page_level, listing_slug, true, modal_id)
				else
					### --- Reset to Modal 1 on enquiry button Click --- ###
					resetTemplate(modal_id, 'step_1', $("#enquiry_slug").val())
					resetPlugins(modal_id)
			else # else fail the response
				if $(this).closest("#rhs-enquiry-form").length > 0
					$(modal_id).modal 'hide'

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

			### --- Change the Contact No & Regenarate OTP --- ###
			$(document).on "click", modal_id + " #level-two-enquiry #new-mobile-verify-btn", (event) ->
				$(modal_id + " #listing_popup_fill div.verification__row span.mobile").text("+" + $(this).closest('div.new-verify-number').find("input[type='tel'][name='contact']").intlTelInput("getSelectedCountryData").dialCode + " " + $(this).closest('div.new-verify-number').find("input[type='tel'][name='contact']").val())
				$(document).find(modal_id + " #new-mobile-modal").modal "hide"
				getVerification(modal_id, $(modal_id + " #level-two-enquiry #level-two-resend-btn").data('value'), $("#enquiry_slug").val(), false, true, $(this).parent().find("div.new-verify-number input[type='tel'][name='contact']").intlTelInput("getSelectedCountryData").dialCode + '-' + $(this).parent().find("div.new-verify-number input[type='tel'][name='contact']").val())
				event.stopImmediatePropagation() # Prevent making multiple AJAX calls
				return

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
				getArea(modal_id, $(this).val(), $(this).closest('ul').find('select[name="area"]'))
				event.stopImmediatePropagation() # Prevent making multiple AJAX calls
				return
			
			### --- On click of "+ Add more" on Enquiry 3 Popup "Areas", new set will be added --- ###
			$(document).on "click", modal_id + " #level-three-enquiry #add-city-areas", (event) ->
				$(modal_id + " #area_dom_skeleton").clone("true").removeAttr('id').removeClass('hidden').appendTo(modal_id + " #area_section #area_operations")
				multiSelectInit(modal_id + " #level-three-enquiry #area_section #area_operations", false)
				# event.stopImmediatePropagation() # Prevent making multiple AJAX calls
				return

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

				# if $(document).find("#level-three-enquiry #other_details_container").parsley().validate()
				if $(document).find(modal_id + " #level-three-enquiry #enquiry_core_categories").parsley().validate() and $(document).find(modal_id + " #level-three-enquiry #area_operations").parsley().validate()
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
					$("#category-select #previously_available_categories").val(JSON.stringify(main_page_categories))
					return
				return

			### --- On Categories Modal close, update the Level 3 with checkboxes --- ###
			$(document).on "hidden.bs.modal", "#category-select", (event) ->
				$(modal_id).modal "show"
				checked_categories = []
				index = 0
				html = ""
				
				if $(modal_id + " #level-three-enquiry #modal_categories_chosen").val().length > 2 and JSON.parse($(modal_id + " #level-three-enquiry #modal_categories_chosen").val()).length > 0
					checked_categories = JSON.parse($(modal_id + " #level-three-enquiry #modal_categories_chosen").val())

				$(modal_id + " #level-three-enquiry input[name='categories_interested[]']").prop "checked", false
				while index < checked_categories.length
					if $(modal_id + " #level-three-enquiry input[name='categories_interested[]'][value='" + checked_categories[index]["slug"] + "']").length > 0
						$(modal_id + " #level-three-enquiry input[name='categories_interested[]'][value='" + checked_categories[index]["slug"] + "']").prop "checked", true
					else
						html += "<li><label class=\"flex-row\"><input type=\"checkbox\" class=\"checkbox\" for=\" " + checked_categories[index]["slug"] + " \" name=\"categories_interested[]\" value=\"" + checked_categories[index]["slug"] + "\" data-parsley-trigger=\"change\" data-parsley-mincheck=\"1\" data-required=\"true\" required=\"true\" checked=\"checked\">
							<p class=\"text-medium categories__text flex-points__text text-color\" id=\"\">" + checked_categories[index]["name"] + "</p></label>
								</li>"
					index++

				if html.length > 0
					$(modal_id + " #level-three-enquiry #enquiry_core_categories").append html
				
				return
			#return

			#e.stopimmediatepropagation()
			return
	return