@extends('admin.layout')

@section('content')
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Sidebar Start -->
        @include('admin.sidebar')
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">

            <!-- Navbar Start -->
            @include('admin.navbar')
            <!-- Navbar End -->

            <!-- Brands Start -->
            @include('admin.brands')
            <!-- Brands End -->

        </div>
        <!-- Content End -->

    </div>
@endsection
