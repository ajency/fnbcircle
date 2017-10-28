@extends('layouts.email')

@section('content')
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr style="text-align: center;">
      <td style="padding: 30px; font-family: sans-serif; font-size: 16px; line-height: 24px; color: #555555;">
  

        <div style="color: rgba(123, 123, 123, 0.77);font-weight: 300;">
          <p>Hi <b style="color: #7f7f7f;"> </b></p>
         
          
        </div>

        <!-- Tips -->

        <div style="margin-top: 2em;">
         

          <div style="margin-bottom: 0.8em;">
        
            <div style="float: left;text-align: left;width: 85%;color: rgba(123, 123, 123, 0.77);font-size: 0.9em;">
          

					Please review “Job”. {{ url('/job/'.$job->getJobSlug()) }}. <br> <br>

          Details of the job: <br> <br>
          Title: <a href="{{ url('/job/'.$job->getJobSlug()) }}"  target="_blank">{{ $job->title }}</a> <br>
          Business Type: {{ $job->getJobCategoryName() }} <br>
          Job Role: {{ implode(',',$keywords) }} <br>
          @foreach($locations as $city => $locAreas)
            State : {{ $city }}<br>
            Area:  {{ implode(',',$locAreas) }}<br><br>
          @endforeach
          Company: {{ $jobCompany->title }} <br>


          @if(!empty($contactEmail) || !empty($contactMobile))
          Details of the job owner:<br><br>
         
          
          @if(!empty($contactEmail))
          Email :
            @foreach($contactEmail as $email)
              {{ $email['email'] }} (@if($email['verified']) verified @else unverified  @endif) <br>
            @endforeach
          @endif
            <br> <br> <br>
          
          @if(!empty($contactMobile))
          Phone: 
            @foreach($contactMobile as $mobile)
              {{ $mobile['mobile'] }} (@if($mobile['verified']) verified @else unverified  @endif) <br>
            @endforeach
          @endif

          @endif



            </div>
            <div style="clear: both;display:table;"></div>
          </div>
 

        </div>

      <!-- Tips ends -->

      </td>
    </tr>
  </table>
 @endsection