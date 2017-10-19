$('input[type=radio][name=plan-select]').change ->
  if $(this).is(':checked')
    $(this).closest('.pricing-table__cards').addClass('active').siblings().removeClass 'active'
    # console.log $(this).closest('.pricing-table__cards').hasClass('free-plan')
    $(this).closest('.selection').find('.planCaption').text 'Your current plan'
    $(this).closest('.pricing-table__cards').siblings().find('.planCaption').text 'Click here to choose this plan'
    if $(this).closest('.pricing-table__cards').hasClass('free-plan')
        # console.log 'free-plan'
        $('#subscribe-btn').prop('disabled',true);
    else
    	$('#subscribe-btn').prop('disabled',false);
  return

$('body').on 'click', '#subscribe-btn', (e) ->
	planID = $('input[type=radio][name=plan-select]:checked').val()
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
		console.log 'request sent of plan'+planID

$('input[type=radio][name=plan-select]').change()