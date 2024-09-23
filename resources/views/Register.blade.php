@extends('TemplateLayout.UserLayout')

@push('title')
    <title>QRUN Website - Register</title>
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

        // This is for confirmation password
        document.querySelector('#eyeShowIconconfirm').addEventListener('click', (e) => {
            document.querySelector('#pw-2').type = 'text';
            document.querySelector('#eyeShowIconconfirm').style.display = 'none';
            document.querySelector('#eyeShowIconconfirm2').style.display = 'block';
        });

        document.querySelector('#eyeShowIconconfirm2').addEventListener('click', (e) => {
            document.querySelector('#pw-2').type = 'password';
            document.querySelector('#eyeShowIconconfirm').style.display = 'block';
            document.querySelector('#eyeShowIconconfirm2').style.display = 'none';
        });

        document.querySelector('#registerBtn').disabled = true;

        var checker = document.getElementById('agreed');
        var sendbtn = document.getElementById('registerBtn');

        checker.onchange = function() {
            sendbtn.disabled = !this.checked;
        };
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
                            <div class="col-lg-12 col-xl-12">
                              
                                <div style="padding: 30px">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4 font-weight-bold">Register To QRUN</h1>
                                    </div>
                                    <form method="POST" action="{{ route('register.store') }}">
                                        @csrf
                                        <div class="form-group">
                                            <label for="nameLogin">Name<small class="text-danger">*required</small></label>
                                            <input value="{{ old('name') }}" type="text"
                                                class="form-control form-control-user" id="nameLogin" name="name"
                                                placeholder="Enter name Address..." required>
                                            @error('name')
                                                <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        {{-- Phone Num --}}
                                        <div class="form-group">
                                            <label for="phoneNum">Phone Number<small
                                                    class="text-danger">*required</small></label>
                                            <div class="input-group">
                                                <span class="input-group-text">+62</span>
                                                <input value="{{ old('phone') }}" id="phoneNum" type="number"
                                                    class="form-control" placeholder="Phone..." name="phone">
                                            </div>
                                            @error('phone')
                                                <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        {{-- End of phone --}}
                                        {{-- <div class="form-group">
                                            <label for="phoneNum">Phone Number<small
                                                    class="text-danger">*required</small></label>
                                            <input value="{{ old('phone') }}" type="number"
                                                class="form-control form-control-user" id="phoneNum" name="phone"
                                                placeholder="Enter Phone Num (08..).." required>
                                            @error('phone')
                                                <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                                            @enderror
                                        </div> --}}

                                        <div class="form-group">
                                            <label for="exampleInputEmail">Email<small
                                                    class="text-danger">*required</small></label>
                                            <input value="{{ old('email') }}" type="email"
                                                class="form-control form-control-user" id="exampleInputEmail" name="email"
                                                aria-describedby="emailHelp" placeholder="Enter Email Address..." required>
                                            @error('email')
                                                <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        {{-- Form Password --}}
                                        <div class="form-group">
                                            <label for="pw">New Password<small
                                                    class="text-danger">*required</small></label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="eyeShowIcon"><i
                                                        class="fas fa-eye"></i></span>
                                                <span class="input-group-text" id="eyeShowIcon2" style="display: none"><i
                                                        class="fas fa-eye-slash"></i></span>
                                                <input value="{{ old('password') }}" id="pw" type="password"
                                                    class="form-control" placeholder="Password" aria-label="Password"
                                                    name="password" aria-describedby="eyeShowIcon">
                                            </div>
                                            @error('password')
                                                <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="pw-2">Confirm Password<small
                                                    class="text-danger">*required</small></label>

                                            <div class="input-group">
                                                <span class="input-group-text" id="eyeShowIconconfirm"><i
                                                        class="fas fa-eye"></i></span>
                                                <span class="input-group-text" id="eyeShowIconconfirm2"
                                                    style="display: none"><i class="fas fa-eye-slash"></i></span>
                                                <input value="{{ old('password2') }}" id="pw-2" type="password"
                                                    class="form-control" placeholder="Confirm Password..."
                                                    aria-label="Password" name="password2" aria-describedby="eyeShowIcon">
                                            </div>


                                            {{-- <input value="{{ old('password2') }}" type="password" name="password2"
                                                class="form-control form-control-user" id="exampleInputPassword2"
                                                placeholder="Confirm Password..." required> --}}
                                            @error('password2')
                                                <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="inputAddress">Address<small
                                                    class="text-danger">*required</small></label>
                                            <textarea name="address" class="form-control" id="inputAddress" required>{{ old('address') }}</textarea>
                                            @error('address')
                                                <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group d-flex justify-content-center align-items-center">
                                            <input style="height: 25px; width:15%;" type="checkbox" id="agreed" name="agreedTOS">
                                            <label style="width: 80%; margin-left: 2%" for="agreed">Dengan Ini Saya membaca, memahami, dan menyetujui hal hal yang tercantum pada  <a href="{{route('termsOfService')}}">Terms of Service</a>
                                            </label>
                                        </div>


                                        <button id="registerBtn" type="submit"
                                            class="btn btn-success btn-user btn-block">
                                            Register
                                        </button>
                                        <p class="mt-3">Have An Account ? <a href="{{ route('login') }}"
                                                class="">
                                                Login Here
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
