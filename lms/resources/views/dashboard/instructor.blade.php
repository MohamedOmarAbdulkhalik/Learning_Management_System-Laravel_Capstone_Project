@extends('layouts.app')

@section('content')
<h1 class="text-3xl font-bold mb-6">Instructor Dashboard</h1>

<div class="bg-white shadow rounded p-4 mb-6">
    <h2 class="text-lg font-semibold mb-4">My Courses</h2>
    <ul class="list-disc list-inside">
        @foreach($courses as $course)
            <li>{{ $course->title }} ({{ $course->lessons->count() }} lessons)</li>
        @endforeach
    </ul>
</div>

<div class="bg-white shadow rounded p-4 mb-6">
    <h2 class="text-lg font-semibold mb-4">Assignments Status</h2>
    <div id="vue-app">
        <assignments-status-chart 
        :labels='@json($chartLabels)'
        :submitted='@json($submittedCounts)'
        :graded='@json($gradedCounts)'>
        </assignments-status-chart>
    </div>

</div>

<div class="bg-white shadow rounded p-4">
    <h2 class="text-lg font-semibold mb-4">Latest Student Activities</h2>
    <table class="w-full text-left">
        <thead>
            <tr class="border-b">
                <th class="p-2">Student</th>
                <th class="p-2">Action</th>
                <th class="p-2">At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activities as $activity)
            <tr class="border-b">
                <td class="p-2">{{ $activity->student->name }}</td>
                <td class="p-2">{{ $activity->description }}</td>
                <td class="p-2">{{ $activity->created_at->diffForHumans() }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
