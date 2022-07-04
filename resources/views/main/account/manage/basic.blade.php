<x-layouts.main.authenticated>
    @section('seo')
        <title>Manage account &raquo; {{ config('main.name') }}</title>
        <meta name="description" content="{{ config('main.name') }} Manage account">
    @stop
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white md:text-primary leading-tight">
            Manage Account
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

        @include('fragments.general._flash')

        @include('fragments.main.account.manage._default')
        <x-general.section-border/>


        <div class="mt-10 sm:mt-0">
            @include('fragments.main.account.manage._password')
        </div>

    </div>


</x-layouts.main.authenticated>
