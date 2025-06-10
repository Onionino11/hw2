{{-- I dati utente ora vengono passati direttamente dal controller --}}

@extends('layouts.app')

@section('title', 'Il tuo profilo')

@section('scripts')
    <link rel="stylesheet" href="{{ asset('css/profilo.css') }}">
@endsection

@section('page_header')
    <img class="panel-icon icon" src="{{ asset('img/profilo.svg') }}"> Il tuo profilo
@endsection

@section('content')
    @if($user)
    <div class="profilo-container">
        <div class="profilo-info">
            <h2>Dati personali</h2>
            <p><strong>Nome:</strong> {{ $user->first_name }}</p>
            <p><strong>Cognome:</strong> {{ $user->last_name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Telefono:</strong> {{ $user->phone }}</p>
            <p><strong>Città:</strong> {{ $user->city }}</p>
            <p><strong>Provincia:</strong> {{ $user->province }}</p>
        </div>       
    </div>
    @endif
@endsection
