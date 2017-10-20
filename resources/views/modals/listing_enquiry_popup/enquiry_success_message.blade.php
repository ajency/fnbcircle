@if(isset($data))
	@if($data["premium"])
		<div class="premium">
			<p class="title">Email and SMS with your details has been sent to the owner of {{ $data["title"]["name"] }}.</p>
			<p class="subtitle">You will be contacted soon by the owner.</p>
		</div>
	@else
		<div class="non-premium">
			<p class="title">Email and SMS with your details has been sent to the relevant owners.</p>
			<p class="subtitle">You will be contacted soon.</p>
		</div>
	@endif
@else
	<div class="">
		<p class="title">Email & SMS sent to the owner successfully.</p>
		<p class="subtitle">You will be contacted soon.</p>
	</div>
@endif