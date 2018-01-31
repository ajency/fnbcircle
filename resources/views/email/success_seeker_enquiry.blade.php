@extends('layouts.email')

@section('content')
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr style="text-align: center;">
		<td style="padding: 30px; font-family: sans-serif; font-size: 16px; line-height: 24px; color: #555555;">
	        <div style="color: rgba(123, 123, 123, 0.77);font-weight: 300;">
	          <p>Hi <b style="color: #7f7f7f;">{{ $name }} </b></p>
	        </div>

	        <!-- Tips -->
	        <div style="margin-top: 2em;">
				<div style="margin-bottom: 0.8em;">        
					<div style="float: left;text-align: left;color: rgba(123, 123, 123, 0.77);font-size: 0.9em;">
						@if(isset($is_premium) && $is_premium)
							Thank you for showing your interest in <a href="{{ $listing_url }}" target="_blank">{{ $listing_name }}</a>. Your details have been shared via email and sms with the listing owner of this business. They would contact you soon.<br>
						@else
							Thank you for showing your interest.<br><br>
							We have sent your enquiry details via email and sms to <a href="{{ $listing_url }}" target="_blank" style="color: #ec6d4b;">{{ $listing_name }}</a> &amp; few similar businesses matching your requirements. They would contact you soon.<br><br>
						@endif
						
						@if(isset($is_premium) && $is_premium)
							<b>Listing Details:</b><br>
						@else
							Based on your enquiry, here are a few similar listings: <br><br>
						@endif

						@if(isset($listing_data))
							@foreach($listing_data as $listing_index => $listing_value)
								Name:  <a href="{{ isset($listing_value['link']) ? $listing_value['link'] : $listing_url }}" target="_blank">{{ isset($listing_value['name']) ? $listing_value['name'] : $listing_name }}</a><br>
								Type:  {{ isset($listing_value['type']) ? $listing_value['type']['name'] : '' }}<br>
							 	(Featured Indication)
							 	@if(isset($listing_value['cores']) && sizeof($listing_value['cores']) > 0)
									Core Categories:<br>
										@foreach($listing_value['cores'] as $core_index => $core_value)
											{{ $core_value["name"] }}{{ $core_index < (sizeof($listing_value['cores']) - 1) ? ', ' : '' }}
										@endforeach
								@endif
								<br>
								@if(isset($listing_value['operation_areas']) && sizeof($listing_value['operation_areas']) > 0)
									Area(s) of Operation:<br>
										@foreach($listing_value['operation_areas'] as $operations_index => $operations_value)
											{{ $operations_value["city"]["name"] }}<br>
											@foreach($operations_value["areas"] as $operation_area_index => $operation_area_value)
												{{ $operation_area_value["name"] }}{{ $operation_area_index < (sizeof($operations_value["areas"]) - 1) ? ', ' : '' }}
											@endforeach
											<br>
										@endforeach
								@endif
								Rating: -<br>
							@endforeach
						@endif

					
						<div style="font-size: 0.9em;"><b>Disclaimer:</b> FnB Circle is only a intermediary platform between the business owners and seekers and hence shall neither be responsible nor liable to mediate or resolve any disputes or disagreements between the business owners and seekers.</div>
						<div>
	          				Regards,<br>
	          				Team FnB Circle<br>
	          			</div>
					</div>
	            	<div style="clear: both;display:table;"></div>
	          	</div>
	        </div>
	      <!-- Tips ends -->
		</td>
    </tr>
</table>
@endsection