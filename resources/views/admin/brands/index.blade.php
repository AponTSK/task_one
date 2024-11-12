@extends('admin.layout')

@section('content')
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

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
                <div class="row g-4">
                    <div class="col-sm-12">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-2">All Brands</h6>

                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addBrandModal">
                                Add Brand
                            </button>

                            <table class="table mt-2">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Brand Name</th>
                                        <th>Description</th>
                                        <th>Brand Image</th>
                                        <th>Category</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($brands as $brand)
                                        <tr>
                                            <td>{{ $brand->id }}</td>
                                            <td>{{ $brand->name }}</td>
                                            <td>{{ $brand->description }}</td>
                                            <td>
                                                @if ($brand->image)
                                                    <img src="{{ asset('storage/' . $brand->image) }}" alt="{{ $brand->name }}" style=" width: 100px; height: 50px;">
                                                @else
                                                    <span>No Image</span>
                                                @endif
                                            </td>
                                            <td>{{ $brand->category->name ?? 'No category assigned' }}</td>
                                            <td>
                                                <!-- Edit Button -->
                                                <a href="{{ route('admin.brands.edit', $brand->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                                <!-- Delete Button -->
                                                <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this brand?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Form End -->

            @include('admin.brands.create')
        </div>
        <!-- Content End -->


        </body>

        </html>
    @endsection
