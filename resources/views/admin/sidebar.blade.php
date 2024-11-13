<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a {{ route('admin.categories.index') }} class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>@lang('DASHMIN')</h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <img class="rounded-circle" src="{{ asset('img/user.jpg') }}" alt="" style="width: 40px; height: 40px;">
                <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0">Jhon Doe</h6>
                <span>@lang('Admin')</span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            <a href="{{ route('admin.dashboard') }}" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>@lang('Dashboard')</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>@lang('Categories')</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ route('admin.categories.create') }}" class="dropdown-item">@lang('Add Category')</a>
                    <a href="{{ route('admin.categories.index') }}" class="dropdown-item">@lang('Show Categories')</a>
                </div>
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>@lang('Brands')</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ route('admin.brands.index') }}" class="dropdown-item">@lang('Show Brands')</a>
                </div>
            </div>

            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="far fa-file-alt me-2"></i>@lang('Profile Settings')</a>
            <div class="dropdown-menu bg-transparent border-0">
                <a href={{ route('admin.changepass') }} class="dropdown-item">@lang('Change password')</a>
            </div>
        </div>
</div>
