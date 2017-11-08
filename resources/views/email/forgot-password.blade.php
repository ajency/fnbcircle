@extends('layouts.email')

@section('content')
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr style="text-align: center;">
        <td style="padding: 30px; font-family: sans-serif; font-size: 16px; line-height: 24px; color: #555555;">
  

            <div style="color: rgba(123, 123, 123, 0.77);font-weight: 300;">
              <p>Hello <b style="color: #7f7f7f;">{{ $name }}</b>,</p>
            </div>

            <!-- Tips -->
            <div style="margin-top: 2em;">
                <div style="margin-bottom: 0.8em;">
                    <div style="float: left;text-align: left;color: rgba(123, 123, 123, 0.77);font-size: 0.9em;">
                        Forgot your password? Let's get you a new one.<br>
                        Kindly click on the below button to reset your password.<br>
                        <a href="{{ $reset_password_url }}" class="btn" target="_blank">Reset Password</a><br>
                        or<br>
                        You can copy paste the link: {{ $reset_password_url }}<br>
                        If you don't want to reset your password, you can ignore this email.<br><br>
                        <b>NOTE</b> : The above link is valid only for 2 hours.<br><br>
                        <div>
                            Regards,<br>
                            Team FnB Circle<br>
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>
</table>


@endsection