@extends('layouts.email')

@section('content')
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr style="text-align: center;">
      <td style="padding: 30px; font-family: sans-serif; font-size: 16px; line-height: 24px; color: #555555;">
  

        <div style="color: rgba(123, 123, 123, 0.77);font-weight: 300;">
          <p>Hi <b style="color: #7f7f7f;"> {{ $ownerName}}</b></p>
         
          
        </div>

 <!-- Tips -->

            <div style="margin-top: 2em;">
             

              <div style="margin-bottom: 0.8em;">
            
                <div style="width: 100%;color: rgba(123, 123, 123, 0.77);font-size: 0.9em;">
              

          
              
              We regret to inform you that your job <a href="{{ url('/job/'.$job->getJobSlug()) }}" style="color: #ec6d4b;" target="_blank">{{ $job->title }}</a> which was sent for review has been rejected by our team.<br><br>

              <div style="font-weight: 600;"><span style="color: #27b7b0; font-weight: 600;">NOTE:</span> Rejected jobs can be submitted for review again.</div><br>

              Please contact us for any queries or concerns.<br><br>

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