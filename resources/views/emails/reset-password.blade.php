<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | QRUN Online</title>
</head>

<body bgcolor="#f4f7fb" style="
    margin:0;
    padding:0;
    background-color:#f4f7fb;
    font-family:Arial, Helvetica, sans-serif;
">

    <table
        width="100%"
        border="0"
        cellpadding="0"
        cellspacing="0"
        bgcolor="#f4f7fb"
    >
        <tr>
            <td align="center" style="padding:40px 15px;">

                <!-- MAIN CONTAINER -->
                <table
                    width="600"
                    border="0"
                    cellpadding="0"
                    cellspacing="0"
                    bgcolor="#ffffff"
                    style="
                        width:600px;
                        max-width:600px;
                        border-radius:16px;
                        border:1px solid #e5e7eb;
                    "
                >

                    <!-- HEADER -->
                    <tr>
                        <td
                            bgcolor="#2d4373"
                            align="center"
                            style="
                                padding:40px 20px;
                                border-radius:16px 16px 0 0;
                            "
                        >

                            <h1 style="
                                margin:0;
                                color:#ffffff;
                                font-size:30px;
                                font-weight:bold;
                                letter-spacing:1px;
                            ">
                                QRUN
                            </h1>

                            <p style="
                                margin-top:10px;
                                margin-bottom:0;
                                color:#dbe4ff;
                                font-size:14px;
                            ">
                                Secure Account Recovery
                            </p>

                        </td>
                    </tr>

                    <!-- BODY -->
                    <tr>
                        <td style="padding:45px 40px;">

                            <!-- ICON -->
                            <table
                                align="center"
                                border="0"
                                cellpadding="0"
                                cellspacing="0"
                            >
                                <tr>
                                    <td
                                        width="80"
                                        height="80"
                                        align="center"
                                        bgcolor="#eef3ff"
                                        style="
                                            width:80px;
                                            height:80px;
                                            border-radius:40px;
                                            font-size:34px;
                                        "
                                    >
                                        🔐
                                    </td>
                                </tr>
                            </table>

                            <div style="height:25px;"></div>

                            <h2 style="
                                margin:0;
                                text-align:center;
                                color:#1f2937;
                                font-size:28px;
                                font-weight:bold;
                            ">
                                Reset Your Password
                            </h2>

                            <div style="height:20px;"></div>

                            <p style="
                                margin:0;
                                color:#6b7280;
                                font-size:15px;
                                line-height:26px;
                                text-align:center;
                            ">
                                Hello
                                @if(isset($user))
                                    <strong>{{ $user->name }}</strong>,
                                @endif

                                we received a request to reset the password
                                associated with your QRUN account.
                            </p>

                            <div style="height:10px;"></div>

                            <p style="
                                margin:0;
                                color:#6b7280;
                                font-size:15px;
                                line-height:26px;
                                text-align:center;
                            ">
                                Click the button below to create a new password.
                            </p>

                            <div style="height:35px;"></div>

                            <!-- BUTTON -->
                            <table
                                align="center"
                                border="0"
                                cellpadding="0"
                                cellspacing="0"
                            >
                                <tr>
                                    <td
                                        bgcolor="#2d4373"
                                        align="center"
                                        style="
                                            border-radius:8px;
                                        "
                                    >
                                        <a
                                            href="{{ $url }}"
                                            style="
                                                display:inline-block;
                                                padding:14px 32px;
                                                color:#ffffff;
                                                text-decoration:none;
                                                font-size:15px;
                                                font-weight:bold;
                                            "
                                        >
                                            Reset Password
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <div style="height:35px;"></div>

                            <!-- INFO BOX -->
                            <table
                                width="100%"
                                border="0"
                                cellpadding="0"
                                cellspacing="0"
                                bgcolor="#f8fbff"
                                style="
                                    border:1px solid #d9e5ff;
                                    border-radius:10px;
                                "
                            >
                                <tr>
                                    <td style="padding:18px;">

                                        <p style="
                                            margin:0;
                                            color:#374151;
                                            font-size:14px;
                                            line-height:24px;
                                        ">
                                            <strong>Security Notice</strong>
                                        </p>

                                        <p style="
                                            margin-top:8px;
                                            margin-bottom:0;
                                            color:#6b7280;
                                            font-size:14px;
                                            line-height:24px;
                                        ">
                                            This password reset link will expire
                                            in <strong>60 minutes</strong>.
                                        </p>

                                    </td>
                                </tr>
                            </table>

                            <div style="height:30px;"></div>

                            <hr style="
                                border:none;
                                border-top:1px solid #eeeeee;
                            ">

                            <div style="height:20px;"></div>

                            <p style="
                                margin:0;
                                color:#6b7280;
                                font-size:14px;
                                line-height:24px;
                            ">
                                If the button above does not work,
                                copy and paste the following URL into
                                your browser:
                            </p>

                            <div style="height:10px;"></div>

                            <p style="
                                margin:0;
                                font-size:13px;
                                line-height:22px;
                                color:#2d4373;
                                word-break:break-all;
                            ">
                                {{ $url }}
                            </p>

                            <div style="height:25px;"></div>

                            <p style="
                                margin:0;
                                color:#6b7280;
                                font-size:14px;
                                line-height:24px;
                            ">
                                If you did not request a password reset,
                                you can safely ignore this email.
                                No changes will be made to your account.
                            </p>

                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td
                            bgcolor="#fafafa"
                            align="center"
                            style="
                                padding:24px;
                                border-top:1px solid #eeeeee;
                                border-radius:0 0 16px 16px;
                            "
                        >

                            <p style="
                                margin:0;
                                color:#6b7280;
                                font-size:13px;
                            ">
                                © {{ date('Y') }} QRUN Online.
                                All rights reserved.
                            </p>

                            <div style="height:8px;"></div>

                            <p style="
                                margin:0;
                                color:#9ca3af;
                                font-size:12px;
                            ">
                                This is an automated message.
                                Please do not reply to this email.
                            </p>

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
