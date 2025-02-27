@extends('layouts.email')

@section('content')
  <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr style="text-align: center;">
      <td style="padding: 30px; font-family: sans-serif; font-size: 16px; line-height: 24px; color: #555555;background-color: #fff;">
  
      <img src="{{ asset('img/email-processing.png') }}" style="margin: 0 auto;display:block;">

        <div style="color: rgba(97, 95, 95, 0.77);font-weight: 300;">
          <p>Hi <b style="color: #7f7f7f;">{{ $name}} </b></p>
        </div>

        <!-- Tips -->
        <div style="margin-top: 2em;">
          <div style="margin-bottom: 0.8em;">
        
            <div style="text-align: center;color: rgba(97, 95, 95, 0.77);font-size: 0.9em;">
 
          To finish setting up this FnB Circle account, we need to make sure this email address is yours.<br>

            <a href="{{ $confirmationLink }}" style="background-color: #ec6d4b;color: #fff;padding: 8px;width: 120px;display: block;margin: 20px auto;text-align: center;text-decoration: none;" target="_blank">Verify Email</a>
            <b style="display:block;margin-bottom: 10px;color: #616161;">OR</b>
             Copy and paste this link into your browser: {{ $confirmationLink }}
          <br><br>
          <b style="color: #616161;">NOTE</b> : The above link is valid only for 2 hours.<br><br><br>
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