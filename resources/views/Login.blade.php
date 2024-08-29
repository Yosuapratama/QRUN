@extends('TemplateLayout.UserLayout')

@push('title')
    <title>QRUN Website - Login</title>
@endpush

@push('script')
    <script>
        // This is for password icon show/hide
        document.querySelector('#eyeShowIcon').addEventListener('click', (e) => {
            document.querySelector('#pw').type = 'text';
            document.querySelector('#eyeShowIcon').style.display = 'none';
            document.querySelector('#eyeShowIcon2').style.display = 'block';
        });

        document.querySelector('#eyeShowIcon2').addEventListener('click', (e) => {
            document.querySelector('#pw').type = 'password';
            document.querySelector('#eyeShowIcon').style.display = 'block';
            document.querySelector('#eyeShowIcon2').style.display = 'none';
        });

    </script>
@endpush
@section('content')
    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-5 col-lg-6 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            {{-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> --}}
                            <div class="col-lg-12 col-xl-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4 font-weight-bold">Welcome To QRUN</h1>
                                    </div>
                                    <form method="POST" action="{{ route('login.store') }}">
                                        @csrf
                                        @if ($errors->any())
                                            <div class="bg bg-danger rounded p-2">
                                                @foreach ($errors->all() as $error)
                                                    <p class="text-white m-2">{{ $error }}</p>
                                                @endforeach
                                            </div>
                                        @endif
                                        <div class="form-group mt-2">
                                            <label for="exampleInputEmail">Email</label>
                                            <input type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" name="email" aria-describedby="emailHelp"
                                                placeholder="Enter Your Email...">
                                        </div>

                                        <div class="form-group">
                                            <label for="pw">Password</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="eyeShowIcon"><i class="fas fa-eye"></i></span>
                                                <span class="input-group-text" id="eyeShowIcon2" style="display: none"><i class="fas fa-eye-slash"></i></span>
                                                <input id="pw" type="password" class="form-control"
                                                    placeholder="Password" aria-label="Password" name="password"
                                                    aria-describedby="eyeShowIcon">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-success btn-user btn-block">
                                            Login
                                        </button>

                                        <p class="mt-3">Don't Have An Account ? <a href="{{ route('register') }}">
                                                Register Here
                                            </a></p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection
