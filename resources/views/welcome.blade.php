<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Laravel</title>
    </head>
    <body>
       <form action="/get-data" method="get">
            <button type="submit">Get Data</button>
        </form>
    </body>
</html>
