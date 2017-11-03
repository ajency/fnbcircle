@extends('layouts.email')

@section('content')
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr style="text-align: center;">
      <td style="padding: 30px; font-family: sans-serif; font-size: 16px; line-height: 24px; color: #555555;">
  

        <div style="color: rgba(123, 123, 123, 0.77);font-weight: 300;">
          <p>Hi <b style="color: #7f7f7f;">{{ $request['name'] }} </b></p>
         
          
        </div>

        <!-- Tips -->

 

 
        <div style="margin-top: 2em;">
         

          <div style="margin-bottom: 0.8em;">
        
            <div style="float: left;text-align: left;color: rgba(123, 123, 123, 0.77);font-size: 0.9em;">
          
             You are now added as the {{ implode(', ',$userRoles)}} on FnB Circle. <br><br>

            Please use the following credentials to login. <br><br>
            Email: {{ $request['email'] }}<br>
            Password: {{ $request['password'] }}<br><br>

            If you wish to change the password, please <a href="#">click here</a>.


 <br><br>

           
            <br>
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