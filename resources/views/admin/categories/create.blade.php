@extends('admin.layout')

@section('content')
    <!-- Form Start -->
    <div class="row align-items-center mr-5">
        <div class="col-sm-12 col-xl-10">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Create Category</h6>
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="name">Category Name</label>
                        <input type="text" name="name" id="name" class="form-control" required placeholder="Enter category name">
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Add Category</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Form End -->

    <!-- Content End -->


    </body>

    </html>
@endsection
