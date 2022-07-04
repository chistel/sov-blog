<div class="flex justify-between p-4 lg:p-15 bg-white">
    <div class="flex items-center">
        <a href="{{ route('main.account.dashboard') }}">
            <span class="text-primary text-2xl font-bold">{{ config('app.name') }}</span>

        </a>

    </div>

    <!-- left header section -->
    <div class="flex items-center justify-between">
        <div class="hidden space-x-6 lg:inline-block text-base text-primary">

            <a href="{{ route('main.account.manage.basic') }}">Account</a>
            <a href="javascript:void(0);"
               onclick="event.preventDefault(); document.getElementById('auth-logout').submit();">Logout</a>
        </div>
    </div>
    <!-- right header section -->
</div>

<form id="auth-logout" action="{{ route('main.account.logout') }}" method="POST" class="hidden">
    @method('DELETE')
    @csrf
</form>
