getTemplateHTML = (templateToRender, data) ->
	list = {}
	list['list'] = data

	theTemplateScript = $("#"+templateToRender).html()
	theTemplate = Handlebars.compile(theTemplateScript)

	htmlToRender = theTemplate(list)
	return htmlToRender

### --- Function to check if Device is mobile or Desktop --- ###
isMobile = () ->
	if $(window).width() <= 768
		return true
	return false

# initHandleBars = () ->
# 	### --- Handle Bar template functions --- ###
# 	### --- Clear the listing_card_view section --- ###
# 	$('#listing_card_view').empty()
	
# 	### --- Custom If condition --- ###
# 	Handlebars.registerHelper 'ifCond', (v1, v2, options) ->
# 		if v1 == v2
# 			return options.fn(this)
# 		else
# 			return options.inverse(this)
# 		return


# 	Handlebars.registerHelper 'ifLogic', (v1, operator, v2, options) ->
# 		switch operator
# 			when '==', '===', 'is'
# 				return if v1 is v2 then options.fn this else options.inverse this
# 			when '!=', '!=='
# 				return if v1 != v2 then options.fn this else options.inverse this
# 			when '<'
# 				return if v1 < v2 then options.fn this else options.inverse this
# 			when '<='
# 				return if v1 <= v2 then options.fn this else options.inverse this
# 			when '>'
# 				return if v1 > v2 then options.fn this else options.inverse this
# 			when '>='
# 				return if v1 >= v2 then options.fn this else options.inverse this
# 			when '&&', 'and'
# 				return if v1 and v2 then options.fn this else options.inverse this
# 			when '||', 'or'
# 				return if v1 or v2 then options.fn this else options.inverse this
# 			else
# 				return options.inverse this
# 		return

# 	### --- formatDate condition --- ###
# 	Handlebars.registerHelper 'formatDate', (datetime, format, options) ->
# 		month_list = [
# 			"Jan", "Feb", "Mar", "Apr",
# 			"May", "Jun", "Jul", "Aug",
# 			"Sept", "Oct", "Nov", "Dec"
# 		]

# 		# mmnt = moment(date)
# 		# return mmnt.format(format)
# 		date_str = new Date(datetime)
# 		return date_str.getDate() + " " + month_list[date_str.getMonth()] + " " + date_str.getFullYear()

# 	return
# 	### --- End of Handle Bar template functions --- ###

getUrlSearchParams = () ->
	if window.location.search.split("?").length > 1
		return window.location.search.split("?")[1].split("&")
	else
		return [""]
	return

updateUrlPushstate = (key, pushstate_url) ->
	if window.location.search.length <= 0 and window.location.search.indexOf(key) <= -1 and pushstate_url.length > 0
		## -- No params in URL & no key & data is passed, then create -- ##
		window.history.pushState("", "", "?" + pushstate_url)
	else if window.location.search.length > 0 and window.location.search.indexOf(key) <= -1 and pushstate_url.length > 0
		## -- params in URL is there & no key & data is passed, then create -- ##
		window.history.pushState("", "", window.location.search + "&" + pushstate_url)
	else
		## -- params in URL & key exist -- ##
		params = getUrlSearchParams()
		old_url = ""
		i = 0
		
		if params.length > 0 and window.location.search.indexOf(key) > -1
			while i < params.length
				### --- remove the key from the URL --- ###
				if params[i].indexOf(key) <= -1
					old_url += (if old_url.length <= 0 then "?" else "&") + params[i]
				i++

			if pushstate_url.length > 0
				### --- the key has value, then update the new Value in the URL --- ###
				if old_url.length > 0
					window.history.pushState("", "", old_url + "&" + pushstate_url)
				else
					window.history.pushState("", "", "?" + pushstate_url)
			else
				### --- the key has no value, so update the url with rest of the keys --- ###
				if old_url.length > 0
					window.history.pushState("", "", old_url)
				else if window.location.search.length > 0
					window.history.pushState("", "", "?")

	return

