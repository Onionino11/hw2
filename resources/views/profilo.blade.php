{{-- I dati utente ora vengono passati direttamente dal controller --}}

@extends('layouts.app')

@section('title', 'Il tuo profilo')

@section('scripts')
    <link rel="stylesheet" href="{{ asset('css/profilo.css') }}">
    <script src="{{ asset('js/profilo.js') }}" defer></script>
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
        </div>        <div class="profilo-ordini">
            <h2>I tuoi ordini recenti</h2>

            @if(count($ordini) > 0)
                <table class="ordini-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Data</th>
                            <th>Totale</th>
                            <th>Stato</th>
                        </tr>
                    </thead>
                    <tbody>                        @foreach($ordini as $ordine)
                        <tr class="ordine-row" data-ordine-id="{{ $ordine->id }}">
                            <td>#{{ $ordine->id }}</td>
                            <td>{{ date('d/m/Y H:i', strtotime($ordine->created_at)) }}</td>
                            <td>€{{ number_format($ordine->totale, 2, ',', '.') }}</td>
                            <td>Completato <span class="dettagli-btn">&#9660;</span></td>
                        </tr>
                        <tr class="dettagli-ordine hidden" id="dettagli-{{ $ordine->id }}">
                            <td colspan="4">
                                <div class="dettagli-container">
                                    <h4>Dettagli dell'ordine #{{ $ordine->id }}</h4>
                                    @php
                                    $prodotti = DB::table('ordini_prodotti')
                                        ->where('ordine_id', $ordine->id)
                                        ->join('prodotti', 'ordini_prodotti.prodotto_id', '=', 'prodotti.id')
                                        ->select('prodotti.nome', 'ordini_prodotti.quantita', 'ordini_prodotti.prezzo')
                                        ->get();
                                    @endphp
                                    
                                    @if(count($prodotti) > 0)
                                    <table class="dettagli-prodotti">
                                        <thead>
                                            <tr>
                                                <th>Prodotto</th>
                                                <th>Quantità</th>
                                                <th>Prezzo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($prodotti as $prodotto)
                                            <tr>
                                                <td>{{ $prodotto->nome }}</td>
                                                <td>{{ $prodotto->quantita }}</td>
                                                <td>€{{ number_format($prodotto->prezzo, 2, ',', '.') }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @else
                                    <p>Nessun dettaglio disponibile</p>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Non hai ancora effettuato ordini.</p>
            @endif
        </div>
    </div>
    @endif
@endsection
