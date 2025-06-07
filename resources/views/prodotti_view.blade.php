@extends('layouts.app')

@section('title', isset($title) ? $title : 'Prodotti')

@section('scripts')
    <script>
        const categoria = @json($categoria);
    </script>
    <script src="{{ asset('js/prodotti.js') }}" defer></script>
    <script src="{{ asset('js/prodotti_view_loader.js') }}" defer></script>
@endsection

@section('page_header')
    <img class="panel-icon icon" src="{{ asset('img/tag.png') }}"> {{ isset($title) ? $title : 'Prodotti' }}
@endsection

@section('content')
@endsection
