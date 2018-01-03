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

$('body').on 'show.bs.modal','#category-select', ->
	getCategoryDom("#category-select #level-one-category-dom", "level_1")