<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/css/all.css">

        <title>Full stack blog</title>
        <script>
            
            (function(){
                window.Laravel = {
                    csrfToken:'{{ csrf_token() }}'
                };
            })();
        </script>

        <!-- Styles -->
        
    </head>
    <body>
        <div id="app">
            <app></app>
        </div>
        
    </body>
</html>

<script src="{{mix('/js/app.js')}}"></script>
