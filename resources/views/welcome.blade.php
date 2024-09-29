@extends('layout.default')

@section('content')
    <div class="mb-10">
        <livewire:welcome-banner></livewire:welcome-banner>
    </div>

    <div class="bg-gray-50 text-black/50">
        @livewire('list-products')
    </div>
@endsection
