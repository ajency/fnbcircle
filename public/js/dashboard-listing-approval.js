(function() {
  var applyCategFilter, approval_table, categ, categories, changeStatusAPI, getNodes, populate, selected_listings, sendRequest, showBulk;

  window.filters = {
    'submission_date': {
      'start': '',
      'end': ''
    },
    'category_nodes': [],
    'status': ["1", "2", "4", "5"],
    'city': [],
    'updated_by': {
      'user_id': [],
      'user_type': ['internal', 'external']
    },
    'id_filter': {
      'start': document.head.querySelector('[property="start-id"]').content,
      'end': document.head.querySelector('[property="end-id"]').content
    }
  };

  approval_table = $('#datatable-listing_approval').DataTable({
    'language': {
      "zeroRecords": "No listings? Please check if you're not making one of the common mistakes listed below:<br><ul><li>Mark the include Drafts on the top right as ticked</li><li>start_id must always be less than end_id</li></ul>"
    },
    'pageLength': 25,
    'processing': true,
    'order': [[2, 'desc']],
    'serverSide': true,
    'drawCallback': function() {
      if (filters['status'].length === 1) {
        $('.select-checkbox').css('display', 'table-cell');
        return $('.select-checkbox').removeClass('selected');
      }
    },
    'ajax': {
      'url': '/all-listing',
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
        "data": "#"
      }, {
        "data": "name"
      }, {
        "data": "id"
      }, {
        "data": "city"
      }, {
        "data": "categories"
      }, {
        "data": "submission_date"
      }, {
        "data": "updated_on"
      }, {
        "data": "last_updated_by"
      }, {
        "data": "type"
      }, {
        "data": "owner-status"
      }, {
        "data": "duplicates"
      }, {
        "data": "premium"
      }, {
        "data": "source"
      }, {
        "data": "status_ref"
      }, {
        "data": "status"
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
        'orderable': false,
        'className': 'select-checkbox',
        'targets': 0
      }, {
        'targets': [13],
        'visible': false,
        'searchable': false
      }
    ]
  });

  approval_table.columns().iterator('column', function(ctx, idx) {
    $(approval_table.column(idx).header()).append('<span class="sort-icon"/>');
  });

  approval_table.on('click', 'th.select-checkbox', function() {
    if ($('th.select-checkbox').hasClass('selected')) {
      approval_table.rows().deselect();
      $('th.select-checkbox').removeClass('selected');
    } else {
      approval_table.rows().select();
      $('th.select-checkbox').addClass('selected');
    }
  }).on('select deselect', function() {
    'Some selection or deselection going on';
    if (approval_table.rows({
      selected: true
    }).count() !== approval_table.rows().count()) {
      $('th.select-checkbox').removeClass('selected');
    } else {
      $('th.select-checkbox').addClass('selected');
    }
  });

  $('#listingNameSearch').on('keyup', function() {
    approval_table.columns(1).search(this.value).draw();
  });

  $('body').on('click', 'input:radio[name=\'categories\']', function() {
    var cat_icon, cat_name, id, obj;
    $('div.full-modal').removeClass('hidden');
    cat_name = $(this).data('name');
    $('.main-cat-name').html(cat_name);
    cat_icon = $(this).closest('li').find('.cat-icon').clone().addClass('m-r-15');
    $('.sub-category .cat-name').find('.cat-icon').remove();
    $('.sub-category .cat-name').prepend(cat_icon);
    $('.categ-list').html('');
    $('.mobile-categories').html('');
    id = $(this).val();
    obj = {};
    obj[0] = {
      "id": id
    };
    $.ajax({
      type: 'post',
      url: '/get_categories',
      data: {
        'parent': JSON.stringify(obj),
        'status': '1'
      },
      success: function(data) {
        var html, html_mob, i, key;
        html = '';
        html_mob = '';
        i = 0;
        data[id]['children'] = _.sortBy(_.sortBy(data[id]['children'], 'name'), 'order');
        for (key in data[id]['children']) {
          html_mob += '<div class="toggle-collapse desk-hide" data-toggle="collapse" data-target="#' + slugify(data[id]['children'][key]['name']) + '"  name="' + data[id]['children'][key]['id'] + '" aria-expanded="false" aria-controls="' + slugify(data[id]['children'][key]['name']) + '">' + data[id]['children'][key]['name'] + ' <i class="fa fa-angle-down" aria-hidden="true"></i></div><div role="tabpanel" class="tab-pane collapse';
          if (i === 0) {
            html_mob += ' active';
          }
          html_mob += '" id="' + slugify(data[id]['children'][key]['name']) + '" name="' + data[id]['children'][key]['id'] + '"><div id="selectall" class="nodes select-all-nodes"><label class="flex-row"><input type="checkbox" class="checkbox"> Select All</label></div><ul class="nodes"><li>' + data[id]['children'][key]['name'] + '</li></ul></div>';
          html += '<li role="presentation"';
          if (i === 0) {
            html += ' class="active"';
          }
          html += '><a href="#' + slugify(data[id]['children'][key]['name']) + '"  name="' + data[id]['children'][key]['id'] + '" aria-controls="' + slugify(data[id]['children'][key]['name']) + '" role="tab" data-toggle="tab">' + data[id]['children'][key]['name'] + '</a></li>';
          i++;
        }
        $('.categ-list').html(html);
        $('.mobile-categories').html(html_mob);
        categ.length = 0;
        for (key in data[id]['children']) {
          getNodes(data[id]['children'][key]['id']);
          break;
        }
        $('div.full-modal').addClass('hidden');
      },
      async: true,
      error: function(request, status, error) {
        throwError();
      }
    });
  });

  categ = [];

  getNodes = function(branchID) {
    var loader, obj;
    obj = {};
    obj[0] = {
      'id': branchID
    };
    loader = '<div class="site-loader section-loader half-loader"><div id="floatingBarsG"><div class="blockG" id="rotateG_01"></div><div class="blockG" id="rotateG_02"></div><div class="blockG" id="rotateG_03"></div><div class="blockG" id="rotateG_04"></div><div class="blockG" id="rotateG_05"></div><div class="blockG" id="rotateG_06"></div><div class="blockG" id="rotateG_07"></div><div class="blockG" id="rotateG_08"></div></div></div>';
    if (categ[branchID] !== true) {
      $('div[name="' + branchID + '"].tab-pane').addClass('relative');
      $('div[name="' + branchID + '"].tab-pane ul.nodes').html(loader);
      $.ajax({
        type: 'post',
        url: '/get_categories',
        data: {
          'parent': JSON.stringify(obj),
          'status': '1'
        },
        success: function(data) {
          var array, branch, html, i, j, key, node;
          array = [];
          $('ul#view-categ-node').find('input[type=\'hidden\']').each(function(index, data) {
            return array.push($(this).val());
          });
          for (branch in categories['categories']) {
            for (node in categories['categories'][branch]['nodes']) {
              if (_.indexOf(array, categories['categories'][branch]['nodes'][node]['id']) === -1) {
                delete categories['categories'][branch]['nodes'][node];
              }
            }
            j = 0;
            for (i in categories['categories'][branch]['nodes']) {
              j++;
            }
            if (j === 0) {
              delete categories['categories'][branch];
            }
          }
          html = '<input type="hidden" name="parent" value="' + data[branchID]['parent']['name'] + '">';
          html += '<input type="hidden" name="image" value="' + data[branchID]['parent']['icon_url'] + '">';
          html += '<input type="hidden" name="branch" value="' + data[branchID]['name'] + '" id="' + branchID + '">';
          data[branchID]['children'] = _.sortBy(_.sortBy(data[branchID]['children'], 'name'), 'order');
          for (key in data[branchID]['children']) {
            html += '<li><label class="flex-row"><input type="checkbox" class="checkbox" ';
            if (_.indexOf(array, String(data[branchID]['children'][key]['id'])) !== -1) {
              html += 'checked';
            }
            html += ' for="' + slugify(data[branchID]['children'][key]['name']) + '" value="' + data[branchID]['children'][key]['id'] + '" name="' + data[branchID]['children'][key]['name'] + '"><p class="lighter nodes__text" id="' + slugify(data[branchID]['children'][key]['name']) + '">' + data[branchID]['children'][key]['name'] + '</p></label></li>';
          }
          $('div#' + slugify(data[branchID]['name']) + '.tab-pane ul.nodes').html(html);
          categ[branchID] = true;
          if ($('div#' + slugify(data[branchID]['name']) + '.tab-pane ul.nodes input[type="checkbox"]').length === $('div#' + slugify(data[branchID]['name']) + '.tab-pane ul.nodes input[type="checkbox"]:checked').length && $('div#' + slugify(data[branchID]['name']) + '.tab-pane ul.nodes input[type="checkbox"]').length !== 0) {
            $('div#' + slugify(data[branchID]['name']) + '.tab-pane div#selectall input[type="checkbox"]').prop('checked', true);
          }
        },
        async: true,
        error: function(request, status, error) {
          throwError();
        }
      });
    }
  };

  categories = {
    'categories': []
  };

  $('body').on('click', '.categ-list a', function() {
    populate();
    return getNodes($(this).attr('name'));
  });

  $('body').on('click', '.sub-category-back', function() {
    $('.main-category').removeClass('hidden');
    return $('.sub-category').removeClass('shown');
  });

  $('body').on('click', '.category-back', function() {
    $('.main-category').removeClass('hidden');
    $('.sub-category').removeClass('shown');
    $('.desk-level-two').addClass('hidden');
    $('.firstStep').removeClass('hidden mobile-hide');
    return $('.interested-options .radio').prop('checked', false);
  });

  $('body').on('click', '.level-two-toggle', function() {
    $('.mobileCat-back').addClass('hidden');
    return $('.category-back').removeClass('mobile-hide');
  });

  $('.topSelect').click(function() {
    return setTimeout((function() {
      $('.category-back').addClass('hidden');
    }), 100);
  });

  $('.catSelect-click').click(function() {
    return $('.category-back').removeClass('hidden');
  });

  $('#category-select').on('hidden.bs.modal', function(e) {
    $('.interested-options .radio').prop('checked', false);
  });

  populate = function() {
    var source, template;
    source = '{{#categories}}<div class="single-category gray-border add-more-cat m-t-15"><div class="row flex-row categoryContainer corecat-container"><div class="col-sm-4 flex-row"><img class="import-icon cat-icon" src="{{image-url}}"></img><div class="branch-row"><div class="cat-label">{{parent}}</div></div></div><div class="col-sm-2"><strong class="branch">{{branch}}</strong></div><div class="col-sm-6"> <ul class="fnb-cat small flex-row" id="view-categ-node">{{#nodes}}<li><span class="fnb-cat__title">{{name}}<input type=hidden name="categories" value="{{id}}" data-item-name="{{name}}"> <span class="fa fa-times remove"></span></span></li>{{/nodes}}</ul></div> </div><div class="delete-cat"><span class="fa fa-times remove"></span></div></div>{{/categories}}';
    template = Handlebars.compile(source, {
      noEscape: true
    });
    $('div#categories.node-list').html(template(categories));
  };

  $('body').on('click', '.delete-cat', function() {
    return $(this).closest('.single-category').remove();
  });

  $('body').on('click', '.fnb-cat .remove', function() {
    var item, list;
    item = $(this).closest('.fnb-cat__title').parent();
    list = item.parent();
    item.remove();
    if (list.children().length === 0) {
      return list.closest('.single-category').remove();
    }
  });

  $('body').on('change', '.tab-pane.collapse input[type=\'checkbox\']', function() {
    var branchID, id, parentDiv;
    if ($(this).closest('.tab-pane').find('ul.nodes input[type="checkbox"]').length === $(this).closest('.tab-pane').find('ul.nodes input[type="checkbox"]:checked').length) {
      $(this).closest('.tab-pane').find('div#selectall input[type="checkbox"]').prop('checked', true);
    } else {
      if ($(this).closest('.tab-pane').find('div#selectall input[type="checkbox"]').prop('checked')) {
        $(this).closest('.tab-pane').find('div#selectall input[type="checkbox"]').prop('checked', false);
      }
    }
    parentDiv = $(this).closest('div');
    branchID = parentDiv.find('input[name="branch"]').attr('id');
    if (!categories['categories'].hasOwnProperty(branchID)) {
      categories['categories'][branchID] = {
        'image-url': parentDiv.find('input[name="image"]').val(),
        'parent': parentDiv.find('input[name="parent"]').val(),
        'branch': parentDiv.find('input[name="branch"]').val(),
        'nodes': []
      };
    }
    if ($(this)[0].checked) {
      return categories['categories'][branchID]['nodes'][$(this).val()] = {
        'name': $(this).attr('name'),
        'id': $(this).val()
      };
    } else {
      id = $(this).val();
      return delete categories['categories'][branchID]['nodes'][id];
    }
  });

  $('body').on('click', 'button#category-select.fnb-btn', function() {
    var branch, i, j, k;
    k = 0;
    if (categories['categories'].length > 0) {
      for (branch in categories['categories']) {
        j = 0;
        for (i in categories['categories'][branch]['nodes']) {
          j++;
        }
        if (j === 0) {
          delete categories['categories'][branch];
          continue;
        }
        k++;
      }
    }
    populate();
    if (k > 0) {
      $('#categ-selected').removeClass('hidden');
      $('#no-categ-select').addClass('hidden');
      return $('.core-cat-cont').removeClass('hidden');
    } else {
      $('#categ-selected').addClass('hidden');
      $('#no-categ-select').removeClass('hidden');
      return $('.core-cat-cont').addClass('hidden');
    }
  });

  applyCategFilter = function() {
    var array;
    array = [];
    $('ul#view-categ-node').find('input[type=\'hidden\']').each(function(index, data) {
      return array.push($(this).val());
    });
    filters['category_nodes'] = array;
    sendRequest();
  };

  $('body').on('click', 'button#applyCategFilter', function(e) {
    return applyCategFilter();
  });

  $('body').on('click', 'button#resetAll', function(e) {
    $('div#categories.node-list').html('');
    $('input#draftstatus').prop('checked', false);
    $('select#status-filter').multiselect('rebuild');
    $('#submissionDate').val('');
    $('#listingNameSearch').val('');
    $('.multi-dd').each(function() {
      return $(this).multiselect('deselectAll', false);
    });
    window.filters = {
      'submission_date': {
        'start': '',
        'end': ''
      },
      'category_nodes': [],
      'status': ["1", "2", "4", "5"],
      'city': [],
      'updated_by': {
        'user_id': [],
        'user_type': ['internal', 'external']
      },
      'id_filter': {
        'start': document.head.querySelector('[property="start-id"]').content,
        'end': document.head.querySelector('[property="end-id"]').content
      }
    };
    sendRequest();
    showBulk();
  });

  $('body').on('click', 'a#clearSubDate', function() {
    $('#submissionDate').val('');
    filters['submission_date']['start'] = "";
    filters['submission_date']['end'] = "";
    return sendRequest();
  });

  $('div#category-select').on('change', 'div#selectall input[type="checkbox"]', function() {
    if ($(this).prop('checked')) {
      return $(this).closest('.tab-pane').find('ul.nodes input[type="checkbox"]').prop('checked', true).change();
    } else {
      return $(this).closest('.tab-pane').find('ul.nodes input[type="checkbox"]').prop('checked', false).change();
    }
  });

  selected_listings = [];

  $('body').on('change', 'input#draftstatus', function() {
    var prev, status;
    if ($(this).prop('checked')) {
      status = $('select#status-filter');
      prev = status.val();
      status.html('<option value="1">Published</option><option value="2">Pending Review</option> <option value="3">Draft</option><option value="4">Archived</option><option value="5">Rejected</option>');
      status.multiselect('rebuild');
      status.multiselect('select', prev);
      return status.change();
    } else {
      status = $('select#status-filter');
      prev = status.val();
      status.html('<option value="1">Published</option><option value="2">Pending Review</option> <option value="4">Archived</option><option value="5">Rejected</option>');
      status.multiselect('rebuild');
      status.multiselect('select', prev);
      return status.change();
    }
  });

  showBulk = function() {
    var curr;
    if (filters['status'].length === 1) {
      curr = filters['status'][0];
      $('.bulk-status-update select.status-select').val('');
      $('.bulk-status-update select.status-select option').prop('hidden', true);
      if (curr === '1') {
        $('.bulk-status-update select.status-select option[value="4"]').prop('hidden', false);
      }
      if (curr === '2') {
        $('.bulk-status-update select.status-select option[value="1"]').prop('hidden', false);
        $('.bulk-status-update select.status-select option[value="5"]').prop('hidden', false);
      }
      if (curr === '3') {
        $('.bulk-status-update select.status-select option[value="2"]').prop('hidden', false);
      }
      if (curr === '4') {
        $('.bulk-status-update select.status-select option[value="1"]').prop('hidden', false);
      }
      if (curr === '5') {
        $('.bulk-status-update select.status-select option[value="2"]').prop('hidden', false);
      }
      $('.select-checkbox').css('display', 'table-cell');
      $('.bulk-status-update').removeClass('hidden');
      return $('button#bulkupdate').prop('disabled', true);
    } else {
      $('.select-checkbox').css('display', 'none');
      return $('.bulk-status-update').addClass('hidden');
    }
  };

  $('body').on('change', 'select#status-filter', function() {
    var val;
    filters['status'] = [];
    val = $(this).val();
    if (val.length === 0) {
      if ($('input#draftstatus').prop('checked')) {
        filters['status'] = ["1", "2", "3", "4", "5"];
      } else {
        filters['status'] = ["1", "2", "4", "5"];
      }
    } else {
      val.forEach(function(item) {
        return filters['status'].push(item);
      });
    }
    showBulk();
    return sendRequest();
  });

  $('.bulk-status-update').on('click', 'button#bulkupdate', function() {
    var instance, key, l, len, selected_rows, sm;
    $('button#bulkupdate').prop('disabled', true);
    instance = $('.bulk-status-update #bulkupdateform').parsley();
    if (!instance.validate()) {
      $('button#bulkupdate').prop('disabled', false);
      return false;
    }
    selected_rows = approval_table.rows({
      selected: true
    }).data();
    selected_listings = [];
    for (l = 0, len = selected_rows.length; l < len; l++) {
      key = selected_rows[l];
      selected_listings.push({
        'id': key['id']
      });
    }
    selected_listings.forEach(function(listing) {
      return listing['status'] = $('.bulk-status-update select.status-select').val();
    });
    sm = $($('.bulk-status-update input[type="checkbox"]')[0]).prop('checked');
    return changeStatusAPI(sm);
  });

  $('#submissionDate').on('apply.daterangepicker', function(ev, picker) {
    filters['submission_date']['start'] = picker.startDate.format('YYYY-MM-DD');
    filters['submission_date']['end'] = picker.endDate.format('YYYY-MM-DD');
    $('#submissionDate').val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
    sendRequest();
  });

  $('body').on('change', 'select#updateUser', function() {
    filters['updated_by']['user_type'] = $(this).val();
    return sendRequest();
  });

  $('body').on('change', 'select#listingType', function() {
    filters['type'] = $(this).val();
    return sendRequest();
  });

  $('body').on('change', 'select#premiumRequest', function() {
    filters['premium'] = $(this).val();
    return sendRequest();
  });

  $('body').on('change', 'select#citySelect', function() {
    filters['city'] = $(this).val();
    return sendRequest();
  });

  $('body').on('change', 'select#user-status', function() {
    filters['user-status'] = $(this).val();
    return sendRequest();
  });

  $('body').on('change', 'select#source-filter', function() {
    filters['source'] = $(this).val();
    return sendRequest();
  });

  $('#datatable-listing_approval').on('click', 'i.fa-pencil', function(e) {
    var editrow, listing;
    editrow = $(this).closest('td');
    listing = approval_table.row(editrow).data();
    $('#updateStatusModal span#listing-title').html(listing['name']);
    $('#updateStatusModal select.status-select').val('');
    $('#updateStatusModal select.status-select option').prop('hidden', true);
    if (listing['status_ref'] === 1) {
      $('#updateStatusModal select.status-select option[value="4"]').prop('hidden', false);
    }
    if (listing['status_ref'] === 2) {
      $('#updateStatusModal select.status-select option[value="1"]').prop('hidden', false);
      $('#updateStatusModal select.status-select option[value="5"]').prop('hidden', false);
    }
    if (listing['status_ref'] === 3) {
      $('#updateStatusModal select.status-select option[value="2"]').prop('hidden', false);
    }
    if (listing['status_ref'] === 4) {
      $('#updateStatusModal select.status-select option[value="1"]').prop('hidden', false);
    }
    if (listing['status_ref'] === 5) {
      $('#updateStatusModal select.status-select option[value="2"]').prop('hidden', false);
    }
    selected_listings = [];
    return selected_listings.push({
      'id': listing['id']
    });
  });

  $('#updateStatusModal').on('click', 'button#change_status', function() {
    var instance, sm;
    $('button#change_status').prop('disabled', true);
    instance = $('#updateStatusModal #singlestatus').parsley();
    if (!instance.validate()) {
      $('button#change_status').prop('disabled', false);
      console.log('lamama');
      return false;
    }
    selected_listings.forEach(function(listing) {
      return listing['status'] = $('#updateStatusModal select.status-select').val();
    });
    console.log(selected_listings);
    sm = $('#updateStatusModal input[type="checkbox"]').prop('checked');
    return changeStatusAPI(sm);
  });

  changeStatusAPI = function(sm) {
    var url;
    url = document.head.querySelector('[property="status-url"]').content;
    if (sm) {
      sm = "1";
    } else {
      sm = "0";
    }
    console.log('sm = ' + sm);
    return $.ajax({
      type: 'post',
      url: url,
      data: {
        change_request: JSON.stringify(selected_listings),
        sendmail: sm
      },
      success: function(response) {
        var html;
        sendRequest();
        $('#updateStatusModal').modal('hide');
        if (response['status'] === 'Error') {
          html = '';
          response['data']['error'].forEach(function(listing) {
            return html += '<li><a target="_blank" href="' + listing['url'] + '" class="primary-link">' + listing['name'] + '</a><p>' + listing['message'] + '</p></li>';
          });
          $('.bulk-failure ul.listings__links').html(html);
          $('.bulk-failure').modal('show');
        } else {
          $('.alert-success #message').html("Listing status updated successfully.");
          $('.alert-success').addClass('active');
          setTimeout((function() {
            $('.alert-success').removeClass('active');
          }), 2000);
        }
        $('button#change_status').prop('disabled', false);
      }
    });
  };

  approval_table.on('select', function() {
    var selected_rows;
    selected_rows = approval_table.rows({
      selected: true
    }).count();
    console.log(selected_rows);
    if (selected_rows > 0) {
      return $('button#bulkupdate').prop('disabled', false);
    } else {
      return $('button#bulkupdate').prop('disabled', true);
    }
  });

  approval_table.on('deselect', function() {
    var selected_rows;
    selected_rows = approval_table.rows({
      selected: true
    }).count();
    console.log(selected_rows);
    if (selected_rows > 0) {
      return $('button#bulkupdate').prop('disabled', false);
    } else {
      return $('button#bulkupdate').prop('disabled', true);
    }
  });

  sendRequest = function() {
    return approval_table.ajax.reload();
  };

  $('body').on('click', 'button#importListing', function(e) {
    return $('#importListingModal').modal('show');
  });

}).call(this);
