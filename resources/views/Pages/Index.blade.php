<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage | Qrun Website</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <style>
        .hero {
            background-image:url('{{ asset('background.png') }}');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }

        .footer {
            background-color: #333;
            color: white;
            padding: 20px 0;
        }

        .card {
            margin: 15px 0;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
  
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Qrun Website</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mailto:support@qrun.online">Contact</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('login')}}">Login</a>
                    </li>
                    <li class="nav-item bg bg-primary rounded">
                        <a class="nav-link"  style="color: white !important" href="{{route('login')}}">Join Us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero text-center">
        <div class="container">
            <h1>Explore the Place</h1>
            <p>Find A Place Now</p>
            <form method="GET" class="input-group mb-3" style="max-width: 600px; margin: auto;">
                <input type="text" class="form-control" placeholder="Search Destinations"
                    aria-label="Search Destinations">
                <button class="btn btn-primary" type="button">Search</button>
            </form>
            <a href="#" class="btn btn-primary btn-lg">Get Started</a>
        </div>
    </section>

    <!-- Card Section -->
    <section class="container my-5">
        <h2 class="text-center" id="place">Search Place</h2>
        <p class="text-center">QRUN aims to display detailed information when QR codes placed in various locations are scanned.</p>
        {{-- <div > --}}
            <form class="input-group mb-3" style="max-width: 600px; margin: auto;" method="GET">
                <input name="search" autofocus type="text" class="form-control" placeholder="Search Destinations"
                    aria-label="Search Destinations">
                <button class="btn btn-primary" type="submit">Search</button>
                <a href="{{route('homes')}}" class="btn btn-secondary" type="button">Reset</a>

            </form>
        {{-- </div> --}}
        <div class="row">
            @foreach ($data as $dt)
                <div class="col-md-4">
                    <div class="card">
                        {{-- <img src="https://source.unsplash.com/400x300/?mountains" class="card-img-top" alt="Mountains"> --}}
                        <div class="card-body">
                            <h5 class="card-title">{{ $dt->title }} |  <i class="fa-regular fa-eye"></i> {{ $dt->views }}</h5>
                            <p class="card-text">{{ $dt->description }}
                            </p>
                            <a href="/detail-place/{{$dt->place_code}}" class="btn btn-primary">Explore</a>
                        </div>
                    </div>
                </div>
            @endforeach
            @if($data->count() == 0)
            <div class="d-flex justify-content-center">
                <p>0 Data Found !</p>
            </div>
            @endif
            {{-- {{ $data->links() }} --}}
            <div class="d-flex justify-content-center">
                {{ $data->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
            </div>
            
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer text-center">
        <div class="container">
            <p>&copy; 2024 Qrun.online. All Rights Reserved.</p>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="{{route('privacyPolicy')}}" class="text-white">Privacy Policy</a></li>
                <li class="list-inline-item"><a href="{{route('termsOfService')}}" class="text-white">Terms of Service</a></li>
            </ul>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
