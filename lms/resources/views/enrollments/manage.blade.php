@extends('layouts.app')

@section('content')
<h1>Manage Enrollments - {{ $course->title }}</h1>

@include('partials.flash')

<h3>Enrolled Students</h3>
<table class="w-full">
    <thead><tr><th>Name</th><th>Email</th><th></th></tr></thead>
    <tbody>
    @foreach($students as $s)
        <tr>
            <td>{{ $s->name }}</td>
            <td>{{ $s->email }}</td>
            <td>
                <form action="{{ route('courses.students.remove', [$course, $s]) }}" method="POST" style="display:inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger" onclick="return confirm('Remove student?')">Remove</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{ $students->links() }}

<h3 class="mt-6">Add Student</h3>
<form action="{{ route('courses.students.add', $course) }}" method="POST">
    @csrf
    <select name="student_id" required>
        <option value="">Select student</option>
        @foreach($available as $a)
            <option value="{{ $a->id }}">{{ $a->name }} ({{ $a->email }})</option>
        @endforeach
    </select>
    <button class="btn">Add</button>
</form>
@endsection
