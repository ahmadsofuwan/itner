@extends('layouts.app')

@section('style')
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/fancy-file-uploader/fancy_fileupload.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/Drag-And-Drop/dist/imageuploadify.min.css') }}" rel="stylesheet" />
@endsection

@section('wrapper')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Maps</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-map"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Maps</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" id="add" data-bs-toggle="modal"
                            data-bs-target="#modalAdd">
                            <i class="fadeIn animated bx bx-map"></i>
                            <i class="fadeIn animated bx bx-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            <!--end breadcrumb-->
            <h6 class="text-uppercase mb-0">Maps</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table-striped table-bordered table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                                <tr>
                                    <th><input type="text" class="form-control" placeholder="Search Name" /></th>
                                    <th><input type="text" class="form-control" placeholder="Search Type" /></th>
                                    <th><input type="text" class="form-control" placeholder="Search Latitude" /></th>
                                    <th><input type="text" class="form-control" placeholder="Search Longitude" /></th>
                                    <th></th>
                                    <th></th>
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
                            <div><i class="bx bxs-map font-22 text-primary me-1"></i>
                            </div>
                            <h5 class="text-primary mb-0">Maps Add</h5>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="row g-3" id="form" action="{{ route('mapsdata.store') }}" method="POST"
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
                                <label for="inputType" class="form-label">Type</label>
                                <select class="form-control" id="inputType" name="type">
                                    <option value="">Select Type</option>
                                    <option value="tiang" {{ old('type') == 'tiang' ? 'selected' : '' }}>Tiang</option>
                                    <option value="odp" {{ old('type') == 'odp' ? 'selected' : '' }}>ODP</option>
                                    <option value="odc" {{ old('type') == 'odc' ? 'selected' : '' }}>ODC</option>
                                    <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="inputLatitude" class="form-label">Latitude</label>
                                <input type="text" class="form-control" id="inputLatitude" name="latitude"
                                    value="{{ old('latitude') }}">
                                @error('latitude')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="inputLongitude" class="form-label">Longitude</label>
                                <input type="text" class="form-control" id="inputLongitude" name="longitude"
                                    value="{{ old('longitude') }}">
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-12 mx-auto">
                                <div class="input-group">
                                    <label class="input-group-text" for="inputGroupFile01">Upload</label>
                                    <input type="file" name="image" class="form-control" id="inputGroupFile01"
                                        accept="image/jpeg,image/png,image/jpg,image/svg" onchange="previewImage(event)">
                                </div>
                                <div class="mt-3">
                                    <img id="imagePreview" src="#" alt="Image Preview"
                                        style="display: none; max-height: 200px;">
                                </div>
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <script></script>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary px-5">Save</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endpush
@section('script')
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
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
        $(document).ready(function() {
            var table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "",
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'latitude',
                        name: 'latitude'
                    },
                    {
                        data: 'longitude',
                        name: 'longitude'
                    },
                    {
                        data: 'image',
                        name: 'image',
                        render: function(data, type, full, meta) {
                            return "<img src='{{ asset('storage/maps') }}/" + data +
                                "' height='40'/>";
                        }
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
                lengthChange: false,
                initComplete: function() {
                    this.api().columns().every(function() {
                        var column = this;
                        $('input', this.header()).on('keyup change clear', function() {
                            if (column.search() !== this.value) {
                                column.search(this.value).draw();
                            }
                        });
                    });
                },
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
                                    url: "{{ route('mapsdata.destroy', '') }}/" +
                                        id,
                                    type: 'DELETE',
                                    data: {
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function() {
                                        Swal.fire('Deleted!',
                                            'Data Berhasil Dihapus',
                                            'success');
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
                        $("#form").attr('action', "{{ route('mapsdata.update', '') }}/" + id);
                        if ($("#form input[name='_method']").length === 0) {
                            $("#form").append(
                                '<input type="hidden" name="_method" value="PUT">');
                        }

                        $.ajax({
                            url: "{{ route('mapsdata.show', '') }}/" + id,
                            type: 'GET',
                            success: function(response) {
                                $("input[name='name']").val(response.name);
                                $("select[name='type']").val(response.type);
                                $("input[name='latitude']").val(response.latitude);
                                $("input[name='longitude']").val(response
                                    .longitude);
                                $("input[name='image']").val(response.image);
                            }
                        });
                    });
                }
            });

            table.buttons().container().appendTo('#dataTable_wrapper .col-md-6:eq(0)');
            $("#add").click(function() {
                $("#form").attr('action', "{{ route('mapsdata.store') }}");
                $("input[name='_method']").remove();
            });


        });
    </script>
    @if ($errors->any())
        <script>
            $(document).ready(function() {
                $('#modalAdd').modal('show');
            });
        </script>
    @endif
@endsection
