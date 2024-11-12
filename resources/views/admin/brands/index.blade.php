@extends('admin.layout')
@section('content')
    <div class="row g-4">
        <div class="col-sm-12">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-2">All Brands</h6>

                <button type="button" class="btn btn-primary add-btn">
                    Add Brand
                </button>

                <table class="table mt-2">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Brand Name</th>
                            <th>Description</th>
                            <th>Brand Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="brand-table-body">
                        {{-- @include('admin.brands.list') --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addBrandModal" tabindex="-1" aria-labelledby="addBrandModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBrandModalLabel">Add Brand</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Brand Name</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required maxlength="255">
                            <div id="name-error" class="alert alert-danger" style="display: none;"></div>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" class="form-control">{{ old('description') }}</textarea>
                            <div id="description-error" class="alert alert-danger" style="display: none;"></div>
                        </div>

                        <div class="form-group">
                            <label for="image">Brand Image</label>
                            <input type="file" id="image" name="image" class="form-control" accept="image/*">
                            <div id="image-error" class="alert alert-danger" style="display: none;"></div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Add Brand</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit --}}

    <div class="modal fade" id="editBrandModal" tabindex="-1" aria-labelledby="editBrandModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBrandModalLabel">Edit Brand</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Brand Name</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ __($brands->name) }}" required maxlength="255">
                            <div id="name-error" class="alert alert-danger" style="display: none;"></div>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" class="form-control">{{ __($brands->name) }}</textarea>
                            <div id="description-error" class="alert alert-danger" style="display: none;"></div>
                        </div>

                        <div class="form-group">
                            <label for="image">Brand Image</label>
                            <input type="file" id="image" name="image" class="form-control" accept="image/*">
                            @if ($brand->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $brands->image) }}" alt="Current Image" id="image-container" class="img-thumbnail" style=" width: 100px; height: 50px;">
                                </div>
                            @endif
                            @error('image')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Update Brand</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        $(document).ready(function() {
            var $modal = $('#addBrandModal');
            var $form = $modal.find('form');

            $('body').on('click', '.add-btn', function(e) {
                $modal.find('.modal-title').text("@lang('Add Brand')");
                $form.attr('action', "{{ route('admin.brands.store') }} ");
                $form.trigger('reset');
                $modal.modal('show');
            });

            $form.on('submit', function(e) {
                e.preventDefault();
                var data = new FormData(this);
                var brandId = $('#addBrandForm').val();
                var url = $(this).attr('action');
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: data,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            getBrandList();
                            $modal.modal('hide');
                        }
                        alert(response.message);
                    }
                });

            });

            $(document).ready(function() {
                $('body').on('click', '.edit-btn', function(e) {
                    var brand = $(this).data('brand');
                    var action = "{{ route('brands.update', ':id') }}";


                    $('#editBrandForm').find(`input[name=name]`).val(brand.name);
                    $('#editBrandForm').find(`textarea[name=description]`).val(brand.description);
                    $('#editBrandForm').find(`#brandId`).val(brand.id);

                    $('#editBrandForm').attr('action', action.replace(':id', brand.id));


                    $('#editBrandModal').find('.modal-title').text("Edit Brand");


                    $('#editBrandModal').modal('show');
                });


                $('#image').on('change', function(event) {
                    var file = event.target.files[0];
                    $('#imgContainer img').remove();
                    if (file && file.type.startsWith('image/')) {
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            $("<img />", {
                                src: e.target.result,
                                alt: "Image Preview",
                                width: 80,
                                height: 60
                            }).appendTo("#imgContainer");
                        };

                        reader.readAsDataURL(file);
                    }
                });


                $('#editBrandForm').on('submit', function(e) {
                    e.preventDefault();


                    $('.alert-danger').hide();

                    var data = new FormData(this);
                    var url = $(this).attr('action');

                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: data,
                        processData: false,
                        contentType: false,
                        dataType: "json",
                        success: function(response) {
                            if (response.success) {

                                getBrandList();


                                $('#editBrandModal').modal('hide');
                            }


                            alert(response.message);
                        },
                        error: function(xhr, status, error) {

                            var response = xhr.responseJSON;
                            if (response.errors) {

                                if (response.errors.name) {
                                    $('#name-error').text(response.errors.name).show();
                                }
                                if (response.errors.description) {
                                    $('#description-error').text(response.errors.description).show();
                                }
                            } else {
                                alert('An unexpected error occurred. Please try again later.');
                            }
                        }
                    });
                });
            });


            $('body').on('click', '.delete-btn', function() {
                var id = $(this).data('id');
                var action = "{{ route('admin.brands.destroy', ':id') }}";

                if (confirm('Are you sure want to delete this brand?')) {
                    $.ajax({
                        type: 'post',
                        url: action.replace(":id", id),
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                getBrandList();
                                $modal.modal('hide');
                            }
                            alert(response.message);
                        },
                    })
                }
            });


            function getBrandList() {
                $.ajax({
                    type: 'get',
                    url: "{{ route('admin.brands.index') }}",
                    success: function(response) {
                        if (response.success) {
                            $(".brand-table-body").html(response.html);
                        }
                    },
                })
            }

            getBrandList();

        });
    </script>
@endpush
