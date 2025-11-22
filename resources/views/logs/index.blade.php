@extends('layouts.app')

@section('content')
    <h1>Logs</h1>

    {{-- Форма фильтрации --}}
    <form method="GET">
        <select name="level" onchange="this.form.submit()">
            <option value="">All Levels</option>
            <option value="error" {{ request('level') == 'error' ? 'selected' : '' }}>Error</option>
            <option value="warning" {{ request('level') == 'warning' ? 'selected' : '' }}>Warning</option>
        </select>
    </form>

    {{-- Таблица логов --}}
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Level</th>
            <th>Message</th>
            <th>Created At</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($logs as $log)
            <tr>
                <td>{{ $log->id }}</td>
                <td>{{ $log->level }}</td>
                <td>{{ $log->message }}</td>
                <td>{{ $log->created_at }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{-- Пагинация --}}
    {{ $logs->appends(request()->query())->links() }}
@endsection
