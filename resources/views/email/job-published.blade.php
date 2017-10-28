@extends('layouts.email')

@section('content')
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr style="text-align: center;">
      <td style="padding: 30px; font-family: sans-serif; font-size: 16px; line-height: 24px; color: #555555;">
  

        <div style="color: rgba(123, 123, 123, 0.77);font-weight: 300;">
          <p>Hi <b style="color: #7f7f7f;">{{ $ownerName}} </b></p>
         
          
        </div>

        <!-- Tips -->

        <div style="margin-top: 2em;">
         

          <div style="margin-bottom: 0.8em;">
        
            <div style="float: left;text-align: left;width: 85%;color: rgba(123, 123, 123, 0.77);font-size: 0.9em;">
          

          Congratulations!<br><br>
          <a href="{{ url('/job/'.$job->getJobSlug()) }}"  target="_blank">{{ $job->title }}</a> has been approved successfully and is now live on FnB Circle.<br><br>

          Click <a href="{{ url('/job/'.$job->getJobSlug()) }}"  target="_blank">here</a> to view the job. <br><br>

          Why notnot Go Premium?<br>
          Get 10 X times more response<br>
          Get premium tag which makes your requirement stand out from rest.<br>
          Your job gets displayed on top of other non premium jobs and gets top priority.
          20 extra days of visibility<br>
          Your job is displayed to candidates while searching for similar other jobs of other employers.<br>
          Go premium link(this would change send a paid/premium request to admin on the payment sbackend or send an email to admin, informing that user wants to go premium)<br><br>

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