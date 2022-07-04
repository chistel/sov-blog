<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" :class="{ 'theme-dark': dark }" x-data="wrapper()">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Chistel Brown">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    @section('seo')
    @show
    @vite(['resources/assets/css/app.css'])
    @stack('styles')
    <script type="text/javascript"><!--
        window.chistel = {{ \Illuminate\Support\Js::from([
            'flash_notification' => ((session()->has('flash_notification')) ? json_encode(session()->get('flash_notification')) : 'false')
        ]) }};
        //--></script>
    @vite(['resources/assets/js/app.js'])
    @stack('head-js')
</head>
