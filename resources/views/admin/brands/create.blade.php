{{-- @push('scripts')
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
                            window.location = '{{ route('admin.brands.index') }}';
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

                $(document).ready(function() {
                    var $modal = $('.modal');
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

                });
    </script>
@endpush --}}
