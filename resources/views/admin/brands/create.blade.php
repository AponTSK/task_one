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

                <form id="addBrandForm" action="" method="POST" enctype="multipart/form-data">
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

                    <button type="submit" class="btn btn-primary mt-3">Save Brand</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#addBrandForm').on('submit', function(e) {
                e.preventDefault();

                $('.alert-danger').addClass('d-none').text('');

                var formData = new FormData(this);

                $.ajax({
                    url: '{{ route('admin.brands.store') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {

                            $('#addBrandModal').modal('hide');
                            alert('Brand added successfully!');
                        } else {

                            if (response.errors) {
                                $.each(response.errors, function(field, message) {
                                    $('#error-' + field).removeClass('d-none').text(message);
                                });
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
