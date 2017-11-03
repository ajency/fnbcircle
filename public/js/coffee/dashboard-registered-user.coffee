registeredUserTable = $('#datatable-registration').DataTable(
  'pageLength': 25
  'processing': true
  'serverSide': true
  'bAutoWidth': false
  'aaSorting': [[0,'desc']]
  'drawCallback': () ->
    displayCheckbox()
  'ajax':
    url: '/admin-dashboard/users/get-registered-users'
    type: 'post'
    data: (data) ->
      
      filters = {}
      filters.user_name = $('#user_name').val()
      filters.user_email = $('#user_email').val()
      filters.user_phone = $('#user_phone').val()
      filters.user_status = $('select[name="user_status"]').val()
      filters.state = $('select[name="user_state"]').val()
      filters.type = $('select[name="user_type"]').val()
      filters.user_created_from = $('input[name="user_created_from"]').val()
      filters.user_created_to = $('input[name="user_created_to"]').val()
      filters.last_login_from = $('input[name="last_login_from"]').val()
      filters.user_created_to = $('input[name="user_created_to"]').val()
      data.filters = filters
      data
    
    error: ->

      return
  'columns': [
    # { 'data': '#' , "orderable": false}
    { 'data': 'name' }
    { 'data': 'type'  , "orderable": false}
    { 'data': 'email' , "orderable": false}
    { 'data': 'phone', "orderable": false}
    { 'data': 'describe'  , "orderable": false}
    { 'data': 'state' , "orderable": false}
    { 'data': 'city' }
    { 'data': 'date_created' }
    { 'data': 'last_login' }
    { 'data': 'total_listing' , "orderable": false}
    { 'data': 'published_listing' , "orderable": false}
    { 'data': 'total_jobs' , "orderable": false}
    { 'data': 'published_jobs' , "orderable": false}
    { 'data': 'job_applied' , "orderable": false}
    { 'data': 'resume_uploaded' , "orderable": false}
    { 'data': 'status' , "orderable": false}
  ]
  "columnDefs": [
    { "width": "60px", "targets": 0 }    
    { "width": "60px", "targets": 1 }    
    { "width": "90px", "targets": 2 }  
    { "width": "100px", "targets": 3 }  
    { "width": "120px", "targets": 4 }
    { "width": "80px", "targets": 5 }
    { "width": "100px", "targets": 6 }
    { "width": "80px", "targets": 7 }
    { "width": "80px", "targets": 8 }
    { "width": "80px", "targets": 9 }
    { "width": "70px", "targets": 10 }
  ])
 

registeredUserTable.columns().iterator 'column', (ctx, idx) ->
  $(jobsTable.column(idx).header()).append '<span class="sort-icon"/>'
  return

$('.usersearchinput').change ->
  registeredUserTable.ajax.reload()
  return

$('.userstrsearchinput').keyup ->
  registeredUserTable.ajax.reload()
  return

$('#datatable-jobs').on 'click', '.update_status', ->
  id = $(this).attr('job-id')
  status_id = $(this).attr('job-status')
  job_name = $(this).attr('job-name')
  job_link = $(this).attr('job-link')
  # $(".job-status").val(status_id)
  $("#job_id").val id
  $("span[id='job-title']").html '<a  href="'+job_link+'"  target="_blank" >'+job_name+'</a>'
  $(".update-error").text ''
  $(".job-status").val('')

  updateStatusValues(status_id,'update-job-status')
  
  return

updateStatusValues = (status_id,className) ->
  console.log className
  can_change_status = _.pluck(avail_status, status_id)
  can_change_status = _.first(can_change_status)

  $('.'+className+' > option').each ->
    console.log can_change_status
    console.log $(this).val()
    if $(this).val() != ""
      if _.contains(can_change_status, parseInt($(this).val()))
        $(this).removeClass('hidden')
      else
        $(this).addClass('hidden')

  return


$('body').on 'click', '.reset-filters', ->
  $('#job_name').val('')
  $('#company_name').val('')
  $('select[name="job_status"]').val('')
  $('select[name="job_city"]').val('')

  $('.date-from').val ''
  $('.date-to').val ''
  $('.date-range').val ''

  $('.multi-dd').each ->
    $(this).multiselect('deselectAll',false).change()

    $('.admin-job-role-search').each ->
      $(this).multiselect('deselectAll',false).change()
 
  jobsTable.ajax.reload()
  return
  
# $('#datatable-jobs').on 'change', 'select[name="job_status"]', ->
#   displayCheckbox()

$('body').on 'click', 'input[name="job_check_all"]', ->
  console.log "job_check_all"
  if $(this).is(':checked') 
    $('input[name="job_check[]"]').prop('checked',true)
  else
    $('input[name="job_check[]"]').prop('checked',false)

$('body').on 'click', 'input[name="job_check[]"]', ->
  console.log "job_check_all"
  allchecked = true
  $('input[name="job_check[]"]').each ->
    if !$(this).is(':checked')
      allchecked = false
    
  if allchecked
    $('input[name="job_check_all"]').prop('checked',true)
  else
    $('input[name="job_check_all"]').prop('checked',false)

  

