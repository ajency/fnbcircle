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
						Thank you for choosing us. It’s great to have you on-board.<br><br>
						Please note your account is registered with us, but is not active.<br>
						<label><a href="{{ $confirmationLink }}" style="color: #ec6d4b;font-weight: 600;" target="_blank">Click here</a></label> to activate and set up your account.<br><br>

						Here’s what you can do on FnB Circle.<br><br>

						<p><b>Hospitality News</b><br>
						Stay upto date and profit from the latest Hospitality industry News, Trends and Research.</p><br><br>

						<p><b>Vendor/Supplier Directory</b><br>
						Find the best Vendors/Suppliers for your business or make them come to you.</p><br><br>

						<p><b>Hospitality Jobs Portal</b><br>
						Hire the best talent to manage your business, or find the most suitable Hospitality Job for yourself.</p><br><br>

						<p><b>Business promotion for Vendors/Suppliers &amp; Service providers</b><br>
						Discover new business opportunities and promote your business to find new customers.</p><br><br>

						<p>I hope you have a wonderful time with FnB Circle.<br>
						If you have any queries or concerns, feel free to reach out to us at nutan@ajency.in </p><br><br>

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