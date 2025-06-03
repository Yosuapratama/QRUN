<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Report Analytics Qrun Website</title>

    <style>
        /* Reset and base styles */
        * {
            box-sizing: border-box;
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
        }
        
        body {
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
            line-height: 1.5;
            color: #374151;
            margin: 0;
            padding: 0;
            font-size: 12px;
        }
        
        /* Layout */
        .container {
            width: 100%;
            padding: 10px;
        }
        
        .mb-8 {
            margin-bottom: 20px;
        }
        
        .p-6 {
            padding: 15px;
        }
        
        .px-6 {
            padding-left: 15px;
            padding-right: 15px;
        }
        
        .py-4 {
            padding-top: 10px;
            padding-bottom: 10px;
        }
        
        .mt-6 {
            margin-top: 15px;
        }
        
        .mt-1 {
            margin-top: 5px;
        }
        
        /* Flex and Grid */
        .flex {
            display: flex;
        }
        
        .items-center {
            align-items: center;
        }
        
        .justify-between {
            justify-content: space-between;
        }
        
        .space-x-3 > * + * {
            margin-left: 8px;
        }
        
        .space-x-4 > * + * {
            margin-left: 10px;
        }
        
        .space-y-1 > * + * {
            margin-top: 5px;
        }
        
        .grid {
            display: grid;
        }
        
        .grid-cols-4 {
            grid-template-columns: repeat(4, 1fr);
        }
        
        .gap-6 {
            gap: 15px;
        }
        
        /* Colors */
        .bg-white {
            background-color: #ffffff;
        }
        
        .text-white {
            color: #ffffff;
        }
        
        .text-gray-600 {
            color: #4b5563;
        }
        
        .text-gray-700 {
            color: #374151;
        }
        
        .text-gray-900 {
            color: #111827;
        }
        
        .text-blue-600 {
            color: #2563eb;
        }
        
        .text-green-600 {
            color: #059669;
        }
        
        .text-green-800 {
            color: #065f46;
        }
        
        .text-red-800 {
            color: #991b1b;
        }
        
        /* Backgrounds */
        .bg-blue-500 {
            background-color: #3b82f6;
        }
        
        .bg-blue-600 {
            background-color: #2563eb;
        }
        
        .bg-blue-100 {
            background-color: #dbeafe;
        }
        
        .bg-green-100 {
            background-color: #d1fae5;
        }
        
        .bg-green-50 {
            background-color: #ecfdf5;
        }
        
        .bg-green-600 {
            background-color: #059669;
        }
        
        .bg-purple-600 {
            background-color: #9333ea;
        }
        
        .bg-red-100 {
            background-color: #fee2e2;
        }
        
        .bg-orange-100 {
            background-color: #ffedd5;
        }
        
        /* Gradients for headers */
        .header-blue {
            background-color: #2563eb;
            color: white;
        }
        
        .header-green {
            background-color: #059669;
            color: white;
        }
        
        .header-purple {
            background-color: #9333ea;
            color: white;
        }
        
        /* Typography */
        .text-3xl {
            font-size: 24px;
            line-height: 30px;
        }
        
        .text-xl {
            font-size: 18px;
            line-height: 24px;
        }
        
        .text-lg {
            font-size: 16px;
            line-height: 22px;
        }
        
        .text-sm {
            font-size: 11px;
            line-height: 16px;
        }
        
        .text-xs {
            font-size: 10px;
            line-height: 14px;
        }
        
        .font-bold {
            font-weight: 700;
        }
        
        .font-semibold {
            font-weight: 600;
        }
        
        .font-medium {
            font-weight: 500;
        }
        
        /* Borders */
        .rounded-2xl {
            border-radius: 12px;
        }
        
        .rounded-xl {
            border-radius: 8px;
        }
        
        .rounded-lg {
            border-radius: 6px;
        }
        
        .rounded-full {
            border-radius: 9999px;
        }
        
        .border {
            border: 1px solid #e5e7eb;
        }
        
        .border-gray-100 {
            border-color: #f3f4f6;
        }
        
        .border-green-200 {
            border-color: #a7f3d0;
        }
        
        .border-l-4 {
            border-left-width: 4px;
        }
        
        /* Shadows */
        .shadow-xl {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        
        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th {
            text-align: left;
            padding: 8px 10px;
            background-color: #f3f4f6;
            font-weight: 600;
            font-size: 11px;
            color: #374151;
            border-bottom: 1px solid #e5e7eb;
        }
        
        td {
            padding: 8px 10px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 11px;
        }
        
        .table-row-alt {
            background-color: #f9fafb;
        }
        
        /* Status badges */
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 10px;
            font-weight: 500;
        }
        
        .badge-green {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .badge-red {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        /* Cards */
        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .card-header {
            padding: 10px 15px;
            color: white;
        }
        
        .card-body {
            padding: 15px;
        }
        
        /* Summary cards */
        .summary-card {
            background-color: white;
            border-radius: 8px;
            padding: 15px;
            border-left: 4px solid;
        }
        
        .summary-card-blue {
            border-left-color: #3b82f6;
        }
        
        .summary-card-green {
            border-left-color: #059669;
        }
        
        .summary-card-purple {
            border-left-color: #9333ea;
        }
        
        .summary-card-orange {
            border-left-color: #f59e0b;
        }
        
        /* Icons */
        .icon {
            width: 16px;
            height: 16px;
            display: inline-block;
            margin-right: 5px;
        }
        
        /* Page settings */
        @page {
            margin: 1cm;
            size: auto;
        }
        
        /* Utilities */
        .overflow-hidden {
            overflow: hidden;
        }
        
        .overflow-x-auto {
            overflow-x: auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="card">
                <div class="p-6">
                    <div class="flex items-center">
                        <div style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); padding: 10px; border-radius: 8px; margin-right: 15px;">
                            <div style="width: 24px; height: 24px; color: white;">📊</div>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Qrun Analytics</h1>
                            <p class="text-gray-600 mt-1">
                                Laporan Periode:
                                @if(isset($start_date) && isset($end_date))
                                    <span class="font-semibold text-blue-600">
                                        {{ \Carbon\Carbon::parse($start_date)->format('d M Y') }} - 
                                        {{ \Carbon\Carbon::parse($end_date)->format('d M Y') }}
                                    </span>
                                @else
                                    <span class="font-semibold text-blue-600">-</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-4 gap-6 mb-8">
            <div class="summary-card summary-card-blue">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Tempat Baru</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $total_place }}</p>
                    </div>
                    {{-- <div style="background-color: #dbeafe; padding: 8px; border-radius: 9999px;">
                        <div style="width: 18px; height: 18px; color: #2563eb;">📍</div>
                    </div> --}}
                </div>
            </div>

            <div class="summary-card summary-card-green">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">User Terdaftar</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $total_user }}</p>
                    </div>
                    {{-- <div style="background-color: #d1fae5; padding: 8px; border-radius: 9999px;">
                        <div style="width: 18px; height: 18px; color: #059669;">👥</div>
                    </div> --}}
                </div>
            </div>

            <div class="summary-card summary-card-purple">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Event</p>
                        <p class="text-3xl font-bold text-gray-900">{{$total_events}}</p>
                    </div>
                    {{-- <div style="background-color: #ede9fe; padding: 8px; border-radius: 9999px;">
                        <div style="width: 18px; height: 18px; color: #9333ea;">🎫</div>
                    </div> --}}
                </div>
            </div>

            <div class="summary-card summary-card-orange">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Views</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $total_views }}</p>
                    </div>
                    {{-- <div style="background-color: #ffedd5; padding: 8px; border-radius: 9999px;">
                        <div style="width: 18px; height: 18px; color: #d97706;">👁️</div>
                    </div> --}}
                </div>
            </div>
        </div>

        <!-- Places Section -->
        <div class="card mb-8">
            <div class="card-header header-blue">
                <div class="flex items-center">
                    {{-- <div style="margin-right: 8px;">📍</div> --}}
                    <h2 class="text-xl font-bold text-white">Tempat Baru Terdaftar</h2>
                </div>
            </div>

            <div class="card-body">
                <div class="overflow-x-auto">
                    <table>
                        <thead>
                            <tr>
                                <th>Info Tempat</th>
                                <th>Statistik</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($places as $place)
                                <tr class="{{ $loop->even ? 'table-row-alt' : '' }}">
                                    <td>
                                        <div>
                                            <h3 class="font-semibold text-gray-900">{{ $place['title'] }}</h3>
                                            <p class="text-sm text-gray-600">{{ $place['description'] }}</p>
                                            <p class="text-xs text-gray-500 mt-1">ID: {{ $place['place_code'] }}</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <div>
                                                <span class="text-sm text-gray-600">{{ $place['views'] }} views</span>
                                            </div>
                                            <div>
                                                <span class="{{ $place['is_comment'] ? 'text-gray-600' : 'text-gray-400' }}">
                                                    {{ $place['comments_count'] }} Komentar
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-sm text-gray-600">
                                            <p>Provinsi: {{ $place['province_name'] ?? '-' }}</p>
                                            <p class="text-gray-400">District: {{ $place['district_name'] ?? '-' }}</p>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge {{ $place['deleted_at'] ? 'badge-red' : 'badge-green' }}">
                                            {{ $place['deleted_at'] ? 'Dihapus' : 'Aktif' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="text-sm">
                                            <p class="text-gray-900">
                                                {{ \Carbon\Carbon::parse($place['created_at'])->format('d M Y') }}
                                            </p>
                                            <p class="text-gray-500">
                                                {{ \Carbon\Carbon::parse($place['created_at'])->format('H:i') }}
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6" style="padding: 10px; background-color: #ecfdf5; border-radius: 8px; border: 1px solid #a7f3d0;">
                    <div class="flex items-center">
                        <div style="margin-right: 8px; color: #059669;">✓</div>
                        <p class="text-lg font-semibold" style="color: #065f46;">
                            Total tempat yang bertambah: <span class="font-bold">{{ $total_place }} tempat</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Section -->
        <div class="card mb-8">
            <div class="card-header header-green">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        {{-- <div style="margin-right: 8px;">👥</div> --}}
                        <h2 class="text-xl font-bold text-white">User Terdaftar</h2>
                    </div>
                    <span style="background-color: rgba(255,255,255,0.2); color: white; padding: 2px 10px; border-radius: 9999px; font-size: 12px; font-weight: 500;">
                        {{$total_user}} Users
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="overflow-x-auto">
                    <table>
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Tanggal Daftar</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="{{ $loop->even ? 'table-row-alt' : '' }}">
                                    <td class="font-semibold text-gray-900">{{ $user['name'] ?? '-' }}</td>
                                    <td class="text-gray-700">{{ $user['email'] ?? '-' }}</td>
                                    <td class="text-gray-700">
                                        {{ isset($user['created_at']) ? \Carbon\Carbon::parse($user['created_at'])->format('d M Y') : '-' }}
                                    </td>
                                    <td>
                                        <span class="badge badge-green">Aktif</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Events Section -->
        <div class="card mb-8">
            <div class="card-header header-purple">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        {{-- <div style="margin-right: 8px;">🎫</div> --}}
                        <h2 class="text-xl font-bold text-white">Event Terdaftar</h2>
                    </div>
                    <span style="background-color: rgba(255,255,255,0.2); color: white; padding: 2px 10px; border-radius: 9999px; font-size: 12px; font-weight: 500;">
                        {{$total_events}} Event
                    </span>
                </div>
            </div>

            <div class="card-body">
                <div class="overflow-x-auto">
                    <table>
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>Tanggal</th>
                                <th>Dibuat Pada</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($events as $event)
                                <tr class="{{ $loop->even ? 'table-row-alt' : '' }}">
                                    <td class="font-semibold text-gray-900">{{ $event['title'] ?? '-' }}</td>
                                    <td class="text-gray-700">{{ $event['description'] ?? '-' }}</td>
                                    <td class="text-gray-700">
                                        {{ isset($event['date']) ? \Carbon\Carbon::parse($event['date'])->format('d M Y') : '-' }}
                                    </td>
                                    <td class="text-gray-700">
                                        {{ isset($event['created_at']) ? \Carbon\Carbon::parse($event['created_at'])->format('d M Y') : '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>