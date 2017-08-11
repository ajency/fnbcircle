(function() {
  var categ, getID, getNodes, id, input, parent, verify;

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
        for (key in data[id]['children']) {
          html_mob += '<div class="toggle-collapse desk-hide" data-toggle="collapse" data-target="#' + slugify(data[id]['children'][key]['name']) + '"  name="' + key + '" aria-expanded="false" aria-controls="' + slugify(data[id]['children'][key]['name']) + '">' + data[id]['children'][key]['name'] + ' <i class="fa fa-angle-down" aria-hidden="true"></i></div><div role="tabpanel" class="tab-pane collapse';
          if (i === 0) {
            html_mob += ' active';
          }
          html_mob += '" id="' + slugify(data[id]['children'][key]['name']) + '" name="' + key + '"><ul class="nodes"><li>' + data[id]['children'][key]['name'] + '</li></ul></div>';
          html += '<li role="presentation"';
          if (i === 0) {
            html += ' class="active"';
          }
          html += '><a href="#' + slugify(data[id]['children'][key]['name']) + '"  name="' + key + '" aria-controls="' + slugify(data[id]['children'][key]['name']) + '" role="tab" data-toggle="tab">' + data[id]['children'][key]['name'] + '</a></li>';
          i++;
        }
        $('.categ-list').html(html);
        $('.mobile-categories').html(html_mob);
        categ.length = 0;
        for (key in data[id]['children']) {
          getNodes(key);
          break;
        }
      }
    });
  });

  categ = [];

  getNodes = function(branchID) {
    var obj;
    obj = {};
    obj[0] = {
      'id': branchID
    };
    if (categ[branchID] !== true) {
      $.ajax({
        type: 'post',
        url: '/get_categories',
        data: {
          'parent': JSON.stringify(obj)
        },
        success: function(data) {
          var html, key;
          html = "";
          for (key in data[branchID]['children']) {
            html += '<li><label class="flex-row"><input type="checkbox" class="checkbox" for="' + slugify(data[branchID]['children'][key]['name']) + '"><p class="lighter nodes__text" id="' + slugify(data[branchID]['children'][key]['name']) + '">' + data[branchID]['children'][key]['name'] + '</p></label></li>';
          }
          $('div#' + slugify(data[branchID]['name']) + '.tab-pane ul.nodes').html(html);
          categ[branchID] = true;
        }
      });
    }
  };

  $('body').on('click', '.categ-list a', function() {
    return getNodes($(this).attr('name'));
  });

  $('body').on('click', 'div.toggle-collapse.desk-hide', function() {
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
    return $('.firstStep').removeClass('hidden');
  });

  $('.topSelect').click(function() {
    return setTimeout((function() {
      $('.category-back').addClass('hidden');
    }), 100);
  });

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

  $('.flexdatalist').flexdatalist();

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
    return $(this).closest('.single-category').remove();
  });

  $('body').on('click', '.fnb-cat .remove', function() {
    return $(this).closest('.fnb-cat__title').parent().remove();
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
      console.log(get_val);
      console.log(id_val);
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
          console.log(id.val());
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
            $(others[index1]).closest('.get-val').find('.dupError').html('Same contact detail added multiple times.');
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
        errordiv.html('Please enter OTP');
      } else {
        errordiv.html('OTP is Invalid');
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
          errordiv.html('OTP is Invalid');
        }
      },
      error: function(request, status, error) {
        $('.processing').addClass('hidden');
        '.default-state'.removeClass('hidden');
        inp.val('');
        errordiv.html('OTP is Invalid');
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
    console.log(id.val());
    setTimeout((function() {
      $('.resend-link').removeClass('sending');
    }), 2500);
  });

  $('body').on('click', '.removeRow', function() {
    return $(this).closest('.get-val').remove();
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

  $('body').on('click', 'button#category-select.fnb-btn', function() {
    var categories, source, template;
    source = '<div class="single-category gray-border add-more-cat m-t-15"><div class="row flex-row categoryContainer"><div class="col-sm-4 flex-row"><img src="{{image-url}}"></img><div class="branch-row"><div class="cat-label">{{parent}}</div></div></div><div class="col-sm-2"><strong class="branch">{{branch}}</strong></div><div class="col-sm-6"> <ul class="fnb-cat small flex-row">{{#nodes}}<li><span class="fnb-cat__title">{{name}}<input type=hidden name="categories" value="{{id}}"> <span class="fa fa-times remove"></span></span></li>{{/nodes}}</ul></div> </div><div class="delete-cat"><span class="fa fa-times remove"></span></div></div>';
    template = Handlebars.compile(source);
    categories = {
      "image-url": 'www.google.com',
      "parent": "Meat n Masala",
      "branch": "Beef Yummy",
      "nodes": [
        {
          "name": "Al Kabeer ",
          "id": "1"
        }, {
          "name": "Pandiyan",
          "id": "2"
        }, {
          "name": "Pandiyan",
          "id": "2"
        }, {
          "name": "Pandiyan",
          "id": "2"
        }, {
          "name": "Pandiyan",
          "id": "2"
        }, {
          "name": "Pandiyan",
          "id": "2"
        }
      ]
    };
    return $('div#categories.node-list').append(template(categories));
  });

  $(document).on('click', '.full.save-btn.gs-next', function(e) {
    var step;
    step = $('input#step-name').val();
    e.preventDefault();
    if (step === 'business-information') {
      window.validateListing(e);
    }
    if (step === 'business-categories') {
      return console.log('save');
    }
  });

}).call(this);
