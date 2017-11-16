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

					We have received an enquiry matching <a href="#">{{ $listing_name }}</a> on FnB Circle.<br><br>

					Please find below details of the seeker.<br>
					<label>Name:</label> {{ $customer_name }}<br>
					<label>Email:</label>  {{ $customer_email }}<br>
					<label>Phone Number:</label> {{ $customer_contact }}<br>
					<label>What describes you the best?</label><br>
						<ul>
                            @php
                                if(isset($customer_describes_best)) {
                                    $describes_best_html = generateHTML("enquiry_popup_display", $customer_describes_best);
                                } else {
                                    $describes_best_html = generateHTML("enquiry_popup_display", []);
                                }
                            @endphp
                            @foreach($describes_best_html as $index_best => $value_best)
                                {!! $value_best["html"] !!}<br>
                            @endforeach
                        </ul>
					<label>Message:</label> {{ $customer_message }}<br><br>

					<a href="{{ $customer_dashboard_url }}" style="color: #ec6d4b;font-weight: 600;" target="_blank">Click here</a> to view the profile of {{ $customer_name }}.
					<br>
					You may now contact the seeker directly.<br><br>


					Disclaimer: FnB Circle is only a intermediary platform between the business owners and seekers and hence shall neither be responsible nor liable to mediate or resolve any disputes or disagreements between the business owners and seekers.
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