### --- get the filters & Update the URL using PushState --- ###
getFilters = (update_url) ->
	filters = 
		"category_search": $(document).find('input[name="category_search"]').val()#$('input[name="category_search"]').val()
		"business_search": $('input[name="business_search"]').val()
		"areas_selected": []
		"business_types": []
		"listing_status": []


	filters["categories"] =  $(".results__body ul.contents #current_category").val() #$(".results__body ul.contents a.bolder").attr("value")
	
	### --- Get 'area' values --- ###
	$("input[type='checkbox'][name='areas[]']:checked").each ->
		filters["areas_selected"].push $(this).val()
		return

	### --- Get 'business_types' values --- ###
	$("input[type='checkbox'][name='business_type[]']:checked").each ->
		filters["business_types"].push $(this).val()
		return

	### --- Get 'listing_status' values --- ###
	$("input[type='checkbox'][name='listing_status[]']:checked").each ->
		filters["listing_status"].push $(this).val()
		return
	
	if update_url
		### --- Update 'category_search' in URL --- ###
		# if filters["category_search"].length > 0 and filters["category_search"].indexOf("|[]") < 0
		# 	updateUrlPushstate("category_search", "category_search" + "=" + filters["category_search"])
		# else
		# 	updateUrlPushstate("category_search", "")
		
		### --- Update 'business_search' in URL --- ###
		if filters["business_search"].length > 0
			updateUrlPushstate("business_search", "business_search" + "=" + filters["business_search"])
		else
			updateUrlPushstate("business_search", "")

		### --- Update 'categories' in URL --- ###
		#updateUrlPushstate("categories", "categories" + "=" + filters["categories"])
		if $(".results__body ul.contents #current_category").val().length > 0 and $(".results__body ul.contents #current_category").val().indexOf("|[]") < 0
			updateUrlPushstate("categories", "categories" + "=" + filters["categories"])
		else
			updateUrlPushstate("categories", "")

		### --- Update 'areas_selected' in URL --- ###
		if filters["areas_selected"].length > 0
			updateUrlPushstate("areas_selected", "areas_selected" + "=" + JSON.stringify(filters["areas_selected"]))
		else
			updateUrlPushstate("areas_selected", "")
			updateUrlPushstate("location", "")

		### --- Update 'business_types' in URL --- ###
		if filters["business_types"].length > 0
			updateUrlPushstate("business_types", "business_types" + "=" + JSON.stringify(filters["business_types"]))
		else
			updateUrlPushstate("business_types", "")

		### --- Update 'listing_status' in URL --- ###
		if filters["listing_status"].length > 0
			updateUrlPushstate("listing_status", "listing_status" + "=" + JSON.stringify(filters["listing_status"]))
		else
			updateUrlPushstate("listing_status", "")

	return filters

### --- Clear the filters --- ###
resetFilter = () ->
	checkbox_name_list = ["areas[]", "business_type[]", "listing_status[]"]
	
	i = 0
	### --- Clear the Checkboxes --- ###
	while i < checkbox_name_list.length
		$("input[type='checkbox'][name='" + checkbox_name_list[i] + "']").prop("checked", "")
		i++

	$(".results__body ul.contents #current_category").val("") ## Clear the Categories filter
	return

resetPagination = () ->
	updateUrlPushstate("page", "page=1")
	return

### --- Capitalize 1st character of the string --- ###
capitalize = (string) ->
	return string.charAt(0).toUpperCase() + string.slice(1)

### --- Update the text labels on change of DOM / content --- ###
updateTextLabels = () ->
	### --- Update the Category labels --- ###
	if $(".listings-page a.bolder").text().length > 0
		$(".listings-page .category_label").text($(".listings-page a.bolder").text())
	else
		#$(".listings-page span.category_label").text("All categories")
		$(".listings-page span.category_label").text ""
		$(".listings-page h5 span.category_label").text "All"
		$(".listings-page p.category_label").text "All"

	### --- Update the State labels --- ###
	if $('input[name="city"]').val().length > 0
		$(".listings-page .state_label").text(capitalize($('input[name="city"]').val()))
		$(".listings-page p.state_label").closest("a").prop("href", window.location.pathname + "?state=" + $('input[name="city"]').val())
	else
		$(".listings-page span.state_label").text("India")
		$(".listings-page p.state_label").text("India")

	return

