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
                                    <form action="{{route('password.update')}}" method="POST">
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
                                        <input type="hidden" name="token" value="{{request()->token}}">
                                        <input type="hidden" name="email" value="{{request()->email}}">

                                        <div class="form-group mt-2">
                                            <label for="password">New Password</label>
                                            <input id="password" type="password" class="form-control form-control-user" name="password"
                                                placeholder="Enter Your New Password...">
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="password">Confirm Password</label>
                                            <input id="password" type="password" class="form-control form-control-user" name="password_confirmation"
                                                placeholder="Enter Your New Password...">
                                        </div>


                                        <button type="submit" class="btn btn-success btn-user btn-block">
                                            Save Password
                                        </button>
                                        {{-- <hr> --}}
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
