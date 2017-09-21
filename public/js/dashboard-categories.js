(function() {
  var cat_table, editrow, resetFilters, saveCategory, status, updateCategories;

  resetFilters = function() {
    $('#datatable-categories th option:selected').each(function() {
      return $(this).prop('selected', false);
    });
    $('#catNameSearch').val('');
    $('#catNameSearch').keyup();
    $('#datatable-categories select').each(function() {
      return $(this).multiselect('refresh');
    });
    $('input[type="checkbox"]').each(function(index, value) {
      $(this).change();
    });
  };

  $('body').on('click', '#resetfilter', function() {
    resetFilters();
  });

  cat_table = $('#datatable-categories').DataTable({
    'pageLength': 25,
    'processing': true,
    'ajax': {
      'url': '/list-categories',
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
        'data': 'isParent'
      }, {
        'data': 'isBranch'
      }, {
        'data': 'isNode'
      }, {
        'data': 'parent'
      }, {
        'data': 'branch'
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
        'data': 'level'
      }, {
        'data': 'parent_id'
      }, {
        'data': 'branch_id'
      }, {
        'data': 'name_data'
      }
    ],
    'order': [[10, 'desc']],
    'columnDefs': [
      {
        'targets': 'no-sort',
        'orderable': false
      }, {
        'targets': [2, 12, 13, 14, 15, 16],
        'visible': false,
        'searchable': false
      }, {
        className: 'text-center',
        'targets': [0, 3, 4, 5, 8]
      }
    ]
  });

  cat_table.columns().iterator('column', function(ctx, idx) {
    $(cat_table.column(idx).header()).append('<span class="sort-icon"/>');
  });

  $('#catNameSearch').on('keyup', function() {
    cat_table.columns(1).search(this.value).draw();
  });

  $('#add_category_modal').on('show.bs.modal', function(e) {
    $('input#parent_cat[name="categoryType"]').prop('checked', true);
    $('input[name="categoryType"]').prop('disabled', false);
    $('input#parent_cat[name="categoryType"]').change();
    $('#add_category_modal .save-btn').prop('disabled', false);
  });

  $('body').on('change', 'input[type=radio][name=categoryType]', function() {
    if (this.value === '1') {
      $('.select-parent-cat, .select-branch-cat').addClass('hidden');
      $('.parent_cat_icon').removeClass('hidden');
      $('.select-parent-cat select').removeAttr('required');
      $('.select-branch-cat select').removeAttr('required');
      $('select[name="status"] option[value="1"]').attr("hidden", "hidden");
      $('select[name="status"] option[value="2"]').attr("hidden", "hidden");
      $('select[name="status"] option[value="0"]').prop("hidden", false);
      $('.namelabel').html("Parent");
    } else if (this.value === '2') {
      $('.select-parent-cat').removeClass('hidden');
      $('.select-branch-cat, .parent_cat_icon').addClass('hidden');
      $('.select-parent-cat select').attr('required', 'required');
      $('.select-branch-cat select').removeAttr('required');
      $('select[name="status"] option[value="1"]').attr("hidden", "hidden");
      $('select[name="status"] option[value="2"]').attr("hidden", "hidden");
      $('select[name="status"] option[value="0"]').prop("hidden", false);
      $('.namelabel').html("Branch");
    } else if (this.value === '3') {
      $('.select-parent-cat, .select-branch-cat').removeClass('hidden');
      $('.parent_cat_icon').addClass('hidden');
      $('.select-branch-cat select').attr('required', 'required');
      $('.select-parent-cat select').attr('required', 'required');
      $('select[name="status"] option[value="1"]').prop('hidden', false);
      $('select[name="status"] option[value="2"]').attr("hidden", "hidden");
      $('select[name="status"] option[value="0"]').prop("hidden", false);
      $('.namelabel').html("Node");
    }
    $('#add_category_modal select').val("");
    $('#add_category_modal input[type="text"]').val("");
    $('input[name="order"]').val('1');
  });

  $('body').on('change', '.select-parent-cat select', function() {
    var id;
    id = this.value;
    $('.select-branch-cat select').prop('disabled', true);
    return $.ajax({
      type: 'post',
      url: '/get-branches',
      data: {
        'id': id
      },
      success: function(data) {
        var html, key;
        if (data['status'] !== "200") {
          $('.alert-failure #message').html(data['msg']);
          $('.alert-failure').addClass('active');
          $('#add_category_modal .save-btn').prop('disabled', false);
          setTimeout((function() {
            $('.alert-failure').removeClass('active');
          }), 5000);
          return;
        }
        html = '<option value="">Select Branch</option>';
        for (key in data['data']) {
          html += '<option value="' + data['data'][key]['id'] + '">' + data['data'][key]['name'] + '</option>';
        }
        $('.select-branch-cat select').html(html);
        return $('.select-branch-cat select').prop('disabled', false);
      },
      async: false,
      error: function(request, status, error) {
        console.log(status);
        console.log(error);
        $('.alert-failure #message').html("An unknown error occured.<br>Please reload and try again.");
        $('.alert-failure').addClass('active');
      }
    });
  });

  $('#add_category_modal').on('click', '.save-btn', function(e) {
    var id, image_url, instance, level, name, parent_id, slug, sort_order, status;
    $('#add_category_modal .save-btn').prop('disabled', true);
    e.preventDefault();
    instance = $('#add_category_modal #categoryForm').parsley();
    if (!instance.validate()) {
      $('#add_category_modal .save-btn').prop('disabled', false);
      return false;
    }
    level = $('#add_category_modal input[type=radio][name=categoryType]:checked').val();
    id = "";
    if (level === "1") {
      parent_id = "";
    }
    if (level === "2") {
      parent_id = $('#add_category_modal .select-parent-cat select').val();
    }
    if (level === "3") {
      parent_id = $('#add_category_modal .select-branch-cat select').val();
    }
    name = $('#add_category_modal input[name="name"]').val();
    slug = $('#add_category_modal input[name="slug"]').val();
    sort_order = $('#add_category_modal input[name="order"]').val();
    status = $('#add_category_modal select[name="status"]').val();
    image_url = "https://freeiconshop.com/wp-content/uploads/edd/meat-solid.png";
    return $.ajax({
      type: 'post',
      url: '/save-category',
      data: {
        'level': level,
        'id': id,
        'parent_id': parent_id,
        'name': name,
        'slug': slug,
        'sort_order': sort_order,
        'status': status,
        'image_url': image_url
      },
      success: function(data) {
        console.log(data);
        if (saveCategory(level, data)) {
          $('.alert-success #message').html("Category added successfully.");
          return $('#add_category_modal').modal('hide');
        }
      },
      error: function(request, status, error) {
        console.log(status);
        console.log(error);
        $('.alert-failure #message').html("An unknown error occured.<br>Please reload and try again");
        $('.alert-failure').addClass('active');
      }
    });
  });

  saveCategory = function(level, data) {
    if (data['status'] !== "200") {
      $('.alert-failure #message').html(data['msg']);
      $('.alert-failure').addClass('active');
      $('.save-btn').prop('disabled', false);
      setTimeout((function() {
        $('.alert-failure').removeClass('active');
      }), 5000);
      return false;
    }
    cat_table.ajax.reload();
    if (level === "1") {
      updateCategories(level, data['data']['other_data']['parents']);
    }
    if (level === "2") {
      updateCategories(level, data['data']['other_data']['branches']);
    }
    $('.alert-success').addClass('active');
    setTimeout((function() {
      $('.alert-success').removeClass('active');
    }), 5000);
    return true;
  };

  updateCategories = function(level, data) {
    var dropdown, filter, i, selected;
    filter = "";
    if (level === "1") {
      dropdown = '<option value="">Select Parent</option>';
    }
    i = 0;
    while (i < data.length) {
      filter += '<option>' + data[i]['name'] + '</option>';
      dropdown += '<option value="' + data[i]['id'] + '">' + data[i]['name'] + '</option>';
      i++;
    }
    if (level === '1') {
      $('#allparents').html(dropdown);
      selected = $('#filterparents').val();
      $('#filterparents').html(filter);
      $('#filterparents').multiselect('rebuild');
      $('#filterparents').multiselect('select', selected);
    }
    if (level === '2') {
      selected = $('#filterbranches').val();
      $('#filterbranches').html(filter);
      $('#filterbranches').multiselect('rebuild');
      return $('#filterbranches').multiselect('select', selected);
    }
  };

  editrow = void 0;

  status = void 0;

  $('#datatable-categories').on('click', 'i.fa-pencil', function() {
    var cat;
    editrow = $(this).closest('td');
    cat = cat_table.row(editrow).data();
    $('input[name="categoryType"]').prop('checked', false);
    console.log(cat);
    if (cat['level'] === 1) {
      $('input#parent_cat[name="categoryType"]').prop('checked', true);
    }
    if (cat['level'] === 2) {
      $('input#branch_cat[name="categoryType"]').prop('checked', true);
      $('.select-parent-cat select').val(cat['parent_id']);
      $('.select-parent-cat select').change();
    }
    if (cat['level'] === 3) {
      $('input#node_cat[name="categoryType"]').prop('checked', true);
      $('.select-parent-cat select').val(cat['parent_id']);
      $('.select-parent-cat select').change();
      $('.select-branch-cat select').val(cat['branch_id']);
    }
    $('input[name="categoryType"]:checked').change();
    $('input[name="categoryType"]').prop('disabled', true);
    $('#edit_category_modal input[name="slug"]').prop('disabled', true);
    $('.select-parent-cat select').prop('disabled', true);
    $('.select-branch-cat select').prop('disabled', true);
    if (cat['status'] === 'Draft') {
      $('select[name="status"] option[value="1"]').prop('hidden', false);
      $('select[name="status"] option[value="2"]').attr("hidden", "hidden");
      $('select[name="status"] option[value="0"]').prop("hidden", false);
      $('select[name="status"]').val('0');
      $('#edit_category_modal input[name="slug"]').prop('disabled', false);
      $('.select-parent-cat select').prop('disabled', false);
      $('.select-branch-cat select').prop('disabled', false);
      status = 0;
    }
    if (cat['status'] === 'Published') {
      $('select[name="status"] option[value="1"]').prop('hidden', false);
      $('select[name="status"] option[value="2"]').prop("hidden", false);
      $('select[name="status"] option[value="0"]').attr("hidden", "hidden");
      $('select[name="status"]').val('1');
      status = 1;
    }
    if (cat['status'] === 'Archived') {
      $('select[name="status"] option[value="1"]').prop('hidden', false);
      $('select[name="status"] option[value="2"]').prop("hidden", false);
      $('select[name="status"] option[value="0"]').attr("hidden", "hidden");
      $('select[name="status"]').val('2');
      status = 2;
    }
    $('#edit_category_modal input[name="level"]').val(cat['level']);
    $('#edit_category_modal input[name="id"]').val(cat['id']);
    $('#edit_category_modal input[name="name"]').val(cat['name_data']);
    $('#edit_category_modal input[name="slug"]').val(cat['slug']);
    $('#edit_category_modal input[name="order"]').val(cat['sort_order']);
    $('#edit_category_modal .save-btn').prop('disabled', false);
    return $('#edit_category_modal').modal('show');
  });

  status = void 0;

  $('#edit_category_modal').on('change', 'select[name="status"]', function(e) {
    var id, new_status;
    $('#edit_category_modal .save-btn').prop('disabled', true);
    id = $('#edit_category_modal input[name="id"]').val();
    new_status = $(this).val();
    $.ajax({
      type: 'post',
      url: '/check-category-status',
      data: {
        "id": id,
        "status": new_status
      },
      success: function(data) {
        console.log(data);
        if (data['data']['continue'] === true) {
          return $('#edit_category_modal .save-btn').prop('disabled', false);
        } else {
          if (new_status === "1") {
            alert(data['data']['message']);
            $('#edit_category_modal select[name="status"]').val(status);
            $('#edit_category_modal .save-btn').prop('disabled', false);
          }
          if (new_status === "2") {
            if (data['status'] === '405') {
              alert(data['data']['message']);
              $('#edit_category_modal select[name="status"]').val(status);
              return $('#edit_category_modal .save-btn').prop('disabled', false);
            } else {
              if (!confirm(data['data']['message'])) {
                $('#edit_category_modal select[name="status"]').val(status);
                return $('#edit_category_modal .save-btn').prop('disabled', false);
              } else {
                return $('#edit_category_modal .save-btn').prop('disabled', false);
              }
            }
          }
        }
      }
    });
  });

  $('#edit_category_modal').on('click', '.save-btn', function(e) {
    var id, image_url, instance, level, name, parent_id, slug, sort_order;
    $('#edit_category_modal .save-btn').prop('disabled', true);
    e.preventDefault();
    instance = $('#edit_category_modal #categoryForm').parsley();
    console.log(instance.validate());
    if (!instance.validate()) {
      console.log("shit");
      $('#edit_category_modal .save-btn').prop('disabled', false);
      return false;
    }
    level = $('#edit_category_modal input[type=radio][name=categoryType]:checked').val();
    id = $('#edit_category_modal input[name="id"]').val();
    if (level === "1") {
      parent_id = "";
    }
    if (level === "2") {
      parent_id = $('#edit_category_modal .select-parent-cat select').val();
    }
    if (level === "3") {
      parent_id = $('#edit_category_modal .select-branch-cat select').val();
    }
    name = $('#edit_category_modal input[name="name"]').val();
    slug = $('#edit_category_modal input[name="slug"]').val();
    sort_order = $('#edit_category_modal input[name="order"]').val();
    status = $('#edit_category_modal select[name="status"]').val();
    image_url = "https://freeiconshop.com/wp-content/uploads/edd/meat-solid.png";
    return $.ajax({
      type: 'post',
      url: '/save-category',
      data: {
        'level': level,
        'id': id,
        'parent_id': parent_id,
        'name': name,
        'slug': slug,
        'sort_order': sort_order,
        'status': status,
        'image_url': image_url
      },
      success: function(data) {
        console.log(data);
        if (saveCategory(level, data)) {
          $('.alert-success #message').html("Category edited successfully.");
          return $('#edit_category_modal').modal('hide');
        }
      },
      error: function(request, status, error) {
        console.log(status);
        console.log(error);
        $('.alert-failure #message').html("An unknown error occured.<br>Please reload and try again");
        $('.alert-failure').addClass('active');
      }
    });
  });

}).call(this);
