<form method="POST" action="{{ route('change-password') }}">
    @csrf
    <div>
        <label for="current_password">Current Password</label>
        <input type="password" name="current_password" id="current_password" required>
    </div>

    <div>
        <label for="new_password">New Password</label>
        <input type="password" name="new_password" id="new_password" required>
    </div>

    <div>
        <label for="new_password_confirmation">Confirm New Password</label>
        <input type="password" name="new_password_confirmation" id="new_password_confirmation" required>
    </div>

    <button type="submit">Change Password</button>
</form>

@if (session('status'))
    <div>{{ session('status') }}</div>
@endif

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif
