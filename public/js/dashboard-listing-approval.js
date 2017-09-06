(function() {
  var applyCategFilter, categ, categories, getNodes, populate;

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
        'status': '0,1,2'
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
          'status': '0,1,2'
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

  applyCategFilter = function() {};

  $('body').on('click', 'button#resetAll', function(e) {
    $('div#categories.node-list').html('');
    applyCategFilter();
  });

  $('div#category-select').on('change', 'div#selectall input[type="checkbox"]', function() {
    if ($(this).prop('checked')) {
      return $(this).closest('.tab-pane').find('ul.nodes input[type="checkbox"]').prop('checked', true).change();
    } else {
      return $(this).closest('.tab-pane').find('ul.nodes input[type="checkbox"]').prop('checked', false).change();
    }
  });

}).call(this);
