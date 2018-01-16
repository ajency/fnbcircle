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

					We have shared the contact details of <a href="{{$listing_url}}" style="color: #ec6d4b;">{{ $listing_name }}</a> with a seeker interested in your listing.<br><br>
					Please find below details of the seeker:<br><br>

					<b>Name:</b> {{ $customer_name }} <br>
					<b>Email:</b>  {{ $customer_email }} @if($email_verified) (verified) @endif<br>
					<b>Phone Number:</b> {{ $customer_contact }} @if($contact_verified) (verified) @endif<br>
					
					@isset($customer_dashboard_url)
					<a href="{{ $customer_dashboard_url }}" style="color: #ec6d4b;font-weight: 600;" target="_blank">Click here</a> to view the profile of {{ $customer_name }}.
					@endisset
					<br>
					You may now contact the seeker directly.<br><br>


					<b>Disclaimer:</b> FnB Circle is only a intermediary platform between the business owners and seekers and hence shall neither be responsible nor liable to mediate or resolve any disputes or disagreements between the business owners and seekers.<br><br>
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