@extends('layouts.app')

@section('style')
    <link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
@endsection

@section('wrapper')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Olt</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Olt</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" id="add" data-bs-toggle="modal"
                            data-bs-target="#modalAdd">
                            <i class="fadeIn animated bx bx-server"></i>
                            <i class="fadeIn animated bx bx-plus"></i>
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
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Address</th>
                                    <th>Port</th>
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
        <div class="modal fade" id="modalAdd" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="card-title d-flex align-items-center">
                            <div><i class="bx bxs-server font-22 text-primary me-1"></i>
                            </div>
                            <h5 class="text-primary mb-0">Olt Add</h5>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="row g-3" id="form" action="{{ route('olt.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-6">
                                <label for="inputLastName" class="form-label">Name</label>
                                <input type="text" class="form-control" id="inputLastName" name="name"
                                    value="{{ old('name') }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="inputLastName" class="form-label">Username</label>
                                <input type="text" class="form-control" id="inputLastName" name="username"
                                    value="{{ old('username') }}">
                                @error('username')
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
                                <label for="inputAddress" class="form-label">Address</label>
                                <input type="text" class="form-control" id="inputAddress" name="address"
                                    value="{{ old('address') }}">
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="inputPort" class="form-label">Port</label>
                                <input type="number" class="form-control" id="inputPort" name="port"
                                    value="{{ old('port') }}">
                                @error('port')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
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
                ajax: "{{ route('olt.index') }}",
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'port',
                        name: 'port'
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
                                    url: "{{ route('olt.destroy', '') }}/" +
                                        id,
                                    type: 'DELETE',
                                    data: {
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function() {
                                        Swal.fire(
                                            'Deleted!',
                                            'Data Berhasil Dihapus',
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
                        $('#modalAdd').modal('show');
                        $("#form").attr('action', "{{ route('olt.update', '') }}/" + id);
                        if ($("#form input[name='_method']").length === 0) {
                            $("#form").append(
                                '<input type="hidden" name="_method" value="PUT">');
                        }

                        $.ajax({
                            url: "{{ route('olt.show', '') }}/" + id,
                            type: 'GET',
                            success: function(response) {
                                $("input[name='name']").val(response.name);
                                $("input[name='username']").val(response.username);
                                $("input[name='password']").val(response.password);
                                $("input[name='address']").val(response.address);
                                $("input[name='port']").val(response.port);
                            }
                        });




                    });
                }
            });

            table.buttons().container()
                .appendTo('#dataTable_wrapper .col-md-6:eq(0)');
            $("#add").click(function() {
                $("#form").attr('action', "{{ route('olt.store') }}");
                $("input[name='_method']").remove();
            })


        });
    </script>
@endsection
