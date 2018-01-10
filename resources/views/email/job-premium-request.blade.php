@extends('layouts.email')

@section('content')
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr style="text-align: center;">
      <td style="padding: 30px; font-family: sans-serif; font-size: 16px; line-height: 24px; color: #555555;">
  

        <div style="color: rgba(123, 123, 123, 0.77);font-weight: 300;">
          <p>Hi <b style="color: #7f7f7f;"> Admin </b>,</p>
         
          
        </div>

        <!-- Tips -->

        <div style="margin-top: 2em;">
         

          <div style="margin-bottom: 0.8em;">
        
            <div style="float: left;text-align: left;width: 85%;color: rgba(123, 123, 123, 0.77);font-size: 0.9em;">
 
              

          The owner of job <a href="{{ url('/job/'.$job->getJobSlug()) }}" style="color: #ec6d4b;" target="_blank">{{ $job->title }}</a> has sent a request for paid plan.<br><br>
          Details as follows:<br><br>

          Job Name:{{ $job->title }}<br>
          Plan:{{ $planname }}<br>
          Job Status:{{ $job->getJobStatus()}}<br>
          Owner Name:{{ $user->name}}<br>
          Email: {{ $user->getPrimaryEmail()}}<br>
          Phone: +({{ $user->getPrimaryContact()['contact_region'] }}) {{ $user->getPrimaryContact()['contact']}}<br><br>


               
              Regards,<br>
              Team FnB Circle<br>





            </div>
            <div style="clear: both;display:table;"></div>
          </div>
 

        </div>

      <!-- Tips ends -->

      </td>
    </tr>
  </table>
 @endsection