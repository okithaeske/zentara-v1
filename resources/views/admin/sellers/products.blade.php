@extends('layouts.admin')

@section('content')
@php($title = $seller->name . ' — Products')
<livewire:admin.seller-products-table :seller="$seller" />
@endsection