### --- Update the Filter's DOM --- ###
getFilterContent = () ->
	page = if window.location.search.indexOf("page") > 0 then window.location.search.split("page=")[1].split("&")[0] else 1
	limit = if window.location.search.indexOf("limit") > 0 then window.location.search.split("limit=")[1].split("&")[0] else 10

	data = 
		"page": page
		"page_size": limit
		"sort_by": "published"
		"sort_order": "desc"
		"city" : $('input[name="city"]').val()
		"area" : $("input[type='hidden'][name='area_hidden']").val()
		"filters":
			getFilters(false)

	# $("#listing_card_view").css "filter", "blur(2px)"

	# console.log getFilters()

	$.ajax
		type: 'post'
		url: '/api/get-listview-data'
		data: data
		dataType: 'json'
		success: (data) ->
			#$("#listing_filter_view").html data["filtered_view"]
			#console.log data
			# if parseInt(data["count"]) > parseInt(data["page"] - 1) * parseInt(data["page_size"])
			# 	start = (parseInt(data["page"]) - 1) * parseInt(data["page_size"]) + 1
			# 	end = start + parseInt(data["page_size"]) - 1 # (parseInt(data["page"]) - 1) * parseInt(data["page_size"]) + 1

			# 	end = if(end > parseInt(data["count"])) then parseInt(data["count"]) else end
				
			# 	if isMobile()
			# 		$(".container div.addShow p.search-actions__title label#listing_filter_count").text(data["count"])
			# 	else
			# 		$(".container div.addShow p.search-actions__title label#listing_filter_count").text(start.toString() + " - " + end.toString() + " of " + data["count"])
			# else
			# 	start = 0
			# 	end = 0
			# 	$(".container div.addShow p.search-actions__title label#listing_filter_count").text(data["count"])

			### --- Load the filter template --- ###
			$("#listing_filter_view").html data["data"]["filter_view"]

			### --- Add the pagination to the HTML --- ###
			# $(".listings-page #pagination").html data["data"]["paginate"]

			updateTextLabels()
			### --- Note: the function below is called again to update the URL post AJAX --- ###
			getFilters(false)
			$("input[type='hidden'][name='area_hidden']").val("")
			# $(document).find(".results__body ul.contents #current_category").val("")

			### ---- HAndleBar template content load ---- ###
			# templateHTML = getTemplateHTML('listing_card_template',data["data"])
			# $('#listing_card_view').append(templateHTML)
		error: (request, status, error) ->
			$("#listing_card_view").css "filter", ""
			console.log error
	return

### --- Update the Filter & Content DOM --- ###
getListContent = () ->
	page = if window.location.search.indexOf("page") > 0 then window.location.search.split("page=")[1].split("&")[0] else 1
	limit = if window.location.search.indexOf("limit") > 0 then window.location.search.split("limit=")[1].split("&")[0] else 10

	data = 
		"page": page
		"page_size": limit
		"sort_by": "published"
		"sort_order": "desc"
		"city" : $('input[name="city"]').val()
		"area" : $("input[type='hidden'][name='area_hidden']").val()
		"filters":
			getFilters(true)

	# $("#listing_card_view").css "filter", "blur(2px)"
	$(".listings-page .site-loader.section-loader").removeClass "hidden"
	# console.log getFilters()

	$.ajax
		type: 'post'
		url: '/api/get-listview-data'
		data: data
		dataType: 'json'
		success: (data) ->
			#$("#listing_filter_view").html data["filtered_view"]
			#console.log data
			if parseInt(data["count"]) > parseInt(data["page"] - 1) * parseInt(data["page_size"])
				start = (parseInt(data["page"]) - 1) * parseInt(data["page_size"]) + 1
				end = start + parseInt(data["page_size"]) - 1 # (parseInt(data["page"]) - 1) * parseInt(data["page_size"]) + 1

				end = if(end > parseInt(data["count"])) then parseInt(data["count"]) else end

				if isMobile()
					$(".container div.addShow p.search-actions__title label#listing_filter_count").text(data["count"])
				else
					$(".container div.addShow p.search-actions__title label#listing_filter_count").text(start.toString() + " - " + end.toString() + " of " + data["count"])
			else
				start = 0
				end = 0
				$(".container div.addShow p.search-actions__title label#listing_filter_count").text(data["count"])

			### --- Load the filter template --- ###
			$("#listing_filter_view").html data["data"]["filter_view"]

			### --- Load the Listing card template --- ###
			$("#listing_card_view").html data["data"]["list_view"]
			# $("#listing_card_view").css "filter", ""

			$(".listings-page .site-loader.section-loader").addClass "hidden"

			### --- For mobile Screen --- ###
			if $(window).width() <= 768
			  businessListing = $('.businessListing').detach()
			  $('.addShow').after businessListing
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
			  advAdd = $('.adv-row').detach()
			  $('.adv-after').append advAdd
			  $('.recent-updates__text').click ->
				  $(this).parent('.recent-updates').siblings('.updates-dropDown').slideToggle 'slow'
				  $(this).toggleClass 'active'
				  $(this).find('.arrowDown').toggleClass 'fa-rotate-180'


			### --- Add the pagination to the HTML --- ###
			# console.log data["data"]["paginate"]
			$(".listings-page #pagination").html data["data"]["paginate"]

			updateTextLabels()
			### --- Note: the function below is called again to update the URL post AJAX --- ###
			getFilters(true)
			$("input[type='hidden'][name='area_hidden']").val("")
			# $(document).find(".results__body ul.contents #current_category").val("")

			### ---- HAndleBar template content load ---- ###
			# templateHTML = getTemplateHTML('listing_card_template',data["data"])
			# $('#listing_card_view').append(templateHTML)
		error: (request, status, error) ->
			$(".listings-page .site-loader.section-loader").addClass "hidden"
			console.log error
	return

