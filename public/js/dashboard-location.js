(function() {
  var editrow, loc_table, resetFilters, status, updateCities;

  loc_table = $('#datatable-locations').DataTable({
    'pageLength': 25,
    'processing': true,
    'ajax': {
      'url': '/view-location',
      'type': 'POST'
    },
    'columns': [
      {
        'data': '#'
      }, {
        'data': 'name'
      }, {
        'data': 'slug'
      }, {
        'data': 'isCity'
      }, {
        'data': 'isArea'
      }, {
        'data': 'city'
      }, {
        'data': 'sort_order'
      }, {
        'data': 'publish'
      }, {
        'data': 'update'
      }, {
        'data': 'status'
      }, {
        'data': 'id'
      }, {
        'data': 'area'
      }, {
        'data': 'city_id'
      }
    ],
    'order': [[8, 'desc']],
    'columnDefs': [
      {
        'targets': 'no-sort',
        'orderable': false
      }, {
        className: 'text-center',
        'targets': [0, 2, 3, 4, 6]
      }, {
        'targets': [2, 10, 11, 12],
        'visible': false,
        'searchable': false
      }
    ]
  });

  loc_table.columns().iterator('column', function(ctx, idx) {
    $(loc_table.column(idx).header()).append('<span class="sort-icon"/>');
  });

  $('#locationNameSearch').on('keyup', function() {
    loc_table.columns(1).search(this.value).draw();
  });

  $('body').on('change', 'input[type=radio][name=locationType]', function() {
    if (this.value === '0') {
      $('.select_city').addClass('hidden');
      $('#locationForm select').val("");
      $('.select_city select').removeAttr('required');
      $('select[name="status"] option[value="1"]').attr("hidden", "hidden");
      $('.namelabel').html("State");
      $('input[name="name"]').attr('data-parsley-required-message', 'Please enter the state name');
      $('input[name="slug"]').attr('data-parsley-required-message', 'Enter the state slug');
      $('input[name="order"]').attr('data-parsley-required-message', 'Sort order for the state is required');
    } else if (this.value === '1') {
      $('.select_city').removeClass('hidden');
      $('.select_city select').attr('required', 'required');
      $('select[name="status"] option[value="1"]').removeAttr("hidden");
      $('input[name="name"]').attr('data-parsley-required-message', 'Please enter the city name');
      $('input[name="slug"]').attr('data-parsley-required-message', 'Enter the city slug');
      $('input[name="order"]').attr('data-parsley-required-message', 'Sort order for the area is required');
      $('#add_location_modal select').val('');
      $('.namelabel').html("City");
    }
    $('input[type="text"]').val('');
    $('input[type="number"]').val('1');
  });

  $('#add_location_modal').on('show.bs.modal', function(e) {
    if (!loc_table.data().count()) {
      $('#add_location_modal #area').prop('disabled', true);
    } else {
      $('#add_location_modal #area').prop('disabled', false);
    }
    $('input#city[name="locationType"]').prop('checked', true);
    $('.select_city').addClass('hidden');
    $('.select_city select').removeAttr('required');
    $('#add_location_modal select').val('');
    $('input[type="text"]').val('');
    $('input[type="number"]').val('1');
    $('select[name="status"] option[value="1"]').attr("hidden", "hidden");
    $('.namelabel').html("State");
    $('input[name="name"]').attr('data-parsley-required-message', 'Please enter the state name');
    $('input[name="slug"]').attr('data-parsley-required-message', 'Enter the state slug');
    $('input[name="order"]').attr('data-parsley-required-message', 'Sort order for the state is required');
    $('#add_location_modal .save-btn').prop('disabled', false);
  });

  $('#add_location_modal').on('click', '.save-btn', function(e) {
    var area_id, city_id, instance, name, slug, sort_order, status, type;
    $('#add_location_modal .save-btn').prop('disabled', true);
    e.preventDefault();
    instance = $('#locationForm').parsley();
    if (!instance.validate()) {
      $('#add_location_modal .save-btn').prop('disabled', false);
      return false;
    }
    city_id = $('.select_city select').val();
    area_id = "";
    type = $('input[type=radio][name=locationType]:checked').val();
    name = $('input[name="name"]').val();
    slug = $('input[name="slug"]').val();
    sort_order = $('input[name="order"]').val();
    status = $('select[name="status"]').val();
    console.log(type, city_id, name, slug, sort_order, status, area_id);
    return $.ajax({
      type: 'post',
      url: '/save-location',
      data: {
        "type": type,
        "city_id": city_id,
        "name": name,
        "slug": slug,
        "sort_order": sort_order,
        "status": status,
        "area_id": area_id
      },
      success: function(serverData) {
        var $status, area, city, data, isarea, iscity, node, opt, opt1, table;
        if (serverData['status'] !== "200") {
          $('.alert-failure #message').html(serverData['msg']);
          $('.alert-failure').addClass('active');
          $('#add_category_modal .save-btn').prop('disabled', false);
          setTimeout((function() {
            $('.alert-failure').removeClass('active');
          }), 5000);
          $('#add_location_modal .save-btn').prop('disabled', false);
          return;
        }
        if (serverData['status'] === "200") {
          data = serverData['data'];
          if (data.hasOwnProperty('city_id')) {
            iscity = '-<span class="hidden">no</span>';
            isarea = '<i class="fa fa-check text-success"></i><span class="hidden">Yes</span>';
            city = data['city']['name'];
            area = "1";
            city_id = data['city_id'];
          } else {
            iscity = '<i class="fa fa-check text-success"></i><span class="hidden">Yes</span>';
            isarea = '-<span class="hidden">no</span>';
            city = "";
            area = "0";
            city_id = "";
            opt = document.createElement('option');
            opt.value = data['id'];
            opt.innerHTML = data['name'];
            document.getElementById('allcities').appendChild(opt);
            opt1 = document.createElement('option');
            opt1.value = data['name'];
            opt1.innerHTML = data['name'];
            document.getElementById('filtercities').appendChild(opt1);
            $('#filtercities').multiselect('rebuild');
          }
          if (data['status'] === 0) {
            $status = 'Draft';
          }
          if (data['status'] === 1) {
            $status = 'Published';
          }
          if (data['status'] === 2) {
            $status = 'Archived';
          }
          table = $('#datatable-locations').DataTable();
          node = table.row.add({
            "#": '<a href="#"><i class="fa fa-pencil"></i></a>',
            "name": data['name'],
            "slug": data['slug'],
            "isCity": iscity,
            "isArea": isarea,
            "city": city,
            "sort_order": data['order'],
            "publish": data['published_date'],
            "update": data['updated_at'],
            "status": $status,
            "id": data['id'],
            "area": area,
            "city_id": city_id
          }).draw().node();
          $('#add_location_modal').modal('hide');
          $('.alert-success #message').html("Location added successfully.");
          $('.alert-success').addClass('active');
          updateCities();
          return setTimeout((function() {
            $('.alert-success').removeClass('active');
          }), 2000);
        }
      },
      error: function(request, status, error) {
        console.log(status);
        console.log(error);
        $('.alert-failure').addClass('active');
      }
    });
  });

  editrow = void 0;

  status = void 0;

  $('#datatable-locations').on('click', 'i.fa-pencil', function() {
    var loc, table;
    table = $('#datatable-locations').DataTable();
    editrow = $(this).closest('td');
    loc = table.row(editrow).data();
    console.log(loc);
    $('#listing_warning').html('');
    $('#edit_location_modal .save-btn').prop('disabled', false);
    $('#edit_location_modal input[name="type"]').val(loc['area']);
    $('#edit_location_modal input[name="area_id"]').val(loc["id"]);
    $('#edit_location_modal select#allcities').val(loc['city_id']);
    if (loc['city_id'] === "") {
      $('#edit_location_modal .select_city').addClass('hidden');
      $('#edit_location_modal .select_city select').removeAttr('required');
      $('#edit_location_modal input[name="area_id"]').val("");
      $('#edit_location_modal select#allcities').val(loc['id']);
      $('.namelabel').html("State");
      $('#edit_location_modal input#city').prop('checked', true);
      $('input[name="name"]').attr('data-parsley-required-message', 'Please enter the state name');
      $('input[name="slug"]').attr('data-parsley-required-message', 'Enter the state slug');
      $('input[name="order"]').attr('data-parsley-required-message', 'Sort order for the state is required');
    } else {
      $('#edit_location_modal .select_city select').attr('required', 'required');
      $('.namelabel').html("City");
      $('#edit_location_modal .select_city').removeClass('hidden');
      $('#edit_location_modal input#area').prop('checked', true);
      $('input[name="name"]').attr('data-parsley-required-message', 'Please enter the city name');
      $('input[name="slug"]').attr('data-parsley-required-message', 'Enter the city slug');
      $('input[name="order"]').attr('data-parsley-required-message', 'Sort order for the city is required');
    }
    $('#edit_location_modal input[name="name"]').val(loc['name']);
    $('#edit_location_modal input[name="slug"]').val(loc['slug']);
    $('#edit_location_modal input[name="order"]').val(loc['sort_order']);
    if (loc['status'] === "Draft") {
      $('#edit_location_modal select[name="status"]').val("0");
      $('#edit_location_modal select[name="status"] option[value="0"]').removeAttr("hidden");
      $('#edit_location_modal select[name="status"] option[value="1"]').removeAttr("hidden");
      $('#edit_location_modal select[name="status"] option[value="2"]').attr("hidden", "hidden");
      $('#edit_location_modal .select_city select').prop('disabled', false);
      $('#edit_location_modal input[name="slug"]').prop('disabled', false);
      status = 0;
    }
    if (loc['status'] === "Published") {
      $('#edit_location_modal select[name="status"]').val("1");
      status = 1;
      $('#edit_location_modal select[name="status"] option[value="0"]').attr("hidden", "hidden");
      $('#edit_location_modal select[name="status"] option[value="1"]').removeAttr("hidden");
      $('#edit_location_modal select[name="status"] option[value="2"]').removeAttr("hidden");
      $('#edit_location_modal .select_city select').prop('disabled', true);
      $('#edit_location_modal input[name="slug"]').prop('disabled', true);
    }
    if (loc['status'] === "Archived") {
      $('#edit_location_modal select[name="status"]').val("2");
      status = 2;
      $('#edit_location_modal select[name="status"] option[value="0"]').attr("hidden", "hidden");
      $('#edit_location_modal select[name="status"] option[value="1"]').removeAttr("hidden");
      $('#edit_location_modal select[name="status"] option[value="2"]').removeAttr("hidden");
      $('#edit_location_modal .select_city select').prop('disabled', true);
      $('#edit_location_modal input[name="slug"]').prop('disabled', true);
    }
    return $('#edit_location_modal').modal('show');
  });

  $('#edit_location_modal').on('click', '.save-btn', function(e) {
    var area_id, city_id, instance, name, slug, sort_order, type;
    $('#edit_location_modal .save-btn').prop('disabled', true);
    e.preventDefault();
    instance = $('#editlocationForm').parsley();
    if (!instance.validate()) {
      $('#edit_location_modal .save-btn').prop('disabled', false);
      return false;
    }
    city_id = $('#edit_location_modal .select_city select').val();
    area_id = $('#edit_location_modal input[name=area_id]').val();
    type = $('#edit_location_modal input[name=type]').val();
    name = $('#edit_location_modal input[name="name"]').val();
    slug = $('#edit_location_modal input[name="slug"]').val();
    sort_order = $('#edit_location_modal input[name="order"]').val();
    status = $('#edit_location_modal select[name="status"]').val();
    console.log(type, city_id, name, slug, sort_order, status, area_id);
    return $.ajax({
      type: 'post',
      url: '/save-location',
      data: {
        "type": type,
        "city_id": city_id,
        "name": name,
        "slug": slug,
        "sort_order": sort_order,
        "status": status,
        "area_id": area_id
      },
      success: function(serverData) {
        var data;
        if (serverData['status'] !== "200") {
          $('.alert-failure #message').html(serverData['msg']);
          $('.alert-failure').addClass('active');
          $('#add_category_modal .save-btn').prop('disabled', false);
          setTimeout((function() {
            $('.alert-failure').removeClass('active');
          }), 5000);
          $('#add_location_modal .save-btn').prop('disabled', false);
          return;
        }
        if (serverData['status'] === "200") {
          data = serverData['data'];
          loc_table.ajax.reload();
          updateCities();
          $('#edit_location_modal').modal('hide');
          $('.alert-success #message').html("Location edited successfully.");
          $('.alert-success').addClass('active');
          return setTimeout((function() {
            $('.alert-success').removeClass('active');
          }), 2000);
        }
      },
      error: function(request, status, error) {
        console.log(status);
        console.log(error);
        $('.alert-failure').addClass('active');
      }
    });
  });

  $('#edit_location_modal').on('change', 'select[name="status"]', function(e) {
    var id, new_status, type;
    $('#edit_location_modal .save-btn').prop('disabled', false);
    type = $('#edit_location_modal input[name=type]').val();
    if (type === "0") {
      id = $('#edit_location_modal .select_city select').val();
    } else {
      id = $('#edit_location_modal input[name=area_id]').val();
    }
    new_status = $(this).val();
    console.log(id, type, new_status);
    if (new_status === "1" || new_status === "2") {
      $.ajax({
        type: 'post',
        url: '/check-location-status',
        data: {
          'id': id,
          'type': type,
          'status': new_status
        },
        success: function(data) {
          if (data['data']['response'] === false) {
            alert(data['data']['message']);
            $('#edit_location_modal select[name="status"]').val(status);
          }
        }
      });
    }
  });

  resetFilters = function() {
    $('#datatable-locations th option:selected').each(function() {
      return $(this).prop('selected', false);
    });
    $('#locationNameSearch').val('');
    $('#locationNameSearch').keyup();
    $('#datatable-locations select').each(function() {
      return $(this).multiselect('refresh');
    });
    $('input[type="checkbox"]').each(function(index, value) {
      $(this).change();
    });
  };

  $('body').on('click', '#resetfilter', function() {
    resetFilters();
  });

  updateCities = function() {
    $.ajax({
      type: 'post',
      url: '/get-cities',
      success: function(data) {
        var dropdown, filter, i, selected;
        filter = "";
        dropdown = '<option value="">Select City</option>';
        i = 0;
        while (i < data.length) {
          filter += '<option>' + data[i]['name'] + '</option>';
          dropdown += '<option value="' + data[i]['id'] + '">' + data[i]['name'] + '</option>';
          i++;
        }
        selected = $('#filtercities').val();
        $('#filtercities').html(filter);
        $('select#allcities').each(function(index, item) {
          console.log(index);
          return $(item).html(dropdown);
        });
        $('#filtercities').multiselect('rebuild');
        $('#filtercities').multiselect('select', selected);
      }
    });
  };

}).call(this);
