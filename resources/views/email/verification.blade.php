@extends('layouts.email')
@section('content')

<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr style="text-align: center;background-color: #fff;">
	    <td style="padding: 30px; font-family: sans-serif; font-size: 16px; line-height: 24px; color: #555555;">
	          <div style="color: rgba(123, 123, 123, 0.77);font-weight: 300;">
	            <p>Hi <b style="color: #7f7f7f;">{{$name}}, </b></p>
	          </div>

	          <!-- Tips -->
	          <div style="margin-top: 2em;">
	        		<div style="margin-bottom: 0.8em;">        
			          	<div style="color: rgba(123, 123, 123, 0.77);font-size: 0.9em;">            
			            Please use the following code to verify {{$email}}.<br><br>

			            Code : <b>{{$code}}</b><br><br>

				            <div style="text-align: left;">
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