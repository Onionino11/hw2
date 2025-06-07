<script src="{{ asset('js/cart_render.js') }}"></script>

<div id="cart">
    <div id="panel-heading"> <img class="panel-icon icon" src="{{ asset('img/cart.svg') }}"> Il tuo ordine</div>
    <div id="panel-body">
        <div id="cart-collection">
        </div>
    </div>
    <div id="cart-total">
        Totale ordine: <strong id="totale">0,00 €</strong>
    </div>
    <a href="{{ route('checkout') }}" id="ConcludiOrdine" class="btn-concludi-ordine"><span>Concludi Ordine</span> <img src="{{ asset('img/avanti.svg') }}" class="icon"></a>
</div>


