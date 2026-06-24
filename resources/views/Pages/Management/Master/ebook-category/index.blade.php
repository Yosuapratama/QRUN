@extends('TemplateLayout.AdminLayout')

@section('content')
    @push('title')
        <title>Ebook Categories - QRUN Website</title>
    @endpush

    <div class="container-fluid">

        <h1 class="h3 text-gray-800 font-weight-bold m-2">Ebook Categories</h1>

        @if (session()->has('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({ icon: 'success', title: 'Success', text: @json(session('success')), timer: 1800, showConfirmButton: false });
                });
            </script>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <div class="row">

            {{-- ADD CATEGORY --}}
            <div class="col-lg-4 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Add Category</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('ebook-category.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="small font-weight-bold text-dark">Category Name</label>
                                <input type="text" name="name" class="form-control" placeholder="e.g. Novel, Komik..." required>
                            </div>
                            <button type="submit" class="btn btn-success btn-block">
                                <i class="fas fa-plus mr-1"></i> Add Category
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- CATEGORY LIST --}}
            <div class="col-lg-8 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">All Categories ({{ $categories->count() }})</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Name</th>
                                        <th class="text-center" style="width:120px;">Ebooks</th>
                                        <th class="text-center" style="width:180px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($categories as $category)
                                        <tr>
                                            <td>{{ $category->name }}</td>
                                            <td class="text-center">
                                                <span class="badge badge-info">{{ $counts[$category->name] ?? 0 }}</span>
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-outline-primary edit-cat"
                                                    data-id="{{ $category->id }}" data-name="{{ $category->name }}">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger delete-cat"
                                                    data-id="{{ $category->id }}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted py-4">No categories yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- HIDDEN UPDATE FORM --}}
    <form id="updateForm" action="{{ route('ebook-category.update') }}" method="POST" class="d-none">
        @csrf
        <input type="hidden" name="id" id="updateId">
        <input type="hidden" name="name" id="updateName">
    </form>

    @push('script')
        <script>
            $(document).on('click', '.edit-cat', function () {
                const id = $(this).data('id');
                const name = $(this).data('name');

                Swal.fire({
                    title: 'Rename Category',
                    input: 'text',
                    inputValue: name,
                    showCancelButton: true,
                    confirmButtonText: 'Save',
                    inputValidator: (value) => (!value || !value.trim()) ? 'Name is required' : undefined
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#updateId').val(id);
                        $('#updateName').val(result.value.trim());
                        $('#updateForm').submit();
                    }
                });
            });

            $(document).on('click', '.delete-cat', function () {
                const id = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This category will be deleted. Ebooks already tagged keep their label.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'DELETE',
                            url: '/management/master/ebook-category/' + id + '/delete',
                            dataType: 'json',
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            success: function (response) {
                                if (response.success) {
                                    Swal.fire({ icon: 'success', title: response.success, timer: 1400, showConfirmButton: false })
                                        .then(() => location.reload());
                                } else {
                                    Swal.fire({ icon: 'error', title: response.errors || 'Error' });
                                }
                            }
                        });
                    }
                });
            });
        </script>
    @endpush
@endsection
