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
        <td>
            <!-- Edit Button -->
            <a class="btn btn-warning edit-btn btn-sm">Edit</a>

            <!-- Delete Button -->
            <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm delete-btn">Delete</button>
            </form>
        </td>
    </tr>
@endforeach