### --- Search the list of city & area on text type --- ###
getCity = (data, populate_id) ->
	$.ajax
		type: 'post'
		url: '/api/search-city'
		data: data
		dataType: 'json'
		# async: false
		success: (data) ->
			html_content = ""
			updateCityDropdown(data["data"], populate_id)
		error: (request, status, error) ->
			console.log error
	return

### --- Generate the City list dropdown --- ###
updateCityDropdown = (data, populate_id) ->
	if data.length
		data.forEach (value, index) ->
			html_content += "<option value=\"" + value.slug + "\">" + value.name + "</option>"
	else
		html_content = "<option value=\"\"></option>"
	
	$("#" + populate_id).html html_content
	return

$(document).ready () ->
	### --- This object is used to store old values -> Mainly for search-boxes --- ###
	old_values = {}

	### --- Load all the popular city on load --- ###
	# getCity({"search": ""}, "states")
	updateTextLabels()

	window.onpopstate = (event) ->
		console.log "back "
		if event and event.state
			window.location.reload()
			return

	### --- City filter dropdown --- ###
	## -- Note: flexdatalist appends "flexdatalist-" to the name i.e. name="city" becomes name="flexdatalist-city" -- ##
	$('input[name="city"]').flexdatalist
		url: '/api/search-city'
		# params: {"search": $('input[name="city"]').val()}
		requestType: 'post'
		# requestContentType: 'json'
		# focusFirstResult: true

		minLength: 0
		cache: false
		selectionRequired: true
		keywordParamName: 'search'
		resultsProperty: "data"
		searchIn: ['search_text']
		valueProperty: 'search_value'
		visibleProperties: ["search_text"]#["name", "city"]
		# textProperty: '{name}, {city}'
		# toggleSelected: true

		#-- Limit the number of values in a multiple input. --#
		#limitOfValues: 2

		#-- On backspace key, remove previous value (multiple values setting) --#
		# removeOnBackspace: false

		#-- Delimiter used in multiple values. --#
		# valuesSeparator: ','
		
		searchContain: true
		#searchEqual: false
		#searchDisabled: false

		searchDelay: 200

		searchByWord: true
		allowDuplicateValues: false
		debug: false
		noResultsText: 'Sorry! No results found for "{keyword}"'
	
	$('input[name="category_search"]').flexdatalist
		url: '/api/search-category'
		requestType: 'post'
		# params: {"search": $('input[name="category_search"]').val()}

		minLength: 0
		cache: false
		selectionRequired: false

		keywordParamName: "search"
		resultsProperty: "data"
		searchIn: ['name']
		valueProperty: 'node_children'
		visibleProperties: ["name", "search_name"] ## Order of display & dropdown contents to display
		
		searchContain: true
		# searchEqual: false
		# searchDisabled: false

		#searchDelay: 200

		searchByWord: true
		allowDuplicateValues: false
		debug: false
		noResultsText: 'Sorry! No categories found for "{keyword}"'
	

	$('input[name="business_search"]').flexdatalist
		url: '/api/search-business'
		requestType: 'post'
		params: {
			#"search": $('input[name="business_search"]').val()
			"city": old_values["state"]
			"category": $('input[name="category_search"]').val()
		}

		keywordParamName: "search"
		resultsProperty: "data"
		searchIn: ['title']
		valueProperty: 'slug'
		visibleProperties: ["title", "area"] ## Order of display & dropdown contents to display
		
		minLength: 1
		cache: false

		searchContain: true
		searchEqual: false
		searchDisabled: false

		#searchDelay: 200

		searchByWord: false
		allowDuplicateValues: false
		noResultsText: 'Sorry! No business names found for this search criteria'#'Sorry! No business names found for "{keyword}"'

	### --- Update the filters from the URL if any exist --- ###
	if window.location.search.length > 0
		search_box_params =
			#"state" : "city"
			"category_search" : "category_search"
			"business_search" : "business_search"

		filter_listing_params =
			"categories" : "current_category"

		get_params = getUrlSearchParams()

		### --- Update SearchBox values --- ###
		for key of search_box_params
			i = 0
			while i < get_params.length
				if get_params[i].indexOf(key + "=") > -1
					value_assigned = get_params[i].split("=")[1]
					$('input[name="' + search_box_params[key] + '"]').flexdatalist('value', value_assigned)
				i++

		### --- Update Filter values --- ###
		# for key of filter_listing_params
		# 	i = 0
		# 	while i < get_params.length
		# 		if get_params[i].indexOf(key + "=") > -1
		# 			value_assigned = get_params[i].split("=")[1]

		# 			$('input[id="' + filter_listing_params[key] + '"]').val(value_assigned)
		# 		i++

	### --- Triggered every time the value in input changes --- ###
	$('input[name="city"], input[name="category_search"], input[name="business_search"]').on 'change:flexdatalist', (event, set, options) ->
		### -- make a request if any one the Searchbox is cleared -- ###
		key = ""

		if $(this).attr("name") == "city"
			key = "state"
		else
			key = $(this).attr("name")

		if $(this).attr("name") == "business_search"
			$('input[name="business_search"]').flexdatalist('params', {'city': $('input[name="city"]').val()})
		
		if $(this).val().length <= 0
			updateUrlPushstate(key, "")

			if $(this).prop("name") == "category_search"
				### --- update the value to null on change --- ###
				$(document).find(".results__body ul.contents #current_category").val($(this).val())

			# console.log $(this).val()
			## -- Do not make AJAX request if state is empty -- ##
			# if key != "state" then getListContent() else ''
			if key != "state"
				resetPagination()
				getListContent()
			
			## --  For mobile -- ##
			#if key != "state" && isMobile()
			#	$('.searchBy.fly-out').removeClass 'active'
		return
		# else if key == "category_search" and $(this).val().length <= 0
		# 	updateUrlPushstate(key, "")
		return

	### -- Triggered every time the user selects an option -- ###
	$('input[name="city"], input[name="category_search"], input[name="business_search"]').on 'select:flexdatalist', () ->
		key = ""

		if $(this).prop("name") == "category_search"
			$(document).find(".results__body ul.contents #current_category").val($(this).val())

		if $(this).attr("name") == "city"
			key = "state"
			
			location = if $(this).val().split(',').length <= 1 then $(this).val() else $(this).val().split(',')[1] # Get State
			areas = if $(this).val().split(',').length > 1 then $(this).val().split(',')[0] else '' # Get area

			$(this).flexdatalist('value', location)
			pushstate_url = key + "=" + location

			old_values["state"] = location ## Assign the value to the temp old_values list

			### --- Clear the Area selection section --- ###
			$("input[type='checkbox'][name='areas[]']").prop("checked", "")
			
			if areas.length > 0
				$("input[name='area_hidden']").val areas
				updateUrlPushstate("location", "location=" + areas)
				updateUrlPushstate("areas_selected", "areas_selected=" + JSON.stringify([areas]))
			else
				$("input[name='area_hidden']").val ""
				updateUrlPushstate("location", "")
		else
			key = $(this).attr("name")
			pushstate_url = $(this).attr("name") + "=" + $(this).val()

		if key != "category_search"
			updateUrlPushstate(key, pushstate_url)

		if isMobile()
			setTimeout (->
				resetPagination()
				getListContent()
				return
			), 500
			
			$('.searchBy.fly-out').removeClass 'active'
		else
			setTimeout (->
				resetPagination()
				getListContent()
				return
			), 500
		return

	### --- Detect <a> click for categories --- ###
	$(document).on "click", ".results__body ul.contents a", (e) ->
		$(document).find(".results__body ul.contents #current_category").val($(this).attr("value"))
		# updateUrlPushstate("categories", "categories=" + $(this).attr("value"))
		#$(document).find('#category input[name="category_search"]').flexdatalist('value', $(this).attr("value"))

		# $('#category input[name="category_search"]').prop('value', $(this).attr("value"))
		$('#category input[name="category_search"]').flexdatalist('value', $(this).attr("value"))

		#getListContent()
		if not isMobile()
			setTimeout (->
				resetPagination()
				getListContent()
				return
			), 100
		else
			getFilterContent()
		
		#console.log $(this).attr("value")
		#console.log $(this).text()
		# e.preventDefault()
		# e.stopImmediatePropagation()
		return false

	### --- On click of Pagination, load that page --- ###
	$(document).on "click", "#pagination a.paginate.page", (e) ->
		updateUrlPushstate("page", "page=" + $(this).attr("page"))

		if window.location.search.indexOf("limit") < 0 then updateUrlPushstate("limit", "limit=10") else ''
		getListContent()
		return

	### --- On City Searchbox focusIn, copy the value in the searchbox --- ###
	$(document).on "focusin", 'input[type="text"][name="flexdatalist-city"]', (event) ->
		old_values["state"] = $('input[name="city"]').val()
		$('input[name="city"]').flexdatalist 'value', ""
		return

	### --- On City Searchbox focusOut, if the textbox is NULL, then restore old value in the searchbox --- ###
	$(document).on "focusout", 'input[type="text"][name="flexdatalist-city"]', (event) ->
		setTimeout (->
			if $('input[name="city"]').val().length <= 0
				$('input[name="city"]').flexdatalist 'value', old_values["state"]
		), 200
		return

	### --- On filter checkbox select --- ###
	$(document).on "change", "input[type='checkbox'][name='areas[]'], input[type='checkbox'][name='business_type[]'], input[type='checkbox'][name='listing_status[]']", (e) ->
		# getListContent()
		if not isMobile()
			setTimeout (->
				resetPagination()
				getListContent()
				return
			), 100
		else
			getFilterContent()
		return

	### --- Clear the Filter Area, Business-Type, Listing-Status checkbox --- ###
	$(document).on "click", "div#section-area div.check-section label.sub-title.clear, div#section-business div.check-section label.sub-title.clear, div#section-list-status div.check-section label.sub-title.clear", (e) ->
		e.preventDefault()

		checkbox_name_linking = 
			"section-area": "areas[]"
			"section-business": "business_type[]"
			"section-list-status": "listing_status[]"

		$("input[type='checkbox'][name='" + checkbox_name_linking[$(this).parent().parent().attr("id")] + "']").prop("checked", "")

		resetPagination()
		getListContent()
		return

	### --- On click of "Clear All" in filters --- ###
	$(document).on "click", ".filterBy a#clear_all_filters", (e) ->
		if isMobile()
			resetFilter()
			setTimeout (->
				getListContent()
				return
			), 100

			$('.filterBy.fly-out').removeClass 'active'

		return
	
	### --- Mobile => If User clicks on the clear-search link, then clear that searchbox --- ###
	$(document).on "click", ".searchBy #clear_search", (e) ->
		if isMobile()
			$(this).parent().find('input').val("")
			setTimeout (->
				resetPagination()
				getListContent()
				return
			), 100
			
			$('.searchBy.fly-out').removeClass 'active'
		return

	### --- Mobile => Apply the filter on 'Apply' button click --- ###
	$(document).on "click", "#apply_listing_filter", (e) ->
		if isMobile()
			setTimeout (->
				resetPagination()
				getListContent()
				return
			), 100
			
			$('.filterBy.fly-out').removeClass 'active'
		return

	### --- On click --- ###
	$(document).on "click", "#section-area #moreAreaShow", (event) ->
		
		if $(this).attr('aria-expanded') == "true"
			$(this).text($(this).text().replace("more", "less"))
		else
			$(this).text($(this).text().replace("less", "more"))
		return

	### --- On Input / Change of area-search in Left filterbox, search the name --- ###
	$(document).on "input change", ".filter-group.area #section-area input[type='text']#area_search", (event) ->
		search_key = $(this).val()
		areas_found = 0

		if not ($(this).closest("#section-area").find("#moreDown").attr('aria-expanded') == "true")
			$(this).closest("#section-area").find("#moreDown").collapse 'show'
		
		if search_key.length > 0
			$("input[type='checkbox'][name='areas[]']").parent().addClass 'hidden'

			$("input[type='checkbox'][name='areas[]']").each ->
				if($(this).parent().text().toLowerCase().indexOf(search_key.toLowerCase()) > -1)
					areas_found += 1
					$(this).parent().removeClass "hidden"
				return
			
			## -- Hide other cities & display the "area found" count -- ##
			# if areas_found > 0 and areas_found - parseInt($(this).closest("#section-area").find("#areas_hidden").val()) > 0
			# 	$(this).closest("#section-area").find("#moreAreaShow").text("+ " + areas_found - parseInt($(this).closest("#section-area").find("#areas_hidden").val()) + " more")

			## -- Hide "+'n' more" areas TEXT on search -- ##
			$(this).closest("#section-area").find("#moreAreaShow").addClass 'hidden'
		else
			## -- If the areas are greater than 0, then hide "other areas" section -- ##
			if $(this).closest("#section-area").find("#areas_hidden").val() > 0
				$(this).closest("#section-area").find("#moreDown").collapse 'hide'
			$(this).closest("#section-area").find("#moreAreaShow").removeClass 'hidden'
			$("input[type='checkbox'][name='areas[]']").parent().removeClass 'hidden'
		return
	
	# initHandleBars()

	### --- Working of "Back to Top" button --- ###
	$(window).scroll ->
		if $(this).scrollTop() > 500
			$('.listings-page #backToTop').fadeIn()
		else
			$('.listings-page #backToTop').fadeOut()
		return

	$('.listings-page #backToTop').on "click", () ->
		$('body, html').animate { 
			scrollTop: 0
		}, 1000
		return

	### --- 
	#	Timeout of 1 sec set as the values in search boxes are initially empty & are load from JS,
	#	hence a timelag is set so that value is assigned, then function call is made 
	--- ###
	setTimeout (->
		getListContent()
		return
	), 1000

	$(document).on 'click', '.send-enquiry', ->
		$('.enquiry-card').addClass 'active'
		return

	$(document).on 'click', '.back-icon', ->
		$('.fly-out').removeClass 'active'
		return

