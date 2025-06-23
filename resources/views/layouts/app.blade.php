<!DOCTYPE html>
<html>
<head>
    @include('header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Maluburger')</title>
    <script src="{{ asset('js/navigation.js') }}" defer></script>
    @yield('scripts')
</head>
<body>
    <div id="modal-view" class="hidden"></div>
    @include('navbar')
    @include('header_section')
    @include('navigazione')
    <h2 id=errori> </h2>
    <article>
        <section id="panel">
            <div id="panel-heading">
            @hasSection('page_header')
                @yield('page_header')
            @else
                <img class="panel-icon icon" src="http://localhost/hw2/laravel_app/public/img/tag.png"> Menù
            @endif
            </div>
            <div id="panel-body"> @yield('content') </div>
        </section>
        @if(View::hasSection('cart'))
            @yield('cart')
        @else
            @include('cart')
        @endif
    </article>
   
    @include('footer')
</body>
</html>
