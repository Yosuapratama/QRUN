<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Approval Disetujui</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7f6;
            /* Light background for the whole email */
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .email-wrapper {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            border: 1px solid #e0e0e0;
        }

        .email-header {
            padding: 24px;
            background-color: #f8f8f8;
            border-bottom: 1px solid #e0e0e0;
        }

        .email-header h2 {
            color: #28a745;
            /* A pleasant green */
            font-size: 24px;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .email-content {
            padding: 24px;
            color: #333333;
            line-height: 1.6;
        }

        .email-content p {
            margin-bottom: 16px;
        }

        table {
            width: 100%;
            border-collapse: separate;
            /* Use separate for rounded corners */
            border-spacing: 0;
            margin-top: 20px;
            border-radius: 8px;
            overflow: hidden;
            /* Ensures rounded corners apply to content */
            border: 1px solid #e0e0e0;
        }

        th,
        td {
            text-align: left;
            padding: 12px 16px;
            vertical-align: top;
        }

        th {
            background-color: #f0f0f0;
            width: 35%;
            /* Slightly adjusted width */
            color: #555555;
            font-weight: 600;
            border-bottom: 1px solid #e0e0e0;
        }

        td {
            background-color: #ffffff;
            color: #333333;
            border-bottom: 1px solid #e0e0e0;
        }

        tr:last-child th,
        tr:last-child td {
            border-bottom: none;
            /* No border for the last row */
        }

        .email-footer {
            padding: 24px;
            text-align: center;
            font-size: 13px;
            color: #777777;
            border-top: 1px solid #e0e0e0;
            background-color: #f8f8f8;
            margin-top: 20px;
        }

        .email-footer strong {
            color: #555555;
        }
    </style>
</head>

<body>
    <div class="email-wrapper">
        <div class="email-header">
            <h2><span role="img" aria-label="user icon">👤</span> Akun Anda Berhasil Disetujui</h2>
        </div>

        <div class="email-content">
            <table>
                <tr>
                    <th>Nama</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $user->address ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Nomor HP</th>
                    <td>{{ $user->phone ?? '-' }}</td>
                </tr>
                {{-- <tr>
                    <th>Google ID</th>
                    <td>{{ $user->google_id ?? '-' }}</td>
                </tr> --}}
                <tr>
                    <th>Waktu Daftar</th>
                    <td>{{ $user->created_at?->format('d M Y H:i') ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Status Verifikasi</th>
                    <td>{{ $user->email_verified_at ? '✅ Verified' : '❌ Belum diverifikasi' }}</td>
                </tr>
                <tr>
                    <th>Disetujui Oleh Admin</th>
                    <td>
                        @if ($user->approved_at)
                            ✅ Ya - {{ \Carbon\Carbon::parse($user->approved_at)->format('d M Y H:i') }}
                        @else
                            ❌ Belum
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        <div class="email-footer">
            <p>📬 Email ini dikirim otomatis oleh sistem <strong>{{ config('app.name') }}</strong>.</p>
        </div>
    </div>
</body>

</html>
