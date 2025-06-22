@extends('layouts.app')

@section('title', 'I tuoi ordini')

@section('scripts')
    <link rel="stylesheet" href="{{ asset('css/ordini.css') }}">
    <script src="{{ asset('js/ordini.js') }}" defer></script>
@endsection

@section('page_header')
    <img class="panel-icon icon" src="{{ asset('img/ordini.svg') }}"> I tuoi ordini
@endsection

@section('content')    <div class="ordini-container" id="ordini-container">
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        
        <div id="ordini-content">
        
        </div>
    </div>
@endsection
