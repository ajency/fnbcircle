getTemplateHTML = (templateToRender, data) ->
	list = {}
	list['list'] = data

	theTemplateScript = $("#"+templateToRender).html()
	theTemplate = Handlebars.compile(theTemplateScript)

	htmlToRender = theTemplate(list)
	return htmlToRender

getUrlSearchParams = () ->
	if window.location.search.split("?").length > 1
		return window.location.search.split("?")[1].split("&")
	else
		return [""]
	return

getListContent = () ->
	# data = 
	# 	"title" : "sharath"
	# 	"business_type" : 11
	# 	"verified" : 1

	data = 
		"page": 1,
		"page_size": 10,
		"sort_by": "published",
		"sort_order": "desc",
		"city" : $('input[type="hidden"][name="city"]').val(),
		# "node_category": 1,
		"filters":
		# 	"areas": [1, 2, 6],
		# 	"business_type": [11, 12, 13],
		# 	"listing_status": [],
			"category_search": $('input[type="hidden"][name="category_search"]').val(),
			"business_search": $('input[type="hidden"][name="business_search"]').val(),
		# 	"rating": []

	$("#listing_card_view").css "filter", "blur(2px)"

	$.ajax
		type: 'post'
		url: '/api/get-listview-data'
		data: data
		dataType: 'json'
		success: (data) ->
			#$("#listing_filter_view").html data["filtered_view"]
			#console.log data
			if parseInt(data["count"]) > 0
				start = (parseInt(data["page"]) - 1) * parseInt(data["page_size"]) + 1
				end = start + parseInt(data["page_size"]) - 1

				end = if((end % parseInt(data["count"])) < parseInt(data["count"])) then parseInt(data["count"]) else end

				$(".container div.addShow p.search-actions__title label#listing_filter_count").text(start.toString() + " - " + end.toString() + " of " + data["count"])
			else
				start = 0
				end = 0
				$(".container div.addShow p.search-actions__title label#listing_filter_count").text(data["count"])

			$("#listing_card_view").html data["data"]["list_view"]
			$("#listing_card_view").css "filter", ""

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

	### --- Load all the popular city on load --- ###
	getCity({"search": ""}, "states")

	
	
	### --- City filter dropdown --- ###
	## -- Note: flexdatalist appends "flexdatalist-" to the name i.e. name="city" becomes name="flexdatalist-city" -- ##
	$('input[type="hidden"][name="city"].flexdatalist').flexdatalist
		url: '/api/search-city'
		params: {"search": $('input[type="hidden"][name="city"].flexdatalist').val()}
		requestType: 'post'
		
		keywordParamName: 'search'
		resultsProperty: "data"
		searchIn: ['name']
		valueProperty: 'slug'
		# toggleSelected: true
		minLength: 0
		cache: false

		# Limit the number of values in a multiple input.
		#limitOfValues: 2

		# Delimiter used in multiple values.
		# valuesSeparator: ','
		
		searchContain: true
		searchEqual: false
		searchDisabled: false
		# visibleProperties: ["id","name", "slug"]

		searchDelay: 200

		searchByWord: false
		allowDuplicateValues: false
		noResultsText: 'Sorry! No results found for "{keyword}"'
	
	
	$('input[type="hidden"][name="category_search"].flexdatalist').flexdatalist
		url: '/api/search-category'
		requestType: 'post'
		params: {"search": $('input[type="hidden"][name="category_search"].flexdatalist').val()}

		keywordParamName: "search"
		resultsProperty: "data"
		searchIn: ['name']
		valueProperty: 'id'
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
		params: {"search": $('input[type="hidden"][name="business_search"].flexdatalist').val()}

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
		noResultsText: 'Sorry! No business names found for "{keyword}"'

	### --- Update the filters from the URL if any exist --- ###
	if window.location.search.length > 0
		search_box_params =
			"state" : "city"
			"category_search" : "category_search"
			"business_search" : "business_search"

		get_params = getUrlSearchParams()

		for key of search_box_params
			i = 0
			while i < get_params.length
				if get_params[i].indexOf(key + "=") > -1
					$('input[type="hidden"][name="' + search_box_params[key] + '"].flexdatalist').val(get_params[i].split("=")[1])
				i++

	### --- Triggered every time before display of data --- ###
	# $('input[type="text"][name="city"].flexdatalist').on 'before:flexdatalist.search', (e) ->
	# 	# if $(this).val().length <= 0
	# 	# 	$(this).attr('list', "imp-states")
	# 	# else
	# 	# 	$(this).attr('list', "states")
	# 	data = 
	# 		"search" : $(this).val()
	# 	getCity(data, "states")

	# 	#e.stopPropagation()
	# 	return

	### --- Triggered every time the value in input changes --- ###
	# $('input[type="hidden"][name="city"].flexdatalist').on 'change:flexdatalist', () ->
	# 	data = 
	# 		"search" : $(this).val()
	# 	getCity(data, "states")

	# 	### -- make a request if the Searchbox is cleared -- ###
	# 	if $(this).val().length <= 0
	# 		key = "state"
	# 		pushstate_url = "state=" + $(this).val()

	# 		getListContent()
	# 	return

	$('input[type="hidden"][name="city"].flexdatalist, input[type="hidden"][name="category_search"].flexdatalist, input[type="hidden"][name="business_search"].flexdatalist').on 'change:flexdatalist', () ->
		### -- make a request if any one the Searchbox is cleared -- ###
		if $(this).val().length <= 0
			key = ""
			if $(this).attr("name") == "city"
				key = "state"
			else
				key = $(this).attr("name")
			
			if window.location.search.length > 0 and window.location.search.indexOf(key) > -1
				params = window.location.search.split('?')[1].split("&")
				old_url = ""
				i = 0
				
				while i < params.length
					if params[i].indexOf(key) <= -1
						old_url += (if old_url.length <= 0 then "?" else "&") + params[i]
					i++
				
				if old_url.length > 0
					window.history.pushState("", "", old_url)
				else
					window.history.pushState("", "", "?")
		
			getListContent()		
		return

	### -- Triggered every time the user selects an option -- ###
	$('input[type="hidden"][name="city"].flexdatalist, input[type="hidden"][name="category_search"].flexdatalist, input[type="hidden"][name="business_search"].flexdatalist').on 'select:flexdatalist', () ->
		key = ""
		if $(this).attr("name") == "city"
			key = "state"
			pushstate_url = "state=" + $(this).val()
		else
			key = $(this).attr("name")
			pushstate_url = $(this).attr("name") + "=" + $(this).val()

		if window.location.search.length <= 0 and window.location.search.indexOf(key) <= -1
			## -- No params in URL & no data -- ##
			window.history.pushState("", "", "?" + pushstate_url)
		else if window.location.search.length > 0 and window.location.search.indexOf(key) <= -1
			window.history.pushState("", "", window.location.search + "&" + pushstate_url)
		else
			params = window.location.search.split('?')[1].split("&")
			old_url = ""
			i = 0
			
			while i < params.length
				if params[i].indexOf(key) <= -1
					old_url += (if old_url.length <= 0 then "?" else "&") + params[i]
				i++

			if old_url.length > 0
				window.history.pushState("", "", old_url + "&" + pushstate_url)
			else
				window.history.pushState("", "", "?" + pushstate_url)

		getListContent()
		
		return




	# ### --- Handle Bar template functions --- ###
	# ### --- Clear the listing_card_view section --- ###
	# $('#listing_card_view').empty()
	
	# ### --- Custom If condition --- ###
	# Handlebars.registerHelper 'ifCond', (v1, v2, options) ->
	# 	if v1 == v2
	# 		return options.fn(this)
	# 	else
	# 		return options.inverse(this)
	# 	return


	# Handlebars.registerHelper 'ifLogic', (v1, operator, v2, options) ->
	# 	switch operator
	# 		when '==', '===', 'is'
	# 			return if v1 is v2 then options.fn this else options.inverse this
	# 		when '!=', '!=='
	# 			return if v1 != v2 then options.fn this else options.inverse this
	# 		when '<'
	# 			return if v1 < v2 then options.fn this else options.inverse this
	# 		when '<='
	# 			return if v1 <= v2 then options.fn this else options.inverse this
	# 		when '>'
	# 			return if v1 > v2 then options.fn this else options.inverse this
	# 		when '>='
	# 			return if v1 >= v2 then options.fn this else options.inverse this
	# 		when '&&', 'and'
	# 			return if v1 and v2 then options.fn this else options.inverse this
	# 		when '||', 'or'
	# 			return if v1 or v2 then options.fn this else options.inverse this
	# 		else
	# 			return options.inverse this
	# 	return

	# ### --- formatDate condition --- ###
	# Handlebars.registerHelper 'formatDate', (datetime, format, options) ->
	# 	month_list = [
	# 		"Jan", "Feb", "Mar", "Apr",
	# 		"May", "Jun", "Jul", "Aug",
	# 		"Sept", "Oct", "Nov", "Dec"
	# 	]

	# 	# mmnt = moment(date)
	# 	# return mmnt.format(format)
	# 	date_str = new Date(datetime)
	# 	return date_str.getDate() + " " + month_list[date_str.getMonth()] + " " + date_str.getFullYear()
	# ### --- End of Handle Bar template functions --- ###
	
	### --- 
	#	Timeout of 1 sec set as the values in search boxes are initially empty & are load from JS,
	#	hence a timelag is set so that value is assigned, then function call is made 
	--- ###
	setTimeout (->
		getListContent()
		return
	), 1000

	return