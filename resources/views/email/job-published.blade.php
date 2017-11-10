@extends('layouts.email')

@section('content')
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr style="text-align: center;">
      <td style="padding: 30px; font-family: sans-serif; font-size: 16px; line-height: 24px; color: #555555;">
  

        <div style="color: rgba(123, 123, 123, 0.77);font-weight: 300;">
          <p>Hi <b style="color: #7f7f7f;">{{ $ownerName}} </b></p>
         
          
        </div>

        <!-- Tips -->

        <img src="{{ asset('img/congrats.png') }}" style="margin: 2em auto;display:block;">


        <div style="margin-top: 2em;">
         

          <div style="margin-bottom: 0.8em;">
        
            <div style="float: left;text-align: left;color: rgba(123, 123, 123, 0.77);font-size: 0.9em;">
          

          <h4 style="margin: 0; text-align: center;font-weight: 600;font-size: 1.1em;color: #7d7d7d;">Congratulations!</h4><br><br>
          <a href="{{ url('/job/'.$job->getJobSlug()) }}" style="color: #ec6d4b;font-weight: 600;" target="_blank">{{ $job->title }}</a> has been approved successfully and is now live on FnB Circle.<br><br>

          Click <a href="{{ url('/job/'.$job->getJobSlug()) }}" style="color: #ec6d4b;font-weight: 600;" target="_blank">here</a> to view the job. <br><br>

          <div>
          <div style="float: left;width: 100%;text-align: center;border-bottom: 1px solid #eee;margin-bottom: 0.8em;"><img src="{{ asset('img/power-icon.png') }}" style="margin: 0.5em auto;vertical-align: middle;" width="40"><h4 style="display: inline-block;color: #7d7d7d;">Why not Go Premium?</h4><br style="clear: both;"></div>

          <b style="margin: 0.8em 0; display: block;">1. Get 10 X times more response</b>
          <b style="margin: 0.8em 0; display: block;">2. Get premium tag which makes your requirement stand out from rest.</b>
          <b style="margin: 0.8em 0;display: block;">3. Your job gets displayed on top of other non premium jobs and gets top priority. 20 extra days of visibility</b>
          <b style="margin: 0.8em 0; display: block;">4. Your job is displayed to candidates while searching for similar other jobs of other employers.</b>
          <b style="margin: 0.8em 0; display: block;">5. Go premium link(this would change send a paid/premium request to admin on the payment sbackend or send an email to admin, informing that user wants to go premium)</b>
          </div>
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