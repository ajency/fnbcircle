(function() {
  var getID, id, input, parent;

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
    var cat_icon, cat_name;
    cat_name = $(this).data('name');
    $('.main-cat-name').html(cat_name);
    cat_icon = $(this).closest('li').find('.cat-icon').clone().addClass('m-r-15');
    $('.sub-category .cat-name').find('.cat-icon').remove();
    return $('.sub-category .cat-name').prepend(cat_icon);
  });

  $('body').on('click', '.sub-category-back', function() {
    $('.main-category').removeClass('hidden');
    return $('.sub-category').removeClass('shown');
  });

  if ($(window).width() <= 768) {
    $('.single-category').each(function() {
      var branchAdd, branchrow;
      branchAdd = $(this).find('.branch-row');
      branchrow = $(this).find('.branch').detach();
      $(branchAdd).append(branchrow);
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
    var contact_group, contact_group_clone;
    e.preventDefault();
    contact_group = $(this).closest('.business-contact').find('.contact-group');
    contact_group_clone = contact_group.clone();
    contact_group_clone.removeClass('contact-group hidden');
    return contact_group_clone.insertBefore(contact_group);
  });

  $('body').on('click', '.review-submit', function(e) {
    e.preventDefault();
    $('.status-changer').text('Processing').removeClass('text-primary').addClass('text-secondary');
    $('.draft-status').attr('data-original-title', 'Listing is under process');
    return $(this).addClass('hidden');
  });

  getID = $('.gs-form .tab-pane').attr('id');

  $('.gs-steps .form-toggle').each(function() {
    if ($(this).attr('id') === getID) {
      $(this).parent().addClass('active');
    }
  });

  parent = void 0;

  input = void 0;

  id = void 0;

  $(document).on('click', '.verify-link', function() {
    var get_val, id_val, type, valid, validator;
    event.preventDefault();
    parent = $(this).closest('.business-contact');
    input = $(this).closest('.get-val').find('.fnb-input');
    id = $(this).closest('.get-val').find('.comm-id');
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
        async: false
      });
      $('.verification-step-modal .number').text(get_val);
    } else {
      $('#email-modal').modal('hide');
      $('#phone-modal').modal('hide');
    }
  });

  $('.edit-number').click(function() {
    event.preventDefault();
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
    var get_value;
    event.preventDefault();
    $('.default-state').removeClass('hidden');
    $('.add-number').addClass('hidden');
    $('.verificationFooter').removeClass('no-bg');
    get_value = $(this).siblings('.value-enter').val();
    $('.show-number .number').text(get_value);
    $(input).val(get_value);
    $('.value-enter').val('');
  });

  $('.code-send').click(function() {
    $('.default-state,.add-number,.verificationFooter').addClass('hidden');
    $('.processing').removeClass('hidden');
    setTimeout((function() {
      $('.processing').addClass('hidden');
      $('.step-success').removeClass('hidden');
    }), 2500);
  });

  $('.verification-step-modal').on('hidden.bs.modal', function(e) {
    $('.step-success,.add-number').addClass('hidden');
    $('.verificationFooter').removeClass('no-bg');
    $('.default-state,.verificationFooter').removeClass('hidden');
  });

  $('.resend-link').click(function() {
    event.preventDefault();
    $(this).addClass('sending');
    setTimeout((function() {
      $('.resend-link').removeClass('sending');
    }), 2500);
  });

  $('body').on('click', '.removeRow', function() {
    return $(this).closest('.get-val').remove();
  });

  setTimeout((function() {
    $('.listing-sections').addClass('active');
  }), 3000);

}).call(this);
