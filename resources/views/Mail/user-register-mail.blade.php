<!doctype html>
<html lang="en-US">

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>Register user verify email</title>
    <meta name="description" content="Register user verify email">
    <style type="text/css">
        a:hover {
            text-decoration: underline !important;
        }
    </style>
</head>

<body marginheight="0" topmargin="0" marginwidth="0" style="margin: 10px; background-color: #f2f3f8;" leftmargin="0">
    <!--100% body table-->
    <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8"
        style="@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: 'Open Sans', sans-serif;">
        <tr>
            <td>
                <table style="background-color: b;ie; max-width:670px; margin:0 auto;" width="100%" border="0"
                    cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="height:80px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>
                            <table width="95%" border="0"cellpadding="0" cellspacing="0"
                                style="max-width:720px;background:#fff; border-radius:3px;webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06); padding:30px;">
                                <td style="text-align:center;">
                                    <a href="https://app.serpwizz.com/" title="logo" target="_blank">
                                        <img style="width:170px" src="https://app.serpwizz.com/assets/images/logo.svg"
                                            title="logo" alt="logo">
                                    </a>
                                </td>
                                <tr>
                                    <td style="height:40px;">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td style="padding:0 35px;">
                                        <p style="color:#455056; font-size:15px;line-height:24px; margin:0;">
                                            Hi {{ $user->first_name . $user->last_name }}, <br>
                                            You're almost done! Please go ahead and click the link below to activate
                                            your SERPWizz subdomain and get going you Wizard!.
                                        </p>

                                        <a href="javascript:void(0);"></a>

                                        <a href="{{ config('serpwizz.account_active_url') }}"
                                            style="background:Black;text-decoration:none !important; font-weight:500; margin-top:35px; margin-bottom:35px; color:#fff; font-size:14px;padding:10px 24px;display:inline-block;border-radius:50px;"
                                            class="btn-green">
                                            Activate My Account
                                        </a>

                                        <p style="color:#455056; font-size:15px;line-height:24px; margin:0;">
                                            Also - here are your SERPWizz logins amigo:
                                        </p>
                                        <p style="font-size:14px;">
                                            <span style="color:#ff8c00">Login URL:</span>
                                            <a href="https://app.serpwizz.com/login"target="blank"
                                                text-decoration:underline>https://app.serpwizz.com/login</a>
                                        </p>
                                        <p style="padding-right:74px;font-size:14px;">
                                            <span style="color:#ff8c00;">Username:</span>
                                            <a href="{{ $user->email }}" target="blank"text-decoration:underline
                                                target="blank" color:blue;>{{ $user->email }}</a>
                                        </p>
                                        <p style="padding-top:40px;font-size:14px;">
                                            Btw, in case you need some help, please feel free to reply to this email
                                            and
                                            we will be with you right away.
                                        </p>

                                        <p style="font-size:14px;">
                                            Your in SEO, <br>
                                            The SERPWizz Team
                                        </p>
                                        <p
                                            style="font-size:14px; color:rgba(69, 80, 86, 0.7411764705882353); line-height:18px; margin:0 0 0;">
                                            ©2024 SERPWizz All rights reserved.
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height:40px;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="height:80px;">&nbsp;</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <!--/100% body table-->
</body>

</html>
