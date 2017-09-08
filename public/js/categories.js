(function() {
  var categ, categories, change_view, getNodes, populate, update_core;

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
          html_mob += '" id="' + slugify(data[id]['children'][key]['name']) + '" name="' + data[id]['children'][key]['id'] + '"><ul class="nodes"><li>' + data[id]['children'][key]['name'] + '</li></ul></div>';
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
        },
        async: true,
        error: function(request, status, error) {
          throwError();
        }
      });
    }
  };

  $('body').on('click', '.categ-list a', function() {
    populate();
    return getNodes($(this).attr('name'));
  });

  $('body').on('click', 'div.toggle-collapse.desk-hide', function() {
    $('.collapse').collapse('hide');
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
    $('.firstStep').removeClass('hidden');
    return $('.interested-options .radio').prop('checked', false);
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

  setTimeout((function() {
    $('.brand-list').flexdatalist({
      removeOnBackspace: false,
      minLength: 1,
      url: '/get_brands',
      searchIn: ["name"]
    });
  }), 500);

  categories = window.categories;

  $('body').on('change', '.tab-pane.collapse input[type=\'checkbox\']', function() {
    var branchID, id, parentDiv;
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

  populate = function() {
    var source, template;
    source = '{{#categories}}<div class="single-category gray-border add-more-cat m-t-15"><div class="row flex-row categoryContainer corecat-container"><div class="col-sm-4 flex-row"><img class="import-icon cat-icon" src="{{image-url}}"></img><div class="branch-row"><div class="cat-label">{{parent}}</div></div></div><div class="col-sm-2"><strong class="branch">{{branch}}</strong></div><div class="col-sm-6"> <ul class="fnb-cat small flex-row" id="view-categ-node">{{#nodes}}<li><span class="fnb-cat__title">{{name}}<input type=hidden name="categories" value="{{id}}" data-item-name="{{name}}"> <span class="fa fa-times remove"></span></span></li>{{/nodes}}</ul></div> </div><div class="delete-cat"><span class="fa fa-times remove"></span></div></div>{{/categories}}';
    template = Handlebars.compile(source, {
      noEscape: true
    });
    $('div#categories.node-list').html(template(categories));
    update_core();
  };

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
      $('.core-cat-cont').removeClass('hidden');
    } else {
      $('#categ-selected').addClass('hidden');
      $('#no-categ-select').removeClass('hidden');
      $('.core-cat-cont').addClass('hidden');
    }
    if ($(window).width() <= 768) {
      return $('.single-category').each(function() {
        var branchAdd, branchrow;
        branchAdd = $(this).find('.branch-row');
        branchrow = $(this).find('.branch').detach();
        return $(branchAdd).append(branchrow);
      });
    }
  });

  change_view = function() {
    if ($('div#categories.node-list').children().length === 0) {
      $('#categ-selected').addClass('hidden');
      $('div.core-cat-cont').addClass('hidden');
      $('#no-categ-select').removeClass('hidden');
    } else {
      $('#categ-selected').removeClass('hidden');
      $('div.core-cat-cont').removeClass('hidden');
      $('#no-categ-select').addClass('hidden');
    }
    return update_core();
  };

  update_core = function() {
    var core, html, item_id, item_name;
    item_id = [];
    item_name = [];
    core = [];
    $('ul#view-categ-node').find('input[type=\'hidden\']').each(function(index, data) {
      item_id.push($(this).val());
      return item_name.push($(this).attr('data-item-name'));
    });
    $('input.core-cat-select[type="checkbox"]:checked').each(function(index, data) {
      return core.push($(this).val());
    });
    html = '';
    item_id.forEach(function(item, index) {
      html += '<li><input type="checkbox" data-parsley-required data-parsley-errors-container="#core-errors" data-parsley-multiple="core_categ" data-parsley-mincheck=1 data-parsley-maxcheck=10 data-parsley-maxcheck-message="Core categories cannot be more than 10." data-parsley-required-message="At least one core category should be selected for a business." class="checkbox core-cat-select" id="cat-label-' + item + '" value="' + item + '"';
      if (_.indexOf(core, item) !== -1) {
        html += ' checked="checked"';
      }
      html += '><label class="core-selector__label m-b-0" for="cat-label-' + item + '"><span class="fnb-cat__title text-medium">' + item_name[index] + '</span></label></span></li>';
    });
    return $('.core-selector').html(html);
  };

  window.validateCategories = function() {
    var brands, cat, cores, form, instance, parameters;
    instance = $('#info-form').parsley();
    if ($('div#categories.node-list').children().length === 0) {
      $('div#no-categ-error').removeClass('hidden');
      return false;
    }
    if (!instance.validate()) {
      return false;
    }
    $('.section-loader').removeClass('hidden');
    cat = {};
    cores = {};
    $('#view-categ-node input[name="categories"]').each(function(index, item) {
      var category;
      category = {};
      category['id'] = $(this).val();
      return cat[index] = category;
    });
    $('input[data-parsley-multiple="core_categ"]:checked').each(function(index, item) {
      var core;
      core = {};
      core['id'] = $(this).val();
      return cores[index] = core;
    });
    brands = $('input#brandsinput').val();
    parameters = {};
    parameters['listing_id'] = document.getElementById('listing_id').value;
    parameters['step'] = 'business-categories';
    parameters['change'] = window.change;
    parameters['categories'] = JSON.stringify(cat);
    parameters['core'] = JSON.stringify(cores);
    parameters['brands'] = brands;
    if (window.submit === 1) {
      parameters['submitReview'] = 'yes';
    }
    form = $('<form></form>');
    form.attr("method", "post");
    form.attr("action", "/listing");
    $.each(parameters, function(key, value) {
      var field;
      field = $('<input></input>');
      field.attr("type", "hidden");
      field.attr("name", key);
      field.attr("value", value);
      form.append(field);
      console.log(key + '=>' + value);
    });
    $(document.body).append(form);
    return form.submit();
  };

  $('body').on('click', '.delete-cat', function() {
    $(this).closest('.single-category').remove();
    return change_view();
  });

  $('body').on('click', '.fnb-cat .remove', function() {
    var item, list;
    item = $(this).closest('.fnb-cat__title').parent();
    list = item.parent();
    item.remove();
    if (list.children().length === 0) {
      list.closest('.single-category').remove();
    }
    return change_view();
  });

}).call(this);
