(function() {
  var array, getAreas, populate, selectState;

  window.city = [];

  window.cities = {
    'cities': []
  };

  $('body').on('click', '.city-list a', function() {
    return getAreas($(this).attr('name'));
  });

  $('body').on('click', 'div.toggle-collapse.desk-hide', function() {
    $('.collapse').collapse('hide');
    return getAreas($(this).attr('name'));
  });

  getAreas = function(cityID) {
    var loader;
    loader = '<div class="site-loader section-loader half-loader"><div id="floatingBarsG"><div class="blockG" id="rotateG_01"></div><div class="blockG" id="rotateG_02"></div><div class="blockG" id="rotateG_03"></div><div class="blockG" id="rotateG_04"></div><div class="blockG" id="rotateG_05"></div><div class="blockG" id="rotateG_06"></div><div class="blockG" id="rotateG_07"></div><div class="blockG" id="rotateG_08"></div></div></div>';
    if (city[cityID] === true) {
      return;
    }
    $('div[name="' + cityID + '"].tab-pane').addClass('relative');
    $('div[name="' + cityID + '"].tab-pane ul.nodes').html(loader);
    $.ajax({
      type: 'post',
      url: '/get_areas',
      data: {
        'city': cityID
      },
      success: function(data) {
        var html, key;
        html = '';
        for (key in data) {
          html += '<li><label class="flex-row"><input type="checkbox" ';
          if (_.indexOf(array, data[key]['id']) !== -1) {
            html += 'checked';
          }
          html += ' class="checkbox" for="' + slugify(data[key]['name']) + '" value="' + data[key]['id'] + '" name="' + data[key]['name'] + '"><p class="lighter nodes__text" id="' + slugify(data[key]['name']) + '">' + data[key]['name'] + '</p></label></li>';
        }
        city[cityID] = true;
        $('div[name="' + cityID + '"].tab-pane ul.nodes').html(html);
      },
      error: function(request, status, error) {
        throwError();
      },
      async: false
    });
    if ($('div[name="' + cityID + '"].tab-pane ul.nodes input[type=\'checkbox\']:checked').length === $('div[name="' + cityID + '"].tab-pane ul.nodes input[type=\'checkbox\']').length) {
      return $('div[name="' + cityID + '"].tab-pane input#throughout_city').prop('checked', true);
    } else {
      $('div[name="' + cityID + '"].tab-pane ul.nodes').removeClass('disable-section');
      if ($('div[name="' + cityID + '"].tab-pane input#throughout_city').prop('checked')) {
        return $('div[name="' + cityID + '"].tab-pane input#throughout_city').prop('checked', false);
      }
    }
  };

  array = [];

  $('body').on('show.bs.modal', '#area-select', function(e) {
    var cityID;
    setTimeout((function() {
      $('.tab-pane .disable-section input[type="checkbox"]').prop("checked", true);
    }), 500);
    array = [];
    $('.city-list li').each(function(index, item) {
      if (index === 0) {
        $('.tab-pane').removeClass('active');
        $(this).addClass('active');
        return $('div[name="' + $(this).find('a').attr('name') + '"].tab-pane').addClass('active');
      } else {
        return $(this).removeClass('active');
      }
    });
    cityID = $('.city-list .active a').attr('name');
    $('div#disp-operation-areas').find('input[type=\'hidden\']').each(function(index, data) {
      array.push($(this).val());
    });
    getAreas(cityID);
    $('.tab-pane ul.nodes input[type="checkbox"]').each(function() {
      var key;
      key = $(this).val();
      if (_.indexOf(array, key) !== -1) {
        return $(this).prop("checked", true);
      } else {
        return $(this).prop("checked", false);
      }
    });
  });

  $('body').on('change', '.tab-pane.collapse ul.nodes input[type=\'checkbox\']', function() {
    var cityID;
    if (this.checked) {
      if ($(this).closest('ul.nodes').find('input[type=\'checkbox\']:checked').length === $(this).closest('ul.nodes').find('input[type=\'checkbox\']').length) {
        $(this).closest('.tab-pane').find('input#throughout_city').prop('checked', true);
        cityID = $(this).closest('div').find('input[name="city"]').attr('data-city-id');
        $('.city-list input#checkbox-' + cityID).prop('checked', true).change();
      }
    } else {
      if ($(this).closest('.tab-pane').find('input#throughout_city').prop('checked')) {
        $(this).closest('.tab-pane').find('input#throughout_city').prop('checked', false);
      }
      cityID = $(this).closest('div').find('input[name="city"]').attr('data-city-id');
      if (cities['cities'][cityID] && cities['cities'][cityID]['areas'][$(this).val()]) {
        delete cities['cities'][cityID]['areas'][$(this).val()];
      }
    }
  });

  $('body').on('click', '.fnb-modal button.operation-save', function() {
    $('.tab-pane.collapse ul.nodes input[type=\'checkbox\']:checked').each(function() {
      var parent, pid, pval;
      parent = void 0;
      pid = void 0;
      pval = void 0;
      parent = $(this).closest('div').find('input[name="city"]');
      pid = parent.attr('data-city-id');
      pval = parent.val();
      if (!cities['cities'].hasOwnProperty(pid)) {
        cities['cities'][pid] = {
          name: pval,
          id: pid,
          areas: []
        };
      }
      if ($(this)[0].checked) {
        cities['cities'][pid]['areas'][$(this).val()] = {
          'name': $(this).attr('name'),
          'id': $(this).val()
        };
      } else {
        delete cities['cities'][pid]['areas'][$(this).val()];
      }
    });
    $('.city-list li .city-checkbox:checked').each(function() {
      var pid;
      pid = $(this).siblings('a').attr('name');
      return cities['cities'][pid]['areas'].length = 0;
    });
    populate();
  });

  populate = function() {
    var k, source, template;
    k = 0;
    source = '{{#cities}}<div class="single-area single-category gray-border m-t-10 m-b-20" data-city-id="{{id}}"> <div class="row flex-row areaContainer corecat-container"> <div class="col-sm-3"> <strong class="branch text-secondary">{{name}}</strong> </div> <div class="col-sm-9"> <ul class="fnb-cat small flex-row"> {{#areas}}<li><span class="fnb-cat__title"><input type="hidden" name="areas" value="{{id}}" data-item-name="{{name}}">{{name}}<span class="fa fa-times remove"></span></span> </li>{{/areas}} </ul> </div> </div> <div class="delete-cat"> <span class="fa fa-times remove"></span> </div> </div>{{/cities}}';
    template = Handlebars.compile(source);
    return $('div#disp-operation-areas.node-list').html(template(cities));
  };

  $('body').on('click', '#disp-operation-areas .delete-cat', function() {
    var pid;
    pid = parseInt($(this).closest('.single-category').attr('data-city-id'));
    console.log(pid);
    delete cities['cities'][pid];
    $(this).closest('.single-category').remove();
    return $('.city-list input#checkbox-' + pid).prop('checked', false).change();
  });

  $('body').on('click', '#disp-operation-areas .fnb-cat .remove', function() {
    var $deletedAreaCity, aid, cid, item, list;
    item = $(this).closest('.fnb-cat__title').parent();
    list = item.parent();
    $deletedAreaCity = list.closest('.single-area').attr('data-city-id');
    $('#area-select input#checkbox-' + $deletedAreaCity).prop('checked', false);
    cid = parseInt($(this).closest('.single-category').attr('data-city-id'));
    aid = parseInt(item.find('input[type="hidden"]').val());
    console.log(cid, aid);
    delete cities['cities'][cid]['areas'][aid];
    item.remove();
    if (list.children().length === 0) {
      console.log(cid);
      return selectState($('.city-list input[type="checkbox"]#checkbox-' + cid).prop('checked', true)[0]);
    }
  });

  selectState = function(element) {
    var cityID, cityValue, city_link;
    console.log(element);
    city_link = $(element).parent().find('a');
    city_link.click();
    if (element.checked) {
      $('.tab-pane.active .nodes').addClass('disable-section');
      setTimeout((function() {
        $('.tab-pane .disable-section input[type="checkbox"]').prop("checked", true);
      }), 100);
      cityID = city_link.attr('name');
      cityValue = $('div[name="' + cityID + '"].tab-pane input[type="hidden"][name="city"]').val();
      console.log(cityID, cityValue);
      cities['cities'][cityID] = {
        name: cityValue,
        id: cityID,
        areas: []
      };
    } else {
      $('.tab-pane .disable-section input[type="checkbox"]').prop("checked", false);
      $('.tab-pane.active .nodes').removeClass('disable-section');
      console.log('unchecked');
      cityID = city_link.attr('name');
      delete cities['cities'][cityID];
    }
  };

  $('body').on('change', '.city-list input[type="checkbox"]', function() {
    return selectState(this);
  });

  $('body').on('change', '.mobile-child-selection', function() {
    var city_link;
    city_link = $(this).siblings('.toggle-collapse');
    city_link.click();
    if (this.checked) {
      setTimeout((function() {
        $('.tab-pane.in .nodes').addClass('disable-section');
        $('.tab-pane .disable-section input[type="checkbox"]').prop("checked", true);
      }), 500);
    } else {
      $('.tab-pane .disable-section input[type="checkbox"]').prop("checked", false);
      $('.tab-pane.in .nodes').removeClass('disable-section');
    }
  });

}).call(this);
