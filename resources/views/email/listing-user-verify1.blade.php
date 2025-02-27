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

            <p style="text-align: center;color: rgba(97, 95, 95, 0.77);font-size: 0.9em;margin-bottom: 15px;">Following listing(s) are in draft status. Please log in to your account and complete these listings.</p>


        <div style="font-size: 14px;text-align: center;background-color: #eee;padding: 15px 0;">
            <b style="display: block;padding-bottom: 5px;font-size: 14px;margin-bottom: 5px;text-transform: uppercase;border-bottom: 1px solid #c7c3c3;color: #ec6d4b;">Details of the Listing(s)</b>
            @foreach($listings as $listing)
              <b>Listing Name</b>: <a href="{{url('/listing/'.$listing['listing_reference'].'/edit')}}">{{$listing['listing_name']}}</a><br>
              <b>Type</b>: {{$listing['listing_type']}}<br>
              <b>State</b>: {{$listing['listing_state']}}<br>
              <b>City</b>: {{$listing['listing_city']}}<br>
              <br>
            @endforeach
        </div>    
        <br>
            <div style="text-align: center;color: rgba(97, 95, 95, 0.77);font-size: 0.9em;">
          Please click on the link below to activate your account and access/edit your business/listing.<br>

            <a href="{{ $confirmationLink }}" style="background-color: #ec6d4b;color: #fff;padding: 8px;width: 120px;display: block;margin: 20px auto;text-align: center;text-decoration: none;" target="_blank">Verify Email</a>
            <b style="display:block;margin-bottom: 10px;color: #616161;">OR</b>
             Copy and paste this link into your browser: {{ $confirmationLink }}
          <br><br>
          <b style="color: #616161;">NOTE</b> : The above link is valid only for 2 hours.<br><br><br>
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
