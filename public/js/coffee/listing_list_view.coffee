getTemplateHTML = (templateToRender, data) ->
	list = {}
	list['list'] = data

	theTemplateScript = $("#"+templateToRender).html()
	theTemplate = Handlebars.compile(theTemplateScript)

	htmlToRender = theTemplate(list)
	return htmlToRender

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
		# "city" : "goa",
		# "node_category": 1,
		# "filters":
		# 	"areas": [1, 2, 6],
		# 	"business_type": [11, 12, 13],
		# 	"listing_status": [],
		# 	"categories": "chicken-wings",
		# 	"business": "asdasd",
		# 	"rating": []

	$.ajax
		type: 'post'
		url: '/api/get-view-data'
		data: data
		dataType: 'json'
		success: (data) ->
			console.log data
			$(".container div.addShow p.search-actions__title label#listing_filter_count").text data["count"]
			console.log data["data"]
			templateHTML = getTemplateHTML('listing_card_template',data["data"])
			$('#listing_card_view').append(templateHTML)
		error: (request, status, error) ->
			console.log error
	return

$(document).ready () ->
	$('#listing_card_view').empty()
	
	### --- Custom If condition --- ###
	Handlebars.registerHelper 'ifCond', (v1, v2, options) ->
		if v1 == v2
			return options.fn(this)
		else
			return options.inverse(this)
		return


	Handlebars.registerHelper 'ifLogic', (v1, operator, v2, options) ->
		switch operator
			when '==', '===', 'is'
				return if v1 is v2 then options.fn this else options.inverse this
			when '!=', '!=='
				return if v1 != v2 then options.fn this else options.inverse this
			when '<'
				return if v1 < v2 then options.fn this else options.inverse this
			when '<='
				return if v1 <= v2 then options.fn this else options.inverse this
			when '>'
				return if v1 > v2 then options.fn this else options.inverse this
			when '>='
				return if v1 >= v2 then options.fn this else options.inverse this
			when '&&', 'and'
				return if v1 and v2 then options.fn this else options.inverse this
			when '||', 'or'
				return if v1 or v2 then options.fn this else options.inverse this
			else
				return options.inverse this
		return

	### --- formatDate condition --- ###
	Handlebars.registerHelper 'formatDate', (datetime, format, options) ->
		month_list = [
			"Jan", "Feb", "Mar", "Apr",
			"May", "Jun", "Jul", "Aug",
			"Sept", "Oct", "Nov", "Dec"
		]

		# mmnt = moment(date)
		# return mmnt.format(format)
		date_str = new Date(datetime)
		return date_str.getDate() + " " + month_list[date_str.getMonth()] + " " + date_str.getFullYear()
	
	getListContent()
	return