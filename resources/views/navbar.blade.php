{{-- Navbar Blade --}}
@php
    $loggato = Cookie::get('loggato');
@endphp

<nav>
    <h3 id="home"><a id="navbar-brand" href="#">Maluburger</a></h3>
    <div id="navbar-header">
        <div id="nav-campanella">
            <a href="#"><img class="icon" src="{{ asset('img/campanella.svg') }}">
                <div id="letterbox" class="hidden">
                    <div id="letterbox-titolo"><img class="icon" src="{{ asset('img/campanella.svg') }}"> Notifiche</div>
                    <div id="letterbox-noItem"><img src="{{ asset('img/cart.svg') }}"> Nessuna notifica</div>
                </div>
            </a>
        </div>

        <p id="nav-pippo" class="@if($loggato) hidden @endif">
            <strong>
                <a id="nav-registrazione" class="linknero" href="{{ url('singup') }}">Registrazione</a>
                <a id="recupero_pass" class="linknero" href="#">Password dimenticata?</a>
            </strong>
        </p>
        @if($loggato)
            <form action="{{ url('logout_cookie') }}" method="get" class="form" id="nav-form">
                <input type="hidden" name="logout" value="1">
                <input type="submit" value="Logout" class="submit">
            </form>
        @else
            <form action="{{ url('login_cookie') }}" method="get" class="form" id="nav-form">
                <input class="nav-input" type="text" placeholder="Email" name="email">
                <input class="nav-input" type="password" placeholder="Password" name="password">
                @if(request('err') == 1)
                    Password errata
                @endif
                <input type="submit" name="login" value="Accedi" class="submit">
            </form>
        @endif

        <a class="linknero" id="nav-flag" href="#" data-linguaattuale="Italiano"> <img src="{{ asset('img/Flag_of_Italy.svg') }}">
            <span id="nav-freccia">▼</span>
        </a>
        <div id="language-menu" class="hidden">
            <a id="Italiano" class="lingua" data-value="Italiano" href="#"><img src="{{ asset('img/Flag_of_Italy.svg') }}"> Italiano</a>
            <a id="English" class="lingua" data-value="English" href="#"><img src="{{ asset('img/Flag_of_the_United_Kingdom.svg') }}"> English</a>
        </div>
        <div id="nav-campanella2"><a href="#"><img class="icon" src="{{ asset('img/campanella.svg') }}"></a></div>
        <div id="nav-profilo"><a href="#"><img class="icon" src="{{ asset('img/profilo.svg') }}"></a></div>
    </div>
</nav>

