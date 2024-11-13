@extends('admin.layout')

@section('content')
    <div class="row align-items-center mr-5">
        <div class="col-sm-12 col-xl-10">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">@lang('Create Category')</h6>
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">@lang('Category Name')</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="@lang('Enter category name')">
                        @error('name')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">@lang('Add Category')</button>
                </form>
            </div>
        </div>
    </div>
@endsection
