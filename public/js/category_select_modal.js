(function() {
  var getBranchNodeCategories, getNodeCategories, getPreviouslyAvailableCategories;

  getBranchNodeCategories = function(path, parent_id) {
    var html;
    html = '';
    $.ajax({
      type: 'post',
      url: '/api/get_listing_categories',
      data: {
        'category_id': [parent_id]
      },
      success: function(data) {
        var key;
        key = void 0;
        $(path).html(data["modal_template"]);
      },
      error: function(request, status, error) {
        throw Error();
      }
    });
  };

  getNodeCategories = function(path, parent_id, checked_values) {
    var html;
    html = '';
    if (checked_values.length <= 0) {
      $.each($(path + " input[type='checkbox']:checked"), function() {
        checked_values.push($(this).val());
      });
    }
    console.log(checked_values);
    $.ajax({
      type: 'post',
      url: '/api/get_node_listing_categories',
      data: {
        'branch': [parent_id]
      },
      success: function(data) {
        var html_upload, index, key, node_children;
        key = void 0;

        /* --- The HTML skeleton is defined under a <div id="node-skeleton"> --- */
        node_children = data["data"][0]["children"];
        $(path + "div#" + data["data"][0]["id"]);
        if (node_children.length > 0) {
          index = 0;
          html_upload = "<ul class=\"nodes\">";
          while (index < node_children.length) {
            html_upload += "<li><label class=\"flex-row\">";
            if (checked_values.length > 0 && $.inArray(node_children[index]['slug'], checked_values) !== -1) {
              html_upload += "<input type=\"checkbox\" class=\"checkbox\" for=\"" + node_children[index]['slug'] + "\" value=\"" + node_children[index]['slug'] + "\" checked=\"checked\">";
            } else {
              html_upload += "<input type=\"checkbox\" class=\"checkbox\" for=\"" + node_children[index]['slug'] + "\" value=\"" + node_children[index]['slug'] + "\">";
            }
            html_upload += "<p class=\"lighter nodes__text\" id=\"" + node_children[index]['slug'] + "\">" + node_children[index]['name'] + "</p>";
            html_upload += "</label></li>";
            index++;
          }
          html_upload += "</ul>";
        } else {
          html_upload = "Sorry! No Categories found under <b>" + data["data"][0]["name"] + "</b>.";
        }
        $(path + "div#" + data["data"][0]["id"]).html(html_upload);
      },
      error: function(request, status, error) {
        throw Error();
      }
    });
  };

  getPreviouslyAvailableCategories = function() {
    var error, error1, get_core_cat_checked;
    get_core_cat_checked = [];
    try {
      if ($("#category-select #previously_available_categories").val().length > 1 && JSON.parse($("#category-select #previously_available_categories").val()).length > 0) {
        get_core_cat_checked = JSON.parse($("#category-select #previously_available_categories").val());
      }
    } catch (error1) {
      error = error1;
      console.log("Sorry, met with a JSON.parse error for #previously_available_categories. Please pass it as Array & Stringify it.");
    }
    return get_core_cat_checked;
  };

  $(document).ready(function() {

    /* --- On Category Modal Shown --- */
    $(document).on("shown.bs.modal", "#category-select", function(event) {
      $("#category-select #level-two-category").addClass("hidden");
      $("#category-select #level-one-category").removeClass("hidden");
      $("#category-select #level-one-category input[type='radio']").prop("checked", false);
    });

    /* --- On Ca --- */
    $(document).on("click", "#category-select #level-one-category input[name='categories']", function() {
      $("#category-select #level-two-category").addClass("hidden");
      $("#category-select #level-one-category").removeClass("hidden");
    });

    /* --- On click of "Back to Categories", display "Category-One" & hide "Category-Two" --- */
    $(document).on("click", "#category-select #back_to_categories", function() {
      $("#category-select #level-two-category").addClass("hidden");
      $("#category-select #level-one-category").removeClass("hidden");
    });

    /* --- On click of 'x', hide / close the Modal --- */
    $(document).on("click", "#category-select #category-select-close", function() {
      $(this).closest("div#category-select").modal('hide');
    });

    /* --- On change of "Select Categories", Disable the Radio option with the "Same VALUE" --- */
    $(document).on("change", "#category-select #level-one-category input[name='select-categories']", function() {
      if ($(this).prop('checked')) {
        $("#category-select #level-one-category input[type='radio'][value='" + $(this).val() + "']").attr('disabled', 'true');
      } else {
        $("#category-select #level-one-category input[type='radio'][value='" + $(this).val() + "']").removeAttr('disabled');
      }
    });

    /* --- On change / select of Radio Option, Get the Category LEvel 2 DOM, & Hide Level 1 & display Level 2  --- */
    $(document).on("change", "#category-select #level-one-category input[type='radio'][name='parent-categories']", function() {
      var get_core_cat_checked;
      getBranchNodeCategories("#category-select #level-two-category-dom", $(this).val());
      $(this).closest("div#level-one-category").addClass("hidden");
      get_core_cat_checked = [];
      get_core_cat_checked = getPreviouslyAvailableCategories();
      setTimeout((function() {
        getNodeCategories("#category-select #level-two-category ", $("#category-select #level-two-category #branch_categories li.active").find('a').attr("aria-controls"), get_core_cat_checked);
      }), 200);
    });

    /* --- On click of Branch Categories, Get it's children --- */
    $(document).on("click", "#category-select #level-two-category ul#branch_categories li", function() {
      getNodeCategories("#category-select #level-two-category ", $(this).find('a').attr("aria-controls"), []);
    });

    /* --- On Click of "Add Selected", add those Checked values & close the Popup --- */
    $(document).on("click", "#category-select #level-two-category button#category-select-btn", function() {
      var checked_categories, main_page_categories;
      checked_categories = [];
      main_page_categories = [];
      main_page_categories = getPreviouslyAvailableCategories();
      $.each($("#category-select #level-two-category  #cat-dataHolder input[type='checkbox']:checked"), function() {
        checked_categories.push({
          "slug": $(this).val(),
          "name": $(this).parent().find('p#' + $(this).val()).text()
        });
      });
      if ($(document).find("input[type='hidden']#modal_categories_chosen").length > 0) {
        $(document).find("input[type='hidden']#modal_categories_chosen").val(JSON.stringify(checked_categories));
      }
      $("#category-select").modal("hide");
    });
  });

}).call(this);
