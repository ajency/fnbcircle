@extends('layouts.email')

@section('content')
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr style="text-align: center;background-color: #fff;">
      <td style="padding: 30px; font-family: sans-serif; font-size: 16px; line-height: 24px; color: #555555;">
  

        <div style="color: rgba(123, 123, 123, 0.77);font-weight: 300;">
          <p>Hi <b style="color: #7f7f7f;"> {{ $ownername }}</b>,</p>
         
          
        </div>

        
<!-- Tips -->
        
        <img src="{{ asset('img/note.png') }}" style="margin: 2em auto 0 auto;display:block;" width="60">

        <div style="margin-top: 2em;">
         

          <div style="margin-bottom: 0.8em;">
        
            <div style="width: 100%;color: rgba(123, 123, 123, 0.77);font-size: 0.9em;">
          
          You just received an application for your job <span style="color: #ec6d4b;"><a href="{{ url('/job/'.$job->getJobSlug()) }}" target="_blank"> {{ $job->title}} </a></span>.<br><br>

          <div style="background-color: #eee;padding: 20px 0px;">
            <div style="width: 250px;text-align: left;margin: 0 auto;">
              <p style="color: #ec6d4b;text-transform: uppercase;font-weight: 600;margin-bottom: 10px;margin-top: 0;">Details of the applicant</p>
              <b>Name: </b>{{$applicant_name}}<br>
              <b>Email: </b>{{$applicant_email}}<br>
              <b>Number: </b>+({{$country_code}}){{$applicant_phone}}<br>
              <b>City: </b>{{$applicant_city}}<br>
            </div>
          </div>

         
            <br>
            @if($resumeId)
            Copy of the CV of the applicant is attached with this email.<br><br>
            @endif
            <br>

            <div style="text-align: left;">
            Regards,<br>
            Team FnB Circle
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