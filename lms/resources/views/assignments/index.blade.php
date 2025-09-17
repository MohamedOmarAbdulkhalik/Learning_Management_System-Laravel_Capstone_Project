@extends('layouts.app')
@section('content')
<h1>Assignments for: {{ $lesson->title }}</h1>

@can('manageLessons', $course)
  <a href="{{ route('courses.lessons.assignments.create', [$course,$lesson]) }}" class="btn">Create Assignment</a>
@endcan

@include('partials.flash')

<table class="w-full">
  <thead><tr><th>Title</th><th>Due</th><th></th></tr></thead>
  <tbody>
    @foreach($assignments as $assignment)
      <tr>
        <td><a href="{{ route('courses.lessons.assignments.show', [$course,$lesson,$assignment]) }}">{{ $assignment->title }}</a></td>
        {{-- <td>{{ $assignment->due_date ? $assignment->due_date->format('Y-m-d H:i') : '-' }}</td> --}}
<td>
  <a href="{{ route('courses.lessons.assignments.show', [$course,$lesson,$assignment]) }}" class="btn">View</a>
  @can('update', $assignment)
    <a href="{{ route('courses.lessons.assignments.edit', [$course,$lesson,$assignment]) }}" class="btn">Edit</a>
  @endcan

  @can('delete', $assignment)
    <form action="{{ route('courses.lessons.assignments.destroy', [$course,$lesson,$assignment]) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this assignment?')">
      @csrf
      @method('DELETE')
      <button type="submit" class="btn btn-danger">Delete</button>
    </form>
  @endcan
</td>

      </tr>
    @endforeach
  </tbody>
</table>

{{ $assignments->links() }}
@endsection
