@extends('layouts.email')
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
          

					You just received an application for your job {{$job_name}}.<br><br>
					Details of the applicant:<br><br>
					Name: {{$applicant_name}}<br>
					Email: {{$applicant_email}}<br>
					Number {{$applicant_phone}}<br>
					City {{$applicant_city}}<br>

					<br><br>
					Copy of the CV of the applicant is attached with this email.<br><br>

					Regards,
					Team FnB Circle


            </div>
            <div style="clear: both;display:table;"></div>
          </div>
 

        </div>

      <!-- Tips ends -->

      </td>
    </tr>
  </table>