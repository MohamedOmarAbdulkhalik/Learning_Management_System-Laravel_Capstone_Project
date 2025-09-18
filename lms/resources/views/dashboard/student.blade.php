@extends('layouts.app')

@section('content')
  <div>
    <h1>Assignments for: mo</h1>

    <!-- هنا نضع عنصر Vue مركّب -->
    <div id="vue-app">
      <example-component></example-component>
    </div>

    <!-- بقية الصفحة -->
  </div>
@endsection

{{-- احذف هذا الجزء --}}
{{-- @push('scripts')
  @vite(['resources/js/app.js'])
@endpush --}}