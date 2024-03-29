<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title',__('Garagem 46'))</title>
    <wireui:scripts/>
    @livewireStyles

    @vite(['resources/js/app.js',  'resources/css/app.css' ])

    <link rel="preconnect" href="https://fonts.gstatic.com"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap"/>

</head>
@extends('admin.master.navbar')
<body>

@section('content')
    {{ $slot }}
@endsection



@stack('modals')
@livewireScripts
@livewireChartsScripts

</body>
