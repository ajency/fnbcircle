(function() {
  var change_view, getBranchNodeCategories, getCategoryDom, getNodeCategories, getPreviouslyAvailableCategories;

  getBranchNodeCategories = function(path, parent_id) {
    var html;
    html = '';
    $.ajax({
      type: 'post',
      url: '/api/get_listing_categories',
      data: {
        'category': [parent_id]
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

  getNodeCategories = function(path, parent_id, checked_values, is_all_checked) {
    var html;
    html = '';
    if (checked_values.length <= 0) {
      $.each($(path + " input[type='checkbox']:checked"), function() {
        checked_values.push($(this).val());
      });
    }
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
            if (is_all_checked) {
              html_upload += "<input type=\"checkbox\" class=\"checkbox\" for=\"" + node_children[index]['id'] + "\" value=\"" + node_children[index]['id'] + "\" checked=\"checked\">";
            } else {
              if (checked_values.length > 0 && $.inArray(node_children[index]['id'].toString(), checked_values) !== -1) {
                html_upload += "<input type=\"checkbox\" class=\"checkbox\" for=\"" + node_children[index]['id'] + "\" value=\"" + node_children[index]['id'] + "\" checked=\"checked\">";
              } else {
                html_upload += "<input type=\"checkbox\" class=\"checkbox\" for=\"" + node_children[index]['id'] + "\" value=\"" + node_children[index]['id'] + "\">";
              }
            }
            html_upload += "<input type=\"hidden\" name=\"hierarchy\" id=\"hierarchy\" value='" + JSON.stringify(node_children[index]["hierarchy"]) + "'>";
            html_upload += "<p class=\"lighter nodes__text\" id=\"" + node_children[index]['id'] + "\">" + node_children[index]['name'] + "</p>";
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
    var error, get_core_cat_checked;
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

  getCategoryDom = function(path, level) {
    $.ajax({
      type: 'post',
      url: '/api/get_categories_modal_dom',
      data: {
        'level': level
      },
      success: function(data) {
        $(path).html(data["modal_template"]);
      },
      error: function(request, status, error) {
        throw Error();
      }
    });
  };

  change_view = function() {
    if ($('div#categories.node-list').children().length === 0) {
      $('#categ-selected').addClass('hidden');
      $('div.core-cat-cont').addClass('hidden');
      return $('#no-categ-select').removeClass('hidden');
    } else {
      $('#categ-selected').removeClass('hidden');
      $('div.core-cat-cont').removeClass('hidden');
      return $('#no-categ-select').addClass('hidden');
    }
  };

  $(document).ready(function() {
    getCategoryDom("#category-select #level-one-category-dom", "level_1");
    $('body').on('click', '#category-select .sub-category-back', function() {
      $('.main-category').removeClass('hidden');
      return $('.sub-category').removeClass('shown');
    });
    $('body').on('click', '#category-select .category-back', function() {
      $('.main-category').removeClass('hidden');
      $('.sub-category').removeClass('shown');
      $('.desk-level-two').addClass('hidden');
      $('.firstStep').removeClass('hidden');
      return $('.interested-options .radio').prop('checked', false);
    });
    $('#category-select .topSelect').click(function() {
      return setTimeout((function() {
        $('#category-select .category-back').addClass('hidden');
      }), 100);
    });
    $('#category-select .catSelect-click').click(function() {
      return $('.category-back').removeClass('hidden');
    });
    $('#category-select').on('hidden.bs.modal', function(e) {
      $('.interested-options .radio').prop('checked', false);
    });
    if ($(window).width() < 768) {
      $('.topSelect').click(function() {
        return setTimeout((function() {
          $('.category-back').addClass('hidden');
          $('.cat-cancel').addClass('hidden');
          $('.mobileCat-back').removeClass('hidden');
        }), 100);
      });
    }
    if ($(window).width() <= 768) {
      $('.single-category').each(function() {
        var branchAdd, branchrow;
        branchAdd = $(this).find('.branch-row');
        branchrow = $(this).find('.branch').detach();
        $(branchAdd).append(branchrow);
      });
      $('.get-val').each(function() {
        var addRow, removeRow;
        removeRow = $(this).find('.fnb-input');
        addRow = $(this).find('.removeRow').detach();
        return $(removeRow).after(addRow);
      });
    }
    $('body').on('click', '#category-select .delete-cat', function() {
      $(this).closest('.single-category').remove();
      return change_view();
    });
    $('body').on('click', '#category-select .fnb-cat .remove', function() {
      var item, list;
      item = $(this).closest('.fnb-cat__title').parent();
      list = item.parent();
      item.remove();
      if (list.children().length === 0) {
        list.closest('.single-category').remove();
      }
      return change_view();
    });

    /* --- On Category Modal Shown --- */
    $(document).on("shown.bs.modal", "#category-select", function(event) {
      $("#category-select #level-two-category").addClass("hidden");
      $("#category-select #level-one-category").removeClass("hidden");
      $("#category-select #level-one-category input[type='radio']").prop("checked", false);
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
        getNodeCategories("#category-select #level-two-category ", $("#category-select #level-two-category #branch_categories li.active").find('a').attr("aria-controls"), get_core_cat_checked, false);
      }), 200);
    });

    /* --- On click of Branch Categories, Get it's children --- */
    $(document).on("click", "#category-select #level-two-category ul#branch_categories li a", function() {
      var get_core_cat_checked;
      get_core_cat_checked = [];
      if ($("#category-select #level-two-category div#" + $(this).attr("aria-controls") + " input[type='checkbox']").length < 1) {
        get_core_cat_checked = getPreviouslyAvailableCategories();
        getNodeCategories("#category-select #level-two-category ", $(this).attr("aria-controls"), get_core_cat_checked, false);
      }
    });

    /* -- If a branch category is selected, then select all the core categories --- */
    $(document).on("change", "#category-select #level-two-category ul#branch_categories input[type='checkbox']", function() {
      if ($("#category-select #level-two-category div#" + $(this).val() + " input[type='checkbox']").length < 1) {
        if ($(this).prop('checked')) {
          getNodeCategories("#category-select #level-two-category ", $(this).val(), [], true);
        } else {
          getNodeCategories("#category-select #level-two-category ", $(this).val(), [], false);
        }
      } else {
        if ($(this).prop('checked')) {
          $("#category-select #level-two-category #cat-dataHolder div#" + $(this).val() + " input[type='checkbox']").prop("checked", "true");
        } else {
          $("#category-select #level-two-category #cat-dataHolder div#" + $(this).val() + " input[type='checkbox']").prop("checked", "false");
        }
      }
    });

    /* --- On Click of "Add Selected", add those Checked values & close the Popup --- */
    $(document).on("click", "#category-select #level-two-category button#category-select-btn", function() {
      var checked_categories, main_page_categories;
      checked_categories = [];
      main_page_categories = [];
      main_page_categories = getPreviouslyAvailableCategories();
      $.each($("#category-select #level-two-category #cat-dataHolder input[type='checkbox']:checked"), function() {
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
