start_date="";
end_date = "";
$('body').on 'change', '#internal-email-type', ->
	if @value != ""
		url = document.head.querySelector('[property="mailtype-change-url"]').content
		$.ajax
			type: 'post'
			url: url
			data:
				type: @value
			success: (response) ->
				$('#filter-area').html response
				$('#submissionDate').daterangepicker({
					autoUpdateInput:false,
					maxDate: moment()
				});
				start_date="";
				end_date = "";
				$('#submissionDate').on 'apply.daterangepicker', (ev, picker) ->
					$('#submissionDate').val(picker.startDate.format('YYYY-MM-DD')+' to '+picker.endDate.format('YYYY-MM-DD'))
					start_date = picker.startDate.format('YYYY-MM-DD')
					end_date = picker.endDate.format('YYYY-MM-DD')

$('body').on 'show.bs.modal','#category-select', ->
	getCategoryDom("#category-select #level-one-category-dom", "level_1")

getSelectedFilters = (url_check)->
	type = $('input[name="mail-type"]').val()
	if type == 'draft-listing-active' or type == 'draft-listing-inactive'
		source_filter = $('select[name="listing_source"]').val();
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
		url_count = document.head.querySelector('[property="mail-count"]').content
		url_send = document.head.querySelector('[property="mail-send"]').content
		switch url_check
			when url_count
				$.ajax
					url:url_count
					type: 'post'
					data:
						type: type
						areas: loc_area_array
						cities: loc_city_array
						categories: JSON.stringify(getLeafNodes())
						source: source_filter
					success: (response)->
						$('#user_number').html response['email_count'];
						$('#confirmBox').modal('show')
				return
			when url_send
				$.ajax
					url:url_send
					type: 'post'
					data:
						type: type
						areas: loc_area_array
						cities: loc_city_array
						categories: JSON.stringify(getLeafNodes())
						source: source_filter
					success: (response)->
						$('#messageBox').modal('show')
				return
	if type == 'user-activate'
		description_filter = $('select[name="description"]').val();
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
		console.log description_filter
		url_count = document.head.querySelector('[property="mail-count"]').content
		url_send = document.head.querySelector('[property="mail-send"]').content
		switch url_check
			when url_count
				$.ajax
					url:url_count
					type: 'post'
					data:
						type: type
						areas: loc_area_array
						cities: loc_city_array
						description:description_filter
						start:start_date
						end:end_date
					success: (response)->
						$('#user_number').html response['email_count'];
						$('#confirmBox').modal('show')
				return
			when url_send
				$.ajax
					url:url_send
					type: 'post'
					data:
						type: type
						areas: loc_area_array
						cities: loc_city_array
						description:description_filter
						start:start_date
						end:end_date
					success: (response)->
						$('#messageBox').modal('show')
				return


$('body').on 'click','#mail-check',()->
	url = document.head.querySelector('[property="mail-count"]').content
	getSelectedFilters(url)

$('body').on 'click','#send-mail-confirm', ()->
	$('#confirmBox').modal('hide')
	url = document.head.querySelector('[property="mail-send"]').content
	getSelectedFilters(url)
		