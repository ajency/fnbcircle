@extends('layouts.email')

@section('content')
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr style="text-align: center;">
      <td style="padding: 30px; font-family: sans-serif; font-size: 16px; line-height: 24px; color: #555555;">
  

        <div style="color: rgba(123, 123, 123, 0.77);font-weight: 300;">
          <p>Hi <b style="color: #7f7f7f;"> {{ $ownername }} </b></p>
         
          
        </div>

        
<!-- Tips -->
        
        <img src="/img/note.png" style="margin: 2em auto;display:block;">

        <div style="margin-top: 2em;">
         

          <div style="margin-bottom: 0.8em;">
        
            <div style="width: 100%;color: rgba(123, 123, 123, 0.77);font-size: 0.9em;">
          

          You just received an application for your job <span style="color: #27b7b0;">{{$job_name}}.</span><br><br>
          Details of the applicant:<br>
          <b>Name:</b> {{$applicant_name}}<br>
          <b>Email:</b> {{$applicant_email}}<br>
          <b>Number: </b>{{$applicant_phone}}<br>
          <b>City: </b>{{$applicant_city}}<br>

          <br>
          Copy of the CV of the applicant is attached with this email.<br><br>
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