@extends('layouts.email')

@section('content')
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr style="text-align: center;">
      <td style="padding: 30px; font-family: sans-serif; font-size: 16px; line-height: 24px; color: #555555;background-color: #fff;">
  

        <div style="color: rgba(123, 123, 123, 0.77);font-weight: 300;">
          <p>Hi <b style="color: #7f7f7f;">{{ $name}} </b></p>
         
          
        </div>

        <!-- Tips -->

 
        <div style="margin-top: 2em;">
         

          <div style="margin-bottom: 0.8em;">
        
            <div style="float: left;text-align: center;color: rgba(123, 123, 123, 0.77);font-size: 0.9em;">
          

         
        Thank you for choosing us. It’s great to have you on-board.<br><br>

        <p style="color: #e86b21;font-weight: 600;border-bottom: 1px solid #eee;padding-bottom: 10px;">Here’s what you can do on FnB Circle.<br></p>
        <div>
        <div>
          <div style="width: 50%;float: left;text-align:center;">
            <img src="/img/hospitality.png" style="margin:0 auto;display:block;" width="70">
            <b style="color: #000;margin: 5px 0;display: block;">Hospitality News</b>
            Stay upto date and profit from the latest Hospitality industry News, Trends and Research.<br><br>
          </div>
          <div style="width: 50%;float: left;text-align:center;">
            <img src="/img/vendor.png" style="margin:0 auto;display:block;" width="70">
            <b style="color: #000;margin: 5px 0;display: block;">Vendor/Supplier Directory</b>
            Find the best Vendors/Suppliers for your business or make them come to you.<br><br>
          </div>
          <div style="clear:both;"></div>
          <div style="width: 50%;float: left;text-align:center;">
            <img src="/img/jobs-2.png" style="margin:0 auto;display:block;" width="70">
            <b style="color: #000;margin: 5px 0;display: block;">Hospitality Jobs Portal</b>
            Hire the best talent to manage your business, or find the most suitable Hospitality Job for yourself.<br><br>
          </div>
          <div style="width: 50%;float: left;text-align:center;">
            <img src="/img/promotion.png" style="margin:0 auto;display:block;" width="70">
            <b style="color: #000;margin: 5px 0;display: block;">Business promotion for Vendors/Suppliers &amp; Service providers</b>
            Discover new business opportunities and promote your business to find new customers.<br><br>
          </div>
          <div style="clear:both;"></div>
        </div>
        <br>
          I hope you have a wonderful time with FnB Circle.<br>
          If you have any queries or concerns, feel free to reach out to us at {{ $contactEmail }}
          <br><br>
           
            <br>
          <div style="text-align:left;">
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