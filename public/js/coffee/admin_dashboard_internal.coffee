filters_array = ['roles', 'status']

getColumns = () ->
	columns = [
		{data : "edit"}
		{data : "name"}
		{data : "email"}
		{data : "role"}
		{data : "status"}
	]

getFiltersForListInternalUsers = () ->
	filters = 
		user_type : "internal"
	filters_param_url = ''

	sort_value = $('#datatable-internal-users').dataTable().fnSettings().aaSorting
	if sort_value.length > 0 and sort_value[0].length > 0
		if sort_value[0][1] == 'desc'
			filters['orderBy'] = "-" # If descending, then add '-'
		else
			filters['orderBy'] = ""

		columns_replacement = 
			'who_meta': 'who_id'
			'whom_meta': 'whom_id'

		if sort_value[0][0]
			filters['orderBy'] = filters['orderBy'] + getColumns()[sort_value[0][0]].data # Get column_name/<object_name>
			#if columns_replacement.hasOwnProperty getColumns()[sort_value[0][0]].data
			#	filters['orderBy'] = filters['orderBy'] + columns_replacement[getColumns()[sort_value[0][0]].data] # Get column_name/<object_name>
			#else
			#	filters['orderBy'] = filters['orderBy'] + getColumns()[sort_value[0][0]].data # Get column_name/<object_name>

	start = $('#datatable-internal-users').dataTable().fnSettings()._iDisplayStart
	length = $('#datatable-internal-users').dataTable().fnSettings()._iDisplayLength

	### -- Set the page No & the No of Entries in the URL -- ###
	#page_param_url = '?page=' + (parseInt(start / length) + 1) + '&entry_no=' + length + filters_param_url + '&order_by=' + filters['orderBy']
	#window.history.pushState '', '', page_param_url

	### -- Get the start point -- ###
	filters['start'] = start
	### -- Get the length / no of rows -- ###
	filters['length'] = length

	return filters

get_filters = () ->
	### --- This function will read the 'Search Params' from URL & apply values to the Filter --- ###
	jQuery.each filters_array, (index, name_value) ->
		### --- Check if the filter was selected by checking the URL --- ###
		if window.location.search.split(name_value + '=')[1]
			### --- If the filter was selected, then update by selecting the Filters before making the DataTable AJAX call --- ###
			filter_value_array = decodeURIComponent window.location.search.split(name_value + '=')[1].split('&')[0] # replace all 'UTF-8' to 'ASCII' chars
			filter_value_array = JSON.parse filter_value_array
			jQuery.each filter_value_array, (index, value) ->
				### --- Select all the values that were selected in the Filter & updated in the URL --- ###
				$('input:checkbox[name="' + name_value + '"][value="' + value + '"]').attr 'checked','true'
				return
			return
	return

get_page_no_n_entry_no = () ->
	### --- This function will get the 'Page No' & the 'No of Entries on a page' from URL --- ###
	length = if window.location.search.split('entry_no=')[1] then parseInt(window.location.search.split('entry_no=')[1].split('&')[0]) else 25
	start =  if window.location.search.split('page=')[1] then (parseInt(window.location.search.split('page=')[1].split('&')[0]) - 1) * length else 0

	return [start, length]

get_sort_order = () ->
	### --- This function will get the 'Sort Order' from URL --- ###
	if window.location.search.indexOf('order_by=') > -1
		### --- Checks if the order of display is ascending or descending --- ###
		display_order = if window.location.search.split('order_by=')[1][0] == '-' then 'desc' else 'asc'


		key_column = window.location.search.split('order_by=')[1]
		key_column = if display_order == 'desc' then key_column.substring(1, key_column.length) else key_column

		display_column = 0
		getColumns().find (item, i) ->
			if (item.data == key_column)
				display_column = i
				return i

	else
		display_order = 'desc'
		display_column = 2

	return [display_column, display_order]

