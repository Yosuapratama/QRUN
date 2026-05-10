@extends('TemplateLayout.AdminLayout')

@push('title')
    <title>Management Blog Admin - QRUN Website</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#escript',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            900: '#1e3a8a'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .collapse {
            visibility: visible !important;
        }
    </style>
@endpush

@section('content')
    <!-- Main Content -->

    <div style="max-width: 95rem !important;" class="mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-xl p-3 border border-gray-100 mb-3">
                <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-2 sm:space-y-0 sm:space-x-4 mb-4">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const startInput = document.getElementById('start_date');
                                const endInput = document.getElementById('end_date');
                                const periodeSpan = document.querySelector('p.text-gray-600.mt-1 span.font-semibold.text-blue-600');

                                // Set default value: start = first day, end = last day of current month
                                const now = new Date();
                                const firstDay = new Date(now.getFullYear(), now.getMonth(), 1);
                                const lastDay = new Date(now.getFullYear(), now.getMonth() + 1, 0);

                                function toDateInputValue(date) {
                                    const d = new Date(date);
                                    const month = (d.getMonth() + 1).toString().padStart(2, '0');
                                    const day = d.getDate().toString().padStart(2, '0');
                                    return `${d.getFullYear()}-${month}-${day}`;
                                }

                                startInput.value = toDateInputValue(firstDay);
                                endInput.value = toDateInputValue(lastDay);

                                function formatDate(dateStr) {
                                    if (!dateStr) return '';
                                    const months = [
                                        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                                    ];
                                    const d = new Date(dateStr);
                                    if (isNaN(d)) return '';
                                    const day = String(d.getDate()).padStart(2, '0');
                                    const month = months[d.getMonth()];
                                    const year = d.getFullYear();
                                    return `${day} ${month} ${year}`;
                                }

                                function updatePeriode() {
                                    const start = formatDate(startInput.value);
                                    const end = formatDate(endInput.value);
                                    if (start && end) {
                                        periodeSpan.textContent = `${start} - ${end}`;
                                    } else if (start) {
                                        periodeSpan.textContent = `${start}`;
                                    } else if (end) {
                                        periodeSpan.textContent = `${end}`;
                                    }
                                }

                                startInput.addEventListener('change', updatePeriode);
                                endInput.addEventListener('change', updatePeriode);

                                // Set initial periode text
                                updatePeriode();
                            });
                        </script>
                        <input type="date" id="start_date" name="start_date"
                            class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" />
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                        <input type="date" id="end_date" name="end_date"
                            class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" />
                    </div>
                    <div class="flex items-end">
                        <button
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold mt-4 sm:mt-0 transition-colors"
                            id="filterBtn">
                            Filter
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">

                    <div class="flex items-center space-x-4">
                        <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-3 rounded-xl">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Qrun Analytics</h1>
                            <p class="text-gray-600 mt-1">Laporan Periode: <span
                                    class="font-semibold text-blue-600">-</span></p>
                        </div>
                    </div>
                    <div class="mt-4 lg:mt-0 flex space-x-3">
                        <a href="{{ route('report.pdf') }}?start_date=" id="exportPdfBtn"
                            onclick="event.preventDefault(); 
                                var start = document.getElementById('start_date').value; 
                                var end = document.getElementById('end_date').value; 
                                var url = '{{ route('report.pdf') }}?start_date=' + encodeURIComponent(start) + '&end_date=' + encodeURIComponent(end); 
                                window.open(url, '_blank');"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            <span>Export PDF</span>
                        </a>
                        {{-- <button
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            <span>Export Excel</span>
                        </button> --}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Tempat Baru</p>
                        <p id="total-places" class="text-3xl font-bold text-gray-900">0</p>
                        {{-- <p id="places-growth" class="text-sm text-green-600 mt-1">↗ 0% dari periode lalu</p> --}}
                        <script>
                            // Only run this logic once after places are fetched, not on DOMContentLoaded
                            function setupPlacesGrowthUpdater() {
                                const totalPlacesElem = document.getElementById('total-places');
                                const placesGrowthElem = document.getElementById('places-growth');

                                // Helper to fetch previous period total
                                async function fetchPreviousTotal() {
                                    const startDate = document.getElementById('start_date').value;
                                    const endDate = document.getElementById('end_date').value;
                                    // Calculate previous period
                                    const start = new Date(startDate);
                                    const end = new Date(endDate);
                                    const diff = end - start;
                                    const prevEnd = new Date(start.getTime() - 1);
                                    const prevStart = new Date(prevEnd.getTime() - diff);

                                    function toDateInputValue(date) {
                                        const d = new Date(date);
                                        const month = (d.getMonth() + 1).toString().padStart(2, '0');
                                        const day = d.getDate().toString().padStart(2, '0');
                                        return `${d.getFullYear()}-${month}-${day}`;
                                    }

                                    const prevStartStr = toDateInputValue(prevStart);
                                    const prevEndStr = toDateInputValue(prevEnd);

                                    try {
                                        const response = await fetch(
                                            `{{ route('report.places') }}?date_start=${prevStartStr}&date_end=${prevEndStr}&page=1`
                                        );
                                        const data = await response.json();
                                        if (data.status === 'success' && data.meta && typeof data.meta.total !== 'undefined') {
                                            return data.meta.total;
                                        }
                                    } catch (e) {}
                                    return 0;
                                }

                                async function updatePlacesGrowth() {
                                    const currentTotal = parseInt(totalPlacesElem.textContent) || 0;
                                    const prevTotal = await fetchPreviousTotal();
                                    let percent = 0;
                                    if (prevTotal > 0) {
                                        percent = ((currentTotal - prevTotal) / prevTotal) * 100;
                                    } else if (currentTotal > 0) {
                                        percent = 100;
                                    }
                                    const arrow = percent >= 0 ? '↗' : '↘';
                                    const color = percent >= 0 ? 'text-green-600' : 'text-red-600';
                                    // placesGrowthElem.textContent = `${arrow} ${Math.abs(percent).toFixed(0)}% dari periode lalu`;
                                    // placesGrowthElem.className = `text-sm mt-1 ${color}`;
                                }

                                // Expose for global use after fetchPlaces
                                window.updatePlacesGrowth = updatePlacesGrowth;
                            }

                            // Call setup once on DOMContentLoaded
                            document.addEventListener('DOMContentLoaded', setupPlacesGrowthUpdater);
                        </script>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">User Terdaftar</p>
                        <p id="total-users" class="text-3xl font-bold text-gray-900">
                            <span id="users-total-badge2">0</span>
                        </p>
                        {{-- <p id="users-growth" class="text-sm text-green-600 mt-1">↗ 0% dari periode lalu</p> --}}
                        <script>
                            // Update #total-users-value after fetch users
                            document.addEventListener('DOMContentLoaded', function() {
                                // Patch fetchUsers to update #total-users-value
                                const oldFetchUsers = window.fetchUsers;
                                window.fetchUsers = async function(page = 1) {
                                    if (typeof oldFetchUsers === 'function') await oldFetchUsers(page);
                                    // After fetch, update #total-users-value from meta.total
                                    try {
                                        const usersTotalBadge = document.getElementById('users-total-badge');
                                        const usersTotalBadge2 = document.getElementById('users-total-badge2');
                                        const totalUsersValue = document.getElementById('total-users-value');
                                        if (usersTotalBadge && totalUsersValue) {
                                            // Extract number from badge text (e.g. "12 Users")
                                            const match = usersTotalBadge.textContent.match(/\d+/);
                                            if (match) totalUsersValue.textContent = match[0];
                                        }
                                        if (usersTotalBadge2 && totalUsersValue) {
                                            // Extract number from badge text (e.g. "12 Users")
                                            const match = usersTotalBadge2.textContent.match(/\d+/);
                                            if (match) totalUsersValue.textContent = match[0];
                                        }
                                    } catch (e) {}
                                };
                            });
                        </script>
                        <script>
                            // Only run this logic once after users are fetched, not on DOMContentLoaded
                            function setupUsersGrowthUpdater() {
                                const totalUsersElem = document.getElementById('total-users');
                                const usersGrowthElem = document.getElementById('users-growth');

                                // Helper to fetch previous period total
                                async function fetchPreviousTotalUsers() {
                                    const startDate = document.getElementById('start_date').value;
                                    const endDate = document.getElementById('end_date').value;
                                    // Calculate previous period
                                    const start = new Date(startDate);
                                    const end = new Date(endDate);
                                    const diff = end - start;
                                    const prevEnd = new Date(start.getTime() - 1);
                                    const prevStart = new Date(prevEnd.getTime() - diff);

                                    function toDateInputValue(date) {
                                        const d = new Date(date);
                                        const month = (d.getMonth() + 1).toString().padStart(2, '0');
                                        const day = d.getDate().toString().padStart(2, '0');
                                        return `${d.getFullYear()}-${month}-${day}`;
                                    }

                                    const prevStartStr = toDateInputValue(prevStart);
                                    const prevEndStr = toDateInputValue(prevEnd);

                                    try {
                                        const response = await fetch(
                                            `{{ route('report.users') }}?date_start=${prevStartStr}&date_end=${prevEndStr}&page=1`
                                        );
                                        const data = await response.json();
                                        if (data.status === 'success' && data.meta && typeof data.meta.total !== 'undefined') {
                                            return data.meta.total;
                                        }
                                    } catch (e) {}
                                    return 0;
                                }

                                async function updateUsersGrowth() {
                                    const currentTotal = parseInt(totalUsersElem.textContent) || 0;
                                    const prevTotal = await fetchPreviousTotalUsers();
                                    let percent = 0;
                                    if (prevTotal > 0) {
                                        percent = ((currentTotal - prevTotal) / prevTotal) * 100;
                                    } else if (currentTotal > 0) {
                                        percent = 100;
                                    }
                                    const arrow = percent >= 0 ? '↗' : '↘';
                                    const color = percent >= 0 ? 'text-green-600' : 'text-red-600';
                                    // usersGrowthElem.textContent = `${arrow} ${Math.abs(percent).toFixed(0)}% dari periode lalu`;
                                    // usersGrowthElem.className = `text-sm mt-1 ${color}`;
                                }

                                // Expose for global use after fetchUsers
                                window.updateUsersGrowth = updateUsersGrowth;
                            }

                            // Call setup once on DOMContentLoaded
                            document.addEventListener('DOMContentLoaded', setupUsersGrowthUpdater);
                        </script>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Event</p>
                        <p class="text-3xl font-bold text-gray-900" id="events-total-badge2">0</p>
                        {{-- <p class="text-sm text-red-600 mt-1">↘ 1 Dihapus</p> --}}
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 112 0v1m-6 0h12l-1 12a2 2 0 01-2 2H7a2 2 0 01-2-2L4 7z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-orange-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Views</p>
                        <p id="total-views" class="text-3xl font-bold text-gray-900">0</p>
                        <script>
                            // Update total views after fetchPlaces
                            document.addEventListener('DOMContentLoaded', function() {
                                // Patch fetchPlaces to update #total-views
                                const oldFetchPlaces = window.fetchPlaces;
                                window.fetchPlaces = async function(page = 1) {
                                    // Call the original fetchPlaces (which renders table and total-places)
                                    if (typeof oldFetchPlaces === 'function') await oldFetchPlaces(page);

                                    // Fetch again just for total_views (or you can update this logic to avoid double fetch)
                                    try {
                                        const startDate = document.getElementById('start_date');
                                        const endDate = document.getElementById('end_date');
                                        const searchInput = document.getElementById('search_place');
                                        const search = searchInput ? searchInput.value : '';
                                        const response = await fetch(
                                            `{{ route('report.places') }}?date_start=${startDate.value}&date_end=${endDate.value}&page=${page}&search=${encodeURIComponent(search)}`
                                        );
                                        const data = await response.json();
                                        if (data.status === 'success' && data.meta && typeof data.meta.total_views !==
                                            'undefined') {
                                            const totalViewsElem = document.getElementById('total-views');
                                            if (totalViewsElem) totalViewsElem.textContent = data.meta.total_views;
                                        }
                                    } catch (e) {}
                                };
                            });
                        </script>
                        {{-- <p class="text-sm text-blue-600 mt-1">↗ Engagement tinggi</p> --}}
                    </div>
                    <div class="bg-orange-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Places Section -->
        <div class="bg-white rounded-2xl shadow-xl mb-8 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                        </svg>
                        <h2 class="text-xl font-bold text-white">Tempat Baru Terdaftar</h2>
                    </div>
                    <div class="flex space-x-2">
                        <input type="text" id="search_place" placeholder="Cari tempat..."
                            class="px-3 py-1 rounded-lg text-sm text-gray-700 bg-white/90 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-white/50">
                        <button id="search_place_btn" type="button"
                            class="bg-white/20 hover:bg-white/30 text-white px-3 py-1 rounded-lg text-sm transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Info Tempat</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Statistik</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Lokasi</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Status</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">

                        </tbody>
                    </table>
                </div>

                <div class="mt-6 p-4 bg-green-50 rounded-xl border border-green-200">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-lg font-semibold text-green-800">
                            Total tempat yang bertambah: <span class="font-bold" id="place-count">0 tempat</span>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    // Update #place-count when total-places changes
                                    const totalPlacesElem = document.getElementById('total-places');
                                    const placeCountElem = document.getElementById('place-count');

                                    function updatePlaceCount() {
                                        if (totalPlacesElem && placeCountElem) {
                                            placeCountElem.textContent = `${totalPlacesElem.textContent} tempat`;
                                        }
                                    }

                                    // Initial update
                                    updatePlaceCount();

                                    // Observe changes to #total-places
                                    if (window.MutationObserver) {
                                        const observer = new MutationObserver(updatePlaceCount);
                                        observer.observe(totalPlacesElem, {
                                            childList: true
                                        });
                                    }
                                });
                            </script>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Section -->
        <div class="bg-white rounded-2xl shadow-xl mb-8 overflow-hidden">
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                            </path>
                        </svg>
                        <h2 class="text-xl font-bold text-white">User Terdaftar</h2>
                    </div>
                    <span id="users-total-badge"
                        class="bg-white/20 text-white px-3 py-1 rounded-full text-sm font-medium">0
                        Users</span>
                </div>
            </div>
            <div class="p-6">
                <div class="flex justify-between items-center mb-4 flex-wrap gap-2">
                    <input type="text" id="search_user" placeholder="Cari user..."
                        class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <button id="search_user_btn"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">Cari</button>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Nama</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Email</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Tanggal Daftar</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Status</th>
                            </tr>
                        </thead>
                        <tbody id="users-table-body" class="divide-y divide-gray-100">
                            <!-- Data will be injected here -->
                        </tbody>
                    </table>
                </div>
                <div id="users-pagination" class="flex justify-end mt-4 space-x-2"></div>
            </div>
        </div>


        <!-- Events Section -->
        <div class="bg-white rounded-2xl shadow-xl mb-8 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-indigo-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 112 0v1m-6 0h12l-1 12a2 2 0 01-2 2H7a2 2 0 01-2-2L4 7z">
                            </path>
                        </svg>
                        <h2 class="text-xl font-bold text-white">Event Terdaftar</h2>
                    </div>
                    <span id="events-total-badge"
                        class="bg-white/20 text-white px-3 py-1 rounded-full text-sm font-medium">0
                        Event</span>
                </div>
            </div>

            <div class="p-6">
                <div class="flex justify-between items-center mb-4 flex-wrap gap-2">
                    <input type="text" id="search_event" placeholder="Cari event..."
                        class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <button id="search_event_btn"
                        class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">Cari</button>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Judul</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Deskripsi</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Tanggal</th>
                                {{-- <th class="text-left py-3 px-4 font-semibold text-gray-700">Tanggal Selesai</th> --}}
                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Dibuat Pada</th>
                            </tr>
                        </thead>
                        <tbody id="events-table-body" class="divide-y divide-gray-100">
                            <!-- Data will be injected here -->
                        </tbody>
                    </table>
                </div>
                <div id="events-pagination" class="flex justify-end mt-4 space-x-2"></div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const eventsTableBody = document.getElementById('events-table-body');
                    const searchInput = document.getElementById('search_event');
                    const searchBtn = document.getElementById('search_event_btn');
                    const eventsTotalBadge = document.getElementById('events-total-badge');
                    const eventsTotalBadge2 = document.getElementById('events-total-badge2');
                    const startDate = document.getElementById('start_date');
                    const endDate = document.getElementById('end_date');
                    let currentPage = 1;
                    let lastPage = 1;

                    async function fetchEvents(page = 1) {
                        try {
                            const search = searchInput ? searchInput.value : '';
                            const dateStart = startDate ? startDate.value : '';
                            const dateEnd = endDate ? endDate.value : '';
                            const response = await fetch(
                                `{{ route('report.events') }}?date_start=${dateStart}&date_end=${dateEnd}&page=${page}&search=${encodeURIComponent(search)}`
                            );
                            const data = await response.json();

                            if (data.status === 'success') {
                                // Update badge
                                if (eventsTotalBadge && data.meta && typeof data.meta.total !== 'undefined') {
                                    eventsTotalBadge.textContent =
                                        `${data.meta.total} Event${data.meta.total > 1 ? 's' : ''}`;
                                }
                                if (eventsTotalBadge2 && data.meta && typeof data.meta.total !== 'undefined') {
                                    eventsTotalBadge2.textContent =
                                        `${data.meta.total} ${data.meta.total > 1 ? '' : ''}`;
                                }
                                // Render table
                                if (!data.data || data.data.length === 0) {
                                    eventsTableBody.innerHTML =
                                        `<tr><td colspan="5" class="py-4 px-4 text-center text-gray-400">Tidak ada data event</td></tr>`;
                                } else {
                                    eventsTableBody.innerHTML = (data.data || []).map(event => `
                        <tr class="hover:bg-purple-50 transition-colors">
                            <td class="py-4 px-4 font-semibold text-gray-900">${event.title || '-'}</td>
                            <td class="py-4 px-4 text-gray-700">${event.description || '-'}</td>
                            <td class="py-4 px-4 text-gray-700">
                            ${event.date ? new Date(event.date).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }) : '-'}
                            </td>
                            <td class="py-4 px-4 text-gray-700">
                            ${event.created_at ? new Date(event.created_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }) : '-'}
                            </td>
                        </tr>
                        `).join('');
                                }

                                // Pagination
                                currentPage = data.meta?.current_page || 1;
                                lastPage = data.meta?.last_page || 1;
                                renderEventsPagination();
                            }
                        } catch (error) {
                            eventsTableBody.innerHTML =
                                `<tr><td colspan="5" class="py-4 px-4 text-center text-red-500">Gagal memuat data event</td></tr>`;
                        }
                    }
                    window.fetchEvents = fetchEvents;

                    function renderEventsPagination() {
                        const paginationContainer = document.getElementById('events-pagination');
                        paginationContainer.innerHTML = '';

                        // Previous button
                        const prevBtn = document.createElement('button');
                        prevBtn.textContent = 'Prev';
                        prevBtn.disabled = currentPage === 1;
                        prevBtn.className = 'px-3 py-1 rounded bg-gray-200 text-gray-700 disabled:opacity-50';
                        prevBtn.onclick = () => {
                            if (currentPage > 1) fetchEvents(currentPage - 1);
                        };
                        paginationContainer.appendChild(prevBtn);

                        // Page numbers (show max 5 pages)
                        let start = Math.max(1, currentPage - 2);
                        let end = Math.min(lastPage, currentPage + 2);
                        for (let i = start; i <= end; i++) {
                            const pageBtn = document.createElement('button');
                            pageBtn.textContent = i;
                            pageBtn.className =
                                `px-3 py-1 rounded ${i === currentPage ? 'bg-purple-600 text-white' : 'bg-gray-100 text-gray-700'}`;
                            pageBtn.disabled = i === currentPage;
                            pageBtn.onclick = () => fetchEvents(i);
                            paginationContainer.appendChild(pageBtn);
                        }

                        // Next button
                        const nextBtn = document.createElement('button');
                        nextBtn.textContent = 'Next';
                        nextBtn.disabled = currentPage === lastPage;
                        nextBtn.className = 'px-3 py-1 rounded bg-gray-200 text-gray-700 disabled:opacity-50';
                        nextBtn.onclick = () => {
                            if (currentPage < lastPage) fetchEvents(currentPage + 1);
                        };
                        paginationContainer.appendChild(nextBtn);
                    }

                    // Initial fetch
                    fetchEvents();

                    // Search button click handler
                    if (searchBtn) {
                        searchBtn.addEventListener('click', () => fetchEvents());
                    }

                    // Enter key triggers search
                    if (searchInput) {
                        searchInput.addEventListener('keydown', function(e) {
                            if (e.key === 'Enter') {
                                fetchEvents();
                            }
                        });
                        // Debounce for live search
                        let debounceTimer;
                        searchInput.addEventListener('input', function() {
                            clearTimeout(debounceTimer);
                            debounceTimer = setTimeout(() => fetchEvents(), 400);
                        });
                    }
                });
            </script>
        </div>


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const usersTableBody = document.getElementById('users-table-body');
                const searchInput = document.getElementById('search_user');
                const searchBtn = document.getElementById('search_user_btn');
                const usersTotalBadge = document.getElementById('users-total-badge');
                const usersTotalBadge2 = document.getElementById('users-total-badge2');
                const startDate = document.getElementById('start_date');
                const endDate = document.getElementById('end_date');
                let currentPage = 1;
                let lastPage = 1;

                async function fetchUsers(page = 1) {
                    try {
                        const search = searchInput ? searchInput.value : '';
                        const dateStart = startDate ? startDate.value : '';
                        const dateEnd = endDate ? endDate.value : '';
                        const response = await fetch(
                            `{{ route('report.users') }}?date_start=${dateStart}&date_end=${dateEnd}&page=${page}&search=${encodeURIComponent(search)}`
                        );
                        const data = await response.json();

                        if (data.status === 'success') {
                            // Update badge
                            if (usersTotalBadge && data.meta && typeof data.meta.total !== 'undefined') {
                                usersTotalBadge.textContent =
                                    `${data.meta.total} User${data.meta.total > 1 ? 's' : ''}`;
                            }
                            if (usersTotalBadge2 && data.meta && typeof data.meta.total !== 'undefined') {
                                usersTotalBadge2.textContent =
                                    `${data.meta.total} ${data.meta.total > 1 ? '' : ''}`;
                            }
                            // Render table
                            if (!data.data || data.data.length === 0) {
                                usersTableBody.innerHTML =
                                    `<tr><td colspan="4" class="py-4 px-4 text-center text-gray-400">Tidak ada data user</td></tr>`;
                            } else {
                                usersTableBody.innerHTML = (data.data || []).map(user => `
                        <tr class="hover:bg-green-50 transition-colors">
                            <td class="py-4 px-4 font-semibold text-gray-900">${user.name || '-'}</td>
                            <td class="py-4 px-4 text-gray-700">${user.email || '-'}</td>
                            <td class="py-4 px-4 text-gray-700">
                            ${user.created_at ? new Date(user.created_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }) : '-'}
                            </td>
                            <td class="py-4 px-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${user.deleted_at ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'}">
                                ${user.deleted_at ? 'Dihapus' : 'Aktif'}
                            </span>
                            </td>
                        </tr>
                        `).join('');
                            }

                            // Pagination
                            currentPage = data.meta?.current_page || 1;
                            lastPage = data.meta?.last_page || 1;
                            renderUsersPagination();
                            if (typeof window.updateUsersGrowth === 'function') window.updateUsersGrowth();
                        }
                    } catch (error) {
                        usersTableBody.innerHTML =
                            `<tr><td colspan="4" class="py-4 px-4 text-center text-red-500">Gagal memuat data user</td></tr>`;
                    }
                }
                window.fetchUsers = fetchUsers;

                function renderUsersPagination() {
                    const paginationContainer = document.getElementById('users-pagination');
                    paginationContainer.innerHTML = '';

                    // Previous button
                    const prevBtn = document.createElement('button');
                    prevBtn.textContent = 'Prev';
                    prevBtn.disabled = currentPage === 1;
                    prevBtn.className = 'px-3 py-1 rounded bg-gray-200 text-gray-700 disabled:opacity-50';
                    prevBtn.onclick = () => {
                        if (currentPage > 1) fetchUsers(currentPage - 1);
                    };
                    paginationContainer.appendChild(prevBtn);

                    // Page numbers (show max 5 pages)
                    let start = Math.max(1, currentPage - 2);
                    let end = Math.min(lastPage, currentPage + 2);
                    for (let i = start; i <= end; i++) {
                        const pageBtn = document.createElement('button');
                        pageBtn.textContent = i;
                        pageBtn.className =
                            `px-3 py-1 rounded ${i === currentPage ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700'}`;
                        pageBtn.disabled = i === currentPage;
                        pageBtn.onclick = () => fetchUsers(i);
                        paginationContainer.appendChild(pageBtn);
                    }

                    // Next button
                    const nextBtn = document.createElement('button');
                    nextBtn.textContent = 'Next';
                    nextBtn.disabled = currentPage === lastPage;
                    nextBtn.className = 'px-3 py-1 rounded bg-gray-200 text-gray-700 disabled:opacity-50';
                    nextBtn.onclick = () => {
                        if (currentPage < lastPage) fetchUsers(currentPage + 1);
                    };
                    paginationContainer.appendChild(nextBtn);
                }

                // Initial fetch
                fetchUsers();

                // Search button click handler
                if (searchBtn) {
                    searchBtn.addEventListener('click', () => fetchUsers());
                }

                // Enter key triggers search
                if (searchInput) {
                    searchInput.addEventListener('keydown', function(e) {
                        if (e.key === 'Enter') {
                            fetchUsers();
                        }
                    });
                    // Debounce for live search
                    let debounceTimer;
                    searchInput.addEventListener('input', function() {
                        clearTimeout(debounceTimer);
                        debounceTimer = setTimeout(() => fetchUsers(), 400);
                    });
                }
            });
        </script>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterBtn = document.getElementById('filterBtn');
            const startDate = document.getElementById('start_date');
            const endDate = document.getElementById('end_date');
            const tableBody = document.querySelector('tbody');
            const searchInput = document.getElementById('search_place');
            const searchBtn = document.getElementById('search_place_btn');
            const exportButtons = document.querySelectorAll('button');

            let currentPage = 1;
            let lastPage = 1;

            function renderPlaceRow(place) {
                const createdAt = new Date(place.created_at);
                return `
                <tr class="hover:bg-blue-50 transition-colors">
                    <td class="py-4 px-4">
                        <div class="flex items-start space-x-3">
                            <div class="bg-blue-100 p-2 rounded-lg">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">${place.title}</h3>
                                <p class="text-sm text-gray-600">${place.description}</p>
                                <p class="text-xs text-gray-500 mt-1">ID: ${place.place_code}</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-4">
                        <div class="space-y-1">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="text-sm text-gray-600">${place.views} views</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 ${place.is_comment ? 'text-green-500' : 'text-gray-400'}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                <span class="text-sm ${place.is_comment ? 'text-gray-600' : 'text-gray-400'}">${place.comments_count} Komentar</span>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-4">
                        <div class="text-sm text-gray-600">
                            <p>Provinsi: ${place.province_name || '-'}</p>
                            <p class="text-gray-400">District: ${place.district_name || '-'}</p>
                        </div>
                    </td>
                    <td class="py-4 px-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${place.deleted_at ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'}">
                            ${place.deleted_at ? 'Dihapus' : 'Aktif'}
                        </span>
                    </td>
                    <td class="py-4 px-4">
                        <div class="text-sm">
                            <p class="text-gray-900">${createdAt.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' })}</p>
                            <p class="text-gray-500">${createdAt.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })}</p>
                        </div>
                    </td>
                </tr>
            `;
            }

            async function fetchPlaces(page = 1) {
                try {
                    const search = searchInput?.value || '';
                    const url =
                        `{{ route('report.places') }}?date_start=${startDate.value}&date_end=${endDate.value}&page=${page}&search=${encodeURIComponent(search)}`;
                    const response = await fetch(url);
                    const data = await response.json();

                    if (data.status === 'success') {
                        // document.getElementById('total-places')?.textContent = (data.meta && typeof data.meta.total !== 'undefined') ? data.meta.total : '';
                        // document.getElementById('total-views')?.textContent = (data.meta && typeof data.meta.total_views !== 'undefined') ? data.meta.total_views : '';
                        document.getElementById('total-places').textContent = (data.meta && typeof data.meta.total !== 'undefined') ? data.meta.total : '0';
                        document.getElementById('total-views').textContent = (data.meta && typeof data.meta.total_views !== 'undefined') ? data.meta.total_views : '0';

                        tableBody.innerHTML = data.data.map(renderPlaceRow).join('');

                        currentPage = data.meta?.current_page || 1;
                        lastPage = data.meta?.last_page || 1;
                        renderPagination();
                    }
                } catch (error) {
                    console.error('Error fetching data:', error);
                }
            }

            function renderPagination() {
                let container = document.getElementById('places-pagination');
                if (!container) {
                    container = document.createElement('div');
                    container.id = 'places-pagination';
                    container.className = 'flex justify-end mt-4 space-x-2';
                    tableBody.parentElement.appendChild(container);
                }
                container.innerHTML = '';

                const createBtn = (text, disabled, onClick, isActive = false) => {
                    const btn = document.createElement('button');
                    btn.textContent = text;
                    btn.disabled = disabled;
                    btn.className =
                        `px-3 py-1 rounded ${isActive ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700'} ${disabled ? 'opacity-50' : ''}`;
                    btn.onclick = onClick;
                    container.appendChild(btn);
                };

                createBtn('Prev', currentPage === 1, () => fetchPlaces(currentPage - 1));

                const start = Math.max(1, currentPage - 2);
                const end = Math.min(lastPage, currentPage + 2);
                for (let i = start; i <= end; i++) {
                    createBtn(i, i === currentPage, () => fetchPlaces(i), i === currentPage);
                }

                createBtn('Next', currentPage === lastPage, () => fetchPlaces(currentPage + 1));
            }

            // Event Listeners
            filterBtn?.addEventListener('click', () => {
                fetchPlaces();
                if (typeof fetchUsers === 'function') fetchUsers();
                if (typeof fetchEvents === 'function') fetchEvents();
            });

            searchBtn?.addEventListener('click', () => fetchPlaces());

            if (searchInput) {
                searchInput.addEventListener('keydown', e => {
                    if (e.key === 'Enter') fetchPlaces();
                });

                let debounceTimer;
                searchInput.addEventListener('input', () => {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => fetchPlaces(), 400);
                });
            }

            exportButtons.forEach(button => {
                button.addEventListener('click', function() {
                    if (this.textContent.trim().includes('Export')) {
                        console.log('Exporting:', this.textContent.trim());
                        // Add actual export logic here
                    }
                });
            });

            // Initial fetch
            fetchPlaces();
        });
    </script>
@endsection
