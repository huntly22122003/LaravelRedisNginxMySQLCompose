@if(session('success'))
    <div class="success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="error">{{ session('error') }}</div>
@endif
{{-- Add User --}}
<h2>Add New User</h2>
<form method="POST" action="{{ route('admin.users.store') }}">
    @csrf
    <input type="text" name="name" placeholder="Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="phone" placeholder="Phone">
    <input type="text" name="address" placeholder="Address">
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Register</button>
    <select name="role_id" required>
        <option value="">-- Select Role --</option>
        @foreach($roles as $role)
            <option value="{{ $role->id }}">{{ $role->name }}</option>
        @endforeach
    </select>
</form>