validatePassword = (password, confirm_password = '', parent_path = '', child_path = "#password_errors") ->
	# Password should have 8 or more characters with atleast 1 lowercase, 1 UPPERCASE, 1 No or Special Chaaracter
	expression = /^(?=.*[0-9!@#$%^&*])(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z])(?!.*\s).{8,}$/
	message = ''
	status = true

	if(expression.test(password))
		if (confirm_password != '' && confirm_password == password) # Confirm_password isn't empty & is Same
			status = true
		else if (confirm_password == '') #Just validate Password
			status = true
		else # confirm_password != '' && password != confirm_password
			message = "Password & Confirm Password are not matching"
			status = false
	else # Else password not Satisfied the criteria
		message = "Please enter a password of minimum 8 characters and has atleast 1 lowercase, 1 UPPERCASE, and 1 Number or Special character"
		status = false

	if(!status && parent_path != '')
		$(parent_path + " " + child_path).removeClass('hidden').text(message)
	else if(status && parent_path != '')
		#$(parent_path + " " + child_path).addClass('hidden')
		$(parent_path + " " + child_path).addClass('hidden')

	return status

requestData = (table_id) ->
	# disable error mode for data tables
	$.fn.dataTable.ext.errMode = 'none'

	# data table defaults
	$.extend $.fn.dataTable.defaults,
		#destroy: true
		# scrollY: 620
		# scrollX: true
		# scrollCollapse: true
		# searching: true
		# ordering: true
		# pagingType: 'simple'
		#fixedColumns: leftColumns: 2
		#lengthMenu: [[ 25, 50, 100, 200, 500, -1],[ 25, 50, 100, 200, 500, 'All']]
		iDisplayStart: get_page_no_n_entry_no()[0]# $('#datatable-internal-users').dataTable().fnSettings()._iDisplayStart
		iDisplayLength: get_page_no_n_entry_no()[1]# $('#datatable-internal-users').dataTable().fnSettings()._iDisplayLength
		#dom: 'pBlfrti'
		#buttons: []

	if window.location.hash != '' and window.location.hash != '#'
		hash_url = window.location.hash

	internal_user_table = $("#" + table_id).DataTable
		'processing': true
		# 'serverSide': true
		'iDisplayLength': 25
		'columns': getColumns()
		'aoColumns':[
			{ mData: "edit", sWidth: "5%", bSearchable: false, bSortable: false, bVisible: true }
			{ mData: "name", sWidth: "20%", className: "sorting_1", bSearchable: true, bSortable: true }
			{ mData: "email", sWidth: "20%", className: "text-center", bSearchable: false, bSortable: true }
			{ mData: "roles", sWidth: "30%", className: "text-center", bSearchable: true, bSortable: false }
			{ mData: "status", sWidth: "20%", className: "text-center", bSearchable: true, bSortable: false }
		]
		'bSort': true
		'order': [get_sort_order()]#[[ 2, "desc" ]]
		'ajax':
			url: '/admin-dashboard/users/get-users'
			type: 'post'
			dataSrc: "data"
			dataType: "json"
			data: (d) ->
				d.filters = getFiltersForListInternalUsers()
				return
			#success: (data) ->
			#	console.log data
			error: (e)->
				# error handling
				#$('.employee-grid-error').html ''
				console.log "error"
				console.log e.status
				# console.log e
				$('#' + table_id).append '<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>'
				#$('#employee-grid_processing').css 'display', 'none'
				return
		
		'fnDrawCallback': (oSettings) ->
			#jsonData = if internal_user_table.ajax.json().hasOwnProperty 'lead_day_counts' then internal_user_table.ajax.json().lead_day_counts else []
			# table_id = get_active_table_id()
			# $('[data-toggle="tooltip"]').tooltip
			# 	placement: 'right'
			# 	viewport:
			# 		'selector': table_id
			# 		'padding': 10

			# dataTableResetBtnBind()
			# #$('[data-toggle="popover"]').popover()
			# $('.bcf_details').popover({trigger:'hover click',container: 'body'})
				
			### --- Search box --- ###
			# $("#datatable-internal-users_filter label").html($("#datatable-internal-users_filter label").children())
			div = $("#datatable-internal-users_filter label")[0]
			if div.childNodes.length
			  i = 0
			  while i < div.childNodes.length
			    if div.childNodes[i].nodeType == 3
			      div.removeChild div.childNodes[i]
			    i++
			$(".admin_internal_users #datatable-internal-users_filter label input[type='search']").prop "placeholder", "Search by Name"
			$(".admin_internal_users #datatable-internal-users_filter label input[type='search']").addClass "fnb-input"

			# $('#datatable-internal-users_filter #internal_name_search').on 'input keyup click', () ->
			# 	$('#datatable-internal-users').DataTable().search($('#datatable-internal-users_filter #internal_name_search').val()).draw()
			# 	return

			return
	return internal_user_table

init_Multiselect = ->
	$('.multi-ddd').multiselect
		# buttonContainer: '<span></span>'
		# buttonClass: ''
		maxHeight: 200
		templates: 
			button: '<span class="multiselect dropdown-toggle" data-toggle="dropdown"><i class="fa fa-filter"></i></span>'
		includeSelectAllOption: true
		numberDisplayed: 5
		# delimiterText: ','
		#nonSelectedText: 'Select City'
		onChange: (element, checked) ->
			categories = $(this)[0]['$select'].find('option:selected')
			selected = []
			$(categories).each (index, city) ->
				selected.push '^' + $(this).val() + "$" # Search for exact word & not LIKE "%<string>%", hence "^<string>$"
				return
		
			search = selected.join('|')
			col = $(this)[0]['$select'].closest('th').data('col')
			$('#datatable-internal-users').DataTable().column(col).search(search, true, false).draw()
			# Show/hide first column for Listing Approval table
			# if (selected == "Pending Review") {
			#     $(".select-checkbox").css("display", "table-cell");
			#     $(".bulk-status-update").removeClass('hidden');
			# } else {
			#     $(".select-checkbox").css("display", "none");
			#     $(".bulk-status-update").addClass('hidden');
			# }
			return
	return

$(document).ready () ->

	#get_filters()
	### --- Initialize the Table for 1st time, as the filters will be on Client-Side --- ### 
	table = requestData("datatable-internal-users")
	init_Multiselect()
	
	$("#add_newuser_modal #add_newuser_modal_form input[type='email'][name='email']").on 'keyup change', () ->
		form_obj = $("#add_newuser_modal #add_newuser_modal_form")
		form_obj.find('p#email-error').addClass("hidden").text ""
	# 	specificField = form_obj.find('label#email-error').parsley()
	# 	window.ParsleyUI.removeError(specificField, "custom-email-error")
		return

	$("#add_newuser_modal #add_newuser_modal_form input[type='password'][name='password']").on 'keyup change', () ->
		validatePassword($(this).val(), '', '#add_newuser_modal #add_newuser_modal_form', '#password-error')
		return

	$("#add_newuser_modal #add_newuser_modal_btn").on 'click', () ->
		form_obj = $("#add_newuser_modal #add_newuser_modal_form")

		form_status = form_obj.parsley().validate()
		
		if !form_obj.find('input[type="password"][name="password"]').prop('disabled')
			form_status = if validatePassword(form_obj.find('input[type="password"][name="password"]').val()) then form_status else false

		data = 
			user_type : "internal"
			name : form_obj.find('input[type="text"][name="name"]').val()
			email : form_obj.find('input[type="email"][name="email"]').val()
			roles : if form_obj.find('select[name="role"]').val().length then form_obj.find('select[name="role"]').val() else []
			status : form_obj.find('select[name="status"]').val()
			#'old_password' : if form_obj.find('input[type="password"][name="old_password"]').prop('disabled') then '' else form_obj.find('input[type="password"][name="old_password"]').val()
			password : if form_obj.find('input[type="password"][name="password"]').prop('disabled') then '' else form_obj.find('input[type="password"][name="password"]').val()
			confirm_password : if form_obj.find('input[type="password"][name="confirm_password"]').prop('disabled') then '' else form_obj.find('input[type="password"][name="confirm_password"]').val()

		url_type = form_obj.find("input[type='hidden'][name='form_type']").val()

		if(form_status)
			$(this).find(".fa-circle-o-notch.fa-spin").removeClass "hidden"

			$.ajax
				type: 'post'
				url: '/admin-dashboard/users/' + (if url_type == "add" then "add" else form_obj.find("input[type='hidden'][name='user_id']").val())
				data: data
				dataType: 'json'
				success: (data) ->
					console.log data

					$("#add_newuser_modal #add_newuser_modal_btn").find(".fa-circle-o-notch.fa-spin").addClass "hidden"
					$("#add_newuser_modal").modal "hide"
					if url_type == "add"
						$(".admin_internal_users.right_col").parent().find('div.alert-success #message').text "Successfully created new User"
					else
						$(".admin_internal_users.right_col").parent().find('div.alert-success #message').text "User updated successfully"

					setTimeout (->
						$(".admin_internal_users.right_col").parent().find('div.alert-success').addClass 'active'
						return
					), 1000
					setTimeout (->
						$(".admin_internal_users.right_col").parent().find('div.alert-success').removeClass 'active'
						return
					), 6000

					### --- Reload the DataTable --- ###
					# table = $("#datatable-internal-users").DataTable()
					table.ajax.reload()

				error: (request, status, error) ->
					if(request.status == 406)
						form_obj.find('p#email-error').removeClass("hidden").text "This Email ID already exist"
						#specificField = form_obj.find('label#email-error').parsley()
						#window.ParsleyUI.addError(specificField, "custom-email-error", "This email ID exist.")
						error_message = JSON.parse(request.responseText)

						error_message = if error_message.hasOwnProperty("message") then error_message["message"] else ""
						if(error_message == "email_exist")
							$(".admin_internal_users.right_col").parent().find('div.alert-failure #message').text "This Email ID already exist"
						else if error_message == "password_and_confirm_not_matching"
							$(".admin_internal_users.right_col").parent().find('div.alert-failure #message').text "Password & Confirm password are not matchin"
						else
							$(".admin_internal_users.right_col").parent().find('div.alert-failure #message').text "Sorry! Seems like we met with some error"	
						
					else
						$(".admin_internal_users.right_col").parent().find('div.alert-failure #message').text "Sorry! Seems like we met with some error"

					setTimeout (->
						$(".admin_internal_users.right_col").parent().find('div.alert-failure').addClass 'active'
						return
					), 1000

					setTimeout (->
						$(".admin_internal_users.right_col").parent().find('div.alert-failure').removeClass 'active'
						return
					), 6000


					form_obj.find("button .fa-circle-o-notch.fa-spin").addClass "hidden"
					# throw Error()
		else
			$(this).find(".fa-circle-o-notch.fa-spin").addClass "hidden"
			console.log "Not saved"
		return

	$(document).on "click", "#datatable-internal-users .editUser", () ->
		### --- On click of Edit User (pencil Icon) -> On modal open --- ###

		row = $(this).closest('tr')
		modal_object = $("#add_newuser_modal")

		### --- Reset the Parsley error messages --- ###
		modal_object.find("#add_newuser_modal_form").parsley().reset()
		
		### --- Update the Modal Title --- ###
		modal_object.find("#add_newuser_modal_form .modal-header h6.modal-title").text "Edit Internal User"

		modal_object.find("input[type='hidden'][name='form_type']").val "edit"
		modal_object.find("input[type='hidden'][name='user_id']").val $(this).prop('id')

		# modal_object.find("input[type='password'][name='old_password']").parent().parent().removeClass('hidden')

		### --- Password --- ###
		modal_object.find("input[type='password'][name='password']").attr("disabled", "true")
		modal_object.find("input[type='password'][name='password']").removeAttr("required")
		#modal_object.find(".col-sm-6.new-password").addClass("hidden")
		modal_object.find("input[type='password'][name='password']").closest('div.col-sm-6').addClass('hidden')

		### --- Confirm Password --- ###
		modal_object.find("input[type='password'][name='confirm_password']").attr("disabled", "true")
		modal_object.find("input[type='password'][name='confirm_password']").removeAttr("required")
		modal_object.find("input[type='password'][name='confirm_password']").closest('div.col-sm-6').addClass('hidden')

		#console.log row.find('td:eq(1)').text()
		modal_object.find("input[type='text'][name='name']").val(row.find('td:eq(1)').text())
		modal_object.find("input[type='email'][name='email']").val(row.find('td:eq(2)').text()).attr("disabled", "true")

		### --- Select the user's Role --- ###
		modal_object.find('select.form-control.multiSelect').multiselect('select', [row.find('td:eq(3)').text().toLowerCase()])
		modal_object.find('select.form-control.multiSelect').multiselect('updateButtonText', true)

		console.log row.find('td:eq(4)').text().toLowerCase()
		modal_object.find('select.form-control.status-select').val row.find('td:eq(4)').text().toLowerCase()

		modal_object.find('.createSave').addClass 'hidden'
		modal_object.find('.editSave').removeClass 'hidden'

		return

	$(document).on "click", "div.admin_internal_users div.page-title button.btn-link", () ->
		### --- On click of Add New User -> On modal open --- ###
		modal_object = $("#add_newuser_modal")

		### --- Reset the Parsley error messages --- ###
		modal_object.find("#add_newuser_modal_form").parsley().reset()

		### --- Update the Modal Title --- ###
		modal_object.find("#add_newuser_modal_form .modal-header h6.modal-title").text "Add New Internal User"
		
		modal_object.find("input[type='hidden'][name='form_type']").val "add"
		modal_object.find("input[type='hidden'][name='user_id']").val ""

		### --- Clear the Name & Email textbox & enable the Email textbox --- ###
		modal_object.find("input[type='text'][name='name']").val('')
		modal_object.find("input[type='email'][name='email']").val('').removeAttr("disabled")

		### --- Deselect All the options --- ###
		modal_object.find('select.form-control.multiSelect').multiselect('deselectAll', false)
		### --- Update the text --- ###
		modal_object.find('select.form-control.multiSelect').multiselect('updateButtonText', true)
		
		### --- Unselect the Status --- ###
		modal_object.find("select[name='status'] option:selected").prop("selected", false)

		# modal_object.find("input[type='password'][name='old_password']").parent().parent().addClass('hidden')
		
		### --- Enable the Password option --- ###
		modal_object.find("input[type='password'][name='password']").removeAttr("disabled")
		modal_object.find("input[type='password'][name='password']").attr("required", "true").val('')
		modal_object.find("input[type='password'][name='password']").closest('div.col-sm-6').removeClass('hidden')
		
		### --- Enable the Confirm-Password option --- ###
		modal_object.find("input[type='password'][name='confirm_password']").removeAttr("disabled")
		modal_object.find("input[type='password'][name='confirm_password']").attr("required", "true").val('')
		modal_object.find("input[type='password'][name='confirm_password']").closest('div.col-sm-6').removeClass('hidden')
		
		modal_object.find('.createSave').removeClass 'hidden'
		modal_object.find('.editSave').addClass 'hidden'

		return

	#table = $("#datatable-internal-users").DataTable()
	#table.ajax.reload()
	return