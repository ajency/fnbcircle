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