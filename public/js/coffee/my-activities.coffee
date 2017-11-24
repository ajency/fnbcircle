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
            $('[data-toggle="tooltip"]').tooltip()
            if Object.keys(response['data']).length == 0
                container.append '<div id="load-more-container" class="heavier sub-title text-center text-color m-t-30"><i class="fa fa-frown-o p-r-5 text-darker" aria-hidden="true"></i> No activities found</div>'
            $('#load-more-container').remove()
            for key of response['data']
                # skip loop if the property is from prototype
                if !response['data'].hasOwnProperty(key)
                    continue
                container.append '<p class="default-size mainDate"><span><i class="fa fa-calendar p-r-5" aria-hidden="true"></i> '+key+'</span></p>'
                day = key
                activity = response['data'][key]
                for act of activity
                	if !activity.hasOwnProperty(act)
                		continue
                	container.append activity[act]['html']
            console.log day
            if response['more']>0
            	container.append '<div id="load-more-container"><button type="button" id="load-more-action">Load More</button></div>'
            return

getUserActivities()

$('body').on 'click','#load-more-action', () ->
	getUserActivities()