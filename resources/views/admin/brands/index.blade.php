@extends('admin.layout')
@section('content')
    <div class="row g-4">
        <div class="col-sm-12">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-2">@lang('All Brands')</h6>

                <button type="button" class="btn btn-primary add-btn">
                    @lang('Add Brand')
                </button>

                <table class="table mt-2">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('Brand Name')</th>
                            <th>@lang('Description')</th>
                            <th>@lang('Brand Image')</th>
                            <th>@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody class="brand-table-body">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addBrandModal" tabindex="-1" aria-labelledby="addBrandModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBrandModalLabel">@lang('Add Brand')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">@lang('Brand Name')</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required maxlength="255">
                            <div id="name-error" class="alert alert-danger" style="display: none;"></div>
                        </div>

                        <div class="form-group">
                            <label for="description">@lang('Description')</label>
                            <textarea id="description" name="description" class="form-control">{{ old('description') }}</textarea>
                            <div id="description-error" class="alert alert-danger" style="display: none;"></div>
                        </div>

                        <div class="form-group">
                            <label for="image">@lang('Brand Image')</label>
                            <input type="file" id="image" name="image" class="form-control" accept="image/*">
                            <div id="image-error" class="alert alert-danger" style="display: none;"></div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">@lang('Add Brand')</button>
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
                    <h5 class="modal-title" id="editBrandModalLabel">@lang('Edit Brand')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="editBrandForm" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">@lang('Brand Name')</label>
                            <input type="text" id="name" name="name" class="form-control" value="" required maxlength="255">
                            <div id="name-error" class="alert alert-danger" style="display: none;"></div>
                        </div>

                        <div class="form-group">
                            <label for="description">@lang('Description')</label>
                            <textarea id="description" name="description" class="form-control"></textarea>
                            <div id="description-error" class="alert alert-danger" style="display: none;"></div>
                        </div>

                        <div class="form-group">
                            <label for="image">@lang('Brand Image')</label>
                            <input type="file" id="image" name="image" class="form-control" accept="image/*">

                            <div class="mt-2">
                                <img src="" alt="Current Image" id="image-container" class="img-thumbnail" style=" width: 100px; height: 50px;">
                            </div>

                            @error('image')
                                <div class="alert alert-danger"></div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">@lang('Update Brand')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- alert model --}}
    <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alertModalLabel">@lang('Edit Brand')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="alertModalForm" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <h6>@lang('Are you sure you want to delete this brand')?</h6>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary mt-3">@lang('Yes')</button>
                        <button type="button" data-bs-dismiss="modal" aria-label="Close" class=" btn btn-dark mt-3">@lang('No')</button>
                    </div>
                </form>
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
                $form.trigger('reset');
                $modal.modal('show');
            });

            $form.on('submit', function(e) {
                e.preventDefault();
                var data = new FormData(this);
                var url = "{{ route('admin.brands.store') }}";
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

                    const action = "{{ route('admin.brands.update', '') }}/" + brand.id;
                    $('.editBrandForm').attr('action', action);

                    $('.editBrandForm').find('[name="name"]').val(brand.name);
                    $('.editBrandForm').find('[name="description"]').val(brand.description);

                    $('#image-container').empty();

                    if (brand.image) {
                        const imageUrl = "{{ asset('storage') }}/" + brand.image;
                        $('#image-container').attr('src', imageUrl);
                    } else {
                        $('#image-container').attr('src', '');
                    }

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

                $('.editBrandForm').on('submit', function(e) {
                    e.preventDefault();

                    $('.alert-danger').hide();

                    var data = new FormData(this);
                    var url = $(this).attr('action');
                    console.log(url);

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



            $(document).on('click', '.deleteBtn', function() {

                var action = $(this).data('action');
                $('.alertModalForm').attr('action', action);
                $('#alertModal').modal('show');
            });



            $('.alertModalForm').on('submit', function(e) {
                e.preventDefault()
                $.ajax({
                    type: 'post',
                    url: $(this).attr('action'),
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    },
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            $(".brand-table-body").html(response.html);
                            getBrandList();
                            alert('Brand deleted successfully');
                            $('#alertModal').modal('hide');
                        }
                    },
                })

            })

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
