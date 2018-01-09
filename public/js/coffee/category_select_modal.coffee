getBranchNodeCategories = (path, parent_id) ->
	html = ''

	$.ajax
		type: 'post'
		url: '/api/get_listing_categories'
		data: 
			'category': [parent_id]
			'is_branch_select': if ($(document).find("#is_branch_category_checkbox").val()) then true else false
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

getNodeCategories = (path, branch_id, checked_values, is_all_checked) ->
	html = ''
	console.log checked_values
	if checked_values.length <= 0
		$.each $(path + " input[type='checkbox']:checked"), ->
			checked_values.push $(this).val()
			return

	setTimeout (->
		$.ajax
			type: 'post'
			url: '/api/get_node_listing_categories'
			data: 
				'branch': [branch_id]
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
						if is_all_checked
							html_upload += "<input type=\"checkbox\" class=\"checkbox\" for=\"" + node_children[index]['id'] + "\" value=\""+ node_children[index]['id'] + "\" checked=\"checked\">"
						else
							if checked_values.length > 0 and $.inArray(node_children[index]['id'].toString(), checked_values) != -1
								html_upload += "<input type=\"checkbox\" class=\"checkbox\" for=\"" + node_children[index]['id'] + "\" value=\""+ node_children[index]['id'] + "\" checked=\"checked\">"
							else
								html_upload += "<input type=\"checkbox\" class=\"checkbox\" for=\"" + node_children[index]['id'] + "\" value=\""+ node_children[index]['id'] + "\">"
						html_upload += "<input type=\"hidden\" name=\"hierarchy\" id=\"hierarchy\" value='" + JSON.stringify(node_children[index]["hierarchy"]) + "'>"
						html_upload += "<p class=\"lighter nodes__text\" id=\"" + node_children[index]['id'] + "\">" + node_children[index]['name'] + "</p>"
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

	), 200
	return

getPreviouslyAvailableCategories = () ->
	get_core_cat_checked = []
	try
		if $("#category-select #previously_available_categories").val().length > 1 and JSON.parse($("#category-select #previously_available_categories").val()).length > 0
			get_core_cat_checked = JSON.parse($("#category-select #previously_available_categories").val())
	catch error
		console.log "Sorry, met with a JSON.parse error for #previously_available_categories. Please pass it as Array & Stringify it."

	return get_core_cat_checked

window.getCategoryDom = (path, level) ->
	$.ajax
		type: 'post'
		url: '/api/get_categories_modal_dom'
		data: 
			'level': level
			'is_parent_select': if ($(document).find("#is_parent_category_checkbox").val()) then true else false
		success: (data) ->
			$(path).html data["modal_template"]
			return
		error: (request, status, error) ->
			throw Error()
			return
	return

change_view = () ->
  if $('div#categories.node-list').children().length == 0
    $('#categ-selected').addClass('hidden');
    $('div.core-cat-cont').addClass('hidden');
    $('#no-categ-select').removeClass('hidden');
  else
    $('#categ-selected').removeClass('hidden');
    $('div.core-cat-cont').removeClass('hidden');
    $('#no-categ-select').addClass('hidden');

