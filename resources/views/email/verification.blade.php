@extends('layouts.email')
@section('content')
Hi {{$name}},<br/>
<br/>
Please use the following code to verify {{$email}}.<br/>
<br/>
Code: {{$code}}<br/>
<br/>
Regards,<br/>
Team F&amp;B Circle.<br/>
@endsection