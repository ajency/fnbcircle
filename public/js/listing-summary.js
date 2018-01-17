(function() {
  var filters, format, table, tooltipinit;

  format = function(d) {
    return '<div class="row leads-drop"> <div class="col-sm-6"> <div class="operations m-b-20"> <p class="m-b-5 operations__title default-size text-uppercase grey-darker heavier m-t-0">State - Cities</p>' + d.areas + '</div> <div class="operations"> <p class="m-b-5 operations__title default-size text-uppercase grey-darker heavier m-t-0"><i class="fa fa-comments text-primary" aria-hidden="true"></i> Message</p> <div class="ca-holder">' + d.message + '</div> </div> </div> <div class="col-sm-6"> <div class="operations cate-list"> <p class="m-b-5 operations__title default-size text-uppercase grey-darker heavier m-t-0">Categories</p>' + d.categories + '</div> </div> </div>';
  };

  $('.requestDate').daterangepicker({
    locale: {
      format: 'DD-MM-YYYY'
    },
    maxDate: moment(),
    startDate: moment().subtract(1, 'months'),
    endDate: moment()
  });

  if ($('.post-gallery').length) {
    $('.post-gallery').magnificPopup({
      delegate: 'a',
      type: 'image',
      gallery: {
        enabled: true
      },
      zoom: {
        enabled: true,
        duration: 300
      }
    });
  }

  $('.requestDate').on('apply.daterangepicker', function(ev, picker) {
    var end_date, start_date, url;
    start_date = picker.startDate.format('YYYY-MM-DD');
    end_date = picker.endDate.format('YYYY-MM-DD');
    url = document.head.querySelector('[property="listing-stats"]').content;
    return $.ajax({
      url: url,
      type: 'post',
      data: {
        reference: document.getElementById('listing_id').value,
        start: start_date,
        end: end_date
      },
      success: function(response) {
        $('#direct-count').html(response['direct']);
        $('#shared-count').html(response['shared']);
        return $('#contact-count').html(response['contact']);
      }
    });
  });

  filters = {};

  table = $('#listing-leads').DataTable({
    'ordering': false,
    "dom": 'ltr',
    "searching": false,
    'pageLength': 5,
    'lengthChange': false,
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
        "orderable": false,
        "data": 'object_type',
        "render": function(d) {
          var tabWidth;
          if (d !== 'contact-request') {
            tabWidth = $('#listing-leads').width();
            $('#listing-leads_wrapper').css('width', tabWidth);
            return '<span class="details-control text-secondary heavier cursor-pointer"><span class="more-less-text">More details</span> <i class="fa fa-angle-down" aria-hidden="true"></i></span>';
          } else {
            return '';
          }
        }
      }
    ]
  });

  tooltipinit = function() {
    return setTimeout((function() {
      return $('[data-toggle="tooltip"]').tooltip();
    }), 1000);
  };

  tooltipinit();

  $('#listing-leads tbody').on('click', '.details-control', function() {
    var row, tr;
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
