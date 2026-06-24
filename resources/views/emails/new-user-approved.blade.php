<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Disetujui | QRUN Online</title>
</head>

<body bgcolor="#f4f7fb"
    style="
    margin:0;
    padding:0;
    background-color:#f4f7fb;
    font-family:Arial, Helvetica, sans-serif;
">

    <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#f4f7fb">
        <tr>
            <td align="center" style="padding:40px 15px;">

                <!-- MAIN CONTAINER -->
                <table width="600" cellpadding="0" cellspacing="0" bgcolor="#ffffff"
                    style="
                width:600px;
                max-width:600px;
                border-radius:16px;
                border:1px solid #e5e7eb;
                overflow:hidden;
            ">

                    <!-- HEADER -->
                    <tr>
                        <td bgcolor="#fafafa" align="center" style="padding:35px 20px; border-radius:16px 16px 0 0; border-bottom:1px solid #eeeeee;">

                            <!-- LOGO -->
                            <table border="0" cellpadding="0" cellspacing="0" align="center">
                                <tr>
                                    <td align="center">
                                        <img src="{{ asset('qrun-logo-fullwidth.png') }}" alt="QRUN Logo" width="180"
                                            style="
                            display:block;
                            width:180px;
                            max-width:180px;
                            height:auto;
                            border:0;
                        ">
                                    </td>
                                </tr>
                            </table>

                            <div style="height:18px;"></div>

                            <p
                                style="
            margin:0;
            color:#6b7280;
            font-size:14px;
        ">
                                Account Approval Notification
                            </p>

                        </td>
                    </tr>

                    <!-- BODY -->
                    <tr>
                        <td style="padding:45px 40px;">

                            <!-- ICON -->
                            <table align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="80" height="80" align="center" bgcolor="#eafaf1"
                                        style="
                                    width:80px;
                                    height:80px;
                                    border-radius:40px;
                                    font-size:34px;
                                ">
                                        🎉
                                    </td>
                                </tr>
                            </table>

                            <div style="height:25px;"></div>

                            <h2
                                style="
                            margin:0;
                            text-align:center;
                            color:#1f2937;
                            font-size:28px;
                            font-weight:bold;
                        ">
                                Your Account Has Been Approved
                            </h2>

                            <div style="height:20px;"></div>

                            <p
                                style="
                            margin:0;
                            color:#6b7280;
                            font-size:15px;
                            line-height:26px;
                            text-align:center;
                        ">
                                Hello <strong>{{ $user->name }}</strong>,<br>
                                your QRUN account has been successfully reviewed and approved by our team.
                            </p>

                            <div style="height:30px;"></div>

                            <!-- INFO BOX -->
                            <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#f8fbff"
                                style="
                            border:1px solid #d9e5ff;
                            border-radius:10px;
                        ">
                                <tr>
                                    <td style="padding:18px;">

                                        <p style="margin:0; font-size:14px; color:#374151;">
                                            <strong>Account Details</strong>
                                        </p>

                                        <div style="height:10px;"></div>

                                        <p style="margin:0; font-size:14px; color:#6b7280; line-height:24px;">
                                            <strong>Name:</strong> {{ $user->name }}<br>
                                            <strong>Email:</strong> {{ $user->email }}<br>
                                            <strong>Phone:</strong> {{ $user->phone ?? '-' }}<br>
                                            <strong>Address:</strong> {{ $user->address ?? '-' }}<br>
                                            <strong>Registered:</strong>
                                            {{ $user->created_at?->format('d M Y H:i') }}<br>
                                        </p>

                                    </td>
                                </tr>
                            </table>

                            <div style="height:30px;"></div>

                            <!-- CTA BUTTON -->
                            <table align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td bgcolor="#2d4373" style="border-radius:8px;">
                                        <a href="{{ route('login') }}"
                                            style="
                                        display:inline-block;
                                        padding:14px 32px;
                                        color:#ffffff;
                                        text-decoration:none;
                                        font-size:15px;
                                        font-weight:bold;
                                    ">
                                            Login to Dashboard
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <div style="height:30px;"></div>

                            <hr style="border:none; border-top:1px solid #eeeeee;">

                            <div style="height:20px;"></div>

                            <p
                                style="
                            margin:0;
                            color:#6b7280;
                            font-size:14px;
                            line-height:24px;
                            text-align:center;
                        ">
                                You can now access all features available in your QRUN dashboard.
                            </p>

                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td bgcolor="#fafafa" align="center"
                            style="
                        padding:24px;
                        border-top:1px solid #eeeeee;
                    ">

                            <p style="margin:0; color:#6b7280; font-size:13px;">
                                © {{ date('Y') }} QRUN Online. All rights reserved.
                            </p>

                            <div style="height:8px;"></div>

                            <p style="margin:0; color:#9ca3af; font-size:12px;">
                                This is an automated message. Please do not reply.
                            </p>

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
