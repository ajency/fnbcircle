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
			contact_locality: $(".level-one #level-one-enquiry input[name='contact']").intlTelInput("getSelectedCountryData").dialCode
			contact: $(".level-one #level-one-enquiry input[name='contact']").val()
			description: descr_values
			enquiry_message: $(".level-one #level-one-enquiry #lookingfor input[name='enquiry_message']").val()
			enquiry_level: enquiry_no
			listing_slug: listing_slug

	else if enquiry_no == 'step_2' or enquiry_no == 'step_3'
		descr_values = []
		areas = []
		cities = []
		
		$.each $("#level-three-enquiry input[name='categories_interested[]']:checked"), ->
			descr_values.push $(this).val()
			return

		# $.each $("#level-three-enquiry select[name='area[]']:checked"), ->
		# 	areas.push $(this).val()
		# 	return
		$("#level-three-enquiry select[name='city']").each ->
			cities.push $(this).val()
			return
		$("#level-three-enquiry select[name='area']").each ->
			areas = areas.concat $(this).val()
			return

		data =
			name: $("#level-three-enquiry #enquiry_name").text()
			email: $("#level-three-enquiry #enquiry_email").text()
			contact: $("#level-three-enquiry #enquiry_contact").text()
			categories_interested: descr_values
			city: cities
			area: areas
			enquiry_level: enquiry_no
			listing_slug: listing_slug

	return data

getContent = (enquiry_level, listing_slug) ->
	data = getFilters(enquiry_level, listing_slug)
	
	$.ajax
		type: 'post'
		url: '/api/send_enquiry'
		data: data
		dataType: 'json'
		success: (data) ->
			if data["popup_template"].length > 0
				$(document).find("#updateTemplate #enquiry-modal #listing_popup_fill").html data["popup_template"]
				$(document).find("div.container #enquiry-modal").modal 'show'
				if $("#level-three-enquiry").length > 0
					initCatSearchBox()
					return
		error: (request, status, error) ->
			#$("div.container #enquiry-modal").modal 'show'
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
				$(document).find("#updateTemplate #enquiry-modal #listing_popup_fill").html data["modal_template"]
				$(document).find("div.container #enquiry-modal").modal 'show'
		error: (request, status, error) ->
			## -- Show the enquiry content -- ##
			$("div.container #enquiry-modal").modal 'show'
			console.log error
	return

getVerification = (enquiry_level, listing_slug = '', regenerate = false, new_contact = false, contact_no = '') ->
# getVerification = (enquiry_level, listing_slug, regenerate = false, enquiry_fail_level = '') ->
	data = 
		'enquiry_level': enquiry_level
		# 'enquiry_fail_level': enquiry_fail_level
		'listing_slug': listing_slug
		'contact': if contact_no.length > 0 then contact_no else $("#enquiry-modal #listing_popup_fill div.verification__row span.mobile").text().replace(/ /g,"")
		'otp': $("#enquiry-modal #listing_popup_fill div.verification__row #code_otp").val()
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
			if data["popup_template"].length > 0
				$(document).find("#updateTemplate #enquiry-modal #listing_popup_fill").html data["popup_template"]
				$(document).find("div.container #enquiry-modal").modal 'show'
		error: (request, status, error) ->
			#$("div.container #enquiry-modal").modal 'show'
			if request.status == 410
				console.log "Sorry, the OTP has expired"
				$("#enquiry-modal #otp-error").text("Sorry, the OTP has expired.")
			else if request.status == 400
				$("#enquiry-modal #otp-error").text("Incorrect OTP. Please enter valid one.")
				console.log "Please enter the Valid OTP"
			else if request.status == 404
				$("#enquiry-modal #otp-error").text("Please enter the OTP.")
				console.log "Please enter OTP"
			else
				$("#enquiry-modal #otp-error").text("We have met with an error. Please try after sometime.")
				console.log "Some error in OTP verification"
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

getArea = (city, path) ->
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

			#$('#' + path + ' select[name="area"]').html html
			$(path).html html
			return
		error: (request, status, error) ->
			throw Error()
			return
	return

