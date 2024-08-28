@extends('TemplateLayout.UserLayout')

@push('title')
    <title>QRUN Website - Login</title>
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
                            <div class="col-lg-6 col-xl-12">
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
                                            <label for="exampleInputPassword">Password</label>
                                            <input type="password" name="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Your Password...">
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
