@extends('layout.default')

@section('content')
    <div class="block md:flex justify-between">
        <div class="w-full md:w-1/2">
            <x-filament::section.heading class="mb-10">Про нас</x-filament::section.heading>
            <x-filament::section>
                <x-filament::section.description>
                    Коротка інформація про нас
                </x-filament::section.description>
            </x-filament::section>
        </div>
    </div>
@endsection
