@extends('layouts.email')

@section('content')
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr style="text-align: center;">
      <td style="padding: 30px; font-family: sans-serif; font-size: 16px; line-height: 24px; color: #555555;background-color: #fff;">
  

        <div style="color: rgba(123, 123, 123, 0.77);font-weight: 300;">
          <p>Hi <b style="color: #7f7f7f;">Admin </b></p>
        </div>

        <!-- Tips -->
 
        <div style="margin-top: 2em;">

          <div style="margin-bottom: 0.8em;">
        
            <div style="float: left;text-align: left;color: rgba(123, 123, 123, 0.77);font-size: 0.9em;">
          
             There is a new user registration on FnB Circle.<br><br>

            Please find below user details:<br><br>
            <b>Name:</b> {{ $user->name}}<br>
            <b>Email:</b> {{ $user->getPrimaryEmail()}} <br>
            <b>Phone number:</b> +({{ $user->getPrimaryContact()['contact_region'] }}) {{ $user->getPrimaryContact()['contact']}}<br>
            <b>What describes you the best?</b><br>

            {{ implode(', ',$user->getUserDetails->getSavedUserSubTypes()) }}<br>
            <b>State:</b> {{ $user->getUserDetails->userCity->name}} <br>
            <b>City:</b> {{ $user->getUserDetails->userArea->name}} <br>

            <br>
           
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