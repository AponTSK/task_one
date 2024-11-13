@foreach ($brands as $brand)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ __($brand->name) }}</td>
        <td>{{ __($brand->description) }}</td>
        <td>
            @if ($brand->image)
                <img class="brand_image" src="{{ asset('storage/' . $brand->image) }}" alt="{{ __($brand->name) }}">
            @else
                <span>@lang('No Image')</span>
            @endif
        </td>
        <td>
            <button class="btn btn-warning edit-btn btn-sm">@lang('Edit')</button>
            <a class="btn btn-danger deleteBtn btn-sm" href="{{ route('admin.brands.destroy', $brand->id) }}">
                @lang('Delete')
            </a>
        </td>
    </tr>
@endforeach
