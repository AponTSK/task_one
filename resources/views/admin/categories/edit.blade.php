@extends('admin.layout')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row justify-content-center align-items-center">
            <div class="col-sm-12 col-xl-6">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">@lang('Edit Category')</h6>
                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">@lang('Category Name')</label>
                            <input type="text" name="name" id="name" class="form-control" required placeholder="Enter category name" value="{{ $category->name }}">
                            @error('name')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">@lang('Update Category')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
