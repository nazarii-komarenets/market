@extends('layout.default')

@section('content')
    @include('partials._fancybox')

    @livewire('view-product', ['product' => $product, 'userOrderCount' => $userOrderCount])
@endsection
