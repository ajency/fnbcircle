getTemplateHTML = (templateToRender, data) ->
	list = {}
	list['list'] = data

	theTemplateScript = $("#"+templateToRender).html()
	theTemplate = Handlebars.compile(theTemplateScript)

	htmlToRender = theTemplate(list)
	return htmlToRender

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
	return

getFilters = () ->
	filters = 
		"category_search": $(document).find('input[type="hidden"][name="category_search"].flexdatalist').val()#$('input[type="hidden"][name="category_search"]').val()
		"business_search": $('input[type="hidden"][name="business_search"]').val()
		"areas_selected": []
		"business_types": []
		"listing_status": []

	if filters["category_search"].length > 0
		updateUrlPushstate("category_search", "category_search" + "=" + filters["category_search"])
	else
		updateUrlPushstate("category_search", "")

	if filters["business_search"].length > 0
		updateUrlPushstate("business_search", "business_search" + "=" + filters["business_search"])
	else
		updateUrlPushstate("business_search", "")

	filters["categories"] =  $(".results__body ul.contents #current_category").val() #$(".results__body ul.contents a.bolder").attr("value")
	#updateUrlPushstate("categories", "categories" + "=" + filters["categories"])
	if $(".results__body ul.contents #current_category").val().length > 0 and $(".results__body ul.contents #current_category").val().indexOf("|[]") < 0
		updateUrlPushstate("categories", "categories" + "=" + filters["categories"])
	else
		updateUrlPushstate("categories", "")

	### --- Get 'area' values & update URL --- ###
	$("input[type='checkbox'][name='areas[]']:checked").each ->
		filters["areas_selected"].push $(this).val()
		return

	if filters["areas_selected"].length > 0
		updateUrlPushstate("areas_selected", "areas_selected" + "=" + JSON.stringify(filters["areas_selected"]))
	else
		updateUrlPushstate("areas_selected", "")
		updateUrlPushstate("location", "")

	### --- Get 'business_types' values & update URL --- ###
	$("input[type='checkbox'][name='business_type[]']:checked").each ->
		filters["business_types"].push $(this).val()
		return

	if filters["business_types"].length > 0
		updateUrlPushstate("business_types", "business_types" + "=" + JSON.stringify(filters["business_types"]))
	else
		updateUrlPushstate("business_types", "")

	### --- Get 'listing_status' values & update URL --- ###
	$("input[type='checkbox'][name='listing_status[]']:checked").each ->
		filters["listing_status"].push $(this).val()
		return
	
	if filters["listing_status"].length > 0
		updateUrlPushstate("listing_status", "listing_status" + "=" + JSON.stringify(filters["listing_status"]))
	else
		updateUrlPushstate("listing_status", "")

	return filters

capitalize = (string) ->
	return string.charAt(0).toUpperCase() + string.slice(1)

updateTextLabels = () ->
	### --- Update the Category labels --- ###
	if $(".listings-page a.bolder").text().length > 0
		$(".listings-page .category_label").text($(".listings-page a.bolder").text())
	else
		$(".listings-page span.category_label").text("All categories")
		$(".listings-page p.category_label").text("all")

	### --- Update the State labels --- ###
	if $('input[type="hidden"][name="city"]').val().length > 0
		$(".listings-page .state_label").text(capitalize($('input[type="hidden"][name="city"]').val()))
		$(".listings-page p.state_label").closest("a").prop("href", window.location.pathname + "?state=" + $('input[type="hidden"][name="city"]').val())
	else
		$(".listings-page span.state_label").text("India")
		$(".listings-page p.state_label").text("India")

	return