initCatSearchBox = () ->
	### --- Initialize categories search  --- ###
	$(document).find('#level-three-enquiry input[name="get_categories"]').flexdatalist
		url: '/api/search-category'
		requestType: 'post'
		params: {"category_level" : 3, "ignore_categories" : []}

		minLength: 1
		cache: false
		# selectionRequired: false

		keywordParamName: "search"
		resultsProperty: "data"
		searchIn: ['name']
		valueProperty: 'slug'
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
	$(document).on 'change:flexdatalist','#level-three-enquiry input[name="get_categories"]', (event, item, options) ->
		key = ""
		categories_found = []

		$("#level-three-enquiry #enquiry_core_categories li input").each ()->
			categories_found.push $(this).val()
			return

		$(this).flexdatalist('params', {"category_level": 3, "ignore_categories": categories_found})
		event.preventDefault()
		return

	### --- On select of search box add new core categories  --- ###
	$(document).on 'select:flexdatalist','#level-three-enquiry input[name="get_categories"]', (event, item, options) ->
		key = ""

		html = "<li><label class=\"flex-row\"><input type=\"checkbox\" class=\"checkbox\" for=\" " + item["slug"] + " \" name=\"categories_interested[]\" value=\"" + item["slug"] + "\" data-parsley-trigger=\"change\" data-parsley-mincheck=\"1\" data-required=\"true\" required=\"true\" checked=\"checked\">
			<p class=\"text-medium categories__text flex-points__text text-color\" id=\"\">" + item["name"] + "</p></label>
				</li>"

		$("#level-three-enquiry #enquiry_core_categories").append html

		$(this).val ""

		event.preventDefault()
		return
	return

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

getBranchNodeCategories = (path, parent_id) ->
	html = ''

	$.ajax
		type: 'post'
		url: '/api/get_listing_categories'
		data: 
			'category_id': [parent_id]
		success: (data) ->
			key = undefined
			#$('#' + path + ' select[name="area"]').html html
			# console.log data["modal_template"]
			$(path).html data["modal_template"]
			return
		error: (request, status, error) ->
			throw Error()
			return
	return

