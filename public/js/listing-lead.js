(function() {
  var filters, format, table;

  format = function(d) {
    return '<div class="row leads-drop"> <div class="col-sm-6"> <div class="operations m-b-20"> <p class="m-b-5 operations__title default-size text-uppercase grey-darker heavier m-t-0">City - areas</p>' + d.areas + '</div> <div class="operations"> <p class="m-b-5 operations__title default-size text-uppercase grey-darker heavier m-t-0"><i class="fa fa-comments text-primary" aria-hidden="true"></i> Message</p> <div class="ca-holder">' + d.message + '</div> </div> </div> <div class="col-sm-6"> <div class="operations cate-list"> <p class="m-b-5 operations__title default-size text-uppercase grey-darker heavier m-t-0">Categories</p>' + d.categories + '</div> </div> </div>';
  };

  $('.requestDate').daterangepicker();

  filters = {};

  table = $('#listing-leads').DataTable({
    'ordering': false,
    "searching": false,
    'pageLength': 10,
    'processing': true,
    'serverSide': true,
    'ajax': {
      'url': document.head.querySelector('[property="listing-enquiry"]').content,
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
        "className": 'text-secondary cursor-pointer',
        "orderable": false,
        "data": 'archive',
        "render": function(d) {
          if (d === 0) {
            return '<a href="#" class="archiveaction">archive</a>  <span class="details-control"><span class="more-less-text">More details</span> <i class="fa fa-angle-down text-color" aria-hidden="true"></i></span>';
          } else {
            return '<a href="#" class="unarchiveaction">unarchive</a>  <span class="details-control"><span class="more-less-text">More details</span> <i class="fa fa-angle-down text-color" aria-hidden="true"></i></span>';
          }
        }
      }
    ]
  });

  $('#listing-leads tbody').on('click', '.details-control', function() {
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

  $('body').on('change', 'input#namefilter', function() {
    filters['enquirer_name'] = this.value;
    return table.ajax.reload();
  });

  $('body').on('change', 'input#emailfilter', function() {
    filters['enquirer_email'] = this.value;
    return table.ajax.reload();
  });

  $('body').on('change', 'input#phonefilter', function() {
    filters['enquirer_contact'] = this.value;
    return table.ajax.reload();
  });

  $('body').on('change', 'input#archivefilter', function() {
    if (this.checked) {
      filters['archive'] = 1;
    } else {
      filters['archive'] = 0;
    }
    return table.ajax.reload();
  });

  $('body').on('click', '.archiveaction', function() {
    var editrow, enquiry;
    editrow = $(this).closest('td');
    enquiry = table.row(editrow).data();
    console.log(enquiry);
    $('#enquiryarchive a.archive-enquiry-confirmed').attr('data-enquiry-id', enquiry['id']);
    return $('#enquiryarchive').modal('show');
  });

  $('body').on('click', '#cancelenquiryarchive', function() {
    return $('#enquiryarchive a.archive-enquiry-confirmed').removeAttr('data-enquiry-id');
  });

  $('#enquiryarchive').on('click', 'a.archive-enquiry-confirmed', function() {
    var id;
    id = $(this).attr('data-enquiry-id');
    return $.ajax({
      type: 'post',
      url: document.head.querySelector('[property="listing-enquiry-archive"]').content,
      data: {
        'listing_id': document.getElementById('listing_id').value,
        'enquiry_id': id
      },
      success: function(data) {
        if (data['status'] === 200) {
          table.ajax.reload();
          $('.alert-success span.message').html('enquiry archived successfully');
          $('.alert-success').addClass('active');
          return setTimeout((function() {
            $('.alert-success').removeClass('active');
          }), 5000);
        }
      }
    });
  });

  $('body').on('click', '.unarchiveaction', function() {
    var editrow, enquiry;
    editrow = $(this).closest('td');
    enquiry = table.row(editrow).data();
    console.log(enquiry);
    return $.ajax({
      type: 'post',
      url: document.head.querySelector('[property="listing-enquiry-unarchive"]').content,
      data: {
        'listing_id': document.getElementById('listing_id').value,
        'enquiry_id': enquiry['id']
      },
      success: function(data) {
        if (data['status'] === 200) {
          table.ajax.reload();
          $('.alert-success span.message').html('enquiry unarchived successfully');
          $('.alert-success').addClass('active');
          return setTimeout((function() {
            $('.alert-success').removeClass('active');
          }), 5000);
        }
      }
    });
  });

}).call(this);
