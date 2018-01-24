(function() {
  var listing_table;

  window.filters = {};

  listing_table = $('#datatable-manage_listings').DataTable({
    'pageLength': 25,
    'processing': true,
    'order': [[0, 'desc']],
    'serverSide': true,
    'ajax': {
      'url': '/show-listings',
      'type': 'post',
      'data': function(d) {
        var datavar;
        datavar = d;
        datavar.search['value'] = $('#listingNameSearch').val();
        datavar.filters = filters;
        return datavar;
      }
    },
    "columns": [
      {
        "data": "id"
      }, {
        "data": "city"
      }, {
        "data": "name"
      }, {
        "data": "categories"
      }, {
        "data": "submission_date"
      }, {
        "data": "approval"
      }, {
        "data": "paid"
      }, {
        "data": "status"
      }, {
        "data": "views"
      }, {
        "data": "contact-count"
      }, {
        "data": "direct-count"
      }, {
        "data": "shared-count"
      }
    ],
    'select': {
      'style': 'multi',
      'selector': 'td:first-child'
    },
    'columnDefs': [
      {
        'targets': 'no-sort',
        'orderable': false
      }, {
        'targets': [0],
        'visible': false,
        'searchable': false
      }
    ]
  });

  listing_table.columns().iterator('column', function(ctx, idx) {
    $(listing_table.column(idx).header()).append('<span class="sort-icon"/>');
  });

  $('#listingNameSearch').on('keyup', function() {
    listing_table.columns(1).search(this.value).draw();
  });

}).call(this);
