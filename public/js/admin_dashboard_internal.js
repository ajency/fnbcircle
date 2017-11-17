(function() {
  var filters_array, getColumns, getFiltersForListInternalUsers, get_filters, get_page_no_n_entry_no, get_sort_order, init_Multiselect, requestData, validatePassword;

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

  validatePassword = function(password, confirm_password, parent_path, child_path) {
    var expression, message, status;
    if (confirm_password == null) {
      confirm_password = '';
    }
    if (parent_path == null) {
      parent_path = '';
    }
    if (child_path == null) {
      child_path = "#password_errors";
    }
    expression = /^(?=.*[0-9!@#$%^&*])(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z])(?!.*\s).{8,}$/;
    message = '';
    status = true;
    if (expression.test(password)) {
      if (confirm_password !== '' && confirm_password === password) {
        status = true;
      } else if (confirm_password === '') {
        status = true;
      } else {
        message = "Password & Confirm Password are not matching";
        status = false;
      }
    } else {
      message = "Please enter a password of minimum 8 characters and has atleast 1 lowercase, 1 UPPERCASE, and 1 Number or Special character";
      status = false;
    }
    if (!status && parent_path !== '') {
      $(parent_path + " " + child_path).removeClass('hidden').text(message);
    } else if (status && parent_path !== '') {
      $(parent_path + " " + child_path).addClass('hidden');
    }
    return status;
  };

  requestData = function(table_id) {
    var hash_url, internal_user_table;
    $.fn.dataTable.ext.errMode = 'none';
    $.extend($.fn.dataTable.defaults, {
      iDisplayStart: get_page_no_n_entry_no()[0],
      iDisplayLength: get_page_no_n_entry_no()[1]
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
          bSearchable: true,
          bSortable: false
        }, {
          mData: "status",
          sWidth: "20%",
          className: "text-center",
          bSearchable: true,
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
        var div, i;
        div = $("#datatable-internal-users_filter label")[0];
        if (div.childNodes.length) {
          i = 0;
          while (i < div.childNodes.length) {
            if (div.childNodes[i].nodeType === 3) {
              div.removeChild(div.childNodes[i]);
            }
            i++;
          }
        }
        $(".admin_internal_users #datatable-internal-users_filter label input[type='search']").prop("placeholder", "Search by Name");
        $(".admin_internal_users #datatable-internal-users_filter label input[type='search']").addClass("fnb-input");
      }
    });
    return internal_user_table;
  };

  init_Multiselect = function() {
    $('.multi-ddd').multiselect({
      maxHeight: 200,
      templates: {
        button: '<span class="multiselect dropdown-toggle" data-toggle="dropdown"><i class="fa fa-filter"></i></span>'
      },
      includeSelectAllOption: true,
      numberDisplayed: 5,
      onChange: function(element, checked) {
        var categories, col, search, selected;
        categories = $(this)[0]['$select'].find('option:selected');
        selected = [];
        $(categories).each(function(index, city) {
          selected.push('^' + $(this).val() + "$");
        });
        search = selected.join('|');
        col = $(this)[0]['$select'].closest('th').data('col');
        $('#datatable-internal-users').DataTable().column(col).search(search, true, false).draw();
      }
    });
  };

  $(document).ready(function() {

    /* --- Initialize the Table for 1st time, as the filters will be on Client-Side --- */
    var table;
    table = requestData("datatable-internal-users");
    init_Multiselect();
    $("#add_newuser_modal #add_newuser_modal_form input[type='email'][name='email']").on('keyup change', function() {
      var form_obj;
      form_obj = $("#add_newuser_modal #add_newuser_modal_form");
      form_obj.find('p#email-error').addClass("hidden").text("");
    });
    $("#add_newuser_modal #add_newuser_modal_form input[type='password'][name='password']").on('keyup change', function() {
      validatePassword($(this).val(), '', '#add_newuser_modal #add_newuser_modal_form', '#password-error');
    });
    $("#add_newuser_modal #add_newuser_modal_btn").on('click', function() {
      var data, form_obj, form_status, url_type;
      form_obj = $("#add_newuser_modal #add_newuser_modal_form");
      form_status = form_obj.parsley().validate();
      if (!form_obj.find('input[type="password"][name="password"]').prop('disabled')) {
        form_status = validatePassword(form_obj.find('input[type="password"][name="password"]').val()) ? form_status : false;
      }
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
            console.log(data);
            $("#add_newuser_modal #add_newuser_modal_btn").find(".fa-circle-o-notch.fa-spin").addClass("hidden");
            $("#add_newuser_modal").modal("hide");
            if (url_type === "add") {
              $(".admin_internal_users.right_col").parent().find('div.alert-success #message').text("Successfully created new User");
            } else {
              $(".admin_internal_users.right_col").parent().find('div.alert-success #message').text("User updated successfully");
            }
            setTimeout((function() {
              $(".admin_internal_users.right_col").parent().find('div.alert-success').addClass('active');
            }), 1000);
            setTimeout((function() {
              $(".admin_internal_users.right_col").parent().find('div.alert-success').removeClass('active');
            }), 6000);

            /* --- Reload the DataTable --- */
            return table.ajax.reload();
          },
          error: function(request, status, error) {
            var error_message;
            if (request.status === 406) {
              form_obj.find('p#email-error').removeClass("hidden").text("This Email ID already exist");
              error_message = JSON.parse(request.responseText);
              error_message = error_message.hasOwnProperty("message") ? error_message["message"] : "";
              if (error_message === "email_exist") {
                $(".admin_internal_users.right_col").parent().find('div.alert-failure #message').text("This Email ID already exist");
              } else if (error_message === "password_and_confirm_not_matching") {
                $(".admin_internal_users.right_col").parent().find('div.alert-failure #message').text("Password & Confirm password are not matchin");
              } else {
                $(".admin_internal_users.right_col").parent().find('div.alert-failure #message').text("Sorry! Seems like we met with some error");
              }
            } else {
              $(".admin_internal_users.right_col").parent().find('div.alert-failure #message').text("Sorry! Seems like we met with some error");
            }
            setTimeout((function() {
              $(".admin_internal_users.right_col").parent().find('div.alert-failure').addClass('active');
            }), 1000);
            setTimeout((function() {
              $(".admin_internal_users.right_col").parent().find('div.alert-failure').removeClass('active');
            }), 6000);
            return form_obj.find("button .fa-circle-o-notch.fa-spin").addClass("hidden");
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

      /* --- Reset the Parsley error messages --- */
      modal_object.find("#add_newuser_modal_form").parsley().reset();

      /* --- Update the Modal Title --- */
      modal_object.find("#add_newuser_modal_form .modal-header h6.modal-title").text("Edit Internal User");
      modal_object.find("input[type='hidden'][name='form_type']").val("edit");
      modal_object.find("input[type='hidden'][name='user_id']").val($(this).prop('id'));

      /* --- Password --- */
      modal_object.find("input[type='password'][name='password']").attr("disabled", "true");
      modal_object.find("input[type='password'][name='password']").removeAttr("required");
      modal_object.find("input[type='password'][name='password']").closest('div.col-sm-6').addClass('hidden');

      /* --- Confirm Password --- */
      modal_object.find("input[type='password'][name='confirm_password']").attr("disabled", "true");
      modal_object.find("input[type='password'][name='confirm_password']").removeAttr("required");
      modal_object.find("input[type='password'][name='confirm_password']").closest('div.col-sm-6').addClass('hidden');
      modal_object.find("input[type='text'][name='name']").val(row.find('td:eq(1)').text());
      modal_object.find("input[type='email'][name='email']").val(row.find('td:eq(2)').text()).attr("disabled", "true");

      /* --- Select the user's Role --- */
      modal_object.find('select.form-control.multiSelect').multiselect('select', [row.find('td:eq(3)').text().toLowerCase()]);
      modal_object.find('select.form-control.multiSelect').multiselect('updateButtonText', true);
      console.log(row.find('td:eq(4)').text().toLowerCase());
      modal_object.find('select.form-control.status-select').val(row.find('td:eq(4)').text().toLowerCase());
      modal_object.find('.createSave').addClass('hidden');
      modal_object.find('.editSave').removeClass('hidden');
    });
    $(document).on("click", "div.admin_internal_users div.page-title button.btn-link", function() {

      /* --- On click of Add New User -> On modal open --- */
      var modal_object;
      modal_object = $("#add_newuser_modal");

      /* --- Reset the Parsley error messages --- */
      modal_object.find("#add_newuser_modal_form").parsley().reset();

      /* --- Update the Modal Title --- */
      modal_object.find("#add_newuser_modal_form .modal-header h6.modal-title").text("Add New Internal User");
      modal_object.find("input[type='hidden'][name='form_type']").val("add");
      modal_object.find("input[type='hidden'][name='user_id']").val("");

      /* --- Clear the Name & Email textbox & enable the Email textbox --- */
      modal_object.find("input[type='text'][name='name']").val('');
      modal_object.find("input[type='email'][name='email']").val('').removeAttr("disabled");

      /* --- Deselect All the options --- */
      modal_object.find('select.form-control.multiSelect').multiselect('deselectAll', false);

      /* --- Update the text --- */
      modal_object.find('select.form-control.multiSelect').multiselect('updateButtonText', true);

      /* --- Unselect the Status --- */
      modal_object.find("select[name='status'] option:selected").prop("selected", false);

      /* --- Enable the Password option --- */
      modal_object.find("input[type='password'][name='password']").removeAttr("disabled");
      modal_object.find("input[type='password'][name='password']").attr("required", "true").val('');
      modal_object.find("input[type='password'][name='password']").closest('div.col-sm-6').removeClass('hidden');

      /* --- Enable the Confirm-Password option --- */
      modal_object.find("input[type='password'][name='confirm_password']").removeAttr("disabled");
      modal_object.find("input[type='password'][name='confirm_password']").attr("required", "true").val('');
      modal_object.find("input[type='password'][name='confirm_password']").closest('div.col-sm-6').removeClass('hidden');
      modal_object.find('.createSave').removeClass('hidden');
      modal_object.find('.editSave').addClass('hidden');
    });
  });

}).call(this);
