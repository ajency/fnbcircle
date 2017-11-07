@extends('layouts.email')

@section('content')
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr style="text-align: center;">
        <td style="padding: 30px; font-family: sans-serif; font-size: 16px; line-height: 24px; color: #555555;">
  

            <div style="color: rgba(123, 123, 123, 0.77);font-weight: 300;">
              <p>Hi <b style="color: #7f7f7f;">{{ $email }} </b></p>
            </div>

            <!-- Tips -->
            <div style="margin-top: 2em;">
                <div style="margin-bottom: 0.8em;">
                    <div style="float: left;text-align: left;color: rgba(123, 123, 123, 0.77);font-size: 0.9em;">
                        You are receiving this email because we received a password reset request for your account.<br>
                        <a href="{{ $reset_password_url }}" target="_blank">Reset Password</a><br>
                        If you did not request a password reset, no further action is required.<br><br>

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