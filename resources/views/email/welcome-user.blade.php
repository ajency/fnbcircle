@extends('layouts.email')

@section('content')
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr style="text-align: center;">
      <td style="padding: 30px; font-family: sans-serif; font-size: 16px; line-height: 24px; color: #555555;">
  

        <div style="color: rgba(123, 123, 123, 0.77);font-weight: 300;">
          <p>Hi <b style="color: #7f7f7f;">{{ $name}} </b></p>
         
          
        </div>

        <!-- Tips -->

 

 
        <div style="margin-top: 2em;">
         

          <div style="margin-bottom: 0.8em;">
        
            <div style="float: left;text-align: left;color: rgba(123, 123, 123, 0.77);font-size: 0.9em;">
          

         
         Thank you for choosing us. It’s great to have you on-board.<br><br>

        Here’s what you can do on FnB Circle.<br><br>

        Hospitality News<br>
        Stay upto date and profit from the latest Hospitality industry News, Trends and Research.<br><br>

        Vendor/Supplier Directory<br>
        Find the best Vendors/Suppliers for your business or make them come to you.<br><br>

        Hospitality Jobs Portal<br>
        Hire the best talent to manage your business, or find the most suitable Hospitality Job for yourself.<br><br>


        Business promotion for Vendors/Suppliers & Service providers<br>
        Discover new business opportunities and promote your business to find new customers.<br><br>


        I hope you have a wonderful time with FnB Circle.<br>
        If you have any queries or concerns, feel free to reach out to us at {{ $contactEmail }}

 <br><br>

           
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