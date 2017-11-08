@if(isset($old_password) && $old_password == true)
	<div class="form-group m-b-10 p-b-10">
	    <label class="m-b-0 text-lighter float-label required" for="new-pass">Old Password</label>
	    <input id="old-pass" type="password" class="form-control fnb-input float-input" name="old_password" value="" required="">
	    @if ($errors->has('old_password'))
		    <label id="name-error" class="fnb-errors">
		    	<span class="help-block">
		    		<strong>{{ $errors->first('old_password') }}</strong>
		    	</span>
		    </label>
	   	@endif
	</div>
@endif
<div class="form-group m-b-10 p-b-10">
    <label class="m-b-0 text-lighter float-label required" for="new-pass">New Password</label>
    <input id="new-pass" type="password" class="form-control fnb-input float-input" name="password" value="" required="">
    @if ($errors->has('password'))
    	<label id="name-error" class="fnb-errors">
    		<span class="help-block">
    			<strong>{{ $errors->first('password') }}</strong>
    		</span>
    	</label>
    @endif
</div>
@if(isset($confirm_password) && $confirm_password == true)
	<div class="form-group m-b-10 p-b-10">
	    <label class="m-b-0 text-lighter float-label required" for="confirm-password">Confirm Password</label>
	    <input id="confirm-password" type="password" class="form-control fnb-input float-input" name="password_confirmation" value="" required="">
	    @if ($errors->has('password_confirmation'))
	    	<label id="name-error" class="fnb-errors">
	    		<span class="help-block">
	    			<strong>{{ $errors->first('password_confirmation') }}</strong>
	    		</span>
	    	</label>
	    @endif
	</div>
@endif