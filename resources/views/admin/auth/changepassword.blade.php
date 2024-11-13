@extends('admin.layout')

@section('content')


    <div class="row h-100 align-items-center justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="bg-light rounded p-3 p-sm-4 my-3 mx-2">
                <div class="align-items-center justify-content-between mb-2">
                    <a href="index.html" class="">
                        <h5 class="text-primary"><i class="fa fa-hashtag me-2"></i>@lang('DASHMIN')</h5>
                    </a>
                    <h5>@lang('Change Password')</h5>
                </div>

                @if (session('status'))
                    <div class="alert alert-success mb-3">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="text-danger mb-3">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.change-password') }}">
                    @csrf

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                        <label for="current_password">@lang('Current Password')</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                        <label for="new_password">@lang('New Password')</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                        <label for="new_password_confirmation">@lang('Confirm New Password')</label>
                    </div>

                    <button type="submit" class="btn btn-primary py-2 w-100 mb-3">@lang('Change Password')</button>
                </form>
            </div>
        </div>
    </div>

    @include('admin.js')
@endsection
