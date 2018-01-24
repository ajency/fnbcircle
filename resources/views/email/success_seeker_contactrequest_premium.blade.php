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
						Thank you for showing your interest in <a href="{{$listing_url}}" style="color: #ec6d4b;">{{$listing->title}} </a>. We have shared your contact details with the owner of this listing. They would contact you soon.<br><br>
						
						Please find below contact details of the listing.<br><br>

						<b>Listing Name:</b> {{$listing->title}} <br>

						@php
							$contacts = $listing->getAllContacts();
						@endphp
						@if(count($contacts['email']))				
							<b>Email:</b>
							@foreach($contacts['email'] as $email)
								<a href="mailto:{{$email['email']}}"> {{$email['email']}} </a> @if($email['is_verified'])(verified) @else (unverified) @endif <br>
							@endforeach
						@endif
						@if(count($contacts['mobile']))
							<b>Phone:</b>
							@foreach($contacts['mobile'] as $mobile)
								<a href="tel:{{$mobile['contact_region']}}{{$mobile['contact']}}"> +{{$mobile['contact_region']}}-{{$mobile['contact']}} </a> @if($mobile['is_verified'])(verified) @else (unverified) @endif <br>
							@endforeach
						@endif
						@if(count($contacts['landline']))
							<b>Landline:</b>
							@foreach($contacts['landline'] as $mobile)
								<a href="tel:{{$mobile['contact_region']}}{{$mobile['contact']}}"> +{{$mobile['contact_region']}}-{{$mobile['contact']}} </a> @if($mobile['is_verified'])(verified) @else (unverified) @endif <br>
							@endforeach	
						@endif

						<br><br>

						You may now contact the owner directly.
						When you contact the listing, don't forget to mention that you found it on FnB Circle.

						<br><br>

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