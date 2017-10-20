$('input[type=radio][name=plan-select]').change ->
  if $(this).is(':checked')
    $(this).closest('.pricing-table__cards').addClass('active').siblings().removeClass 'active'
    # console.log $(this).closest('.pricing-table__cards').hasClass('free-plan')
    # $(this).closest('.selection').find('.planCaption').text 'Your current plan'
    # $(this).closest('.pricing-table__cards').siblings().find('.planCaption').text 'Click here to choose this plan'
    if $(this).closest('.pricing-table__cards').hasClass('free-plan')
        # console.log 'free-plan'
        $('#subscribe-btn').prop('disabled',true);
    else
    	$('#subscribe-btn').prop('disabled',false);
  return

$('body').on 'click', '#subscribe-btn', (e) ->
	planID = $('input[type=radio][name=plan-select]:checked').val()
	planContainer = $('input[type=radio][name=plan-select]:checked').closest('.plan__footer')
	if(confirm('are you sure?'))
		url = document.head.querySelector('[property="premium-url"]').content
		$.ajax
			type: 'post'
			url: url
			data:
				'plan_id': planID
				'type': 'listing'
				'id': document.getElementById('listing_id').value
			success: (data) ->
				if data['status'] == '200'
					$('#pending-request').html '(Request Pending)'
					$('#subscribe-btn').remove()
					# planContainer.
					$('.alert-success').find('.success-message').html 'Plan request sent successfully'
					$('.alert-success').addClass('active')
					
		console.log 'request sent of plan'+planID

window.validatePremium = () ->
  parameters = {}
  parameters['listing_id'] = document.getElementById('listing_id').value
  parameters['step'] = 'business-premium'
  if window.submit ==1
    parameters['submitReview'] = 'yes'
  if window.archive ==1
    parameters['archive'] = 'yes'
  if window.publish ==1
    parameters['publish'] = 'yes'
  form = $('<form></form>')
  form.attr("method", "post")
  form.attr("action", "/listing")
  $.each parameters, (key, value) ->
    field = $('<input></input>');
    field.attr("type", "hidden");
    field.attr("name", key);
    field.attr("value", value);
    form.append(field);
    console.log key + '=>' + value
    return
  $(document.body).append form
  form.submit()
  return


$('input[type=radio][name=plan-select]').change()