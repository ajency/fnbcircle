day = ""
getUserActivities =  () ->
	container = $('#recent-activity')
	url = document.head.querySelector('[property="get-activities-url"]').content
	$.ajax
        type: 'post'
        url: url
        data:
          email : document.head.querySelector('[property="user-email"]').content
          day : day
        success: (response)->
            for key of response
                # skip loop if the property is from prototype
                if !response.hasOwnProperty(key)
                    continue
                console.log key
                container.append '<p class="default-size mainDate"><span><i class="fa fa-calendar p-r-5" aria-hidden="true"></i> '+key+'</span></p>'
                day = key
                activity = response[key]
                for act of activity
                	if !activity.hasOwnProperty(act)
                		continue
                	container.append activity[act]['html']
            return

getUserActivities()