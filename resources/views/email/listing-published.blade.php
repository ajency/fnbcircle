@extends('layouts.email')
@section('email_content')
Hi {{$owner_name}},</br>
</br>
Congratulations!</br>
{{$listing_name}} has been approved successfully and is now live on FnB Circle.</br>
</br>
<a href="{{$public_link}}">Click here to view the listing. </a></br>
</br>
Some tips to business owners:</br>
<ul>
<li>Make sure the details of your listing are correct. Also ensure that your listing is as detailed as possible.</li>
<li>Verify your contact details.</li>
<li>Post updates related to your listing regularly. Frequently updated listings will always show up first under browse listings.</li>
<li>Go Premium. Benefits of making your listing premium
<ol>
<li>Any enquiries or contacts made on the site will be directed to the premium listings first on priority. </li>
<li>Premium listings are displayed on top when the seekers browse through listings.</li>
<li>Premium Listings are given Power Seller status. It makes your listing stand out from the rest.</li>
</ol></li>
</ul><br/>
Regards,</br>
Team FnB Circle </br>
@endsection


