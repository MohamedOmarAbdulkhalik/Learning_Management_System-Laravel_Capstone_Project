    @extends('layouts.app')

    @section('content')
    <div id="dashboard-app"> {{-- Vue mount point --}}
    <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white shadow rounded p-4 text-center">
            <h2 class="text-lg font-semibold">Students</h2>
            <p class="text-2xl font-bold">{{ $studentsCount }}</p>
        </div>
        <div class="bg-white shadow rounded p-4 text-center">
            <h2 class="text-lg font-semibold">Courses</h2>
            <p class="text-2xl font-bold">{{ $coursesCount }}</p>
        </div>
        <div class="bg-white shadow rounded p-4 text-center">
            <h2 class="text-lg font-semibold">Assignments</h2>
            <p class="text-2xl font-bold">{{ $assignmentsCount }}</p>
        </div>
    </div>

    <div class="bg-white shadow rounded p-4 mb-6">
        <h2 class="text-lg font-semibold mb-4">Students per Course</h2>

        {{-- pass arrays as JSON into component props --}}
        <div id="vue-app">
        <course-distribution-chart 
            :labels='@json($chartLabels)' 
            :data='@json($chartData)'>
        </course-distribution-chart>
        </div>
    </div>

    <div class="bg-white shadow rounded p-4">
        <h2 class="text-lg font-semibold mb-4">Latest Submissions</h2>
        <table class="w-full text-left">
            <thead>
                <tr class="border-b">
                    <th class="p-2">Student</th>
                    <th class="p-2">Assignment</th>
                    <th class="p-2">Course</th>
                    <th class="p-2">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($latestSubmissions as $sub)
                <tr class="border-b">
                    <td class="p-2">{{ $sub->student->name }}</td>
                    <td class="p-2">{{ $sub->assignment->title }}</td>
                    <td class="p-2">{{ $sub->assignment->lesson->course->title }}</td>
                    <td class="p-2">{{ ucfirst($sub->status) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
    @endsection
