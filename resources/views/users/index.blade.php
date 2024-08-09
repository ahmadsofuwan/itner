@extends('layouts.app')

@section('style')
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endsection

@section('wrapper')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Users</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Users</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" id="addUser" data-bs-toggle="modal"
                            data-bs-target="#addUserModal">
                            <i class="fadeIn animated bx bx-user-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            <!--end breadcrumb-->
            <h6 class="text-uppercase mb-0">Users</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table-striped table-bordered table">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end page wrapper -->
@endsection
@push('modal')
    <div>
        <div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="card-title d-flex align-items-center">
                            <div><i class="bx bxs-user font-22 text-primary me-1"></i>
                            </div>
                            <h5 class="text-primary mb-0">User Add</h5>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="row g-3" id="form" action="{{ route('users.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-4">
                                <label for="inputLastName" class="form-label">Name</label>
                                <input type="text" class="form-control" id="inputLastName" name="name"
                                    value="{{ old('name') }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="inputLastName" class="form-label">Username</label>
                                <input type="text" class="form-control" id="inputLastName" name="username"
                                    value="{{ old('username') }}">
                                @error('username')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="inputLastName" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="inputLastName" name="phone"
                                    value="{{ old('phone') }}">
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="inputEmail" name="email"
                                    value="{{ old('email') }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="inputPassword" class="form-label">Password</label>
                                <input type="password" class="form-control" id="inputPassword" name="password"
                                    value="{{ old('password') }}">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="inputState" class="form-label">Role</label>
                                <select id="inputState" class="form-select" name="role">
                                    <option selected="">Pilih Role...</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                                </select>
                                @error('role')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="formFileDisabled" class="form-label">Foto Profile</label>
                                <input class="form-control" type="file" name="image" accept="image/*"
                                    onchange="previewImage(event)">
                                <img id="imagePreview" src="#" alt="Preview Image"
                                    style="display: none; margin-top: 10px; max-width: 20%; height: auto;">
                            </div>
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary px-5">Register</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endpush
@section('script')
    <script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('users.index') }}",
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'role',
                        name: 'role'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
                lengthChange: false,
                drawCallback: function() {
                    $('.delete').click(function() {
                        var id = $(this).data('id');
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: "{{ route('users.destroy', '') }}/" +
                                        id,
                                    type: 'DELETE',
                                    data: {
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function() {
                                        Swal.fire(
                                            'Deleted!',
                                            'User has been deleted.',
                                            'success'
                                        );
                                        table.ajax.reload();
                                    }
                                });
                            }
                        });
                    });
                    $(".edit").click(function() {
                        var id = $(this).data('id');
                        console.log(id);
                        $('#addUserModal').modal('show');
                        $("#form").attr('action', "{{ route('users.update', '') }}/" + id);
                        if ($("#form input[name='_method']").length === 0) {
                            $("#form").append(
                                '<input type="hidden" name="_method" value="PUT">');
                        }

                        $.ajax({
                            url: "{{ route('users.show', '') }}/" + id,
                            type: 'GET',
                            success: function(response) {
                                $("input[name='name']").val(response.name);
                                $("input[name='username']").val(response.username);
                                $("input[name='email']").val(response.email);
                                $("select[name='role']").val(response.role);
                                $("input[name='password']").val('');
                                $("input[name='phone']").val(response.phone);
                            }
                        });




                    });
                }
            });

            table.buttons().container()
                .appendTo('#dataTable_wrapper .col-md-6:eq(0)');
            $("#addUser").click(function() {
                $("#form").attr('action', "{{ route('users.store') }}");
                $("input[name='_method']").remove();
            })


        });
    </script>
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('imagePreview');
                output.src = reader.result;
                output.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
        @if ($errors->any())
            $(document).ready(function() {
                $('#addUserModal').modal('show');
            });
        @endif
    </script>
@endsection
