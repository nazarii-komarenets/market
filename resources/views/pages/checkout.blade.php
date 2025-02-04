@extends('layout.default')

@section('content')
    @include('partials._fancybox')

    @livewire('checkout-product', ['product' => $product])
@endsection
