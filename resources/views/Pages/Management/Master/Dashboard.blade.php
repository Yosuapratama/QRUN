@extends('TemplateLayout.AdminLayout')

@section('content')
    <!-- Main Content -->
    @push('title')
        <title>Dashboard Admin - QRUN Website</title>
    @endpush
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <div class="alert alert-primary">
                Place Limit : {{ $data['account_limit'] }}
            </div>
        </div>



        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $err)
                    {{ $err }}
                @endforeach
            </div>
        @endif

        @if (!Auth::user()->email_verified_at)
            <div class="alert alert-danger">
                <p>Your Account must be verified first, before you creating a new place !</p>
                <form action="{{ route('verification.send') }}" method="POST">
                    @csrf
                    <button class="btn btn-primary" type="submit" name="submit">Resend Email Verification</button>
                </form>
            </div>
        @endif
        @if (!Auth::user()->approved_at)
            <div class="alert alert-warning">
                Welcome ! Please Wait For Admin Approval
            </div>
        @endif
        <div class="alert alert-warning">
            QRUN aims to display detailed information when QR codes placed in various locations are scanned. Each QR code
            will be associated with a specific location or venue, and when scanned, will display information such as venue
            description, upcoming events, and other relevant details.
        </div>
        <!-- Content Row -->
        @if (Auth::user()->hasRole('superadmin'))
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Users (Active)</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['user_count'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Users (Not Verified)</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['user_not_verified'] }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Pending Approved</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['user_pending'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-exclamation fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Place Total</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['place_total'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-map fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Event Active
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['event_count'] }}
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Comments
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                {{ $data['comments_count'] }}
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-envelope fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Requests Card Example -->
                <!-- Earnings (Monthly) Card Example -->
            </div>
            <canvas id="myChart" width="800" height="400"></canvas>
        @else
            @php
                $limitUser = \App\Helpers\SidebarHelper::getAmountOfLimitUser();
            @endphp

            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Place Total</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $data['place_total'] }}/{{ $data['account_limit'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-map fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Comments
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                {{ $data['comments_count'] }}
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-envelope fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">My Event Total
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $data['event_count'] }}
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
    <!-- /.container-fluid -->
    @push('script')
        <script>
            fetch('/management/master/dashboard/data/chart')
                .then(response => response.json())
                .then(data => {
                    console.log(data.data);

                    const ctx = document.getElementById('myChart').getContext('2d');
                    const myChart = new Chart(ctx, {
                        type: 'line', // jenis chart
                        data: {
                            labels: data.data.place_code[0],
                            datasets: [{
                                label: 'Highest Views Data (By Place Code)',
                                data: data.data.no[0],
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1,
                                fill: true
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true, // Memastikan y-axis mulai dari 0
                                    min: 0, // Mengatur nilai minimum
                                    ticks: {
                                        callback: function(value) {
                                            return value; // Menampilkan nilai di y-axis
                                        }
                                    }
                                },
                                x: {
                                    ticks: {
                                        autoSkip: false // Menghindari penghilangan label
                                    }
                                }
                            }
                        }
                    });
                });
        </script>
    @endpush
    <!-- End of Main Content -->
@endsection
