@extends('TemplateLayout.AdminLayout')

@section('content')
    <!-- Main Content -->
    @push('title')
        <title>My Profile Admin - QRUN Website</title>
    @endpush
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 text-gray-800 font-weight-bold m-2">My Profile</h1>
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
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">My Profile</h6>
            </div>
            <div class="card-body">
                {{-- Create Place Form --}}
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="nameUser" class="form-label">Name</label>
                        <input id="nameUser" value="{{ $User->name }}" name="name" type="text" class="form-control"
                            placeholder="Name...">
                        @error('name')
                            <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="addressUser" class="form-label">Address</label>
                        <textarea id="addressUser" name="address" class="form-control" placeholder="Address...">{{ $User->address }}</textarea>
                        @error('address')
                            <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input id="phone" value="{{ $User->phone }}" name="phone" type="number" class="form-control"
                            placeholder="Phone...Ex: 0812">
                        @error('phone')
                            <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" value="{{ $User->email }}" disabled name="email" type="email"
                            class="form-control" placeholder="Email...">
                        @error('email')
                            <p class="text-danger mt-2 mb-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <hr class="sidebar-divider">
                    <p>Setup New Password</p>
                    <div class="mb-3">
                        <label for="password" class="form-label">Current Password</label>
                        <input id="password" name="currpassword" type="password" class="form-control"
                            placeholder="Password...">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" name="password" type="password" class="form-control"
                            placeholder="Password...">
                    </div>
                    <div class="mb-3">
                        <label for="password2" class="form-label">Confirm Password</label>
                        <input id="password2" name="password2" type="password" class="form-control"
                            placeholder="Confirm Password...">
                    </div>

                    <button type="submit" class="btn btn-primary btn-md">Update Profile</button>
                </form>
            </div>
        </div>

    </div>

    @push('script')
        <script>
            //Setup SummerNote (Content Textarea Box)
            $(document).ready(function() {
                $('#summernote').summernote({
                    tabsize: 2,
                    height: 300
                });
            });
        </script>
    @endpush
    <!-- End of Main Content -->
@endsection