getListContent = () ->
	# data = 
	# 	"title" : "sharath"
	# 	"business_type" : 11
	# 	"verified" : 1
	page = if window.location.search.indexOf("page") > 0 then window.location.search.split("page=")[1].split("&")[0] else 1
	limit = if window.location.search.indexOf("limit") > 0 then window.location.search.split("limit=")[1].split("&")[0] else 1
	data = 
		"page": page
		"page_size": limit
		"sort_by": "published"
		"sort_order": "desc"
		"city" : $('input[type="hidden"][name="city"]').val()
		"area" : $("input[type='hidden'][name='area_hidden']").val()
		"filters":
			getFilters()

	$("#listing_card_view").css "filter", "blur(2px)"

	console.log getFilters()

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

				$(".container div.addShow p.search-actions__title label#listing_filter_count").text(start.toString() + " - " + end.toString() + " of " + data["count"])
			else
				start = 0
				end = 0
				$(".container div.addShow p.search-actions__title label#listing_filter_count").text(data["count"])

			### --- Load the filter template --- ###
			$("#listing_filter_view").html data["data"]["filter_view"]

			### --- Load the Listing card template --- ###
			$("#listing_card_view").html data["data"]["list_view"]
			$("#listing_card_view").css "filter", ""

			### --- Add the pagination to the HTML --- ###
			console.log data["data"]["paginate"]
			$(".listings-page #pagination").html data["data"]["paginate"]

			updateTextLabels()
			### --- Note: the function below is called again to update the URL post AJAX --- ###
			getFilters()
			$("input[type='hidden'][name='area_hidden']").val("")
			$(document).find(".results__body ul.contents #current_category").val("")

			### ---- HAndleBar template content load ---- ###
			# templateHTML = getTemplateHTML('listing_card_template',data["data"])
			# $('#listing_card_view').append(templateHTML)
		error: (request, status, error) ->
			$("#listing_card_view").css "filter", ""
			console.log error
	return

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

	### --- City filter dropdown --- ###
	## -- Note: flexdatalist appends "flexdatalist-" to the name i.e. name="city" becomes name="flexdatalist-city" -- ##
	$('input[type="hidden"][name="city"].flexdatalist').flexdatalist
		url: '/api/search-city'
		# params: {"search": $('input[type="hidden"][name="city"].flexdatalist').val()}
		requestType: 'post'
		# requestContentType: 'json'
		focusFirstResult: true

		minLength: 0
		cache: false
		selectionRequired: false
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
	
	$('input[type="hidden"][name="category_search"].flexdatalist').flexdatalist
		url: '/api/search-category'
		requestType: 'post'
		params: {"search": $('input[type="hidden"][name="category_search"].flexdatalist').val()}

		keywordParamName: "search"
		resultsProperty: "data"
		searchIn: ['name']
		valueProperty: 'node_children'
		visibleProperties: ["name", "search_name"] ## Order of display & dropdown contents to display

		minLength: 0
		cache: false
		
		searchContain: true
		searchEqual: false
		searchDisabled: false

		searchDelay: 200

		searchByWord: false
		allowDuplicateValues: false
		noResultsText: 'Sorry! No categories found for "{keyword}"'
	

	$('input[type="hidden"][name="business_search"].flexdatalist').flexdatalist
		url: '/api/search-business'
		requestType: 'post'
		params: {
			#"search": $('input[type="hidden"][name="business_search"].flexdatalist').val()
			"city": $('input[type="hidden"][name="city"].flexdatalist').val()
			"category": $('input[type="hidden"][name="category_search"].flexdatalist').val()
		}

		keywordParamName: "search"
		resultsProperty: "data"
		searchIn: ['title']
		valueProperty: 'id'
		visibleProperties: ["title", "area"] ## Order of display & dropdown contents to display
		
		minLength: 1
		cache: false

		searchContain: true
		searchEqual: false
		searchDisabled: false

		searchDelay: 200

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
					$('input[type="hidden"][name="' + search_box_params[key] + '"].flexdatalist').val(value_assigned)
				i++

		### --- Update Filter values --- ###
		# for key of filter_listing_params
		# 	i = 0
		# 	while i < get_params.length
		# 		if get_params[i].indexOf(key + "=") > -1
		# 			value_assigned = get_params[i].split("=")[1]

		# 			$('input[type="hidden"][id="' + filter_listing_params[key] + '"]').val(value_assigned)
		# 		i++

	### --- Triggered every time the value in input changes --- ###
	$('input[type="hidden"][name="city"].flexdatalist, input[type="hidden"][name="category_search"].flexdatalist, input[type="hidden"][name="business_search"].flexdatalist').on 'change:flexdatalist', () ->
		### -- make a request if any one the Searchbox is cleared -- ###
		key = ""
		
		if $(this).attr("name") == "city"
			key = "state"
		else
			key = $(this).attr("name")
		
		if $(this).val().length <= 0
			updateUrlPushstate(key, "")

			if $(this).prop("name") == "category_search"
				### --- update the value to null on change --- ###
				$(document).find(".results__body ul.contents #current_category").val($(this).val())

			## -- Do not make AJAX request if state is empty -- ##
			if key != "state" then getListContent() else ''
		# else if key == "category_search" and $(this).val().length <= 0
		# 	updateUrlPushstate(key, "")
		return

	### -- Triggered every time the user selects an option -- ###
	$('input[type="hidden"][name="city"].flexdatalist, input[type="hidden"][name="category_search"].flexdatalist, input[type="hidden"][name="business_search"].flexdatalist').on 'select:flexdatalist', () ->
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

		updateUrlPushstate(key, pushstate_url)

		setTimeout (->
			getListContent()
		), 500
		return

	### --- Detect <a> click --- ###
	$(document).on "click", ".results__body ul.contents a", (e) ->
		console.log "clicking Category"
		$(document).find(".results__body ul.contents #current_category").val($(this).attr("value"))
		#console.log $(this).attr("value")
		updateUrlPushstate("categories", "categories=" + JSON.stringify($(this).attr("value")))
		$(document).find('input[type="hidden"][name="category_search"].flexdatalist').val($(this).attr("value"))
		
		#getListContent()
		
		setTimeout (->
			getListContent()
			return
		), 100
		
		#console.log $(this).attr("value")
		#console.log $(this).text()
		# e.preventDefault()
		e.stopImmediatePropagation()
		return false

	### --- On click of Pagination, load that page --- ###
	$(document).on "click", "#pagination a.paginate.page", (e) ->
		updateUrlPushstate("page", "page=" + $(this).attr("page"))
		getListContent()
		return

	$(document).on "focusin", 'input[type="text"][name="flexdatalist-city"]', (event) ->
		old_values["state"] = $('input[type="hidden"][name="city"].flexdatalist').val()
		return

	$(document).on "focusout", 'input[type="text"][name="flexdatalist-city"]', (event) ->
		if $('input[type="hidden"][name="city"].flexdatalist').val().length <= 0
			$('input[type="hidden"][name="city"].flexdatalist').flexdatalist('value', old_values["state"])

		return

	### --- On filter checkbox select --- ###
	$(document).on "change", "input[type='checkbox'][name='areas[]'], input[type='checkbox'][name='business_type[]'], input[type='checkbox'][name='listing_status[]']", (e) ->
		getListContent()
		return
	
	$(document).on "input change", ".filter-group.area #section-area input[type='text']#area_search", (event) ->
		search_key = $(this).val()
		
		if search_key.length > 0
			$("input[type='checkbox'][name='areas[]']").parent().addClass('hidden')

			$("input[type='checkbox'][name='areas[]']").each ->
				if($(this).parent().text().toLowerCase().indexOf(search_key.toLowerCase()) > -1)
					$(this).parent().removeClass "hidden"
				return
		else
			$("input[type='checkbox'][name='areas[]']").parent().removeClass('hidden')
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


	return