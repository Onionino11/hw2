<!DOCTYPE html>
<html>
<head>
    @include('header')
    <title>@yield('title', 'Maluburger')</title>
    <!-- <script src="{{ asset('js/index.js') }}" defer></script> -->
</head>
<body>
    <div id="modal-view" class="hidden"></div>
    @include('navbar')
    @include('header_section')
    @include('navigazione')
    <article>
        <section id="panel">
            <div id="panel-heading">
                <img class="panel-icon icon" src="{{ asset('img/tag.png') }}"> Menu @yield('title')
            </div>
            <div id="panel-body"></div>
        </section>
        @include('cart')
    </article>
    @yield('content')
    @include('footer')
</body>
</html>