$(document).ready () ->

	getCategoryDom("#category-select #level-one-category-dom", "level_1")

	$('body').on 'click', '#category-select .sub-category-back', ->
	  $('.main-category').removeClass 'hidden'
	  $('.sub-category').removeClass 'shown'


	$('body').on 'click', '#category-select .category-back', ->
	  $('.main-category').removeClass 'hidden'
	  $('.sub-category').removeClass 'shown'
	  $('.desk-level-two').addClass 'hidden'
	  $('.firstStep').removeClass 'hidden'
	  $('.interested-options .radio').prop 'checked', false


	$('#category-select .topSelect').click ->
	  setTimeout (->
	    $('#category-select .category-back').addClass 'hidden'
	    return
	  ), 100

	$('#category-select .catSelect-click').click ->
	  $('.category-back').removeClass 'hidden'


	$('#category-select').on 'hidden.bs.modal', (e) ->
	  $('.interested-options .radio').prop 'checked', false
	  return


	if $(window).width() < 768
	  $('.topSelect').click ->
	    setTimeout (->
	      $('.category-back').addClass 'hidden'
	      $('.cat-cancel').addClass 'hidden'
	      $('.mobileCat-back').removeClass 'hidden'
	      return
	    ), 100

	# detaching sections
	if $(window).width() <= 768
	  $('.single-category').each ->
	    branchAdd = $(this).find('.branch-row')
	    branchrow = $(this).find('.branch').detach()
	    $(branchAdd).append branchrow
	    return
	  $('.get-val').each ->
	    removeRow = $(this).find('.fnb-input')
	    addRow = $(this).find('.removeRow').detach()
	    $(removeRow).after addRow

	# setTimeout (->
	#   $('.brand-list').flexdatalist
	#     removeOnBackspace: false
	#     minLength: 1
	#     url: '/get_brands'
	#     searchIn: ["name"]
	#   return
	# ), 500

	$('body').on 'click', '#category-select .delete-cat', ->
	  $(this).closest('.single-category').remove()
	  change_view()

	$('body').on 'click', '#category-select .fnb-cat .remove', ->
	  item = $(this).closest('.fnb-cat__title').parent()
	  list= item.parent()
	  item.remove()
	  if list.children().length == 0
	    list.closest('.single-category').remove()
	  change_view()

	### --- On Category Modal Shown --- ###
	$(document).on "show.bs.modal", "#category-select", (event) ->
		#$("#category-select #level-one-category-dom")
		$("#category-select #level-two-category").addClass "hidden"
		$("#category-select #level-one-category").removeClass "hidden"
		$("#category-select #level-one-category input[type='radio']").prop "checked", false
		## -- Get the Core Categories slug array  -- ##
		get_core_cat_checked = getPreviouslyAvailableCategories()
		console.log get_core_cat_checked
		setTimeout ( ->
			$('#category-select #level-one-category .cat-select li .multi-label-select input[type="checkbox"][name="select-categories"]').each (index,element)->
				# console.log @value,get_core_cat_checked,$.inArray(@value,get_core_cat_checked)
				if !$.inArray(@value,get_core_cat_checked)
					$(this).prop('checked', true).change()
				else
					$(this).prop('checked', false).change()
		),300
		return

	### --- On click of "Back to Categories", display "Category-One" & hide "Category-Two" --- ###
	$(document).on "click", "#category-select #back_to_categories", () ->
		$("#category-select #level-two-category").addClass "hidden"
		$("#category-select #level-one-category").removeClass "hidden"

		return

	### --- On click of 'x', hide / close the Modal --- ###
	$(document).on "click", "#category-select #category-select-close", () ->
		$(this).closest("div#category-select").modal 'hide'
		return

	### --- On change of "Select Categories", Disable the Radio option with the "Same VALUE" --- ###
	$(document).on "change", "#category-select #level-one-category input[name='select-categories']", () ->
		if $(this).prop('checked')
			$("#category-select #level-one-category input[type='radio'][value='" + $(this).val() + "']").attr('disabled', 'true')
		else
			$("#category-select #level-one-category input[type='radio'][value='" + $(this).val() + "']").removeAttr('disabled')
		return

	### --- On change / select of Radio Option, Get the Category LEvel 2 DOM, & Hide Level 1 & display Level 2  --- ###
	$(document).on "change", "#category-select #level-one-category input[type='radio'][name='parent-categories']", (event) ->
		getBranchNodeCategories("#category-select #level-two-category-dom", $(this).val()) # add DOM to this level
		$(this).closest("div#level-one-category").addClass "hidden"
		get_core_cat_checked = []

		setTimeout ( ->
			## -- Get the Core Categories slug array  -- ##
			get_core_cat_checked = getPreviouslyAvailableCategories()
			$('#category-select #level-two-category ul#branch_categories li input[type="checkbox"][name="branch_categories_select"]').each (index,element)->
				console.log @value
				if $.inArray(@value,get_core_cat_checked) > -1
					console.log @value
					$(this).prop('checked', true).change()
				else
					$(this).prop('checked', false).change()

			# console.log $("#category-select #level-two-category #branch_categories li.active").find('a').attr("aria-controls")
			if !$('#category-select #level-two-category #branch_categories li.active input[type="checkbox"][name="branch_categories_select"]').prop('checked')
				getNodeCategories("#category-select #level-two-category ", $("#category-select #level-two-category #branch_categories li.active").find('a').attr("aria-controls"), get_core_cat_checked, false)
			return
		), 300
		event.stopImmediatePropagation() # Prevent making multiple AJAX calls
		return

	### --- On click of Branch Categories, Get it's children --- ###
	$(document).on "click", "#category-select #level-two-category ul#branch_categories li a", (event) ->
		get_core_cat_checked = []
		if $("#category-select #level-two-category div#" + $(this).attr("aria-controls") + " input[type='checkbox']").length < 1 ## If no checkboxes exist, then populate the Checkboxes under that div
			get_core_cat_checked = getPreviouslyAvailableCategories()
			getNodeCategories("#category-select #level-two-category ", $(this).attr("aria-controls"), get_core_cat_checked, false)

		## -- Display that specific div with Checkboxes, as the bootstrap fails to do the functionality in certain scenario -- ##
		$("#category-select #level-two-category #cat-dataHolder div").removeClass "active"
		$("#category-select #level-two-category #cat-dataHolder div#" + $(this).attr("aria-controls")).addClass "active"

		event.stopImmediatePropagation() # Prevent making multiple AJAX calls
		return

	### -- If a branch category is selected, then select all the core categories --- ###
	$(document).on "change", "#category-select #level-two-category ul#branch_categories input[type='checkbox']", (event) ->
		if $("#category-select #level-two-category div#" + $(this).val() + " input[type='checkbox']").length < 1
			if $(this).prop('checked')
				getNodeCategories("#category-select #level-two-category ", $(this).val(), [], true)
			else
				getNodeCategories("#category-select #level-two-category ", $(this).val(), [], false)
		else
			if $(this).prop('checked')
				$("#category-select #level-two-category #cat-dataHolder div#" + $(this).val() + " input[type='checkbox']").prop "checked", true
			else
				$("#category-select #level-two-category #cat-dataHolder div#" + $(this).val() + " input[type='checkbox']").prop "checked", false
		event.stopImmediatePropagation() # Prevent making multiple AJAX calls
		return

	### --- If a node Category is selected, & if all are selected, then check the Branch --- ###
	$(document).on "change", "#category-select #level-two-category #cat-dataHolder input[type='checkbox']", () ->
		branch_id = $(this).closest('div.tab-pane').attr('id')
		path = "#category-select #level-two-category "

		if $(path + "#cat-dataHolder #" + branch_id + " input[type='checkbox']").length == $(path + "#cat-dataHolder #" + branch_id + " input[type='checkbox']:checked").length
			$(path + "#branch_categories input[type='checkbox'][value='" + branch_id + "']").prop "checked", true
		else
			$(path + "#branch_categories input[type='checkbox'][value='" + branch_id + "']").prop "checked", false

		main_page_categories = getPreviouslyAvailableCategories()

		if main_page_categories.indexOf($(this).val()) > -1
			main_page_categories.pop(main_page_categories.indexOf($(this).val()))
			$("#category-select #previously_available_categories").val(JSON.stringify(main_page_categories))
		
		return

	### --- On Click of "Add Selected", add those Checked values & close the Popup --- ###
	$(document).on "click", "#category-select #level-two-category button#category-select-btn", () ->
		checked_categories = []
		main_page_categories = []
		index = 0
		checked_hierarchy_categories = []

		main_page_categories = getPreviouslyAvailableCategories()

		### ---- Share only the child values ---- ###
		$.each $("#category-select #level-two-category #cat-dataHolder input[type='checkbox']:checked"), ->
			if main_page_categories.indexOf($(this).val()) <= -1
				checked_categories.push {"slug": $(this).val(), "name": $(this).parent().find('p#' + $(this).val()).text() }
			return

		while index < main_page_categories.length
			checked_categories.push {"slug": main_page_categories[index]}
			index++
		
		if $(document).find("input[type='hidden']#modal_categories_chosen").length > 0
			$(document).find("input[type='hidden']#modal_categories_chosen").val(JSON.stringify(checked_categories))

		### --- Share even the Branch value --- ###
		$.each $("#category-select input[type='checkbox']:checked"), ->
			checked_hierarchy_categories.push {"slug": $(this).val(), "name": $(this).parent().find('p#' + $(this).val()).text() }
			return

		if $(document).find("input[type='hidden']#modal_categories_hierarchy_chosen").length > 0
			$(document).find("input[type='hidden']#modal_categories_hierarchy_chosen").val(JSON.stringify(checked_hierarchy_categories))
		
		$("#category-select").modal "hide"
		return
	return