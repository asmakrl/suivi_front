<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />

    @livewireStyles
</head>
<body class="antialiased">
<livewire:requests-form />

<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
@yield('scripts')

</body>
</html>
