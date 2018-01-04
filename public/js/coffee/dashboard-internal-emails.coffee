$('body').on 'change', '#internal-email-type', ->
	if @value != ""
		url = document.head.querySelector('[property="mailtype-change-url"]').content
		$.ajax
			type: 'post'
			url: url
			data:
				type: @value
			success: (response) ->
				console.log response
				$('#filter-area').html response
				$('#submissionDate').daterangepicker({
			        autoUpdateInput:false,
			        maxDate: moment()
			    });
				$('#submissionDate').on 'apply.daterangepicker', (ev, picker) ->
					$('#submissionDate').val(picker.startDate.format('YYYY-MM-DD')+' to '+picker.endDate.format('YYYY-MM-DD'))

$('body').on 'show.bs.modal','#category-select', ->
	getCategoryDom("#category-select #level-one-category-dom", "level_1")

$('body').on 'click','#mail-check',()->
	type = $('input[name="mail-type"]').val()
	if type == 'draft-listing-active' or 'draft-listing-inactive'
		loc_city_array = []
		loc_area_array = []
		for entry of cities['cities']
			j=0
			for i of cities['cities'][entry]['areas']
				console.log 
				loc_area_array.push(cities['cities'][entry]['areas'][i]['id'])
				j++
			if j == 0
				loc_city_array.push(cities['cities'][entry]['id'])
		console.log 'cities=',loc_city_array
		console.log 'areas=',loc_area_array
		url = document.head.querySelector('[property="mail-count"]').content
		$.ajax
			url:url
			type: 'post'
			data:
				type: type
				areas: loc_area_array
				cities: loc_city_array
			success: (response)->
				console.log response