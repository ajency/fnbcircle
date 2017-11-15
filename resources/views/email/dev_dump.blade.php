To: {{ json_encode($data['to']) }} <br>
Cc: {{ json_encode($data['cc']) }} <br>
Subject: {{ $data['subject'] }} <br>
<br><br>
Content:<br>
@if(is_array($data["content"]))
	@foreach($data["content"] as $content_index => $content_data)
		{{ $content_data }},
	@endforeach
@else
	{{ $data["content"] }}
@endif