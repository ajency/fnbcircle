(function() {
  var filters_array, getColumns, getFiltersForListInternalUsers, get_filters, get_page_no_n_entry_no, get_sort_order, requestData;

  filters_array = ['roles', 'status'];

  getColumns = function() {
    var columns;
    return columns = [
      {
        data: "edit"
      }, {
        data: "name"
      }, {
        data: "email"
      }, {
        data: "role"
      }, {
        data: "status"
      }
    ];
  };

  getFiltersForListInternalUsers = function() {
    var columns_replacement, filters, filters_param_url, length, sort_value, start;
    filters = {
      user_type: "internal"
    };
    filters_param_url = '';
    sort_value = $('#datatable-internal-users').dataTable().fnSettings().aaSorting;
    if (sort_value.length > 0 && sort_value[0].length > 0) {
      if (sort_value[0][1] === 'desc') {
        filters['orderBy'] = "-";
      } else {
        filters['orderBy'] = "";
      }
      columns_replacement = {
        'who_meta': 'who_id',
        'whom_meta': 'whom_id'
      };
      if (sort_value[0][0]) {
        filters['orderBy'] = filters['orderBy'] + getColumns()[sort_value[0][0]].data;
      }
    }
    start = $('#datatable-internal-users').dataTable().fnSettings()._iDisplayStart;
    length = $('#datatable-internal-users').dataTable().fnSettings()._iDisplayLength;

    /* -- Set the page No & the No of Entries in the URL -- */

    /* -- Get the start point -- */
    filters['start'] = start;

    /* -- Get the length / no of rows -- */
    filters['length'] = length;
    return filters;
  };

  get_filters = function() {

    /* --- This function will read the 'Search Params' from URL & apply values to the Filter --- */
    jQuery.each(filters_array, function(index, name_value) {

      /* --- Check if the filter was selected by checking the URL --- */
      var filter_value_array;
      if (window.location.search.split(name_value + '=')[1]) {

        /* --- If the filter was selected, then update by selecting the Filters before making the DataTable AJAX call --- */
        filter_value_array = decodeURIComponent(window.location.search.split(name_value + '=')[1].split('&')[0]);
        filter_value_array = JSON.parse(filter_value_array);
        jQuery.each(filter_value_array, function(index, value) {

          /* --- Select all the values that were selected in the Filter & updated in the URL --- */
          $('input:checkbox[name="' + name_value + '"][value="' + value + '"]').attr('checked', 'true');
        });
      }
    });
  };

  get_page_no_n_entry_no = function() {

    /* --- This function will get the 'Page No' & the 'No of Entries on a page' from URL --- */
    var length, start;
    length = window.location.search.split('entry_no=')[1] ? parseInt(window.location.search.split('entry_no=')[1].split('&')[0]) : 25;
    start = window.location.search.split('page=')[1] ? (parseInt(window.location.search.split('page=')[1].split('&')[0]) - 1) * length : 0;
    return [start, length];
  };

  get_sort_order = function() {

    /* --- This function will get the 'Sort Order' from URL --- */
    var display_column, display_order, key_column;
    if (window.location.search.indexOf('order_by=') > -1) {

      /* --- Checks if the order of display is ascending or descending --- */
      display_order = window.location.search.split('order_by=')[1][0] === '-' ? 'desc' : 'asc';
      key_column = window.location.search.split('order_by=')[1];
      key_column = display_order === 'desc' ? key_column.substring(1, key_column.length) : key_column;
      display_column = 0;
      getColumns().find(function(item, i) {
        if (item.data === key_column) {
          display_column = i;
          return i;
        }
      });
    } else {
      display_order = 'desc';
      display_column = 2;
    }
    return [display_column, display_order];
  };

  requestData = function(table_id) {
    var hash_url, internal_user_table;
    $.fn.dataTable.ext.errMode = 'none';
    $.extend($.fn.dataTable.defaults, {
      destroy: true,
      scrollY: 620,
      scrollX: true,
      scrollCollapse: true,
      searching: true,
      ordering: true,
      pagingType: 'simple',
      iDisplayStart: get_page_no_n_entry_no()[0],
      iDisplayLength: get_page_no_n_entry_no()[1],
      dom: 'Blfrtip',
      buttons: []
    });
    if (window.location.hash !== '' && window.location.hash !== '#') {
      hash_url = window.location.hash;
    }
    internal_user_table = $("#" + table_id).DataTable({
      'processing': true,
      'iDisplayLength': 25,
      'columns': getColumns(),
      'aoColumns': [
        {
          mData: "edit",
          sWidth: "5%",
          bSearchable: false,
          bSortable: false,
          bVisible: true
        }, {
          mData: "name",
          sWidth: "20%",
          className: "sorting_1",
          bSearchable: true,
          bSortable: true
        }, {
          mData: "email",
          sWidth: "20%",
          className: "text-center",
          bSearchable: false,
          bSortable: true
        }, {
          mData: "roles",
          sWidth: "30%",
          className: "text-center",
          bSearchable: false,
          bSortable: false
        }, {
          mData: "status",
          sWidth: "20%",
          className: "text-center",
          bSearchable: false,
          bSortable: false
        }
      ],
      'bSort': true,
      'order': [get_sort_order()],
      'ajax': {
        url: '/admin-dashboard/users/get-users',
        type: 'post',
        dataSrc: "data",
        dataType: "json",
        data: function(d) {
          d.filters = getFiltersForListInternalUsers();
        },
        error: function(e) {
          console.log("error");
          console.log(e.status);
          $('#' + table_id).append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
        }
      },
      'fnDrawCallback': function(oSettings) {

        /* --- Search box --- */
        $(".admin_internal_users #datatable-internal-users_filter label").html($(".admin_internal_users #datatable-internal-users_filter label input[type='search']").prop('outerHTML'));
        $(".admin_internal_users #datatable-internal-users_filter label input[type='search']").prop("placeholder", "Search by Name");
        $(".admin_internal_users #datatable-internal-users_filter label input[type='search']").addClass("fnb-input");
      }
    });
  };

  $(document).ready(function() {
    requestData("datatable-internal-users");
    $("#add_newuser_modal #add_newuser_modal_btn").on('click', function() {
      var data, form_obj, form_status, url_type;
      form_obj = $("#add_newuser_modal #add_newuser_modal_form");
      form_status = form_obj.parsley().validate();
      data = {
        user_type: "internal",
        name: form_obj.find('input[type="text"][name="name"]').val(),
        email: form_obj.find('input[type="email"][name="email"]').val(),
        roles: form_obj.find('select[name="role"]').val().length ? form_obj.find('select[name="role"]').val() : [],
        status: form_obj.find('select[name="status"]').val(),
        password: form_obj.find('input[type="password"][name="password"]').prop('disabled') ? '' : form_obj.find('input[type="password"][name="password"]').val(),
        confirm_password: form_obj.find('input[type="password"][name="confirm_password"]').prop('disabled') ? '' : form_obj.find('input[type="password"][name="confirm_password"]').val()
      };
      url_type = form_obj.find("input[type='hidden'][name='form_type']").val();
      if (form_status) {
        $(this).find(".fa-circle-o-notch.fa-spin").removeClass("hidden");
        $.ajax({
          type: 'post',
          url: '/admin-dashboard/users/' + (url_type === "add" ? "add" : form_obj.find("input[type='hidden'][name='user_id']").val()),
          data: data,
          dataType: 'json',
          success: function(data) {
            var table;
            console.log(data);
            $("#add_newuser_modal #add_newuser_modal_btn").find(".fa-circle-o-notch.fa-spin").addClass("hidden");
            $("#add_newuser_modal").modal("hide");

            /* --- Reload the DataTable --- */
            table = $("#datatable-internal-users").DataTable();
            return table.ajax.reload();
          },
          error: function(request, status, error) {
            $(this).find(".fa-circle-o-notch.fa-spin").addClass("hidden");
            throw Error();
          }
        });
      } else {
        $(this).find(".fa-circle-o-notch.fa-spin").addClass("hidden");
        console.log("Not saved");
      }
    });
    $(document).on("click", "#datatable-internal-users .editUser", function() {

      /* --- On click of Edit User (pencil Icon) -> On modal open --- */
      var modal_object, row;
      row = $(this).closest('tr');
      modal_object = $("#add_newuser_modal");
      modal_object.find("input[type='hidden'][name='form_type']").val("edit");
      modal_object.find("input[type='hidden'][name='user_id']").val($(this).prop('id'));
      modal_object.find("input[type='password'][name='password']").attr("disabled", "true");
      modal_object.find("input[type='password'][name='confirm_password']").attr("disabled", "true");
      modal_object.find("input[type='text'][name='name']").val(row.find('td:eq(1)').text());
      modal_object.find("input[type='email'][name='email']").val(row.find('td:eq(2)').text());

      /* --- Select the user's Role --- */
      modal_object.find('select.form-control.multiSelect').multiselect('select', [row.find('td:eq(3)').text().toLowerCase()]);
      modal_object.find('select.form-control.multiSelect').multiselect('updateButtonText', true);
    });
    $(document).on("click", "div.admin_internal_users div.page-title button.btn-link", function() {

      /* --- On click of Add New User -> On modal open --- */
      var modal_object;
      modal_object = $("#add_newuser_modal");
      modal_object.find("input[type='hidden'][name='form_type']").val("add");
      modal_object.find("input[type='hidden'][name='user_id']").val("");
      modal_object.find("input[type='password'][name='password']").removeAttr("disabled");
      modal_object.find("input[type='password'][name='confirm_password']").removeAttr("disabled");
      modal_object.find("input[type='text'][name='name']").val('');
      modal_object.find("input[type='email'][name='email']").val('');

      /* --- Deselect All the options --- */
      modal_object.find('select.form-control.multiSelect').multiselect('deselectAll', false);

      /* --- Update the text --- */
      modal_object.find('select.form-control.multiSelect').multiselect('updateButtonText', true);
    });
  });

}).call(this);
