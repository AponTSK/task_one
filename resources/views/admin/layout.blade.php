<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.headers')
</head>

<body>

    <div class="container-xxl position-relative bg-white d-flex p-0">

        <!-- Sidebar Start -->
        @include('admin.sidebar')
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">

            <!-- Navbar Start -->
            @include('admin.navbar')
            <!-- Navbar End -->

            <!-- Form Start -->
            <div class="container-fluid pt-4 px-4">
                @yield('content')
            </div>

        </div>

    </div>

    @include('admin.js')

</body>

</html>
