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

            <!-- Form Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row justify-content-center align-items-center">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Edit Category</h6>
                            <form action="{{ route('admin.categories.update', ['category' => $category->id]) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="name">Category Name</label>
                                    <input type="text" name="name" id="name" class="form-control" required placeholder="Enter category name" value="{{ $category->name }}">
                                </div>

                                <button type="submit" class="btn btn-primary mt-3">Update Category</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Form End -->

        </div>
        <!-- Content End -->


        </body>

        </html>
    @endsection
