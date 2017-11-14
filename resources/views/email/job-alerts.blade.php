@extends('layouts.email')

@section('content')
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr style="text-align: center;">
      <td style="padding: 30px; font-family: sans-serif; font-size: 16px; line-height: 24px; color: #555555;">
  

        <div style="color: rgba(123, 123, 123, 0.77);font-weight: 300;">
          <p>Hi <b style="color: #7f7f7f;"> {{ $userName}}</b></p>
         
          
        </div>

        <!-- Tips -->

        <div style="margin-top: 2em;">
         

          <div style="margin-bottom: 0.8em;">
        
            <div style="float: left;text-align: left;width: 85%;color: rgba(123, 123, 123, 0.77);font-size: 0.9em;">
 
              Here are new job(s) matching the your job alert criteria.<br><br>
              Your current job search criteria is as follows:<br>
              Job Category*
              Keywords*
              Areas*
              Salary
              Years of exp
              Job type

              Here are new job(s) matching the your job alert criteria.<br>
              *jobs List view*

              Looking for a different kind of job?  <br>
              Modify your job search criteria *Modify Action*<br><br>
               
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