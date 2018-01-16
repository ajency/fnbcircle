@extends('layouts.email')
@section('content')

<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr style="text-align: center;background-color: #fff;">
      <td style="padding: 30px; font-family: sans-serif; font-size: 16px; line-height: 24px; color: #555555;">
  

        <div style="color: rgba(123, 123, 123, 0.77);font-weight: 300;">
          <p>Hi <b style="color: #7f7f7f;">{{$owner_name}} </b>,</p>
         
          
        </div>

        <!-- Tips -->

        <img src="{{ asset('img/congrats.png') }}" style="margin: 2em auto;display:block;" width="100">


        <div style="margin-top: 2em;">
         

          <div style="margin-bottom: 0.8em;">
        
            <div style="float: left;text-align: left;color: rgba(123, 123, 123, 0.77);font-size: 0.9em;">
          

          <h4 style="margin: 0; text-align: center;font-weight: 600;font-size: 1.1em;color: #7d7d7d;">Congratulations!</h4><br>

          <p style="text-align: center;">
            <a href="{{$public_link}}" style="color: #ec6d4b;font-weight: 600;" target="_blank">{{$listing_name}}</a> has been approved successfully and is now live on FnB Circle.<br><br>

            Click <a href="{{$public_link}}" style="color: #ec6d4b;font-weight: 600;" target="_blank">here</a> to view the listing.

          </p>
          <br>


          <div>
              <div style="float: left;width: 100%;text-align: center;border-bottom: 1px solid #eee;margin-bottom: 0.8em;"><h4 style="display: inline-block;color: #7d7d7d;">Some tips to business owners</h4><br style="clear: both;"></div>

              <b style="margin: 20px 0; display: block;clear:both;font-weight:500;"><span style="width: 30px;height: 30px;line-height: 30px;text-align: center;border-radius: 50%;margin-right: 10px;background-color: #f8836e;color: #fff;display: inline-table;font-size: 14px;font-weight: 400;float:left;text-shadow: 0px 1px 0px #000;">1</span> <span>Make sure the details of your listing are correct. Also ensure that your listing is as detailed as possible.</span>
              <div style="clear: both;display:table;"></div>
              </b>
              <b style="margin: 20px 0; display: block;font-weight:500;"><span style="width: 30px;height: 30px;line-height: 30px;text-align: center;border-radius: 50%;margin-right: 10px;background-color: #f8836e;color: #fff;display: inline-table;font-size: 14px;font-weight: 400;float:left;text-shadow: 0px 1px 0px #000;">2</span> <span>Verify your contact details.</span>
              <div style="clear: both;display:table;"></div>
              </b>
              <b style="margin: 20px 0;display: block;font-weight:500;"><span style="width: 30px;height: 30px;line-height: 30px;text-align: center;border-radius: 50%;margin-right: 10px;background-color: #f8836e;color: #fff;display: inline-table;font-size: 14px;font-weight: 400;float:left;text-shadow: 0px 1px 0px #000;">3</span> <span>Post updates related to your listing regularly. Frequently updated listings will always show up first under browse listings.</span>
              <div style="clear: both;display:table;"></div>
              </b>
              <b style="margin: 20px 0; display: block;font-weight:500;"><span style="width: 30px;height: 30px;line-height: 30px;text-align: center;border-radius: 50%;margin-right: 10px;background-color: #f8836e;color: #fff;display: inline-table;font-size: 14px;font-weight: 400;float:left;text-shadow: 0px 1px 0px #000;">4</span> <span>Go Premium. Benefits of making your listing premium.</span>
              <div style="clear: both;display:table;"></div>
              </b>
              <div style="padding-left: 3em;font-size: 13.5px;">
                  <b style="margin: 20px 0; display: block;clear:both;font-weight:500;"><span style="width: 25px;height: 25px;line-height: 25px;text-align: center;border-radius: 50%;margin-right: 10px;background-color: #f8836e;color: #fff;display: inline-table;font-size: 11px;font-weight: 400;float:left;text-shadow: 0px 1px 0px #000;">4.1</span> <span>Any enquiries or contacts made on the site will be directed to the premium listings first on priority.</span>
                <div style="clear: both;display:table;"></div>
                </b>
                <b style="margin: 20px 0; display: block;font-weight:500;"><span style="width: 25px;height: 25px;line-height: 25px;text-align: center;border-radius: 50%;margin-right: 10px;background-color: #f8836e;color: #fff;display: inline-table;font-size: 11px;font-weight: 400;float:left;text-shadow: 0px 1px 0px #000;">4.2</span> <span>Premium listings are displayed on top when the seekers browse through listings.</span>
                <div style="clear: both;display:table;"></div>
                </b>
                <b style="margin: 20px 0;display: block;font-weight:500;"><span style="width: 25px;height: 25px;line-height: 25px;text-align: center;border-radius: 50%;margin-right: 10px;background-color: #f8836e;color: #fff;display: inline-table;font-size: 11px;font-weight: 400;float:left;text-shadow: 0px 1px 0px #000;">4.3</span> <span>Premium Listings are given Power Seller status. It makes your listing stand out from the rest.</span>
                <div style="clear: both;display:table;"></div>
                </b>
              </div>

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


