<!DOCTYPE html>
<html>
<head>
    @include('header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Maluburger')</title>
    @yield('scripts')
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
            <div id="panel-body"> @yield('content') </div>
        </section>
        @include('cart')
    </article>
   
    @include('footer')
</body>
</html>
