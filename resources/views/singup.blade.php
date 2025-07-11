@extends('layouts.app')

@section('title', 'Registrazione')

@section('scripts')
    <link rel="stylesheet" href="{{ asset('css/registration.css') }}">
@endsection

@section('page_header')
    <img class="panel-icon icon" src="{{ asset('img/key.svg') }}"> Registrazione
@endsection

@section('content')
<article>
    <section id="panel">
        <div id="panel-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ url('singup') }}" method="post" class="form registration-form">
                @csrf
                <div class="form-group">
                    <label for="email" class="control-label">Email</label>
                    <div class="controls">
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="control-label">Password</label>
                    <div class="controls">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirm_password" class="control-label">Conferma password</label>
                    <div class="controls">
                        <input type="password" name="confirm_password" class="form-control" placeholder="Conferma password">
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label for="first_name" class="control-label">Nome</label>
                    <div class="controls">
                        <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control" placeholder="Nome">
                    </div>
                </div>
                <div class="form-group">
                    <label for="last_name" class="control-label">Cognome</label>
                    <div class="controls">
                        <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control" placeholder="Cognome">
                    </div>
                </div>                <div class="form-group">
                    <label for="birthday" class="control-label">Data di nascita</label>
                    <div class="controls">
                        <div class="control-input-date">
                            <input type="date" name="birthday" value="{{ old('birthday') }}" class="form-control date-input" placeholder="Data di nascita">
                        </div>
                    </div>
                </div>                <div class="form-group">
                    <label for="city" class="control-label">Città</label>
                    <div class="controls">
                        <div class="row">
                            <div class="campo1">
                                <input type="text" name="city" value="{{ old('city') }}" class="form-control" placeholder="Città">
                            </div>
                            <div class="campo2">
                                <input type="text" name="province" value="{{ old('province') }}" class="form-control" placeholder="Provincia" maxlength="2">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone" class="control-label">Telefono</label>
                    <div class="controls">
                        <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" placeholder="Telefono">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label"></label>
                    <div class="signup-accept-marketing">
                        <div>
                            <p>Acconsento al trattamento dei miei dati personali per:</p>
                            <input type="hidden" name="accept_marketing" value="0">                            
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="accept_marketing" value="1" > Ricevere sconti esclusivi, novità ed offerte
                                </label>
                            </div>
                            <p>Registrandoti accetti la nostra <a href="#">politica sulla privacy</a> e prendi visione dell'informativa sul <a href="#">trattamento dei dati personali</a> di Maluburger</p>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label"></label>
                    <input type="submit" name="signup" value="Registrazione" class="submit">
                </div>
            </form>
        </div>
    </section>
</article>
@endsection

@section('cart')
@endsection