# $(document).ready ->
# 	setTimeout (->
# 		### --- For mobile Screen --- ###
# 		if $(window).width() <= 768
# 		  businessListing = $('.businessListing').detach()
# 		  $('.addShow').after businessListing
# 		  $('.filter-data').each ->
# 		    detailrow = $(this).find('.recent-updates__content')
# 		    detailbtn = $(this).find('.detail-move').detach()
# 		    $(detailrow).append detailbtn
# 		    recentrow = $(this).find('.updates-dropDown')
# 		    recentData = $(this).find('.recent-data').detach()
# 		    $(recentrow).append recentData
# 		    publishedAdd = $(this).find('.stats')
# 		    publisherow = $(this).find('.rat-pub').detach()
# 		    $(publishedAdd).append publisherow
# 		    power = $(this).find('.power-seller-container')
# 		    powerseller = $(this).find('.power-seller').detach()
# 		    $(power).append powerseller
# 		    return
# 		  advAdd = $('.adv-row').detach()
# 		  $('.adv-after').append advAdd
# 		  $('.recent-updates__text').click ->
# 			  $(this).parent('.recent-updates').siblings('.updates-dropDown').slideToggle 'slow'
# 			  $(this).toggleClass 'active'
# 			  $(this).find('.arrowDown').toggleClass 'fa-rotate-180'
# 		return
# 	), 1500






