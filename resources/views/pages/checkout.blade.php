@extends('layout.default')

@section('content')
    @livewire('checkout-product', ['product' => $product])
@endsection
