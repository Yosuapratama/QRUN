@extends('TemplateLayout.UserLayout')

@push('title')
    <title>QRUN Website - Register</title>
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
                            <div class="col-lg-6 col-xl-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4 font-weight-bold">Register To QRUN</h1>
                                    </div>
                                    <form method="POST" action="{{ route('register.store') }}">
                                        @csrf
                                        <div class="form-group">
                                            <label for="nameLogin">Name<small class="text-danger">*required</small></label>
                                            <input type="text" class="form-control form-control-user" id="nameLogin"
                                                name="name" placeholder="Enter name Address..." required>
                                            @error('name')
                                                <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="phoneNum">Phone Number<small class="text-danger">*required</small></label>
                                            <input type="number" class="form-control form-control-user" id="phoneNum"
                                                name="phone" placeholder="Enter Phone Num (08..).." required>
                                            @error('phone')
                                                <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail">Email<small
                                                    class="text-danger">*required</small></label>
                                            <input type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" name="email" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address..." required>
                                            @error('email')
                                                <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword">Password<small
                                                    class="text-danger">*required</small></label>
                                            <input type="password" name="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Password" required>
                                            @error('password')
                                                <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword2">Confirm Password<small
                                                    class="text-danger">*required</small></label>
                                            <input type="password" name="password2" class="form-control form-control-user"
                                                id="exampleInputPassword2" placeholder="Confirm Password..." required>
                                            @error('password2')
                                                <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="inputAddress">Address<small
                                                    class="text-danger">*required</small></label>
                                            <textarea name="address" class="form-control" id="inputAddress" required></textarea>
                                            @error('address')
                                                <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-success btn-user btn-block">
                                            Register
                                        </button>
                                        <p class="mt-3">Have An Account ? <a href="{{ route('login') }}" class="">
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
