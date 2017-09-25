getColumns = () ->
	columns = [
		{data : "edit"}
		{data : "name"}
		{data : "email"}
		{data : "role"}
		{data : "status"}
	]

getFiltersForListInternalUsers = () ->
	filters = {}
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
	page_param_url = '?page=' + (parseInt(start / length) + 1) + '&entry_no=' + length + filters_param_url + '&order_by=' + filters['orderBy']
	window.history.pushState '', '', page_param_url

	### -- Get the start point -- ###
	filters['start'] = start
	### -- Get the length / no of rows -- ###
	filters['length'] = length

	return filters

requestData = (table_id) ->
	# disable error mode for data tables
	$.fn.dataTable.ext.errMode = 'none'

	# data table defaults
	$.extend $.fn.dataTable.defaults,
		destroy: true
		scrollY: 620
		scrollX: true
		scrollCollapse: true
		searching: true
		ordering: true
		pagingType: 'simple'
		#fixedColumns: leftColumns: 2
		#lengthMenu: [[ 25, 50, 100, 200, 500, -1],[ 25, 50, 100, 200, 500, 'All']]
		iDisplayStart: $('#datatable-internal-users').dataTable().fnSettings()._iDisplayStart
		iDisplayLength: $('#datatable-internal-users').dataTable().fnSettings()._iDisplayLength
		dom: 'Blfrtip'
		buttons: []

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
			{ mData: "roles", sWidth: "30%", className: "text-center", bSearchable: false, bSortable: false }
			{ mData: "status", sWidth: "20%", className: "text-center", bSearchable: false, bSortable: false }
		]
		'bSort': true
		'order': [[ 2, "desc" ]]
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
			$(".admin_internal_users #datatable-internal-users_filter label").html($(".admin_internal_users #datatable-internal-users_filter label input[type='search']").prop('outerHTML'))
			$(".admin_internal_users #datatable-internal-users_filter label input[type='search']").prop "placeholder", "Search by Name"
			$(".admin_internal_users #datatable-internal-users_filter label input[type='search']").addClass "fnb-input"

			# $('#datatable-internal-users_filter #internal_name_search').on 'input keyup click', () ->
			# 	$('#datatable-internal-users').DataTable().search($('#datatable-internal-users_filter #internal_name_search').val()).draw()
			# 	return

			return
	return

$(document).ready () ->

	requestData("datatable-internal-users")
	
	$("#add_newuser_modal #add_newuser_modal_btn").on 'click', () ->
		form_obj = $("#add_newuser_modal #add_newuser_modal_form")

		data = 
			name : form_obj.find('input[type="text"][name="name"]').val()
			email : form_obj.find('input[type="email"][name="email"]').val()
			roles : if form_obj.find('select[name="role"]').val().length then form_obj.find('select[name="role"]').val() else []
			status : form_obj.find('select[name="status"]').val()
			#'old_password' : if form_obj.find('input[type="password"][name="old_password"]').prop('disabled') then '' else form_obj.find('input[type="password"][name="old_password"]').val()
			password : if form_obj.find('input[type="password"][name="password"]').prop('disabled') then '' else form_obj.find('input[type="password"][name="password"]').val()
			confirm_password : if form_obj.find('input[type="password"][name="confirm_password"]').prop('disabled') then '' else form_obj.find('input[type="password"][name="confirm_password"]').val()

		url_type = form_obj.find("input[type='hidden'][name='form_type']").val()

		if(1)
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

					### --- Reload the DataTable --- ###
					table = $("#datatable-internal-users").DataTable()
					table.ajax.reload()

				error: (request, status, error) ->
					$(this).find(".fa-circle-o-notch.fa-spin").addClass "hidden"
					throw Error()
		else
			$(this).find(".fa-circle-o-notch.fa-spin").addClass "hidden"
			console.log "Not saved"
		return

	$(document).on "click", "#datatable-internal-users .editUser", () ->
		### --- On click of Edit User (pencil Icon) -> On modal open --- ###

		row = $(this).closest('tr')
		modal_object = $("#add_newuser_modal")

		modal_object.find("input[type='hidden'][name='form_type']").val "edit"
		modal_object.find("input[type='hidden'][name='user_id']").val $(this).prop('id')

		# modal_object.find("input[type='password'][name='old_password']").parent().parent().removeClass('hidden')
		modal_object.find("input[type='password'][name='password']").attr("disabled", "true")
		modal_object.find("input[type='password'][name='confirm_password']").attr("disabled", "true")
		#console.log row.find('td:eq(1)').text()
		modal_object.find("input[type='text'][name='name']").val(row.find('td:eq(1)').text())
		modal_object.find("input[type='email'][name='email']").val(row.find('td:eq(2)').text())

		return

	$(document).on "click", "div.admin_internal_users div.page-title button.btn-link", () ->
		### --- On click of Add New User -> On modal open --- ###
		modal_object = $("#add_newuser_modal")
		
		modal_object.find("input[type='hidden'][name='form_type']").val "add"
		modal_object.find("input[type='hidden'][name='user_id']").val ""

		# modal_object.find("input[type='password'][name='old_password']").parent().parent().addClass('hidden')
		modal_object.find("input[type='password'][name='password']").removeAttr("disabled")
		modal_object.find("input[type='password'][name='confirm_password']").removeAttr("disabled")
		modal_object.find("input[type='text'][name='name']").val('')
		modal_object.find("input[type='email'][name='email']").val('')

		return

	#table = $("#datatable-internal-users").DataTable()
	#table.ajax.reload()
	return