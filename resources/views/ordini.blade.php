@extends('layouts.app')

@section('title', 'I tuoi ordini')

@section('scripts')
    <link rel="stylesheet" href="{{ asset('css/ordini.css') }}">
    <script src="{{ asset('js/ordini.js') }}" defer></script>
@endsection

@section('page_header')
    <img class="panel-icon icon" src="{{ asset('img/ordini.svg') }}"> I tuoi ordini
@endsection

@section('content')
    <div class="ordini-container">
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        
        @if(count($ordini) > 0)
            <div class="ordini-header">
                <h2>Storico dei tuoi ordini</h2>
                <p>Visualizza i dettagli di tutti i tuoi ordini precedenti</p>
            </div>
            
            <div class="ordini-list">
                @foreach($ordini as $ordine)
                <div class="ordine-card">
                    <div class="ordine-header">
                        <div class="ordine-info">
                            <h3>Ordine #{{ $ordine->id }}</h3>
                            <span class="ordine-data">{{ date('d/m/Y H:i', strtotime($ordine->created_at)) }}</span>
                        </div>
                        <div class="ordine-status">
                            <span class="status-badge completed">Completato</span>
                        </div>
                    </div>
                    
                    <div class="ordine-body">
                        <div class="ordine-summary">
                            <div class="prodotti-preview">
                                @foreach($ordine->prodotti->take(3) as $index => $prodotto)
                                    <div class="prodotto-preview" style="z-index: {{ 3 - $index }}">
                                        @if($prodotto->immagine)
                                            <img src="{{ asset('img/prodotti/' . $prodotto->immagine) }}" alt="{{ $prodotto->nome }}">
                                        @else
                                            <div class="no-image">{{ substr($prodotto->nome, 0, 1) }}</div>
                                        @endif
                                    </div>
                                @endforeach
                                @if(count($ordine->prodotti) > 3)
                                    <div class="prodotto-preview more">+{{ count($ordine->prodotti) - 3 }}</div>
                                @endif
                            </div>
                            <div class="ordine-totale">
                                <span class="totale-label">Totale</span>
                                <span class="totale-value">€{{ number_format($ordine->totale, 2, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="ordine-footer">
                        <a href="{{ route('ordini.show', $ordine->id) }}" class="btn-details">Visualizza dettagli</a>
                        <a href="#" class="btn-reorder" data-order-id="{{ $ordine->id }}">Riordina</a>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="no-ordini">
                <img src="{{ asset('img/empty-order.svg') }}" alt="Nessun ordine" class="empty-icon">
                <h3>Non hai ancora effettuato ordini</h3>
                <p>Esplora i nostri prodotti e fai il tuo primo ordine!</p>
                <a href="/" class="btn-primary">Sfoglia il menu</a>
            </div>
        @endif
    </div>
@endsection
