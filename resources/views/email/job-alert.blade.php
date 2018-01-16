@extends('layouts.email')

@section('content')
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr style="text-align: center;">
      <td style="padding: 30px; font-family: sans-serif; font-size: 16px; line-height: 24px; color: #555555;background-color: #fff;">
  

        <div style="color: rgba(123, 123, 123, 0.77);font-weight: 300;">
          <p>Hi <b style="color: #7f7f7f;"> {{ $username}}  </b>,</p>
         
          
        </div>

        <!-- Tips -->

        <div style="margin-top: 2em;">
         

          <div style="margin-bottom: 0.8em;">
        
            <div style="text-align: left;color: rgba(123, 123, 123, 0.77);font-size: 0.9em;">
 
              Here are new job(s) matching your job alert criteria.<br><br>
              <b>Your current job search criteria is as follows:</b><br><br>

              @if(!empty($filters['category_name']))
              <b>Job Category</b> : {{ $filters['category_name'] }}
              <br><br>
              @endif

              @if(!empty($filters['keywords_id']))
              <b>Job Roles</b> : {{ implode(',', $filters['keywords_id']) }}
              <br><br>
              @endif

             @if(isset($filters['location_text']) && !empty($filters['location_text']))
               <div style="clear: both;display: table;">
                  <div style="float: left;margin-right: 15px;min-width: 80px;"><b>State:</b></div>
                  <div style="float: left;"><b>City:</b></div><br>
                   @foreach($filters['location_text'] as $location)
                      <div style="float: left;margin-right: 15px;min-width: 80px;">{{ $location['city_name'] }}<br></div>
                      <div style="float: left;">   {{ implode(",",$location['areas']) }}<br></div>
                      <div style="clear: both;display:table;"></div>
                  @endforeach
                  <div style="clear: both;display:table;"></div>
                </div>
                <br>
              @endif


              @if(!empty($filters['salary_type_text']))
              <b>Salary</b> : Rs {{ moneyFormatIndia($filters['salary_lower']) }} - Rs {{ moneyFormatIndia($filters['salary_upper']) }} {{ salarayTypeText($filters['salary_type_text']) }}
              <br><br>
              @endif

              @if(!empty($filters['experience']))
              <b>Years of Experience</b> : {{ implode(' years ,', $filters['experience']) }} years
              <br><br>
              @endif

              @if(!empty($filters['job_type_text']))
              <b>Job type</b> : {{ implode(',', $filters['job_type_text']) }}
              <br><br>
              @endif

              
              <p>If you don’t want to receive more Job Alerts then visit your dashboard and uncheck Send Alerts checkbox.</p>
  
              <br>
              
              @foreach($jobs as $job)
              <div style="padding: 1em;border: 1px solid #ddd;margin: 1em auto;width: 80%;font-size: 0.95em;background-color: rgba(255, 240, 212, 0.6);">
                <h3 title="{{ $job->title }}" style="margin-top: 0;"><a href="{{ url('/job/'.$job->getJobSlug()) }}" class=" text-darker" target="_blank" style="color: #ec774b;">{{ $job->title }}</a></h3>

                @if(!empty($job->getJobCompany()))
                        <p class="location__title default-size m-b-0 text-lighter">{{ $job->getJobCompany()->title }}</p>
                        @endif

                  @if($job->jobPostedOn()!="")
                        <p class="m-b-0 text-lighter default-size lighter published-date"><i>Posted on: {{ $job->jobPostedOn() }}</i></p>
                         @endif

                  <div style=" text-align: center;">
                    <a href="{{ url('/job/'.$job->getJobSlug()) }}" target="_blank" style="background-color: #ec6d4b;color: #fff;padding: 0.3em 0.5em;text-decoration: none;margin: 0.8em 0;font-size:13px;display: inline-block;min-width: 80px;">View Job </a>
                  </div>
              </div>
              @endforeach
              <br><br>
              Search jobs in states :<br><br>

              
              @foreach($searchUrls as $url)
                <a href="{{ $url['url'] }}" style="color: #ec774b;">{{ $url['state'] }}</a><br>
              @endforeach
               
              <br><br>
            
            <div style="text-align: center;margin:0.8em 0;">
                Looking for a different kind of job?
                Modify your job search criteria <br>
                 <a href="{{ url('customer-dashboard') }}" style="background-color: #ec6d4b;color: #fff;padding: 0.3em 0.5em;text-decoration: none;margin: 0.8em 0;display: inline-block;min-width: 80px;text-align: center;font-size: 13px;">Modify</a><br><br>

              </div>
               
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