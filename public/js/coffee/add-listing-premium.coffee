$('input[type=radio][name=plan-select]').change ->
  if $(this).is(':checked')
    $(this).closest('.pricing-table__cards').addClass('active').siblings().removeClass 'active'
    # console.log $(this).closest('.pricing-table__cards').hasClass('free-plan')
    # $(this).closest('.selection').find('.planCaption').text 'Your current plan'
    # $(this).closest('.pricing-table__cards').siblings().find('.planCaption').text 'Click here to choose this plan'
    console.log $('input[type=radio][name=plan-select]:checked').val()
    console.log $('#pending-plan').val()
    if $('input[type=radio][name=plan-select]:checked').val() == $('#pending-plan').val() #or $(this).closest('.pricing-table__cards').hasClass('free-plan')
        # console.log 'free-plan'
        $('#submit-btn').prop('disabled',true);
    else
    	$('#submit-btn').prop('disabled',false);
  if $('#next-plan-selected').val() == '1' or $('#submit-terms-check').prop('checked') == false
    $('#submit-btn').prop('disabled',true);
  return

$('body').on 'change', '#submit-terms-check',()->
  if $('#submit-terms-check').prop('checked') == false
    $('#submit-btn').prop('disabled',true);
  else
    $('input[type=radio][name=plan-select]').change()


$('body').on 'click', '#subscribe-btn', (e) ->
  planID = $('input[type=radio][name=plan-select]:checked').val()
  planContainer = $('input[type=radio][name=plan-select]:checked').closest('.plans__footer')
  url = document.head.querySelector('[property="premium-url"]').content
  parameters = {}
  parameters['id'] = document.getElementById('listing_id').value
  parameters['type'] = 'listing'
  parameters['plan_id'] = planID
  form = $('<form></form>')
  form.attr("method", "post")
  form.attr("action", url)
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
  
	# $.ajax
	# 	type: 'post'
	# 	url: url
	# 	data:
	# 		'plan_id': planID
	# 		'type': 'listing'
	# 		'id': document.getElementById('listing_id').value
	# 	success: (data) ->
	# 		if data['status'] == '200'
	# 			$('#pending-request').html '(Request Pending)'
	# 			$('.premium-plans .planCaption').html 'Click here to choose this plan'
	# 			planContainer.find('.planCaption').html 'Your request for this plan is under process'
	# 			$('.alert-success').find('.success-message').html 'Plan request sent successfully'
	# 			$('.alert-success').addClass('active')
	# console.log 'request sent of plan'+planID

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