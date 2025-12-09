<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đặt lại mật khẩu</title>
</head>
<body>
    <div class="container">
        <h2>Đặt lại mật khẩu</h2>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="email" name="email" value="{{ $email ?? old('email') }}" required>
            <input type="password" name="password" placeholder="Mật khẩu mới" required>
            <input type="password" name="password_confirmation" placeholder="Xác nhận mật khẩu" required>
            <button type="submit">Đặt lại mật khẩu</button>
        </form>
    </div>
</body>
</html>