<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Multipurpose Blog System</title>
        <script>
            (function() {
            window.Laravel = {
                csrfToken: '{{ csrf_token() }}'
            };
        })();
        </script>
        <!-- Fonts -->
        <link rel="stylesheet" href="/css/app.css">
    </head>
    <body>
        <div id="app">
            <mainapp></mainapp>
        </div>
    </body>
</html>
<script src="{{mix('/js/app.js')}}"></script>
