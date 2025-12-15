<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Task Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: #333; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        table, th, td { border: 1px solid #ccc; }
        th, td { padding: 10px; text-align: left; }
        .success { color: green; }
        .error { color: red; }
        form { display: inline-block; margin: 0 5px; }
        input[type="text"], textarea, select { padding: 5px; margin-right: 5px; }
        button { padding: 5px 10px; }
    </style>
</head>
<body>
    <h1>Task Dashboard</h1>

    {{-- Thông báo --}}
    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif

    {{-- Form search --}}
    <form method="GET" action="{{ route('tasks.index') }}">
        <input type="text" name="search" value="{{ $keyword ?? '' }}" placeholder="Search tasks...">
        <button type="submit">Search</button>
    </form>

    {{-- Logout --}}
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>

    {{-- Add task --}}
    <button type="button" class="btn btn-primary" onclick="window.location='{{ route('tasks.create') }}'">Add Task</button>

    {{-- Back --}}
    @if(Auth::guard('shop')->check() && Auth::guard('shop')->user()->hasRole('admin'))
        <button type="button" class="btn btn-secondary" onclick="window.location='{{ route('admin.dashboard') }}'">
            Back
        </button>
    @else
        <button type="button" class="btn btn-secondary" onclick="window.location='{{ route('website') }}'">
            Back
        </button>
    @endif

    {{-- Bảng danh sách task --}}
    <table>
        <thead>
            <tr>
                <th>ID</th><th>Title</th><th>Description</th><th>Status</th><th>Creator</th><th>Assignee</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($tasks as $task)
            <tr>
                <td>{{ $task->id }}</td>
                <td>{{ $task->title }}</td>
                <td>{{ $task->description }}</td>
                <td>{{ $task->status }}</td>
                <td>{{ $task->creator->name ?? 'N/A' }}</td>
                <td>{{ $task->assignee->name ?? 'N/A' }}</td>
                <td>
                    {{-- Form update --}}
                    <form method="POST" action="{{ route('tasks.update', $task->id) }}">
                        @csrf @method('PUT')
                        <input type="text" name="title" value="{{ $task->title }}">
                        <input type="text" name="description" value="{{ $task->description }}">
                        <select name="status">
                            <option value="pending" @if($task->status=='pending') selected @endif>Pending</option>
                            <option value="in_progress" @if($task->status=='in_progress') selected @endif>In Progress</option>
                            <option value="completed" @if($task->status=='completed') selected @endif>Completed</option>
                        </select>
                        @if(Auth::guard('shop')->check() && Auth::guard('shop')->user()->hasRole('admin'))
                            <input type="number" name="assigned_to" value="{{ $task->assigned_to }}">
                        @endif
                        <button type="submit">Update</button>
                    </form>

                    {{-- Form delete --}}
                    <form method="POST" action="{{ route('tasks.destroy', $task->id) }}">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this task?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">No tasks found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</body>
</html>