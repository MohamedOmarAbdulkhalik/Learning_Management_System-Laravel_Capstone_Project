@extends('layouts.app')
@section('content')
<h1>{{ $assignment->title }}</h1>
<p>{{ $assignment->description }}</p>
<p>Due: {{ $assignment->due_date ?? 'No due date' }}</p>

@include('partials.flash')

<hr>
<h2>Submissions</h2>

@auth
  @if(auth()->user()->role === 'student')
    {{-- عرض زر إرسال الحل أو نموذج الإرسال --}}
    @php
      $mySubmission = $assignment->submissions->where('student_id', auth()->id())->first();
    @endphp

    @if(!$mySubmission)
      <form action="{{ route('assignments.submissions.store', $assignment) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div><label>Text answer</label>
          <textarea name="content" class="input"></textarea>
        </div>
        <div class="mt-2">
          <label>File (optional)</label>
          <input type="file" name="file" />
        </div>
        <button class="btn mt-2">Submit</button>
      </form>
    @else
      <div class="bg-gray-100 p-3 rounded">
        <p>Status: {{ $mySubmission->status }}</p>
        <p>Grade: {{ $mySubmission->grade ?? '-' }}</p>
        <p>Feedback: {{ $mySubmission->feedback ?? '-' }}</p>
        @if($mySubmission->file_path)
          <p><a href="{{ Storage::url($mySubmission->file_path) }}" target="_blank">Download your file</a></p>
        @endif
      </div>
    @endif
  @endif
@endauth

<hr>
<h3>All Submissions (for instructors)</h3>
@can('grade', $assignment->submissions->first() ?? null)
  <table class="w-full">
    <thead><tr><th>Student</th><th>Status</th><th>Grade</th><th></th></tr></thead>
    <tbody>
      @foreach($assignment->submissions as $submission)
        <tr>
          <td>{{ $submission->student->name }}</td>
          <td>{{ $submission->status }}</td>
          <td>{{ $submission->grade ?? '-' }}</td>
          <td>
            <a href="{{ route('submissions.show', $submission) }}" class="btn">View</a>
            <form action="{{ route('submissions.grade', $submission) }}" method="POST" class="inline-block">
              @csrf
              <input type="number" name="grade" placeholder="Grade" min="0" max="100" class="input" />
              <input type="text" name="feedback" placeholder="Feedback" class="input" />
              <button class="btn">Save</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endcan

@endsection
