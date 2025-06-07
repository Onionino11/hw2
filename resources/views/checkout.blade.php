@php
$ordine_inviato = $ordine_inviato ?? false;
$errore_ordine = session('error') ?? '';
$riepilogo = $riepilogo ?? [];
$totale = $totale ?? 0;
@endphp

@extends('layouts.app')

@section('title', 'Conferma Ordine')

@section('scripts')
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
    @if (!$ordine_inviato)
    <script src="{{ asset('js/checkout.js') }}" defer></script>
    @endif
@endsection

@section('page_header')
    <img class="panel-icon icon" src="{{ asset('img/cart.svg') }}"> Checkout
@endsection

@section('content')
@if ($ordine_inviato)    <div class="ordine-success">
        <strong>Ordine inviato con successo!</strong>
        <p>Grazie per aver ordinato da Maluburger.</p>
        
        <h3>Riepilogo ordine:</h3>
        <ul>
            @foreach($riepilogo as $item)
                <li>
                    <span>{{ $item->quantita }} x {{ $item->nome }}</span>
                    <span>€{{ number_format($item->prezzo, 2, ',', '') }}</span>
                </li>
            @endforeach
        </ul>
        
        <div class="ordine-totale">
            Totale: <span>{{ number_format($totale, 2, ',', '') }} €</span>
        </div>
        
        <a href="{{ route('home') }}" class="btn-concludi-ordine">
            Torna alla Home
        </a>
    </div>
@elseif ($errors->any())
    <div class="ordine-errore">
        <strong>Errore:</strong> {{ $errors->first() }}
    </div>
@endif

@if (!$ordine_inviato)
                <form action="{{ route('checkout.process') }}" method="post" class="form">
                    @csrf                    <div class="form-group">
                        <label for="note" class="control-label">Note per l'ordine</label>
                        <div class="controls">
                            <textarea name="note" class="form-control" placeholder="Eventuali note da allegare all'ordine.">{{ old('note', '') }}</textarea>
                        </div>
                    </div><div class="form-group">
                        <label for="first_name" class="control-label">Nome</label>
                        <div class="controls">
                            <input type="text" name="first_name" class="form-control" placeholder="Nome" value="{{ old('first_name', $first_name ?? '') }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="last_name" class="control-label">Cognome</label>
                        <div class="controls">
                            <input type="text" name="last_name" class="form-control" placeholder="Cognome" value="{{ old('last_name', $last_name ?? '') }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="control-label">Telefono</label>
                        <div class="controls">
                            <input type="text" name="phone" class="form-control" placeholder="Telefono" value="{{ old('phone', $phone ?? '') }}" required>
                        </div>
                    </div>                    <div class="form-group">
                        <label class="control-label">Metodo di consegna</label>
                        <div class="controls">
                            <label><input type="radio" name="consegna" value="ritiro" {{ old('consegna', 'ritiro') == 'ritiro' ? 'checked' : '' }}> Ritiro presso Maluburger</label>
                            <label><input type="radio" name="consegna" value="tavolo" {{ old('consegna') == 'tavolo' ? 'checked' : '' }}> Ordine al tavolo</label>
                            <label><input type="radio" name="consegna" value="domicilio" {{ old('consegna') == 'domicilio' ? 'checked' : '' }}> Consegna a domicilio</label>
                        </div>
                    </div>                    <div class="form-group">
                        <label class="control-label">Metodo di pagamento</label>
                        <div class="controls">
                            <label><input type="radio" name="pagamento" value="contanti" {{ old('pagamento', 'contanti') == 'contanti' ? 'checked' : '' }}> In contanti</label>
                            <label><input type="radio" name="pagamento" value="carta" {{ old('pagamento') == 'carta' ? 'checked' : '' }}> Bancomat / Carta</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Riepilogo ordine</label>
                        <div class="controls">
                            <ul id="checkout-summary-list"></ul>
                            <div style="text-align:right; font-weight:bold;">Totale: <span id="checkout-summary-totale">0,00 €</span></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Invia ordine" class="submit">
                    </div>
                </form>
@endif            </div>
@endsection

@section('cart')
    Ottima scelta! Il tuo carrello è pronto per essere confermato.
@endsection