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
                @lang('messages.dashboard.place_limit') {{ $data['account_limit'] }}
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
            @lang('messages.dashboard.information_text')
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
                                        @lang('messages.dashboard.total_users_active')</div>
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
                                        @lang('messages.dashboard.total_users_not_verified')</div>
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
                                        @lang('messages.dashboard.total_users_pending_approved')</div>
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
                                        @lang('messages.dashboard.total_place')</div>
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
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1"> @lang('messages.dashboard.total_event_active')
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
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">@lang('messages.dashboard.total_comments')
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

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">@lang('messages.dashboard.total_gallery')
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                {{ $data['gallery_count'] }}
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-images fa-2x text-gray-300"></i>
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
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">@lang('messages.dashboard.total_blog')
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                {{ $data['blog_count'] }}
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-images fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Requests Card Example -->
                <!-- Earnings (Monthly) Card Example -->
            </div>
            <div class="row my-2">
                <div class="col-md-3">
                    <div class="card border-1">
                        <div class="d-flex">
                            <p class="text-md m-auto pt-2 font-weight-bold text-uppercase mb-1">Province Data</p>
                        </div>
                        <canvas id="chartProvince" width="100" height="100"></canvas>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-1">
                        <div class="d-flex">
                            <p class="text-md m-auto pt-2 font-weight-bold text-uppercase mb-1">Regency Data</p>
                        </div>
                        <canvas id="chartRegency" width="100" height="100"></canvas>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-1">
                        <div class="d-flex">
                            <p class="text-md m-auto pt-2 font-weight-bold text-uppercase mb-1">District Data</p>
                        </div>
                        <canvas id="chartDistrict" width="100" height="100"></canvas>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-1">
                        <div class="d-flex">
                            <p class="text-md m-auto pt-2 font-weight-bold text-uppercase mb-1">Village Data</p>
                        </div>
                        <canvas id="chartVillage" width="100" height="100"></canvas>
                    </div>
                </div>
            </div>

           
             <div class="row" style="gap:10px">
                <div id="myChart" class="card col-md-12"></div>
                <div class="card col-md-12" id="myChart2"></d>
            </div>
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
                                        @lang('messages.dashboard.total_place')</div>
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
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">@lang('messages.dashboard.total_comments')
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
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">@lang('messages.navigation_admin.my_event_total')
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
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

        <script>
            $(document).ready(function() {
                $.ajax({
                    url: "{{ route('place.chart-data') }}",
                    method: 'GET',
                    success: function(res) {
                        drawPieChart('chartProvince', res.province, 'Places by Province');
                        drawPieChart('chartRegency', res.regency, 'Places by Regency');
                        drawPieChart('chartDistrict', res.district, 'Places by District');
                        drawPieChart('chartVillage', res.village, 'Places by Village');
                    }
                });

                function drawPieChart(canvasId, data, title) {
                    const ctx = document.getElementById(canvasId).getContext('2d');
                    new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: data.map(item => item.label),
                            datasets: [{
                                data: data.map(item => item.value),
                                backgroundColor: [
                                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                                    '#9966FF', '#FF9F40', '#C9CBCF', '#E7E9ED', '#4D5360'
                                ],
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                title: {
                                    display: true,
                                    text: title
                                },
                                legend: {
                                    position: 'bottom',
                                }
                            }
                        }
                    });
                }
            });

            fetch('/management/master/dashboard/data/chart')
                .then(response => response.json())
                .then(data => {
                    // Ambil array objek tempat
                    const places = data.data.place_code[0];
                    // Ambil views
                    const views = data.data.no[0];

                    // Buat label: pakai title jika ada, jika tidak pakai code
                    const labels = places.map(item => item.title ? item.title : item.code);

                    var options = {
                        chart: {
                            type: 'bar',
                            height: 350,
                            toolbar: {
                                show: false
                            }
                        },
                        plotOptions: {
                            bar: {
                                borderRadius: 6,
                                horizontal: false,
                                columnWidth: '45%',
                                distributed: true
                            }
                        },
                        dataLabels: {
                            enabled: true
                        },
                        colors: ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0'],
                        series: [{
                            name: 'Views',
                            data: views
                        }],
                        xaxis: {
                            categories: labels,
                            labels: {
                                rotate: -30,
                                style: {
                                    fontSize: '14px'
                                }
                            },
                            title: {
                                text: 'Place'
                            }
                        },
                        yaxis: {
                            min: 0,
                            title: {
                                text: 'Views'
                            }
                        },
                        title: {
                            text: 'Top 5 Places by Views',
                            align: 'center',
                            style: {
                                fontSize: '20px'
                            }
                        },
                        tooltip: {
                            y: {
                                formatter: function(val) {
                                    return val + " views";
                                }
                            }
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#myChart"), options);
                    chart.render();
                });

            fetch('/management/master/dashboard/data/user-growth/chart')
                .then(response => response.json())
                .then(data => {
                    // Format bulan menjadi "MMM YYYY"
                    const labels = data.map(item => {
                        const date = new Date(item.month);
                        return date.toLocaleString('default', {
                            month: 'short',
                            year: 'numeric'
                        });
                    });
                    const userCounts = data.map(item => item.user_count);

                    const options = {
                        chart: {
                            type: 'area',
                            height: 350,
                            toolbar: {
                                show: false
                            }
                        },
                        series: [{
                            name: 'User Growth',
                            data: userCounts
                        }],
                        xaxis: {
                            categories: labels,
                            title: {
                                text: 'Month'
                            },
                            labels: {
                                style: {
                                    fontSize: '14px'
                                }
                            }
                        },
                        yaxis: {
                            min: 0,
                            title: {
                                text: 'User Count'
                            }
                        },
                        dataLabels: {
                            enabled: true
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 3
                        },
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0.4,
                                opacityTo: 0.1,
                                stops: [0, 90, 100]
                            }
                        },
                        colors: ['#00B8D9'],
                        title: {
                            text: 'User Growth Per Month',
                            align: 'center',
                            style: {
                                fontSize: '20px'
                            }
                        },
                        tooltip: {
                            y: {
                                formatter: function(val) {
                                    return val + " users";
                                }
                            }
                        }
                    };

                    // Hapus chart lama jika ada
                    if (window.userGrowthChart) {
                        window.userGrowthChart.destroy();
                    }
                    window.userGrowthChart = new ApexCharts(document.querySelector("#myChart2"), options);
                    window.userGrowthChart.render();
                });
        </script>
    @endpush
    <!-- End of Main Content -->
@endsection
