@extends('layouts.app')

@section('scripts')
    <script>
        const categoria = @json($categoria);
    </script>
    <script src="{{ asset('js/prodotti.js') }}" defer></script>
    <script src="{{ asset('js/prodotti_view_loader.js') }}" defer></script>
@endsection

@section('content')
@endsection
