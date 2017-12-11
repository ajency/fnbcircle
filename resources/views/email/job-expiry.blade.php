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
              Your job <a href="{{ url('/job/'.$job->getJobSlug()) }}" style="color: #ec6d4b;" target="_blank">{{ $job->title }}</a> has expired and is no longer listed on FnB Circle. <br>
              Have you filled the position yet? Still looking for appropriate candidates? <br>
              Relist your job now!!<br><br>

              Relisting the job will make the job visible on FnB Circle, so your job will receive more applications.
              <a href="{{ url('/job/'.$job->getJobSlug()) }}" target="_blank" style="background-color: #ec6d4b;color: #fff;padding: 8px;width: 120px;display: block;margin: 20px auto;text-align: center;text-decoration: none;">Relist Job</a>
               
              <br><br>

         

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