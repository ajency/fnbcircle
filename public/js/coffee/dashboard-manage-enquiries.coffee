filters = {}
enquiry_table = $('#datatable-manage_enquiries').DataTable(
  'pageLength': 25
  'processing': true
  'order': [ [
    2
    'desc'
  ] ]
  'serverSide':true
  'ajax':
    'url': '/get-enquiries'
    'type':'post'
    'data': (d) ->
      datavar = d;
      # datavar.search['value'] = $('#listingNameSearch').val()
      datavar.filters = filters
      console.log datavar
      return datavar
  "columns": [
    {"data": "type"}
    {"data": "enquirer_type"}
    {"data": "request_date"}
    {"data": "enquirer_name"}
    {"data": "enquirer_email"}
    {"data": "enquirer_phone"}
    {"data": "enquirer_details"}
    {"data": "message"}
    {"data": "categories"}
    {"data": "areas"}
    {"data": "made_against"}
    {"data": "sent_to"}
  ]
  'columnDefs': [
    {
      'targets': 'no-sort'
      'orderable': false
    }
    {
      'targets': [
        
      ]
      'visible': false
      'searchable': false
    }
  ]
  )
enquiry_table.columns().iterator 'column', (ctx, idx) ->
  $(enquiry_table.column(idx).header()).append '<span class="sort-icon"/>'
  return

$('body').on 'change','select#updateType', ->
  filters['enquiry_type'] = $(this).val()
  enquiry_table.ajax.reload()

$('body').on 'change','select#updateUser', ->
  filters['enquirer_type'] = $(this).val()
  enquiry_table.ajax.reload()

$('body').on 'click','a#clearSubDate', ->
  $('#submissionDate').val('')
  filters['request_date'] = []
  enquiry_table.ajax.reload()

$('#submissionDate').on 'apply.daterangepicker', (ev, picker) ->
  filters['request_date'] = {}
  filters['request_date']['start'] = picker.startDate.format('YYYY-MM-DD')
  filters['request_date']['end'] = picker.endDate.format('YYYY-MM-DD')
  $('#submissionDate').val(picker.startDate.format('YYYY-MM-DD')+' to '+picker.endDate.format('YYYY-MM-DD'))
  enquiry_table.ajax.reload()
  return