
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title')
    </title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" crossorigin="anonymous">


    <style>
        body {
            font-family: 'Nunito';
        }
        .book {
            list-style: none;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-light bg-light">
    <div class="container">
        <a href="/"><span class="navbar-brand mb-0 h1">Shiny's Reading List</span></a>
        <a href="/create"><span class="btn btn-primary">Add New Book</span></a>
    </div>

    @if(session()->has('success'))
    <div class="alert alert-success">

        {{ session()->get('success') }}

    </div>
@endif
</nav>

<div class="container">

    @yield('content')

</div>

</body>

</html>
