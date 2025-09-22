<div class="relative inline-block">
    <button id="notifications-btn" class="px-3 py-2 relative text-gray-700 dark:text-gray-200">
        Notifications
        @if(auth()->user()->unreadNotifications->count() > 0)
            <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                {{ auth()->user()->unreadNotifications->count() }}
            </span>
        @endif
    </button>

    <div id="notifications-dropdown" class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-700 border dark:border-gray-600 rounded shadow hidden z-50">
        <div class="p-3 bg-gray-50 dark:bg-gray-800 border-b dark:border-gray-600">
            <a href="{{ route('notifications.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 block text-center">
                View all notifications
            </a>
        </div>

        @if(auth()->user()->unreadNotifications->count() > 0)
            <div class="max-h-60 overflow-y-auto">
                @foreach(auth()->user()->unreadNotifications->take(5) as $note)
                    @php $data = $note->data; @endphp
                    <div class="p-3 border-b dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <a href="{{ $data['url'] ?? '#' }}" class="block text-sm font-medium text-gray-800 dark:text-gray-100">
                            {{ $data['title'] ?? 'Notification' }}
                        </a>
                        <div class="text-xs text-gray-600 dark:text-gray-300">{{ \Illuminate\Support\Str::limit($data['message'] ?? '', 60) }}</div>
                        <form method="POST" action="{{ route('notifications.read', $note->id) }}" class="mt-1">
                            @csrf
                            <button class="text-xs text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">Mark as read</button>
                        </form>
                    </div>
                @endforeach
            </div>
            <div class="p-2 text-center border-t dark:border-gray-600 bg-gray-50 dark:bg-gray-800">
                <form method="POST" action="{{ route('notifications.readAll') }}">
                    @csrf
                    <button class="text-sm text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400">Mark all as read</button>
                </form>
            </div>
        @else
            <div class="p-4 text-center text-gray-500 dark:text-gray-300">No new notifications</div>
        @endif
    </div>
</div>

{{-- Script --}}
@push('scripts')
<script>

</script>
@endpush
