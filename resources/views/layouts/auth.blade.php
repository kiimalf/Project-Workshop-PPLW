<!DOCTYPE html>
<html lang="en">
    <head>
        @include('layouts.header')
        @include('layouts.style-global')
        @yield('style-page')
    </head>
    
    <body>
        @yield('content')
        @include('layouts.script-global')
        @yield('script-page')
    </body>
</html>

