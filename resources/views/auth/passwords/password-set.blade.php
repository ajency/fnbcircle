@if(isset($old_password) && $old_password == true)
	<div class="form-group m-b-10 p-b-10">
	    <label class="m-b-0 text-lighter float-label required" for="new-pass">Old Password</label>
	    <input id="old-pass" type="password" class="form-control fnb-input float-input" name="old_password" value="" required="">
	    @if ($errors->has('old_password'))
		    <label id="old-pass-error" class="fnb-errors">
		    	<span class="help-block">
		    		<strong>{{ $errors->first('old_password') }}</strong>
		    	</span>
		    </label>
	   	@endif
	</div>
@endif
<div class="form-group m-b-10 p-b-10">
    <label class="m-b-0 text-lighter float-label required" for="new-pass">New Password</label>
    <input id="new-pass" type="password" class="form-control fnb-input float-input" name="password" value="" parsley-type="password" data-parsley-trigger="keyup" data-parsley-errors-container="#new-pass-error" data-required="true" required>
	<label id="new-pass-error" class="fnb-errors">
    	@if ($errors->has('password'))
    		<span class="help-block">
    			<strong>{{ $errors->first('password') }}</strong>
    		</span>
    	@endif
	</label>
</div>
@if(isset($confirm_password) && $confirm_password == true)
	<div class="form-group m-b-10 p-b-10">
	    <label class="m-b-0 text-lighter float-label required" for="confirm-password">Confirm Password</label>
	    <input id="confirm-password" type="password" class="form-control fnb-input float-input" name="password_confirmation" value="" data-parsley-equalto="#new-pass" data-parsley-trigger="keyup" data-parsley-errors-container="#confirm-password-error" data-required="true" required>
    	<label id="confirm-password-error" class="fnb-errors">
	    	@if ($errors->has('password_confirmation'))
	    		<span class="help-block">
	    			<strong>{{ $errors->first('password_confirmation') }}</strong>
	    		</span>
	    	@endif
    	</label>
	</div>
@endif