getNodeCategories = (path, parent_id, checked_values) ->
	html = ''

	if checked_values.length <= 0
		$.each $(path + " input[type='checkbox']:checked"), ->
			checked_values.push $(this).val()
			return

	console.log checked_values

	$.ajax
		type: 'post'
		url: '/api/get_node_listing_categories'
		data: 
			'branch': [parent_id]
		success: (data) ->
			key = undefined
			### --- The HTML skeleton is defined under a <div id="node-skeleton"> --- ###
			# if $(document).find(path + " #node-skeleton").length > 0
			# 	html = $(path + " #node-skeleton").clone().removeClass('hidden').html()
			# 	html = html.replace(/\n/g, "").replace(/  /g, "") # Remove '\n' && '<space><space>' (Double spaces)
			# 	parser = new DOMParser()
			# 	html_dom = parser.parseFromString(html, "text/xml")

			# 	html_upload = ''

			# 	node_children = data["data"][0]["children"]
			# 	console.log html_dom
			# 	html_sub_dom = $(html_dom).find('ul li')
			# 	$(path + "div#" + data["data"][0]["id"])

			# 	if node_children.length > 0
			# 		index = 0
			# 		html_upload = "<ul class=\"nodes\">"
			# 		while index < node_children.length
			# 			# $(html_sub_dom).find("input[type='checkbox']").val(node_children[index]["id"])
			# 			# $(html_sub_dom).find("input[type='checkbox']").attr("for", node_children[index]["id"])
			# 			# $(html_sub_dom).find("p").val(node_children[index]["id"])
			# 			# $(html_sub_dom).find("p").text(node_children[index]["name"])
			# 			# $(html_dom).find('ul').append html_sub_dom
			# 			index++
			# 		html_upload += "</ul>"
			# 	else
			# 		html_upload = "Sorry! No Categories found under <b>" + data["data"][0]["name"] + "</b>."
			#	$(path + "div#" + data["data"][0]["id"]).append html_upload
			
			node_children = data["data"][0]["children"]
			$(path + "div#" + data["data"][0]["id"])

			if node_children.length > 0
				index = 0
				html_upload = "<ul class=\"nodes\">"
				while index < node_children.length
					html_upload += "<li><label class=\"flex-row\">"
					if checked_values.length > 0 and $.inArray(node_children[index]['slug'], checked_values) != -1
						html_upload += "<input type=\"checkbox\" class=\"checkbox\" for=\"" + node_children[index]['slug'] + "\" value=\""+ node_children[index]['slug'] + "\" checked=\"checked\">"
					else
						html_upload += "<input type=\"checkbox\" class=\"checkbox\" for=\"" + node_children[index]['slug'] + "\" value=\""+ node_children[index]['slug'] + "\">"
					html_upload += "<p class=\"lighter nodes__text\" id=\"" + node_children[index]['slug'] + "\">" + node_children[index]['name'] + "</p>"
					html_upload += "</label></li>"
					index++
				html_upload += "</ul>"
			else
				html_upload = "Sorry! No Categories found under <b>" + data["data"][0]["name"] + "</b>."
			$(path + "div#" + data["data"][0]["id"]).html html_upload
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

		if $(document).find("#level-one-enquiry").length > 0
			$('#enquiry-modal').on 'shown.bs.modal', () ->
				initFlagDrop("#level-one-enquiry input[name='contact']")
			
				$(document).on "countrychange", "#level-one-enquiry input[name='contact']", () ->
					$(this).val($(this).intlTelInput("getNumber"))
					return

			if $("#level-one-enquiry input[name='contact']").length <= 1 and $("#level-one-enquiry input[name='contact']").val().indexOf('+') > -1
				$("#level-one-enquiry input[name='contact']").val("")

		$(document).on "click", "div.col-sm-4 div.equal-col div.contact__enquiry button.fnb-btn.primary-btn", () ->
			if getCookie('user_id').length > 0
				if getCookie('user_type') == "user"
					# If user has account on website
					$("#login-modal").modal 'show' # show login popup
				else
					# If type exist & is not "user", then Show Popup
					getTemplate('step_1', $("#enquiry_slug").val())
					#$("div.container #enquiry-modal").modal 'show'
			else
				# Else User is Enquiring 1st time, hence the Popup
				$("div.container #enquiry-modal").modal 'show'
			return

		### --- On click of "Send Enquiry 1" button --- ###
		$(document).on "click", "#level-one-enquiry #level-one-form-btn", () ->
			page_level = if ($(this).data('value') and $(this).data('value').length > 0) then $(this).data('value') else 'step_1'
			if $(document).find("#level-one-enquiry").parsley().validate()
				getContent(page_level, $("#enquiry_slug").val())
			else
				console.log "forms not complete"
			
			return


		### --- On click of OTP submit button --- ###
		$(document).on "click", "#level-two-enquiry #level-two-form-btn", () ->
			getVerification($(this).data('value'), $("#enquiry_slug").val(), false, false, '')
			return

		### --- On click of OTP regenerate button --- ###
		$(document).on "click", "#level-two-enquiry #level-two-resend-btn", () ->
			getVerification($(this).data('value'), $("#enquiry_slug").val(), true, true, '')
			return

		### --- initialize the Flag in Popup 2 --- ###
		$(document).on "click", "#level-two-enquiry", () ->
			initFlagDrop("#level-two-enquiry #new-mobile-modal input[name='contact']")
			return

		### --- On click of 'x', close the Popup 2 modal --- ###
		$(document).on "click", "#level-two-enquiry #close-new-mobile-modal", () ->
			$(document).find("#new-mobile-modal").modal "hide"
			return

		### --- Change the Contact No & Regenarate OTP --- ###
		$(document).on "click", "#level-two-enquiry #new-mobile-verify-btn", () ->
			$("#enquiry-modal #listing_popup_fill div.verification__row span.mobile").text("+" + $(this).closest('div.new-verify-number').find("input[type='tel'][name='contact']").intlTelInput("getSelectedCountryData").dialCode + " " + $(this).closest('div.new-verify-number').find("input[type='tel'][name='contact']").val())
			$(document).find("#new-mobile-modal").modal "hide"
			getVerification($("#level-two-enquiry #level-two-resend-btn").data('value'), $("#enquiry_slug").val(), false, true, $(this).closest('div.new-verify-number').find("input[type='tel'][name='contact']").intlTelInput("getSelectedCountryData").dialCode + '-' + $(this).closest('div.new-verify-number').find("input[type='tel'][name='contact']").val())
			return

		$(document).on "change", "#level-three-enquiry #area_section select[name='city']", () ->
			city_vals = []
			i = 0
			$("#level-three-enquiry #area_section select[name='city'] option").removeClass 'hidden' # Remove all hidden class
			$("#level-three-enquiry #area_section select[name='city']").each -> # get the selected ID values
				city_vals.push $(this).val()
				return

			while i < city_vals.length
				$("#level-three-enquiry #area_section select[name='city'] option[value='" + city_vals[i] + "']").addClass 'hidden' # hide the selected ID values
				i++

			$("#level-three-enquiry #area_section select[name='city']").each ->
				if $.inArray($(this).val(), city_vals) > -1
					$(this).find("option[value='" + $(this).val() + "']").removeClass 'hidden'
				return

			#$(this).find("option[value='" + $(this).val() + "']").removeClass 'hidden' # remove hidden class for that "select"
			getArea($(this).val(), $(this).closest('ul').find('select[name="area"]'))
			return
		
		### --- On click of "+ Add more" on Enquiry 3 Popup "Areas", new set will be added --- ###
		$(document).on "click", "#level-three-enquiry #add-city-areas", () ->
			$("#area_dom_skeleton").clone("true").removeAttr('id').removeClass('hidden').appendTo("#area_section #area_operations")
			return

		### --- On click of close, remove the City-Area DOM --- ###
		$(document).on "click", "#level-three-enquiry #close_areas", () ->
			$("#level-three-enquiry #area_section select[name='city'] option[value='" + $(this).val() + "']").addClass('hidden')
			$("#level-three-enquiry #area_section select[name='city'] option[value='" + $(this).closest('ul').find("select[name='city']").val() + "']").removeClass 'hidden'
			$(this).closest("ul").remove()
			return

		### --- On click of Popup 3 'Save / Send' --- ###
		$(document).on "click", "#level-three-enquiry #level-three-form-btn", () ->
			page_level = if ($(this).data('value') and $(this).data('value').length > 0) then $(this).data('value') else 'step_1'

			if $(document).find("#level-three-enquiry #enquiry_core_categories").parsley().validate() and $(document).find("#level-three-enquiry #area_operations").parsley().validate()
				getContent(page_level, $("#enquiry_slug").val())
			else
				console.log "forms not complete"
			return

		### --- On click of "Add More" categories --- ###
		$(document).on "click", "#level-three-enquiry #select-more-categories", () ->
			main_page_categories = []
			$.each $("#level-three-enquiry input[name='categories_interested[]']:checked"), ->
				main_page_categories.push $(this).val()
				return

			$(document).on "shown.bs.modal", "#category-select", (event) ->
				$("#category-select #previously_available_categories").val(JSON.stringify(main_page_categories))
				return
			return

		### --- On Categories Modal close, update the Level 3 with checkboxes --- ###
		$(document).on "hidden.bs.modal", "#category-select", (event) ->
			checked_categories = []
			index = 0
			html = ""
			
			if $("#level-three-enquiry #modal_categories_chosen").val().length > 2 and JSON.parse($("#level-three-enquiry #modal_categories_chosen").val()).length > 0
				checked_categories = JSON.parse($("#level-three-enquiry #modal_categories_chosen").val())

			while index < checked_categories.length
				if $("#level-three-enquiry input[name='categories_interested[]'][value='" + checked_categories[index]["slug"] + "']").length > 0
					$("#level-three-enquiry input[name='categories_interested[]'][value='" + checked_categories[index]["slug"] + "']").prop "checked", "true"
				else
					html = "<li><label class=\"flex-row\"><input type=\"checkbox\" class=\"checkbox\" for=\" " + checked_categories[index]["slug"] + " \" name=\"categories_interested[]\" value=\"" + checked_categories[index]["slug"] + "\" data-parsley-trigger=\"change\" data-parsley-mincheck=\"1\" data-required=\"true\" required=\"true\" checked=\"checked\">
						<p class=\"text-medium categories__text flex-points__text text-color\" id=\"\">" + checked_categories[index]["name"] + "</p></label>
							</li>"
				index++

			if html.length > 0
				$("#level-three-enquiry #enquiry_core_categories").append html
			
			return

		# $(document).on "click", "#level-three-enquiry #category-select #level-one-category input[name='categories']", () ->
		# 	$("#level-three-enquiry #category-select #level-two-category").addClass "hidden"
		# 	$("#level-three-enquiry #category-select #level-one-category").removeClass "hidden"
		# 	# parent_category = $(this).parent().find("div.interested-label").text().replace(/\n/g, '').replace(/  /g, '')
		# 	# $("#level-three-enquiry #category-select #level-two-category span#main-cat-name").text(parent_category)
		# 	# $("#level-three-enquiry #category-select #level-two-category h5#main-cat-title").text(parent_category)
		# 	# $("#level-three-enquiry #category-select #level-two-category").removeClass "hidden"
		# 	# $("#level-three-enquiry #category-select #level-one-category").addClass "hidden"
		# 	return

		# ### --- On click of "Back to Categories", display "Category-One" & hide "Category-Two" --- ###
		# $(document).on "click", "#level-three-enquiry #category-select #back_to_categories", () ->
		# 	$("#level-three-enquiry #category-select #level-two-category").addClass "hidden"
		# 	$("#level-three-enquiry #category-select #level-one-category").removeClass "hidden"
		# 	return

		# $(document).on "click", "#level-three-enquiry #category-select #category-select-close", () ->
		# 	$(this).closest("div#category-select").modal 'hide'
		# 	return

		# $(document).on "change", "#level-three-enquiry #category-select #level-one-category input[name='select-categories']", () ->
		# 	if $(this).prop('checked')
		# 		$("#level-three-enquiry #category-select #level-one-category input[type='radio'][value='" + $(this).val() + "']").attr('disabled', 'true')
		# 	else
		# 		$("#level-three-enquiry #category-select #level-one-category input[type='radio'][value='" + $(this).val() + "']").removeAttr('disabled')
		# 	return

		# $(document).on "change", "#level-three-enquiry #category-select #level-one-category input[type='radio'][name='parent-categories']", () ->
		# 	getBranchNodeCategories("#level-three-enquiry #category-select #level-two-category-dom", $(this).val()) # add DOM to this level
		# 	$(this).closest("div#level-one-category").addClass "hidden"
		# 	get_core_cat_checked = []

		# 	$.each $("#level-three-enquiry input[type='checkbox'][name='categories_interested[]']:checked"), ->
		# 		get_core_cat_checked.push $(this).val()
		# 		return

		# 	setTimeout ( ->
		# 		console.log $("#level-three-enquiry #category-select #level-two-category #branch_categories li.active").find('a').attr("aria-controls")
		# 		getNodeCategories("#level-three-enquiry #category-select #level-two-category ", $("#level-three-enquiry #category-select #level-two-category #branch_categories li.active").find('a').attr("aria-controls"), get_core_cat_checked)
		# 	), 200
		# 	return

		# $(document).on "click", "#level-three-enquiry #category-select #level-two-category ul#branch_categories li", () ->
		# 	getNodeCategories("#level-three-enquiry #category-select #level-two-category ", $(this).find('a').attr("aria-controls"), [])
		# 	return

		# $(document).on "click", "#level-three-enquiry #category-select #level-two-category button#category-select-btn", () ->
		# 	checked_categories = []
		# 	main_page_categories = []

		# 	$.each $("#level-three-enquiry input[name='categories_interested[]']"), ->
		# 		main_page_categories.push $(this).val()
		# 		return

		# 	$.each $("#level-three-enquiry #category-select #level-two-category  #cat-dataHolder input[type='checkbox']:checked"), ->
		# 		if main_page_categories.length > 0 and $.inArray($(this).val(), main_page_categories) != -1
		# 			## -- If checkbox exist in the Enquiry popup, then just enable that checkbox -- ##
		# 			$("#level-three-enquiry input[name='categories_interested[]'][value='" + $(this).val() + "']").prop "checked", "true"
		# 		else
		# 			## -- else get the slug & name of the Node Categories -- ##
		# 			checked_categories.push {"slug": $(this).val(), "name": $(this).parent().find('p#' + $(this).val()).text() }
		# 		return
			
		# 	index = 0	
		# 	while index < checked_categories.length
		# 		html = "<li><label class=\"flex-row\"><input type=\"checkbox\" class=\"checkbox\" for=\" " + checked_categories[index]["slug"] + " \" name=\"categories_interested[]\" value=\"" + checked_categories[index]["slug"] + "\" data-parsley-trigger=\"change\" data-parsley-mincheck=\"1\" data-required=\"true\" required=\"true\" checked=\"checked\">
		# 		<p class=\"text-medium categories__text flex-points__text text-color\" id=\"\">" + checked_categories[index]["name"] + "</p></label>
		# 			</li>"
		# 		index++

		# 	$("#level-three-enquiry #enquiry_core_categories").append html
		# 	$("#level-three-enquiry #category-select").modal "hide"
		# 	return
	return