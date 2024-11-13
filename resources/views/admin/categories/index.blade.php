@extends('admin.layout')

@section('content')
    <!-- Form Start -->
    <div class="row g-4">
        <div class="col-sm-12">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-2">@lang('All Categories')</h6>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">@lang('Add New Category')</a>
                <table class="table mt-2">
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
                                <td>{{ $category->id }}</td>
                                <td>{{ __($category->name) }}</td>
                                <td>
                                    <!-- Edit Button -->
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning btn-sm">@lang('Edit')</a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('Are you sure you want to delete this category?') }}')">
                                            @lang('Delete')
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Form End -->

    </div>
    <!-- Content End -->


    </body>

    </html>
@endsection
