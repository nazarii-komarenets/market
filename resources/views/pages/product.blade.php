@extends('layout.default')

@section('content')
    @livewire('view-product', ['product' => $product, 'userOrderCount' => $userOrderCount])
@endsection
