<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test 419</title>
</head>
<body>
    <h1>Test POST để check lỗi 419</h1>

    <form action="/test" method="POST">
        @csrf <!-- Comment dòng này để test lỗi 419 -->
        <input type="text" name="name" placeholder="Nhập tên">
        <button type="submit">Gửi POST</button>
    </form>

    <p>
        Nếu bạn **bỏ `@csrf`**, khi submit sẽ nhận **lỗi 419 Page Expired**.
    </p>
</body>
</html>
