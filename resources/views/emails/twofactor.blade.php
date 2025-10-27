<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CristalGrade Two-Factor Verification</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f5f7fa; margin: 0; padding: 0;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f5f7fa; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); padding: 40px;">
                    <tr>
                        <td align="center" style="padding-bottom: 20px;">
                            <img src="{{ asset('images/logoSmall.png') }}" alt="CristalGrade Logo" style="width: 120px; height: auto;">
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align: center; font-size: 18px; color: #2c3e50; padding-bottom: 20px;">
                            Hello {{ $user->name }},
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align: center; font-size: 16px; color: #34495e; padding-bottom: 30px;">
                            Your CristalGrade verification code is:
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="padding-bottom: 30px;">
                            <span style="display: inline-block; font-size: 32px; font-weight: bold; color: #4F46E5; background-color: #e0e7ff; padding: 15px 25px; border-radius: 8px; letter-spacing: 3px;">
                                {{ $user->two_factor_code }}
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align: center; font-size: 14px; color: #7f8c8d; line-height: 1.5;">
                            This code will expire in <strong>10 minutes</strong>.<br>
                            If you did not request this, please ignore this email.
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="padding-top: 30px;">
                            <a href="{{ url('/') }}" style="display: inline-block; padding: 12px 24px; background-color: #4F46E5; color: #ffffff; border-radius: 8px; text-decoration: none; font-weight: bold;">
                                Go to CristalGrade
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding-top: 30px; font-size: 12px; color: #95a5a6; text-align: center;">
                            &copy; {{ date('Y') }} CristalGrade. All rights reserved.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
