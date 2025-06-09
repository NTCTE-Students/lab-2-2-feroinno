<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Task manager</title>
</head>
<body>
    <h1>Task manager</h1>
    <p>Welcome to the task manager application!</p>
    @auth
        <p>Hello, {{ auth()->user()->name }}!</p>
        <ul>
            <li><a href="{{ route('logout') }}">Logout</a></li>
        </ul>
    @else
        <p>To get started, please register or log in.</p>
        <ul>
            <li><a href="{{ route('register') }}">Register</a></li>
            <li><a href="{{ route('login') }}">Login</a></li>
        </ul>
    @endauth

    <h2>Tasks</h2>
    @auth
        <form method="GET" action="{{ route('index') }}">
            <label for="status">Status:</label>
            <select name="status" id="status" onchange="this.form.submit()">
                <option value="">All</option>
                <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="in_progress" {{ $status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
            <label for="sort">Sort by:</label>
            <select name="sort" id="sort">
                <option value=""> None </option>
                <option value="created_at" {{ $sort === 'created_at' ? 'selected' : '' }}>Date</option>
                <option value="status" {{ $sort === 'status' ? 'selected' : '' }}>Status</option>
            </select>
            <select name="direction" id="direction">
                <option value="asc" {{ $direction === 'asc' ? 'selected' : '' }}>Ascending</option>
                <option value="desc" {{ $direction === 'desc' ? 'selected' : '' }}>Descending</option>
            </select>
            <label for="search">Search:</label>
            <input type="text" name="search" id="search" value="{{ $search ?? '' }}" placeholder="Enter...">
            <button type="submit">Apply</button>
            <a href="{{ route('index') }}">Reset</a>
        </form>
        @if ($tasks -> count() > 0)
            <ul>
                @foreach ($tasks as $task)
                    <li>
                        <h3>
                            <b>{{ $task->title }}</b>
                            -
                            {{ $task->status }}
                            |
                            <a href="{{ route('tasks.index', $task -> id) }}">View</a>
                            <a href="{{ route('tasks.delete', $task -> id) }}">Delete</a>
                        </h3>
                        <p>{{ $task->description }}</p>
                    </li>
                @endforeach
            </ul>
            <a href="{{ route('tasks.index') }}">Create a new task</a>
        @else
            <p>You have no tasks{{ $status ? ' with status "' . $status . '"' : ' yet' }}.</p>
            <a href="{{ route('tasks.index') }}">Create a new task</a>
        @endif
    @else
        <p>You need to be logged in to see your tasks.</p>
    @endauth
</body>
</html>
