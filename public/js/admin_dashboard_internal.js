(function() {
  var getColumns, getFiltersForListInternalUsers, requestData;

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
    var columns_replacement, filters, filters_param_url, length, page_param_url, sort_value, start;
    filters = {};
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
    page_param_url = '?page=' + (parseInt(start / length) + 1) + '&entry_no=' + length + filters_param_url + '&order_by=' + filters['orderBy'];
    window.history.pushState('', '', page_param_url);

    /* -- Get the start point -- */
    filters['start'] = start;

    /* -- Get the length / no of rows -- */
    filters['length'] = length;
    return filters;
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
      iDisplayStart: $('#datatable-internal-users').dataTable().fnSettings()._iDisplayStart,
      iDisplayLength: $('#datatable-internal-users').dataTable().fnSettings()._iDisplayLength,
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
      'order': [[2, "desc"]],
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
      var data, form_obj, url_type;
      form_obj = $("#add_newuser_modal #add_newuser_modal_form");
      data = {
        name: form_obj.find('input[type="text"][name="name"]').val(),
        email: form_obj.find('input[type="email"][name="email"]').val(),
        roles: form_obj.find('select[name="role"]').val().length ? form_obj.find('select[name="role"]').val() : [],
        status: form_obj.find('select[name="status"]').val(),
        password: form_obj.find('input[type="password"][name="password"]').prop('disabled') ? '' : form_obj.find('input[type="password"][name="password"]').val(),
        confirm_password: form_obj.find('input[type="password"][name="confirm_password"]').prop('disabled') ? '' : form_obj.find('input[type="password"][name="confirm_password"]').val()
      };
      url_type = form_obj.find("input[type='hidden'][name='form_type']").val();
      if (1) {
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
    });
  });

}).call(this);
