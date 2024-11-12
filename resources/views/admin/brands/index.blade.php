@extends('admin.layout')
@section('content')
    <div class="row g-4">
        <div class="col-sm-12">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-2">All Brands</h6>

                <button type="button" class="btn btn-primary  add-btn">
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

                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select id="category_id" name="category_id" class="form-control" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div id="category_id-error" class="alert alert-danger" style="display: none;"></div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Add Brand</button>
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
                            getBrnadList();
                            $modal.modal('hide');
                        }
                        alert(response.message);
                    }
                });

            });

            function getBrnadList() {
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

            getBrnadList();

        });
    </script>
@endpush
