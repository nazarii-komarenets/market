@extends('layout.default')

@section('content')
    @livewire('view-seller', ['sellerId' => $seller->id])
@endsection
