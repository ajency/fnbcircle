(function() {
  var $_GET, categ, categories, change_view, getID, getNodes, id, input, parent, populate, submitForm, update_core, validateCategories, verify;

  $('body').on('click', '.gs-next', function() {
    return $('.gs-steps > .active').next('li').find('a').trigger('click');
  });

  $('body').on('click', '.gs-prev', function() {
    return $('.gs-steps > .active').prev('li').find('a').trigger('click');
  });

  $('.dropify').dropify({
    messages: {
      'default': 'Add Photo'
    }
  });

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
        'parent': JSON.stringify(obj)
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
      async: true
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
          'parent': JSON.stringify(obj)
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
          html = '<input type="hidden" name="parent" value="' + data[branchID]['parent'] + '">';
          html += '<input type="hidden" name="image" value="' + data[branchID]['image'] + '">';
          html += '<input type="hidden" name="branch" value="' + data[branchID]['name'] + '" id="' + branchID + '">';
          for (key in data[branchID]['children']) {
            html += '<li><label class="flex-row"><input type="checkbox" class="checkbox" ';
            if (_.indexOf(array, key) !== -1) {
              html += 'checked';
            }
            html += ' for="' + slugify(data[branchID]['children'][key]['name']) + '" value="' + key + '" name="' + data[branchID]['children'][key]['name'] + '"><p class="lighter nodes__text" id="' + slugify(data[branchID]['children'][key]['name']) + '">' + data[branchID]['children'][key]['name'] + '</p></label></li>';
          }
          $('div#' + slugify(data[branchID]['name']) + '.tab-pane ul.nodes').html(html);
          categ[branchID] = true;
        },
        async: true
      });
    }
  };

  $('body').on('click', '.categ-list a', function() {
    populate();
    return getNodes($(this).attr('name'));
  });

  $('body').on('click', 'div.toggle-collapse.desk-hide', function() {
    populate();
    return getNodes($(this).attr('name'));
  });

  window.slugify = function(string) {
    return string.toString().trim().toLowerCase().replace(/\s+/g, '-').replace(/[^\w\-]+/g, '').replace(/\-\-+/g, '-').replace(/^-+/, '').replace(/-+$/, '');
  };

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
      minLength: 1
    });
  }), 500);

  $('body').on('click', '.tips', function() {
    $(this).toggleClass('open');
    return $('.tips__steps.collapse').collapse('toggle');
  });

  $('.sample-img').magnificPopup({
    items: {
      src: 'img/sample_listing.png'
    },
    type: 'image',
    mainClass: 'mfp-fade'
  });

  $('body').on('change', 'input:checkbox.all-cities', function() {
    if ($(this).is(':checked')) {
      return $(this).closest('.tab-pane').find('input:checkbox').prop('checked', true);
    } else {
      return $(this).closest('.tab-pane').find('input:checkbox').prop('checked', false);
    }
  });

  $('[data-toggle="tooltip"]').tooltip();

  $('body').on('click', '.add-highlight', function() {
    var highlight_group, highlight_group_clone;
    highlight_group = $(this).closest('.highlight-input-group');
    highlight_group_clone = highlight_group.clone();
    highlight_group_clone.find('.add-highlight').remove();
    highlight_group_clone.find('.delete-highlight').removeClass('hidden');
    highlight_group_clone.insertBefore(highlight_group);
    return highlight_group.find('.highlight-input').val('');
  });

  $('body').on('click', '.delete-highlight', function() {
    return $(this).closest('.highlight-input-group').remove();
  });

  $('body').on('click', '.add-another', function(e) {
    var contact_group, contact_group_clone, input;
    e.preventDefault();
    contact_group = $(this).closest('.business-contact').find('.contact-group');
    contact_group_clone = contact_group.clone();
    contact_group_clone.removeClass('contact-group hidden');
    input = contact_group_clone.find('.fnb-input');
    input.attr('data-parsley-required', true);
    return contact_group_clone.insertBefore(contact_group);
  });

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

  $('body').on('click', '.review-submit', function(e) {
    e.preventDefault();
    $('.status-changer').text('Processing').removeClass('text-primary').addClass('text-secondary');
    $('.draft-status').attr('data-original-title', 'Listing is under process');
    return $(this).addClass('hidden');
  });

  if ($(window).width() > 768) {
    getID = $('.gs-form .tab-pane').attr('id');
    $('.gs-steps .form-toggle').each(function() {
      if ($(this).attr('id') === getID) {
        $(this).parent().addClass('active');
      }
    });
  }

  parent = void 0;

  input = void 0;

  id = void 0;

  verify = function() {
    var get_val, id_val, type, valid, validator;
    $('.validationError').html('');
    if (id.val() === '') {
      id_val = null;
    } else {
      id_val = id.val();
    }
    validator = input.parsley();
    valid = validator.validate();
    if (valid === true && input.val() !== '') {
      get_val = input.val();
      if (parent.hasClass('business-email')) {
        $('#email-modal').modal('show');
        type = '1';
      }
      if (parent.hasClass('business-phone')) {
        $('#phone-modal').modal('show');
        type = '2';
      }
      $.ajax({
        type: 'post',
        url: '/create_OTP',
        data: {
          'value': get_val,
          'type': type,
          'id': id_val
        },
        success: function(data) {
          id.val(data['id']);
          input.val(data['value']);
          get_val = data['value'];
        },
        error: function(request, status, error) {
          id.val("");
          alert("OTP failed. Try Again");
        },
        async: false
      });
      $('.verification-step-modal .number').text(get_val);
      $('.verify-steps').addClass('hidden');
      $('.default-state, .verificationFooter').removeClass('hidden');
    } else {
      $('#email-modal').modal('hide');
      $('#phone-modal').modal('hide');
    }
  };

  window.checkDuplicates = function() {
    var contacts, index, index1, others, value;
    contacts = document.getElementsByClassName('fnb-input');
    index = 0;
    while (index < contacts.length) {
      others = document.getElementsByClassName('fnb-input');
      value = contacts[index].value;
      if (value !== '') {
        index1 = 0;
        while (index1 < others.length) {
          if (value === others[index1].value && index !== index1) {
            $(others[index1]).closest('.get-val').find('.dupError').html('Same contact detail has been added multiple times.');
            return true;
          } else {
            $(others[index1]).closest('.get-val').find('.dupError').html('');
          }
          ++index1;
        }
      }
      ++index;
    }
  };

  $(document).on('blur', '.fnb-input', function() {
    checkDuplicates();
    $('#info-form').parsley();
  });

  $(document).on('click', '.verify-link', function() {
    event.preventDefault();
    parent = $(this).closest('.business-contact');
    input = $(this).closest('.get-val').find('.fnb-input');
    id = $(this).closest('.get-val').find('.comm-id');
    if (checkDuplicates()) {
      return false;
    }
    verify();
  });

  $('.edit-number').click(function() {
    event.preventDefault();
    $('.value-enter').val('');
    $('.default-state').addClass('hidden');
    $('.add-number').removeClass('hidden');
    $('.verificationFooter').addClass('no-bg');
  });

  $('.step-back').click(function() {
    event.preventDefault();
    $('.default-state').removeClass('hidden');
    $('.add-number').addClass('hidden');
    $('.verificationFooter').removeClass('no-bg');
  });

  $('.verify-stuff').click(function() {
    var get_value, inp, validator;
    event.preventDefault();
    inp = $(this).siblings('.value-enter');
    inp.attr('data-parsley-required', 'true');
    if (parent.hasClass('business-email')) {
      inp.attr('data-parsley-type', 'email');
    } else {
      inp.attr('data-parsley-type', 'digits');
      inp.attr('data-parsley-length', '[10,10]');
      inp.attr('data-parsley-length-message', 'Mobile number should be 10 digits');
    }
    validator = inp.parsley();
    if (validator.validate() !== true) {
      inp.removeAttr('data-parsley-required');
      inp.removeAttr('data-parsley-type');
      inp.removeAttr('data-parsley-length');
      inp.removeAttr('data-parsley-length-message');
      return false;
    }
    inp.removeAttr('data-parsley-required');
    inp.removeAttr('data-parsley-type');
    inp.removeAttr('data-parsley-length');
    inp.removeAttr('data-parsley-length-message');
    $('.default-state').removeClass('hidden');
    $('.add-number').addClass('hidden');
    $('.verificationFooter').removeClass('no-bg');
    get_value = $(this).siblings('.value-enter').val();
    $('.show-number .number').text(get_value);
    $(input).val(get_value);
    $(inp).val('');
    $('.validationError').html('');
    verify();
  });

  $('.code-send').click(function() {
    var OTP, errordiv, inp, validator;
    errordiv = $(this).closest('.number-code').find('.validationError');
    inp = $(this).closest('.code-submit').find('.fnb-input');
    inp.attr('data-parsley-required', 'true');
    inp.attr('data-parsley-type', 'digits');
    inp.attr('data-parsley-length', '[4,4]');
    validator = inp.parsley();
    if (validator.isValid() !== true) {
      if (inp.val() === '') {
        errordiv.html('Please enter OTP sent');
      } else {
        errordiv.html('Sorry! The entered OTP is invalid. Please try again.');
      }
      inp.val('');
      inp.removeAttr('data-parsley-required');
      inp.removeAttr('data-parsley-type');
      inp.removeAttr('data-parsley-length');
      return false;
    }
    inp.removeAttr('data-parsley-required');
    inp.removeAttr('data-parsley-type');
    inp.removeAttr('data-parsley-length');
    OTP = inp.val();
    $('.default-state').addClass('hidden');
    $('.processing').removeClass('hidden');
    $.ajax({
      type: 'post',
      url: '/validate_OTP',
      data: {
        'OTP': OTP,
        'id': id.val()
      },
      success: function(data) {
        if (data['success'] === "1") {
          errordiv.html('');
          $('.default-state,.add-number,.verificationFooter').addClass('hidden');
          $('.processing').addClass('hidden');
          $('.step-success').removeClass('hidden');
          $(input).closest('.get-val').find('.verified').html('<span class="fnb-icons verified-icon"></span><p class="c-title">Verified</p>');
          $(input).attr('readonly', true);
        } else {
          $('.processing').addClass('hidden');
          $('.default-state').removeClass('hidden');
          inp.val('');
          errordiv.html('Sorry! The entered OTP is invalid. Please try again.');
        }
      },
      error: function(request, status, error) {
        $('.processing').addClass('hidden');
        '.default-state'.removeClass('hidden');
        inp.val('');
        errordiv.html('Sorry! The entered OTP is invalid. Please try again.');
      },
      async: false
    });
  });

  $('.verification-step-modal').on('hidden.bs.modal', function(e) {
    $('.step-success,.add-number').addClass('hidden');
    $('.verificationFooter').removeClass('no-bg');
    $('.default-state,.verificationFooter').removeClass('hidden');
    $('.default-state .fnb-input').val('');
  });

  $('.resend-link').click(function() {
    event.preventDefault();
    $(this).addClass('sending');
    setTimeout((function() {
      $('.resend-link').removeClass('sending');
    }), 2500);
  });

  $('body').on('click', '.removeRow', function() {
    return $(this).closest('.get-val').parent().remove();
  });

  $(document).on('change', '.business-contact .toggle__check', function() {
    if ($(this).is(':checked')) {
      $(this).closest('.toggle').siblings('.toggle-state').text('Visible on the listing');
    } else {
      $(this).closest('.toggle').siblings('.toggle-state').text('Not visible on the listing');
    }
  });

  $(document).on('change', '.city select', function() {
    var city;
    city = $(this).val();
    return $.ajax({
      type: 'post',
      url: '/get_areas',
      data: {
        'city': city
      },
      success: function(data) {
        var html, key;
        html = '<option value="" selected>Select Area </option>';
        for (key in data) {
          html += '<option value="' + key + '">' + data[key] + '</option>';
        }
        $('.area select').html(html);
      }
    });
  });

  categories = window.categories;

  $('body').on('change', '.tab-pane.collapse input[type=\'checkbox\']', function() {
    var branchID, parentDiv;
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
      return categories['categories'][branchID]['nodes'].push({
        'name': $(this).attr('name'),
        'id': $(this).val()
      });
    } else {
      id = $(this).val();
      return categories['categories'][branchID]['nodes'] = _.reject(categories['categories'][branchID]['nodes'], function(node) {
        if (node["id"] === id) {
          return true;
        } else {
          return false;
        }
      });
    }
  });

  populate = function() {
    var source, template;
    source = '{{#categories}}<div class="single-category gray-border add-more-cat m-t-15"><div class="row flex-row categoryContainer"><div class="col-sm-4 flex-row"><img class="import-icon cat-icon" src="{{image-url}}"></img><div class="branch-row"><div class="cat-label">{{parent}}</div></div></div><div class="col-sm-2"><strong class="branch">{{branch}}</strong></div><div class="col-sm-6"> <ul class="fnb-cat small flex-row" id="view-categ-node">{{#nodes}}<li><span class="fnb-cat__title">{{name}}<input type=hidden name="categories" value="{{id}}" data-item-name="{{name}}"> <span class="fa fa-times remove"></span></span></li>{{/nodes}}</ul></div> </div><div class="delete-cat"><span class="fa fa-times remove"></span></div></div>{{/categories}}';
    template = Handlebars.compile(source, {
      noEscape: true
    });
    console.log(template);
    $('div#categories.node-list').html(template(categories));
    update_core();
  };

  $('body').on('click', 'button#category-select.fnb-btn', function() {
    var branch, i, j, k;
    k = 0;
    if (categories['categories'].length > 0) {
      for (branch in categories['categories']) {
        k++;
        j = 0;
        for (i in categories['categories'][branch]['nodes']) {
          j++;
        }
        if (j === 0) {
          delete categories['categories'][branch];
        }
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

  $(document).on('click', 'a.review-submit-link', function(e) {
    window.submit = 1;
    return submitForm(e);
  });

  $(document).on('click', '.full.save-btn.gs-next', function(e) {
    return submitForm(e);
  });

  submitForm = function(e) {
    var step;
    step = $('input#step-name').val();
    e.preventDefault();
    if (step === 'business-information') {
      window.validateListing(e);
    }
    if (step === 'business-categories') {
      return validateCategories();
    }
  };

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
      html += '<li><input type="checkbox" data-parsley-required data-parsley-multiple="core_categ" data-parsley-mincheck=1 data-parsley-maxcheck=10 data-parsley-maxcheck-message="Core categories cannot be more than 10." data-parsley-required-message="At least one core category should be selected for a business." class="checkbox core-cat-select" id="cat-label-' + item + '" value="' + item + '"';
      if (_.indexOf(core, item) !== -1) {
        html += ' checked="checked"';
      }
      html += '><label class="core-selector__label m-b-0" for="cat-label-' + item + '"><span class="fnb-cat__title text-medium">' + item_name[index] + '</span></label></span></li>';
    });
    return $('.core-selector').html(html);
  };

  validateCategories = function() {
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

  $_GET = [];

  window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(a, name, value) {
    $_GET[name] = value;
  });

  if ($_GET['review'] !== void 0) {
    console.log($_GET['review']);
    $('#listing-review').modal('show');
  }

  if ($_GET['success'] !== void 0) {
    setTimeout((function() {
      $('.alert-success').addClass('active');
    }), 1500);
    setTimeout((function() {
      $('.alert-success').removeClass('active');
    }), 6000);
  }

  if ($('.alert.alert-failure') !== void 0) {
    setTimeout((function() {
      $('.alert-failure').addClass('active');
    }), 1500);
    setTimeout((function() {
      $('.alert-failure').removeClass('active');
    }), 6000);
  }

}).call(this);
