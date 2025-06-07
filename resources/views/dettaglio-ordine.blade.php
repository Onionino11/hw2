@extends('layouts.app')

@section('title', 'Dettaglio Ordine #' . $ordine->id)

@section('scripts')
    <link rel="stylesheet" href="{{ asset('css/ordini.css') }}">
@endsection

@section('page_header')
    <img class="panel-icon icon" src="{{ asset('img/ordini.svg') }}"> Dettaglio Ordine #{{ $ordine->id }}
@endsection

@section('content')
    <div class="dettaglio-ordine-container">
        <div class="dettaglio-header">
            <div class="back-link">
                <a href="{{ route('ordini') }}">
                    <img class="icon" src="{{ asset('img/arrow-left.svg') }}"> Torna agli ordini
                </a>
            </div>
            
            <div class="ordine-meta">
                <div class="meta-item">
                    <span class="meta-label">Data ordine:</span>
                    <span class="meta-value">{{ date('d/m/Y H:i', strtotime($ordine->created_at)) }}</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Stato:</span>
                    <span class="meta-value status-badge completed">Completato</span>
                </div>
                <div class="meta-item">
                    <span class="meta-label">Totale:</span>
                    <span class="meta-value">€{{ number_format($ordine->totale, 2, ',', '.') }}</span>
                </div>
            </div>
        </div>
        
        <div class="dettaglio-body">
            <h3>Prodotti ordinati</h3>
            <div class="prodotti-list">
                @foreach($prodotti as $prodotto)
                <div class="prodotto-item">
                    <div class="prodotto-image">
                        @if($prodotto->immagine)
                            <img src="{{ asset('img/prodotti/' . $prodotto->immagine) }}" alt="{{ $prodotto->nome }}">
                        @else
                            <div class="no-image">{{ substr($prodotto->nome, 0, 1) }}</div>
                        @endif
                    </div>
                    <div class="prodotto-info">
                        <h4 class="prodotto-nome">{{ $prodotto->nome }}</h4>
                        <span class="prodotto-prezzo">€{{ number_format($prodotto->prezzo, 2, ',', '.') }}</span>
                    </div>
                    <div class="prodotto-quantity">
                        <span class="quantity-label">Quantità: </span>
                        <span class="quantity-value">{{ $prodotto->quantita }}</span>
                    </div>
                    <div class="prodotto-subtotal">
                        <span class="subtotal-value">€{{ number_format($prodotto->prezzo * $prodotto->quantita, 2, ',', '.') }}</span>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="dettaglio-totale">
                <div class="totale-row">
                    <span class="totale-label">Subtotale:</span>
                    <span class="totale-value">€{{ number_format($ordine->totale, 2, ',', '.') }}</span>
                </div>
                <div class="totale-row">
                    <span class="totale-label">Spese di consegna:</span>
                    <span class="totale-value">€0,00</span>
                </div>
                <div class="totale-row final">
                    <span class="totale-label">Totale:</span>
                    <span class="totale-value">€{{ number_format($ordine->totale, 2, ',', '.') }}</span>
                </div>
            </div>
        </div>
        
        <div class="dettaglio-actions">
            <a href="#" class="btn-secondary" onclick="window.print()">Stampa ricevuta</a>
            <a href="#" class="btn-primary" id="riordina" data-order-id="{{ $ordine->id }}">Riordina</a>
        </div>
    </div>
@endsection
