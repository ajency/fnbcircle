@extends('layouts.email')

@section('content')
  <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr style="text-align: center;">
      <td style="padding: 30px; font-family: sans-serif; font-size: 16px; line-height: 24px; color: #555555;background-color: #fff;">
  

        <div style="color: rgba(123, 123, 123, 0.77);font-weight: 300;">
          <p>Hi <b style="color: #7f7f7f;">{{ $request['name'] }} </b></p>
         
          
        </div>

        <!-- Tips -->


        <div style="margin-top: 2em;">
         

          <div style="margin-bottom: 0.8em;">
        
            <div style="float: left;text-align: left;color: rgba(123, 123, 123, 0.77);font-size: 0.9em;">
          
             You are now added as the {{ implode(', ',$userRoles)}} on FnB Circle. <br><br>

            Please use the following credentials to login. <br>
            <b>Email:</b> {{ $request['email'] }}<br>
            <b>Password:</b> {{ $request['password'] }}<br>

            If you wish to change the password, you will have to login using the existing credentials and you will be redirected to the change password screen under your profile. 
            <a href="{{ url('/profile/basic-details') }}" style="color: #ec6d4b;">click here</a> to change your password.
     

           <br><br>
            
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