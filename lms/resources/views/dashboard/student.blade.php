@extends('layouts.app')

@section('content')
<h1 class="text-3xl font-bold mb-6">Student Dashboard</h1>

<div class="bg-white shadow rounded p-4 mb-6">
    <h2 class="text-lg font-semibold mb-4">My Courses</h2>
    <ul class="list-disc list-inside">
        @foreach($myCourses as $course)
            <li>{{ $course->title }}</li>
        @endforeach
    </ul>
</div>

<div class="bg-white shadow rounded p-4 mb-6">
    <h2 class="text-lg font-semibold mb-4">My Grades</h2>
    <div id="vue-app">
    <grades-chart 
        :labels='@json($chartLabels)' 
        :data='@json($chartData)'>
    </grades-chart>
    </div>

</div>

<div class="bg-white shadow rounded p-4">
    <h2 class="text-lg font-semibold mb-4">Recent Assignments</h2>
    <table class="w-full text-left">
        <thead>
            <tr class="border-b">
                <th class="p-2">Assignment</th>
                <th class="p-2">Course</th>
                <th class="p-2">Status</th>
                <th class="p-2">Grade</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mySubmissions as $sub)
            <tr class="border-b">
                <td class="p-2">{{ $sub->assignment->title }}</td>
                <td class="p-2">{{ $sub->assignment->lesson->course->title }}</td>
                <td class="p-2">{{ ucfirst($sub->status) }}</td>
                <td class="p-2">{{ $sub->grade ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
