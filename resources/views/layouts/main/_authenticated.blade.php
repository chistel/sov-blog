@include('fragments.main._head')
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100">
    <!-- header/navigation -->

   @include('fragments.main._nav')
    @if(!auth()->user()->hasVerifiedEmail())
        <div class="bg-yellow-300 py-2 px-3 w-full">
            <div class="text-white text-center">
                Your account has not been verified. Please use the verification link sent to your mail,
            </div>
        </div>
    @endif


    @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto">
               <div class="flex justify-end md:justify-start">
                   <span class="w-48 md:w-auto bg-primary md:w-none md:bg-transparent py-4 px-4 sm:px-6 lg:px-6">
                       {{ $header }}
                   </span>
               </div>
            </div>
        </header>
    @endif
    <main>
        {{ $slot }}
    </main>
    <footer class="footer px-4 py-6">
        <div class="footer-content">
            <p class="text-sm text-gray-600 text-center">© {{ config('app.name') }} {{ date('Y') }}. All rights
                reserved. </p>
        </div>
    </footer>

</div>

@stack('modals')
@stack('scripts')
</body>
</html>
