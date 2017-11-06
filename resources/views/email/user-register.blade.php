@extends('layouts.email')

@section('content')
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr style="text-align: center;">
      <td style="padding: 30px; font-family: sans-serif; font-size: 16px; line-height: 24px; color: #555555;">
  

        <div style="color: rgba(123, 123, 123, 0.77);font-weight: 300;">
          <p>Hi <b style="color: #7f7f7f;">Admin </b></p>
         
          
        </div>

        <!-- Tips -->

 

 
        <div style="margin-top: 2em;">
         

          <div style="margin-bottom: 0.8em;">
        
            <div style="float: left;text-align: left;color: rgba(123, 123, 123, 0.77);font-size: 0.9em;">
          
             There is a new user registration on FnB Circle.<br><br>

            Please find below user details:<br><br>
            Name: {{ $user->name}}<br>
            Email: {{ $user->getPrimaryEmail()}} <br>
            Phone number: +({{ $user->getPrimaryContact()['contact_region'] }}) {{ $user->getPrimaryContact()['contact']}}<br>
            What describes you the best?<br>

            {{ implode(', ',$user->getUserDetails->getSavedUserSubTypes()) }}<br>
            City: {{ $user->getUserDetails->userCity->name}} <br>
            Area: {{ $user->getUserDetails->userArea->name}} <br>

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