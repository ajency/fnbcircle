@extends('layouts.email')

@section('content')
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr style="text-align: center;">
      <td style="padding: 30px; font-family: sans-serif; font-size: 16px; line-height: 24px; color: #555555;">
  

        <div style="color: rgba(123, 123, 123, 0.77);font-weight: 300;">
          <p>Hi <b style="color: #7f7f7f;"> {{ $username}}  </b>,</p>
         
          
        </div>

        <!-- Tips -->

        <div style="margin-top: 2em;">
         

          <div style="margin-bottom: 0.8em;">
        
            <div style="float: left;text-align: left;width: 85%;color: rgba(123, 123, 123, 0.77);font-size: 0.9em;">
 
              Here are new job(s) matching the your job alert criteria.<br><br>
              Your current job search criteria is as follows:<br>
              @if(!empty($filters['category_name']))
              Job Category : {{ $filters['category_name'] }}
              <br><br>
              @endif

              @if(!empty($filters['keywords_id']))
              Keywords : {{ implode(',', $filters['keywords_id']) }}
              <br><br>
              @endif

              @if(!empty($filters['salary_type_text']))
              Salary : {{ moneyFormatIndia($filters['salary_lower']) }} - {{ moneyFormatIndia($filters['salary_upper']) }} {{ salarayTypeText($filters['salary_type_text']) }}
              <br><br>
              @endif

              @if(!empty($filters['experience']))
              Years of exp : {{ implode(' years ,', $filters['experience']) }} years
              <br><br>
              @endif

              @if(!empty($filters['job_type_text']))
              Job type: {{ implode(',', $filters['job_type_text']) }}
              <br><br>
              @endif

              @if(isset($filters['location_text']) && !empty($filters['location_text']))
                @foreach($filters['location_text'] as $location)
                State : {{ $location['city_name'] }} <br>
                City : {{ implode(",",$location['areas']) }}<br><br>
                @endforeach
              <br><br>
              @endif

              Here are new job(s) matching the your job alert criteria.<br>
              
              @foreach($jobs as $job)
              <div>
              <h3 title="{{ $job->title }}"><a href="{{ url('/job/'.$job->getJobSlug()) }}" class=" text-darker" target="_blank">{{ $job->title }}</a></h3>

              @if(!empty($job->getJobCompany()))
                      <p class="location__title default-size m-b-0 text-lighter">{{ $job->getJobCompany()->title }}</p>
                      @endif

                @if($job->jobPostedOn()!="")
                      <p class="m-b-0 text-lighter default-size lighter published-date"><i>Posted on: {{ $job->jobPostedOn() }}</i></p>
                       @endif

                <div >
                <!-- <img src="{{ asset('/img/power-seller.png') }}" class="img-responsive power-seller" width="120"> -->
                <a href="{{ url('/job/'.$job->getJobSlug()) }}" target="_blank" >View Job </a>
              </div>
              <hr>
              </div>
              @endforeach
              <br><br>
              Search jobs in states :<br><br>

              
              @foreach($searchUrls as $url)
                <a href="{{ $url['url'] }}">{{ $url['state'] }}<br><br>
              @endforeach
               
<br><br>
              Looking for a different kind of job?  <br>
              Modify your job search criteria <a href="{{ url('customer-dashboard') }}">modify</a><br><br>
               
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