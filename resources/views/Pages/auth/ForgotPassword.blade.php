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
                                    <form action="{{ route('password.email') }}" method="POST">
                                        @csrf
                                        @if ($errors->any())
                                            <div class="bg bg-danger rounded p-2">
                                                @foreach ($errors->all() as $error)
                                                    <p class="text-white m-2">{{ $error }}</p>
                                                @endforeach
                                            </div>
                                        @endif
                                        @if(session()->has('status'))
                                            <div class="alert alert-success">
                                                {{session()->get('status')}}
                                            </div>
                                        @endif
                                        <div class="form-group mt-2">
                                            <label for="emails">Email</label>
                                            <input id="emails" autofocus type="email" class="form-control form-control-user" name="email"
                                                placeholder="Enter Your Email...">
                                        </div>


                                        <button type="submit" class="btn btn-success btn-user btn-block">
                                            Send Reset Password Link
                                        </button>
                                        {{-- <hr> --}}

                                        <p class="mt-3">Back To Login Page ? <a href="{{ route('login') }}">
                                                Login Page
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
