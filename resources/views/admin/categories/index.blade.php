@extends('admin.layout') @section('content')
    <div class="row g-4">
        <div class="col-sm-12">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">@lang('All Categories')</h6>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">@lang('Add New Category')</a>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('Category Name')</th>
                            <th>@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ __($category->name) }}</td>
                                <td class="button-container">
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning btn-sm">@lang('Edit')</a>
                                    <a class="btn btn-danger deleteBtn btn-sm" href="{{ route('admin.categories.destroy', $category->id) }}">
                                        @lang('Delete')
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $(".deleteBtn").on("click", function(e) {
                e.preventDefault();
                if (confirm("@lang('Are you sure to delete this category?')")) {
                    window.location = $(this).attr("href");
                }
            });
        });
    </script>
@endpush
