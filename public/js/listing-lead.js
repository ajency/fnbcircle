(function() {
  var filters, format, table;

  format = function(d) {
    return '<div class="row leads-drop"> <div class="col-sm-6"> <div class="operations m-b-20"> <p class="m-b-5 operations__title default-size text-uppercase grey-darker heavier m-t-0">City - areas</p>' + d.areas + '</div> <div class="operations"> <p class="m-b-5 operations__title default-size text-uppercase grey-darker heavier m-t-0"><i class="fa fa-comments text-primary" aria-hidden="true"></i> Message</p> <div class="ca-holder">' + d.message + '</div> </div> </div> <div class="col-sm-6"> <div class="operations cate-list"> <p class="m-b-5 operations__title default-size text-uppercase grey-darker heavier m-t-0">Categories</p>' + d.categories + '</div> </div> </div>';
  };

  $('.requestDate').daterangepicker();

  filters = {};

  table = $('#listing-leads').DataTable({
    'ordering': false,
    'pageLength': 25,
    'processing': true,
    'serverSide': true,
    'ajax': {
      'url': '/get-listing-enquiries',
      'type': 'post',
      'data': function(d) {
        var datavar;
        datavar = d;
        datavar.listing_id = document.getElementById('listing_id').value;
        datavar.filters = filters;
        console.log(datavar);
        return datavar;
      }
    },
    "columns": [
      {
        "data": "type"
      }, {
        "data": "enquirer_name"
      }, {
        "data": "enquirer_email"
      }, {
        "data": "enquirer_phone"
      }, {
        "data": "enquirer_details"
      }, {
        "className": 'details-control text-secondary cursor-pointer',
        "orderable": false,
        "data": '',
        "defaultContent": '<div class="rating"><div class="bg"></div><div class="value" style=""></div></div><span class="more-less-text">More details</span> <i class="fa fa-angle-down text-color" aria-hidden="true"></i>'
      }
    ]
  });

  $('#listing-leads tbody').on('click', 'td.details-control', function() {
    var row, tr;
    console.log('sadfs');
    tr = $(this).closest('tr');
    row = table.row(tr);
    if (row.child.isShown()) {
      row.child.hide();
      tr.removeClass('shown');
      $(this).find('.more-less-text').text('More details');
    } else {
      row.child(format(row.data())).show();
      tr.addClass('shown');
      $(this).find('.more-less-text').text('Less details');
    }
  });

}).call(this);
