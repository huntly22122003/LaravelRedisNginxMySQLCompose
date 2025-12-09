@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif


<form method="POST" action="{{ route('login') }}">
    @csrf
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Mật khẩu" required>
    <label>
        <input type="checkbox" name="remember"> Remember Me
    </label>
    <button type="submit">Login</button>
</form>
<form method="GET" action="{{route('password.request')}}">
    <button>Forgot password</button>
</form>