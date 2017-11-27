var change = 0;
var submit = 0;
var archive = 0;
var publish = 0;

$('body').on('change', 'input', function() {
    change = 1;
});
$('body').on('change', 'select', function() {
    change = 1;
});
$('body').on('change', 'textarea', function() {
    change = 1;
});

function listingInformation() {
    var form = $('<form></form>');
    form.attr("method", "post");
    form.attr("action", "/listing");
    var contacts = {};
    var value = document.getElementsByClassName("contact-input");
    var i = 0;
    while (i < value.length) {
        if (value[i].value != "") {
            var contact = {};
            if ($(value[i]).closest('.business-contact').hasClass('business-email')) var type = 1
            if ($(value[i]).closest('.business-contact').hasClass('business-phone')) var type = 2
            if ($(value[i]).closest('.business-contact').hasClass('contact-info-landline')) var type = 3
            $.ajax({
                type: 'post',
                url: '/contact_save',
                data: {
                    'value': value[i].value,
                    'country' : $(value[i]).intlTelInput("getSelectedCountryData")['dialCode'],
                    'type': type,
                    'id': $(value[i]).closest('.contact-container').find('.contact-id').val()
                },
                success: function(data) {
                    $(value[i]).closest('.business-contact').find('.contact-id').val(data['id']);
                    console.log(data['id']);
                },
                failure: function(){
                    $('.fnb-alert.alert-failure div.flex-row').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>Oh snap! Some error occurred. Please <a href="/login">login</a> or refresh your page');
                    $('.alert-failure').addClass('active');
                },
                async: false
            });
            contact['id'] = $(value[i]).closest('.contact-container').find('.contact-id').val();
            contact['country'] =  $(value[i]).intlTelInput("getSelectedCountryData")['dialCode'];
            contact['visible'] = ($(value[i]).closest('.contact-container').find('.toggle__check').prop('checked')) ? "1" : "0";
            // contact['visible'] = $(value[i]).closest('.contact-container').find('.contact-visible').prop('checked');
            contact['value'] = $(value[i]).val()
            contacts[i] = contact;
            console.log(contact)
        }
        i++;
    }
    var parameters = {};
    parameters['listing_id'] = document.getElementById('listing_id').value;
    parameters['step'] = 'business-information';
    parameters['change'] = change;
    parameters['title'] = document.getElementsByName("listing_title")[0].value;
    var type = document.getElementsByName("business_type");
    for (var i = 0; i < type.length; i++) {
        if (type[i].checked) {
            parameters['type'] = type[i].value;
        }
    }
    // parameters['type'] = '11';
    parameters['primary_email'] = (document.getElementsByName("primary_email")[0].checked) ? "1" : "0";
    parameters['primary_phone'] = (document.getElementsByName("primary_phone")[0].checked) ? "1" : "0";
    parameters['area'] = $('.area select').val();
    parameters['contacts'] = JSON.stringify(contacts);
    if (submit == 1) {
        parameters['submitReview'] = 'yes';
    }
    if (archive == 1) {
        parameters['archive'] = 'yes';
    }
    if (publish == 1) {
        parameters['publish'] = 'yes';
    }
    $.each(parameters, function(key, value) {
        var field = $('<input></input>');
        field.attr("type", "hidden");
        field.attr("name", key);
        field.attr("value", value);
        form.append(field);
        console.log(key + '=>' + value);
    });
    $(document.body).append(form);
    form.submit();
}

function validateListing(event) {
    var instance = $('#info-form').parsley();
    // if (checkDuplicates()) return false;
    console.log(true);
    if (!instance.validate()) return false;
    $('.section-loader').removeClass('hidden');
    // console.log($('#listing_id').val());
    if ($('#listing_id').val() == "") {
        // console.log(true);
        var title = document.getElementsByName("listing_title")[0].value;
        var value = document.getElementsByName("contacts");
        var cont = [];
        var i = 0;
        while (i < value.length) {
          var type;
          if (value[i].value === '') {
            i++;
            continue;
          }
          if ($(value[i]).closest('.business-contact').hasClass('business-email')) {
            type = 'email';
          }
          if ($(value[i]).closest('.business-contact').hasClass('business-phone')) {
            type = 'mobile';
          }
          if ($(value[i]).closest('.business-contact').hasClass('contact-info-landline')) {
            type = 'landline';
          }

          cont.push(
            {
              'value': value[i].value,
              'country': $(value[i]).intlTelInput("getSelectedCountryData")['dialCode'],
              'type': type
            }
          );
          i++;
        }
          json = JSON.stringify(cont);
        // console.log(json);
        $.ajax({
            type: 'post',
            url: '/duplicates',
            data: {
                'title': title,
                'contacts': json
            },
            success: function(data) {
                console.log(data);
                var myvar = '';
                for (var k in data['similar']) {
                    myvar += '<div class="list-row flex-row">' + '<div class="left">' + '<h5 class="sub-title text-medium text-capitalise list-title">' + data['similar'][k]['name'] + '</h5>';
                    for (var j in data['similar'][k]['messages']) {
                        myvar += '<p class="m-b-0 text-color text-left default-size">' + '<i class="fa fa-exclamation-circle p-r-5 text-primary" aria-hidden="true"></i> <span class="lighter">' + data['similar'][k]['messages'][j] + '</span>' + '</p>';
                    }
                    myvar += '</div>' + '<div class="right">'; 
                    if(data['type'] == 'external') {
                        myvar +=  '<div class="capsule-btn flex-row">' + '<a href="claim/" class="btn fnb-btn outline full border-btn no-border claim text-danger">Claim</a>' + '<a href="claim/" class="btn fnb-btn outline full border-btn no-border delete">Delete</a>' + '</div>' ;
                    }
                    myvar += '</div>' + '</div>';
                    
                }
                $('.list-entries').html(myvar);
                if (myvar != '') {
                    $('.section-loader').addClass('hidden');
                    $('#duplicate-listing').modal('show');
                    $('#duplicate-listing').on('click','#skip-duplicates', function(e) {
                        event.preventDefault();
                        $('.section-loader').removeClass('hidden');
                        listingInformation();
                    });
                } else {
                    event.preventDefault();
                    $('.section-loader').removeClass('hidden');
                    listingInformation();
                }
            },
            error: function(request, status, error){
                    $('.fnb-alert.alert-failure div.flex-row').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i><div>Oh snap! Some error occurred. Please <a href="/login" class="secondary-link">login</a> or refresh your page</div>');
                    $('.alert-failure').addClass('active');
                }
        });
    } else {
        // console.log(true);
        event.preventDefault();
        listingInformation();
    }
    event.preventDefault();
}
$('#info-form').on('keypress', function(e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) {
        e.preventDefault();
        temp=document.activeElement;
          if ($(temp).hasClass('blur')) {
              $(temp).blur();
            }
        if ($(temp).hasClass('allow-newline')) {
              $(temp).val($(temp).val()+'\n');
              e.preventDefault();
            }
        return false;
    }
});