@extends('layouts.email')
@section('content')

<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr style="text-align: center;background-color: #fff;">
      <td style="padding: 30px; font-family: sans-serif; font-size: 16px; line-height: 24px; color: #555555;">
            <div style="color: rgba(123, 123, 123, 0.77);font-weight: 300;">
              <p>Hi</p>
            </div>

            <!-- Tips -->
            <div style="margin-top: 2em;text-align: left;">
              <div style="margin-bottom: 0.8em;">        
                  <div style="color: rgba(123, 123, 123, 0.77);font-size: 0.9em;">  

                  Please review “<a href="{{$listing_link}}">{{$listing_name}}</a>”.<br><br>

                  <b>Details of the Listing</b>:<br/>

                <b>Name</b> : <a href="{{$listing_link}}">{{$listing_name}}</a><br/>
                <b>Type</b> : {{$listing_type}}<br/>
                <b>State</b> : {{$listing_city}}<br/>
                <b>City</b> : {{$listing_area}}<br/>
                <b>Categories</b> : <br/>

                <div class="listed p-t-20 p-b-10" id="listed" style="clear: both;display: table;margin-top: 15px;margin-bottom: 20px;">
                  <!-- <b class="element-title">Also Listed In</b> -->
                  <br>
                  @foreach($listing_categories as $category)
                  <div class="listed__section flex-row">
                      <div class="parent-cat flex-row" style="float: left;min-width: 130px;">
                          <span class="m-r-10" style="display: inline-block;">
                              <img src="{{$category['image-url']}}" width="40" style="vertical-align: middle;">
                          </span>
                          <p class="parent-cat__title cat-size" style=" display: inline-block;margin: 0;">{{$category['parent']}}</p>
                      </div>
                      <div class="child-cat" style="float: left;width: 80px;text-align: center;">
                          <p class="child-cat__title cat-size" style="margin-bottom: 0;margin-top: 7px;">{{$category['branch']}}</p>
                      </div>
                      <ul class="fnb-cat flex-row" style="padding-left: 0;margin-left: 0;list-style: none;float: left;margin-top: 5px;">
                          @foreach($category['nodes'] as $node)
                          <li style=" display: inline-block;border: 1px solid #676767;padding: 0.2em 0.6em;margin: 0 0.2em 0.2em 0.2em;border-radius: 4px;font-size: 12px;"><a href="#" class="fnb-cat__title" style="color: inherit;text-decoration: none;cursor: inherit;">{{$node['name']}}</a></li>
                          @endforeach
                      </ul>
                  </div>
                  @if(!$loop->last)<hr>@endif
                  @endforeach
                </div>


                  <b>Details of the listing owner </b>:<br/>
                  <b>Name</b> : {{$owner_name}}<br/>
                  <b>Email</b> : {{$owner_email}} ({{$email_verified}})<br/>
                  <b>Phone</b> : +{{$owner_phone['contact_region']}}-{{$owner_phone['contact']}} ({{$phone_verified}})<br/>

                  <br>

                  <div style="text-align: left;">
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