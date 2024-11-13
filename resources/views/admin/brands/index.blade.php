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
                        @include('admin.brands.list')
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade">
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
                            @error('name')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">@lang('Description')</label>
                            <textarea id="description" name="description" class="form-control">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="image">@lang('Brand Image')</label>
                            <input type="file" id="image" name="image" class="form-control" accept="image/*">
                            @error('image')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">@lang('Add Brand')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        $(document).ready(function() {
            var $modal = $('.modal');
            var $form = $modal.find('form');

            $('body').on('click', '.add-btn', function(e) {
                const action = "{{ route('admin.brands.store') }}";
                $modal.find('.modal-title').text("@lang('Add Brand')");
                $modal.find(`button[type=submit]`).text("@lang('Add Brand')");
                $modal.find('form').attr('action', action);
                $form.trigger('reset');
                $modal.modal('show');
            });

            $form.on('submit', function(e) {
                e.preventDefault();
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
                            $modal.modal('hide');
                        }
                        alert(response.message);
                    }
                });

            });


            $('body').on('click', '.edit-btn', function(e) {
                var brand = $(this).data('brand');
                const action = "{{ route('admin.brands.update', ':id') }}";

                $modal.find('.modal-title').text("@lang('Edit Brand')");
                $modal.find('form').attr('action', action.replace(":id", brand.id));

                $modal.find('[name="name"]').val(brand.name);
                $modal.find('[name="description"]').val(brand.description);
                $modal.find(`button[type=submit]`).text("@lang('Edit Brand')");

                if (brand.image) {
                    const imageUrl = "{{ asset('storage') }}/" + brand.image;
                    $('#image-container').attr('src', imageUrl);
                    $('#text-container').text('');
                } else {
                    $('#image-container').attr('src', '');
                    $('#text-container').html('No image available');
                }

                $modal.modal('show');
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


            $(".deleteBtn").on("click", function(e) {
                e.preventDefault();
                if (confirm("@lang('Are you sure to delete this?')")) {
                    window.location = $(this).attr("href");
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

        });
    </script>
@endpush
