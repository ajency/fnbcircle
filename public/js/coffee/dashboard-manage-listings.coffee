window.filters = {}

listing_table = $('#datatable-manage_listings').DataTable(
  'pageLength': 25
  'processing': true
  'order': [ [
    1
    'desc'
  ] ]
  'serverSide':true
  'ajax':
    'url': '/show-listings'
    'type':'post'
    'data': (d) ->
      datavar = d;
      datavar.search['value'] = $('#listingNameSearch').val()
      datavar.filters = filters
      return datavar
      # d = datavar
  "columns": [
    {"data": "city"}
    {"data": "name"}
    {"data": "categories"}
    {"data": "submission_date"}
    {"data": "approval"}
    {"data": "premium"}
    {"data": "status"}
    {"data": "views"}
    {"data": "contact-count"}
    {"data": "direct-count"}
    {"data": "shared-count"}

  ]
  'select':
    'style': 'multi'
    'selector': 'td:first-child'
  'columnDefs': [
    {
      'targets': 'no-sort'
      'orderable': false
    }
  ]
  )
listing_table.columns().iterator 'column', (ctx, idx) ->
  $(listing_table.column(idx).header()).append '<span class="sort-icon"/>'
  return
$('#listingNameSearch').on 'keyup', ->
  listing_table.columns(1).search(@value).draw()
  return