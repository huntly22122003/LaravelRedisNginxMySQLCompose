<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Security Logs</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<body>
    <div class="container mt-4">
        <h1>Security Logs</h1>
        <button type="button" class="btn btn-secondary" onclick="window.location='{{ route('website') }}'">Back</button>
        {{-- Hiển thị thông báo thành công nếu có --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Hiển thị lỗi nếu có --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Thời gian</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td>{{ $log->created_at }}</td>
                        <td>{{ $log->action }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center">Chưa có log nào</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Nếu dùng paginate() thì mới có links --}}
        @if(method_exists($logs, 'links'))
            <div class="d-flex justify-content-center">
                {{ $logs->links() }}
            </div>
        @endif
</div>
</body>
</html>