(function() {
  var populate, selected_categ_id;

  selected_categ_id = [];

  window.categories = {
    'parents': []
  };

  $('body').on('hidden.bs.modal', '#category-select', function() {
    var checked_categories, index, selected_categ;
    selected_categ = [];

    /* --- Get the Category ID list --- */
    if ($(document).find("input[type='hidden']#modal_categories_chosen").val().length > 2 && JSON.parse($(document).find("input[type='hidden']#modal_categories_chosen").val()).length > 0) {
      checked_categories = JSON.parse($(document).find("input[type='hidden']#modal_categories_chosen").val());
      index = 0;
      while (index < checked_categories.length) {
        selected_categ_id.push(checked_categories[index]["slug"]);
        index++;
      }
    }
    console.log(selected_categ_id);
    console.log($(document).find("input[type='hidden']#modal_categories_hierarchy_chosen").val());
    if ($(document).find("input[type='hidden']#modal_categories_hierarchy_chosen").val() && $(document).find("input[type='hidden']#modal_categories_hierarchy_chosen").val().length > 0) {
      selected_categ = JSON.parse($(document).find("input[type='hidden']#modal_categories_hierarchy_chosen").val());
    } else {
      selected_categ = "";
    }
    console.log(selected_categ);
    categories['parents'].length = 0;
    if (selected_categ && selected_categ.length > 0) {
      selected_categ.forEach(function(element) {
        var branchID, nodeID, parentID;
        parentID = element['parent']['id'];
        if (!categories['parents'].hasOwnProperty(parentID)) {
          categories['parents'][parentID] = {
            'id': element['parent']['id'],
            'image-url': element['parent']['icon_url'],
            'name': element['parent']['name'],
            'slug': element['parent']['slug'],
            'selected': 0,
            'branches': []
          };
        }
        if (element.hasOwnProperty('branch') && categories['parents'][parentID]['selected'] === 0) {
          branchID = element['branch']['id'];
          if (!categories['parents'][parentID]['branches'].hasOwnProperty(branchID)) {
            categories['parents'][parentID]['branches'][branchID] = {
              'id': element['branch']['id'],
              'name': element['branch']['name'],
              'slug': element['branch']['slug'],
              'selected': 0,
              'nodes': []
            };
          }
          if (element.hasOwnProperty('node') && categories['parents'][parentID]['branches'][branchID]['selected'] === 0) {
            nodeID = element['node']['id'];
            if (!categories['parents'][parentID]['branches'][branchID]['nodes'].hasOwnProperty(nodeID)) {
              return categories['parents'][parentID]['branches'][branchID]['nodes'][nodeID] = {
                'id': element['node']['id'],
                'name': element['node']['name'],
                'slug': element['node']['slug']
              };
            }
          } else {
            categories['parents'][parentID]['branches'][branchID]['selected'] = 1;
            return categories['parents'][parentID]['branches'][branchID]['nodes'] = [];
          }
        } else {
          return categories['parents'][parentID]['selected'] = 1;
        }
      });
    }
    console.log(categories);
    return populate();
  });

  populate = function() {
    var source, template;
    source = '{{#parents}} <div class="single-category gray-border add-more-cat m-t-15" data-categ-id="{{id}}"> <div class="row flex-row categoryContainer corecat-container align-top"> <div class="col-sm-4 flex-row"> <img class="import-icon cat-icon" src="{{image-url}}"> <div class="branch-row"> <div class="cat-label"> {{name}} <input type=hidden name="categories" value="{{id}}" data-item-name="{{slug}}"> </div> </div> </div> <div class="col-sm-8"> {{#branches}} <div class="m-b-10 row branch-container" data-categ-id={{id}}> <div class="col-sm-4"> <ul class="fnb-cat flex-row small"> <li> <span class="fnb-cat__title"> <strong class="branch">{{name}}</strong><span class="fa fa-times remove branch-remove"></span> <input type=hidden name="categories" value="{{id}}" data-item-name="{{name}}"> </span> </li> </ul> </div> <div class="col-sm-8"> <ul class="fnb-cat small flex-row" id="view-categ-node"> {{#nodes}} <li class="node-container"> <span class="fnb-cat__title"> {{name}} <input data-item-name="{{name}}" name="categories" type="hidden" value="{{id}}"> <span class="fa fa-times remove node-remove"></span> </span> </li> {{/nodes}} </ul> </div> </div> {{/branches}} </div> </div> <div class="delete-cat"> <span class="fa fa-times remove"></span> </div> </div> {{/parents}}';
    template = Handlebars.compile(source, {
      noEscape: true
    });
    $('div#categories.node-list').html(template(categories));
  };

  $('body').on('click', '#categories.node-list .delete-cat', function() {
    var pid;
    pid = parseInt($(this).closest('.single-category').attr('data-categ-id'));
    console.log(pid);
    delete categories['parents'][pid];
    return $(this).closest('.single-category').remove();
  });

  $('body').on('click', '#categories.node-list .branch-remove', function() {
    var bid, item, pid;
    item = $(this).closest('.branch-container');
    pid = parseInt($(this).closest('.single-category').attr('data-categ-id'));
    bid = parseInt($(this).closest('.branch-container').attr('data-categ-id'));
    delete categories['parents'][pid]['branches'][bid];
    return item.remove();
  });

  $('body').on('click', '#categories.node-list .fnb-cat .node-remove', function() {
    var bid, item, list, nid, pid;
    item = $(this).closest('.fnb-cat__title').parent();
    list = item.parent();
    pid = parseInt($(this).closest('.single-category').attr('data-categ-id'));
    bid = parseInt($(this).closest('.branch-container').attr('data-categ-id'));
    nid = parseInt(item.find('input[type="hidden"]').val());
    delete categories['parents'][pid]['branches'][bid]['nodes'][nid];
    return item.remove();
  });

  window.getLeafNodes = function() {
    var branch, i, j, leaf_nodes, node, parent;
    leaf_nodes = [];
    for (parent in categories['parents']) {
      i = 0;
      for (branch in categories['parents'][parent]['branches']) {
        i++;
        j = 0;
        for (node in categories['parents'][parent]['branches'][branch]['nodes']) {
          j++;
          leaf_nodes.push(categories['parents'][parent]['branches'][branch]['nodes'][node]['id']);
        }
        if (j === 0) {
          leaf_nodes.push(categories['parents'][parent]['branches'][branch]['id']);
        }
      }
      if (i === 0) {
        leaf_nodes.push(categories['parents'][parent]['id']);
      }
    }
    return leaf_nodes;
  };

  $(document).ready(function() {
    $(document).on("show.bs.modal", "#category-select", function(event) {
      var enquiry_categories, enquiry_categories_string;
      setTimeout((function() {
        $('.tab-pane .disable-section input[type="checkbox"]').prop("checked", true);
      }), 500);
      enquiry_categories = getLeafNodes();
      enquiry_categories_string = [];
      enquiry_categories.forEach(function(element) {
        enquiry_categories_string.push(element.toString());
      });
      $("#category-select #previously_available_categories").val(JSON.stringify(enquiry_categories_string));
      console.log($("#category-select #previously_available_categories").val());
    });
  });

}).call(this);
