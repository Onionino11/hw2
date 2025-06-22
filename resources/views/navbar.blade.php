{{-- Navbar Blade --}}
@php
    $loggato = Cookie::get('loggato');
@endphp

<nav>
    <h3 id="home"><a id="navbar-brand" href="http://localhost/hw2/laravel_app/public/">Maluburger</a></h3>
    <div id="navbar-header">
        <div id="nav-campanella">
            <a href="#"><img class="icon" src="{{ asset('img/campanella.svg') }}">
                <div id="letterbox" class="hidden">
                    <div id="letterbox-titolo"><img class="icon" src="{{ asset('img/campanella.svg') }}"> Notifiche</div>
                    <div id="letterbox-noItem"><img src="{{ asset('img/cart.svg') }}"> Nessuna notifica</div>
                </div>
            </a>
        </div>


        @if($loggato)
        <div id="nav-ordini" class="show-desktop">
            <a href="{{ route('ordini') }}" ><img class="icon" src="{{ asset('img/ordini.svg') }}"></a>
        </div>

            @php
                $user = \DB::table('users')->find($loggato);
            @endphp            
            @if($user)
                <a href="{{ route('profilo') }}" class="nav-username-link">
                    <span class="nav-username">
                        <img class="icon user-profile-icon" src="{{ asset('img/profilo.svg') }}"> 
                        {{ $user->first_name }} {{ $user->last_name }}
                    </span>
                </a>
            @endif
            <form action="{{ url('logout-cookie') }}" method="get" class="form" id="nav-form">
                <input type="hidden" name="logout" value="1">
                <input type="submit" value="Logout" class="submit">
            </form>
        @else  
                <p id="nav-pippo" >
                    <strong>
                        <a id="nav-registrazione" class="linknero" href="{{ url('singup') }}">Registrazione</a>
                        <a id="recupero_pass" class="linknero" href="#">Password dimenticata?</a>
                    </strong>
                </p>
                <form action="{{ url('login-cookie') }}" method="post" class="form" id="nav-form">
                @csrf
                <input class="nav-input" type="text" placeholder="Email" name="email">
                <input class="nav-input" type="password" placeholder="Password" name="password">
                @if(request('err') == 1)
                    Password errata
                @endif
                <input type="submit" name="login" value="Accedi" class="submit">
            </form>
        @endif
        <a class="linknero" id="nav-flag" href="#" data-linguaattuale="Italiano">            
            <div class="flag-container"><img src="{{ asset('img/Flag_of_Italy.svg') }}" width="24" height="18" alt="Italiana"></div>
            <span id="nav-freccia">▼</span>
        </a>
        <div id="language-menu" class="hidden">            
            <a id="Italiano" class="lingua" data-value="Italiano" href="#">            
                <div class="flag-menu-container"><img src="{{ asset('img/Flag_of_Italy.svg') }}" width="20" height="16" alt="Italiano"></div> Italiano
            </a>
            <a id="English" class="lingua" data-value="English" href="#">
                <div class="flag-menu-container"><img src="{{ asset('img/Flag_of_the_United_Kingdom.svg') }}" width="20" height="16" alt="English"></div> English
            </a>
        </div>
        <div id="nav-campanella2"><a href="#"><img class="icon" src="{{ asset('img/campanella.svg') }}"></a></div>        <div id="nav-profilo">
            @if($loggato)
                <a href="{{ route('profilo') }}"><img class="icon" src="{{ asset('img/profilo.svg') }}"></a>
            @else
                <a href="{{ url('singup') }}"><img class="icon" src="{{ asset('img/profilo.svg') }}"></a>
            @endif
        </div>
        <div id="nav-mobile-auth">
            <a href="#" id="mobile-auth-btn">
                @if($loggato)
                    <img class="icon" src="{{ asset('img/logout.svg') }}" alt="Logout">
                @else
                    <img class="icon" src="{{ asset('img/login.svg') }}" alt="Login">
                @endif
            </a>
        </div>   
</nav>


<div id="mobile-auth-modal" class="hidden">
    <div class="mobile-auth-content">
        <div class="mobile-auth-header">
            <h3>@if($loggato) Logout @else Accedi @endif</h3>
            <span class="mobile-auth-close">x</span>
        </div>
        
        @if($loggato)
            @php
                $user = \DB::table('users')->find($loggato);
            @endphp
                <div class="mobile-auth-body">
                <p class="mobile-auth-welcome">Ciao, {{ $user->first_name }} {{ $user->last_name }}</p>
                <form action="{{ url('logout-cookie') }}" method="get">
                    <input type="hidden" name="logout" value="1">
                    <div class="mobile-auth-buttons">
                        <button type="submit" class="mobile-btn mobile-btn-primary">Logout</button>
                    </div>
                </form>
            </div>
        @else
            <div class="mobile-auth-body">
                <form action="{{ url('login-cookie') }}" method="post">
                    @csrf
                    <div class="mobile-auth-field">
                        <label for="mobile-email">Email</label>
                        <input type="text" id="mobile-email" name="email" placeholder="Inserisci la tua email" required>
                    </div>
                    <div class="mobile-auth-field">
                        <label for="mobile-password">Password</label>
                        <input type="password" id="mobile-password" name="password" placeholder="Inserisci la tua password" required>
                    </div>
                    @if(request('err') == 1)
                        <div class="mobile-auth-error">Password errata</div>
                    @endif
                    <div class="mobile-auth-buttons">
                        <a href="{{ url('singup') }}" class="mobile-btn mobile-btn-secondary">Registrati</a>
                        <button type="submit" name="login" class="mobile-btn mobile-btn-primary">Accedi</button>
                    </div>
                </form>
            </div>
        @endif
    </div>
</div>

