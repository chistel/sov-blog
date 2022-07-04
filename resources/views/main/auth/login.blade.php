<x-layouts.main.auth>
    @section('seo')
        <title>Login &raquo; {{ config('app.name') }}</title>
        <meta name="description" content="{{ config('app.name') }} login">
    @stop
    <div class="text-sm sm:text-base text-gray-600 my-3">
        Login To Your Account
    </div>

    <div class="flex flex-col w-full max-w-md">
        @include('fragments.general._flash')


        <div class="bg-white shadow-md px-4 sm:px-6 md:px-4 lg:px-8 py-8 rounded-md">

            <form action="{{ route('main.login.process-login') }}" method="post">
                @csrf
                <div class="flex flex-col mb-3">
                    <x-form.label for="first_name" value="Email"
                                  class="mb-1 text-xs sm:text-sm tracking-wide text-gray-600">
                        <x-general.required-field/>
                    </x-form.label>
                    <div class="relative">
                        <div
                            class="inline-flex items-center justify-center absolute left-0 top-0 h-full w-10 text-gray-400">
                            <svg class="h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                 stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                <path
                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                            </svg>
                        </div>

                        <x-form.input id="identity" type="text" placeholder="Email"
                                      class="text-sm sm:text-base placeholder-gray-500 rounded-lg border border-gray-400 w-full pl-10 py-2 focus:outline-none focus:border-indigo-400"
                                      name="identity" autocomplete="identity"></x-form.input>
                    </div>
                    <x-form.input-error for="identity" class="mt-2"></x-form.input-error>
                </div>
                <div class="flex flex-col mb-3">
                    <x-form.label for="password" value="Password"
                                  class="mb-1 text-xs sm:text-sm tracking-wide text-gray-600">
                        <x-general.required-field/>
                    </x-form.label>
                    <div class="relative">
                        <div
                            class="inline-flex items-center justify-center absolute left-0 top-0 h-full w-10 text-gray-400">
                                  <span>
                                    <svg class="h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                         stroke-width="2"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                      <path
                                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                  </span>
                        </div>
                        <input id="password" type="text" name="password"
                               class="text-sm sm:text-base placeholder-gray-500 pl-10 pr-4 rounded-lg border border-gray-400 w-full py-2 focus:outline-none focus:border-blue-400"
                               placeholder="Password"/>
                    </div>
                    <x-form.input-error for="password" class="mt-2"></x-form.input-error>
                </div>

                <div class="flex items-center mb-6 -mt-3">
                    <div class="flex ml-auto">
                        <a href="{{ route('main.password.reset-request') }}"
                           class="inline-flex text-xs sm:text-sm text-primary hover:text-blue-700">Forgot
                            Your Password?</a>
                    </div>
                </div>

                <div class="flex w-full">
                    <button
                        class="flex items-center justify-center focus:outline-none text-white text-sm sm:text-base bg-primary rounded py-2 w-full transition duration-150 ease-in">
                        <span class="mr-2 uppercase">Login</span>
                        <span>
                      <svg class="h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round"
                           stroke-width="2"
                           viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                      </svg>
                    </span>
                    </button>
                </div>
            </form>

        </div>

        <div class="flex justify-center items-center mt-6">
            <a href="{{ route('main.register.form') }}"
               class="inline-flex items-center font-bold text-primary hover:text-blue-700 text-xs text-center">
                    <span>
                      <svg class="h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                           viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                      </svg>
                    </span>
                <span class="ml-2">You don't have an account?</span>
            </a>
        </div>
    </div>
</x-layouts.main.auth>
