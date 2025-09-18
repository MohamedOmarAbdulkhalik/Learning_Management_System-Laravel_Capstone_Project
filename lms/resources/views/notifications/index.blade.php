@extends('layouts.app')

@section('content')
<h1 class="text-xl font-bold mb-4">Notifications</h1>

@foreach($notifications as $note)
    @php $data = $note->data; @endphp
    <div class="p-4 mb-2 border rounded {{ $note->read_at ? 'bg-white' : 'bg-blue-50' }}">
        <div class="flex justify-between">
            <div>
                <a href="{{ $data['url'] ?? '#' }}" class="font-semibold">{{ $data['title'] ?? 'Notification' }}</a>
                <div class="text-sm text-gray-600">{{ $data['message'] ?? '' }}</div>
            </div>
            <div class="text-sm text-gray-500">{{ $note->created_at->diffForHumans() }}</div>
        </div>
    </div>
@endforeach

{{ $notifications->links() }}
@endsection
