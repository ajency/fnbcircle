@extends('layouts.email')

@section('content')
 <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr style="text-align: center;background-color: #fff;">
      <td style="padding: 30px; font-family: sans-serif; font-size: 16px; line-height: 24px; color: #555555;">
  

        <div style="color: rgba(123, 123, 123, 0.77);font-weight: 300;">
          <p>Hi <b style="color: #7f7f7f;"> </b></p>
         
          
        </div>

       
     <!-- Tips -->

        <div style="margin-top: 2em;">
         

          <div style="margin-bottom: 0.8em;">
        
            <div style="width: 100%;color: rgba(123, 123, 123, 0.77);font-size: 0.9em;">
          

          Please review “Job”. <span style="color: #ec6d4b;">{{ url('/job/'.$job->getJobSlug()) }}.</span> <br> <br>

          <div style="text-align: left;">
          <div style="color:#000;font-weight: 600;margin-bottom: 0.5em;">Details of the job:</div>
          <b>Title:</b> <a href="{{ url('/job/'.$job->getJobSlug()) }}" style="color: #ec6d4b;font-weight: 600;" target="_blank">{{ $job->title }}</a> <br>
          <b>Business Type:</b> {{ $job->getJobCategoryName() }} <br>
          <b>Job Role:</b> {{ implode(',',$keywords) }} <br>
          @foreach($locations as $city => $locAreas)
            <div style="clear: both;display: table;">
              <div style="float: left;margin-right: 15px;"><b>State:</b><br> {{ $city }}<br></div>
              <div style="float: left;"><b>City:</b><br>  {{ implode(',',$locAreas) }}<br></div>
              <div style="clear: both;display:table;"></div>
            </div>
          @endforeach
          <b>Company:</b> {{ $jobCompany->title }} <br><br>


          @if(!empty($contactEmail) || !empty($contactMobile))
          <div style="color:#000;font-weight: 600;margin-bottom: 0.5em;">Details of the job owner:</div>
         
          
          @if(!empty($contactEmail))
          <b>Email:</b>
            @foreach($contactEmail as $email)
              {{ $email['email'] }} (@if($email['verified']) <span style="color: #27b7b0;font-weight: 600;">verified</span> @else <span style="color: #6b6b6b;font-weight: 600;">unverified</span>  @endif) <br>
            @endforeach
          @endif
            <br>
          
          @if(!empty($contactMobile))
          <b>Phone:</b>
            @foreach($contactMobile as $mobile)
              {{ $mobile['mobile'] }} (@if($mobile['verified']) <span style="color: #27b7b0;font-weight: 600;">verified</span> @else <span style="color: #6b6b6b;font-weight: 600;">unverified</span>  @endif) <br>
            @endforeach
          @endif

          @endif

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