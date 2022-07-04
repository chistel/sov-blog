<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="m-0 p-0">


<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="content-language" content="{{ app()->getLocale() }}">
    <meta name="author" content="Chistel Brown">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    @section('seo')
    @show

    <script type="text/javascript"><!--
        window.chistel = {{ \Illuminate\Support\Js::from([
            'flash_notification' => ((session()->has('flash_notification')) ? json_encode(session()->get('flash_notification')) : 'false')
        ]) }};
        //--></script>
    @vite(['resources/assets/css/app.css'])
    @vite(['resources/assets/js/app.js'])
    @stack('styles')
    @stack('head-js')

</head>

<body>
<div class="main-wrapper" id="app">
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 px-4 py-8">
        {{ $slot }}

        <p class="text-xs mt-10">
            {{ date('Y') }} &copy;
            <a href="#">
                {{ config('app.name') }}
            </a>
        </p>
    </div>
</div>
@livewireScripts
@stack('scripts')

</body>
</html>
