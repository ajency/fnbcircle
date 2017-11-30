@extends('layouts.email')

@section('content')
  <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr style="text-align: center;">
      <td style="padding: 30px; font-family: sans-serif; font-size: 16px; line-height: 24px; color: #555555;background-color: #fff;">

      <img src="{{ asset('img/email-processing.png') }}" style="margin: 0 auto;display:block;">

        <div style="color: rgba(97, 95, 95, 0.77);font-weight: 300;">
          <p>Hi, </p>
        </div>

        <!-- Tips -->
        <div style="margin-top: 2em;">
          <div style="margin-bottom: 0.8em;">

            We have added listing {{$listing_name}} under your account on FnB Circle.<br>
<br>
            Details of the Listing:<br>
            Listing Name:{{$listing_name}}<br>
            Type:{{$listing_type}}<br>
            State:{{$listing_state}}<br>
            City:{{$listing_city}}<br>
            
            <div style="text-align: center;color: rgba(97, 95, 95, 0.77);font-size: 0.9em;">
          Please click on the link below to activate your account and access/edit your business/listing.<br>

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