$('body').on 'click', '#bulkupdate', ->
  jobCheck = ''
  $(".bulk-update-error").text ''
  if $('input[name="job_check_all"]').is(':checked')
    jobcheckall = 1
  else
    jobcheckall = 0

    $('input[name="job_check[]"]').each ->
      if $(this).is(':checked')
        jobCheck += $(this).val()+','

  new_status_id = $('.bulk-update-job-status').val()
  old_status_id = $('select[name="job_status"]').val()[0]

  if(new_status_id =="")
    $(".bulk-update-error").text 'Please select status'
    return
  else if(jobcheckall ==0 && jobCheck=='')
    $(".bulk-update-error").text 'Please select jobs to change status'
  else
    $.ajax
      type: 'post'
      url: '/admin-dashboard/jobs/bulk-update-job-status'
      data:
        'new_status_id': parseInt new_status_id
        'old_status_id': parseInt old_status_id
        'jobcheckall': jobcheckall
        'job_check_ids': jobCheck
      success: (data) ->
        if data.status
          $('.alert-success #message').html "Job status updated successfully."
          $('.alert-success').addClass 'active'
          setTimeout (->
            $('.alert-success').removeClass 'active'
            return
          ), 2000
          # $('.bulk-status-update').addClass('hidden')

          jobsTable.ajax.reload()

        else
          $('.alert-failure #message').html "Failed to updated job status."
          $('.alert-failure').addClass 'active'
          setTimeout (->
            $('.alert-failure').removeClass 'active'
            return
          ), 2000


displayCheckbox = () ->
  serachStatus = $('select[name="job_status"]').val()
  if serachStatus.length == 1
    $('input[name="job_check[]"]').removeClass('hidden').prop('checked',false)
    $('input[name="job_check_all"]').removeClass('hidden').prop('checked',false)
    # $(".bulk-status-update").removeClass('hidden')
    status_id = parseInt serachStatus[0]
    updateStatusValues(status_id ,'bulk-update-job-status')
  else
    $('input[name="job_check[]"]').addClass('hidden').prop('checked',false)
    $('input[name="job_check_all"]').addClass('hidden').prop('checked',false)
    # $(".bulk-status-update").addClass('hidden')


$('#updateStatusModal').on 'click', '#change_status', ->
  jobId = $("#job_id").val()
  jobstatus = $(".job-status option:selected").val()
  jobstatusText = $(".job-status option:selected").text()

  console.log jobstatus
  if(jobstatus =="")
    $(".update-error").text 'Please select status'
  else
    $.ajax
      type: 'post'
      url: '/admin-dashboard/jobs/update-job-status'
      data:
        'job_id': jobId
        'job_status': jobstatus
      success: (data) ->
        if data.status
          $('span[status_value="'+jobId+'"]').text jobstatusText
          $('a[job-id="'+jobId+'"]').attr 'job-status',jobstatus
          $('.alert-success #message').html "Job status updated successfully."
          $('.alert-success').addClass 'active'
          jobsTable.ajax.reload()
          setTimeout (->
            $('.alert-success').removeClass 'active'
            
            return
          ), 2000
        else
          $('.alert-failure #message').html "Failed to updated job status."
          $('.alert-failure').addClass 'active'
          setTimeout (->
            $('.alert-failure').removeClass 'active'
            return
          ), 2000
          $("#status-failure").modal('show')
          $("#status-failure").find('.job-title').attr('href',data.link)
          $("#status-failure").find('.job-title').html(data.name)
           
          
        $('#updateStatusModal').modal 'hide'
        return
      error: (request, status, error) ->
        throwError()
        return


$('.date_range_picker').on 'apply.daterangepicker', (ev, picker) ->
  $(this).closest('date-range-picker').find('.date_from').val picker.startDate.format('YYYY-MM-DD')
  $(this).closest('date-range-picker').find('.date_to').val picker.endDate.format('YYYY-MM-DD')
  $(this).val(picker.startDate.format('YYYY-MM-DD')+' to '+picker.endDate.format('YYYY-MM-DD'))
  jobsTable.ajax.reload()

# $('#publishDate').on 'apply.daterangepicker', (ev, picker) ->
#   $('input[name="date_pub_from"]').val picker.startDate.format('YYYY-MM-DD')
#   $('input[name="date_pub_to"]').val picker.endDate.format('YYYY-MM-DD')
#   $('#publishDate').val(picker.startDate.format('YYYY-MM-DD')+' to '+picker.endDate.format('YYYY-MM-DD'))
#   jobsTable.ajax.reload()


$('.jobs-table').closest('.row').addClass 'overflow-table'



$('.admin-job-role-search').multiselect
  buttonContainer: '<span></span>'
  buttonClass: ''
  maxHeight: 200
  templates: button: '<span class="multiselect dropdown-toggle" data-toggle="dropdown"><i class="fa fa-filter"></i></span>'
  enableFiltering: true
  enableCaseInsensitiveFiltering: true

$('.date-range').daterangepicker
  autoUpdateInput: false
  maxDate: moment()

$('.date-range').on 'apply.daterangepicker', (ev, picker) ->
  $(this).closest('.date-range-picker').find('.date-from').val picker.startDate.format('YYYY-MM-DD')
  $(this).closest('.date-range-picker').find('.date-to').val picker.endDate.format('YYYY-MM-DD')
  $(this).val(picker.startDate.format('DD-MM-YYYY')+' to '+picker.endDate.format('DD-MM-YYYY'))
  jobsTable.ajax.reload()


$('body').on 'click', '.clear-date', ->
  $(this).closest('div').find('.date-from').val ''
  $(this).closest('div').find('.date-to').val ''
  $(this).closest('div').find('.date-range').val ''
  jobsTable.ajax.reload()

