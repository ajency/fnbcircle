@extends('layouts.email')
@section('content')
Hi,<br/>
<br/>
Please review “{{$listing_name}}”. ({{$listing_link}}).<br/>
<br/>
Details of the Listing:<br/>
Name: {{$listing_name}} ({{$listing_link}})<br/>
Type: {{$listing_type}}<br/>
City: {{$listing_city}}<br/>
Area: {{$listing_area}}<br/>
Categories: <br/>
<div class="listed p-t-20 p-b-10" id="listed">
	<h3 class="element-title">Also Listed In</h3>
	@foreach($listing_categories as $category)
	<div class="listed__section flex-row">
	    <div class="parent-cat flex-row">
	        <span class="m-r-10">
	            <img src="{{$category['image-url']}}" width="40">
	        </span>
	        <p class="parent-cat__title cat-size">{{$category['parent']}}</p>
	    </div>
	    <div class="child-cat">
	        <p class="child-cat__title cat-size">{{$category['branch']}}</p>
	    </div>
	    <ul class="fnb-cat flex-row">
	        @foreach($category['nodes'] as $node)
	        <li><a href="#" class="fnb-cat__title" >{{$node['name']}}</a></li>
	        @endforeach
	    </ul>
	</div>
	@if(!$loop->last)<hr>@endif
	@endforeach
</div>
<br/>
Details of the listing owner:<br/>
Name: {{$owner_name}}<br/>
Email : {{$owner_email}} ($email_verified)<br/>
Phone: {{$owner_phone}} ($phone_verified)<br/>

@endsection