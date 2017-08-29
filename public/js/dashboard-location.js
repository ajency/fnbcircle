(function() {
  $('body').on('change', 'input[type=radio][name=locationType]', function() {
    if (this.value === '0') {
      $('.select_city').addClass('hidden');
      $('.select_city select').val("");
      $('.select_city select').removeAttr('required');
    } else if (this.value === '1') {
      $('.select_city').removeClass('hidden');
      $('.select_city select').attr('required', 'required');
      $('#add_location_modal select').val('');
    }
    $('input[type="text"]').val('');
    $('input[type="number"]').val('1');
  });

  $('#add_location_modal').on('show.bs.modal', function(e) {
    $('input#area[name="locationType"]').prop('checked', true);
    $('.select_city').removeClass('hidden');
    $('.select_city select').attr('required', 'required');
    $('#add_location_modal select').val('');
    $('input[type="text"]').val('');
    $('input[type="number"]').val('1');
  });

  $('#add_location_modal').on('click', '.save-btn', function(e) {
    var area_id, city_id, instance, name, slug, sort_order, status, type;
    e.preventDefault();
    instance = $('#locationForm').parsley();
    if (!instance.validate()) {
      return false;
    }
    city_id = $('.select_city select').val();
    area_id = "";
    type = $('input[type=radio][name=locationType]:checked').val();
    name = $('input[name="name"]').val();
    slug = $('input[name="slug"]').val();
    sort_order = $('input[name="order"]').val();
    status = $('select[name="status"]').val();
    console.log(type, city_id, name, slug, sort_order, status, area_id);
    return $.ajax({
      type: 'post',
      url: '/save-location',
      data: {
        "type": type,
        "city_id": city_id,
        "name": name,
        "slug": slug,
        "sort_order": sort_order,
        "status": status,
        "area_id": area_id
      },
      success: function(data) {
        var $status, city, isarea, iscity, node, opt, table;
        if (data.hasOwnProperty('city_id')) {
          iscity = '-<span class="hidden">no</span>';
          isarea = '<i class="fa fa-check text-success"></i><span class="hidden">Yes</span>';
          city = data['city']['name'];
        } else {
          iscity = '<i class="fa fa-check text-success"></i><span class="hidden">Yes</span>';
          isarea = '-<span class="hidden">no</span>';
          city = "";
          opt = document.createElement('option');
          opt.value = data['id'];
          opt.innerHTML = data['name'];
          document.getElementById('allcities').appendChild(opt);
        }
        if (data['status'] === 0) {
          $status = 'Draft';
        }
        if (data['status'] === 1) {
          $status = 'Published';
        }
        if (data['status'] === 2) {
          $status = 'Archived';
        }
        table = $('#datatable-locations').DataTable();
        node = table.row.add({
          "id": '<a href="#"><i class="fa fa-pencil"></i></a><span class="hidden">' + data['id'] + '</span>',
          "name": data['name'],
          "slug": data['slug'],
          "isCity": iscity,
          "isArea": isarea,
          "city": city,
          "sort_order": data['order'],
          "publish": data['published_date'],
          "update": data['updated_at'],
          "status": $status
        }).draw().node();
        return $('#add_location_modal').modal('hide');
      },
      error: function(request, status, error) {
        console.log(status);
        console.log(error);
      }
    });
  });

}).call(this);
