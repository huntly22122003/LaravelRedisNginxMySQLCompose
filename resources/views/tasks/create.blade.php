<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tạo Task</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<body>
<div class="container mt-4">
    <h1>Tạo Task</h1>

    {{-- Hiển thị lỗi validate --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Hiển thị thông báo thành công --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label>Tiêu đề</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="form-group mb-3">
            <label>Mô tả</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label>Trạng thái</label>
            <select name="status" class="form-control">
                <option value="pending" @selected(old('status')=='pending')>Pending</option>
                <option value="in_progress" @selected(old('status')=='in_progress')>In Progress</option>
                <option value="completed" @selected(old('status')=='completed')>Completed</option>
            </select>
        </div>

        @if(Auth::guard('shop')->check() && Auth::guard('shop')->user()->hasRole('admin'))
        <div class="form-group mb-3">
            <label>Người được giao</label>
            <select name="assigned_to" class="form-control">
            <option value="">-- Chọn người --</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" @selected(old('assigned_to') == $user->id)>
                    {{ $user->name }}
                </option>
            @endforeach
            </select>
        </div>
        @else
        {{-- User thường: gán mặc định cho chính họ --}}
        <input type="hidden" name="assigned_to" value="{{ Auth::guard('shop')->id() }}">
        @endif

        <button type="submit" class="btn btn-success">Tạo</button>
    </form>
    <button type="button" class="btn btn-secondary" onclick="window.location='{{ url()->previous() }}'">Back</button>
</div>
</body>
</html>