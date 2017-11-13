
$ = jQuery;

$(document).ready(function(){ 

	$('#btn_import_tags').live("click",function(){


				var get_jobs_business_tags_url = $('#laraurl').val()+"/wp-jobbusiness-tags";

				$.get(get_jobs_business_tags_url, {
			       
			       /*category: self.category,
			       limit_posts: self.limit_posts*/

			   }, function(response) { 
			   	 
			   	 	$('#tab_sync_message').find('p').html('Tags are imported successfully');
			   		$('#tab_sync_message').css('display','block');
			    

			   });

	})



})