@foreach ($brands as $brand)
    <tr>
        <td>{{ $brand->id }}</td>
        <td>{{ $brand->name }}</td>
        <td>{{ $brand->description }}</td>
        <td>
            @if ($brand->image)
                <img src="{{ asset('storage/' . $brand->image) }}" alt="{{ __($brand->name) }}" style=" width: 100px; height: 50px;">
            @else
                <span>@lang('No Image')</span>
            @endif
        </td>
        <td>
            <!-- Edit Button -->
            <button class="btn btn-warning edit-btn btn-sm" data-brand="{{ $brand }}">Edit</button>

            <!-- Delete Button -->
            <button data-action="{{ route('admin.brands.destroy', $brand->id) }}" class="deleteBtn btn btn-danger btn-sm delete-btn">@lang('Delete')</button>
        </td>
    </tr>
@endforeach
