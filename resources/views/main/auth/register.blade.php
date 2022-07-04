<x-layouts.main.auth>
    @section('seo')
        <title>Register &raquo; {{ config('app.name') }}</title>
        <meta name="description" content="{{ config('app.name') }} portal register">
    @stop

    <div class="text-sm sm:text-base text-gray-600 my-4">Create new account.</div>
    <div class="flex flex-col w-full max-w-md">
        @include('fragments.general._flash')
        <div
            class="rounded-md bg-white w-full max-w-sm sm:max-w-md border border-gray-200 shadow-md px-4 py-6 sm:p-8"
        >
            <form action="{{ route('main.register.process-register') }}" method="post">
                @csrf
                <div class="flex flex-col mb-4">
                    <label for="firstName" class="mb-1 text-xs sm:text-sm tracking-wide text-gray-600">First
                        name:</label>
                    <div class="relative">
                        <div
                            class="inline-flex items-center justify-center absolute left-0 top-0 h-full w-10 text-gray-400"
                        >
                            <svg
                                class="h-6 w-6"
                                fill="none"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>

                        <input
                            id="firstName"
                            type="text"
                            name="firstName"
                            class="text-sm sm:text-base placeholder-gray-500 pl-10 pr-4 rounded-lg border border-gray-400 w-full py-2 focus:outline-none focus:border-indigo-400"
                            placeholder="First name"
                        />
                    </div>
                    <x-form.input-error for="firstName" class="mt-2"/>
                </div>
                <div class="flex flex-col mb-4">
                    <label for="lastName" class="mb-1 text-xs sm:text-sm tracking-wide text-gray-600">Last name:</label>
                    <div class="relative">
                        <div
                            class="inline-flex items-center justify-center absolute left-0 top-0 h-full w-10 text-gray-400"
                        >
                            <svg
                                class="h-6 w-6"
                                fill="none"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>

                        <input
                            id="lastName"
                            type="text"
                            name="lastName"
                            class="text-sm sm:text-base placeholder-gray-500 pl-10 pr-4 rounded-lg border border-gray-400 w-full py-2 focus:outline-none focus:border-indigo-400"
                            placeholder="Last name"
                        />
                    </div>
                    <x-form.input-error for="lastName" class="mt-2"/>
                </div>
                <div class="flex flex-col mb-4">
                    <label
                        for="email"
                        class="mb-1 text-xs sm:text-sm tracking-wide text-gray-600"
                    >E-Mail Address:</label>
                    <div class="relative">
                        <div
                            class="inline-flex items-center justify-center absolute left-0 top-0 h-full w-10 text-gray-400"
                        >
                            <svg
                                class="h-6 w-6"
                                fill="none"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"
                                />
                            </svg>
                        </div>

                        <input
                            id="email"
                            type="email"
                            name="email"
                            class="text-sm sm:text-base placeholder-gray-500 pl-10 pr-4 rounded-lg border border-gray-400 w-full py-2 focus:outline-none focus:border-indigo-400"
                            placeholder="E-Mail Address"
                        />
                    </div>
                    <x-form.input-error for="email" class="mt-2"/>
                </div>
                <div class="flex flex-col mb-4">
                    <label
                        for="password"
                        class="mb-1 text-xs sm:text-sm tracking-wide text-gray-600"
                    >Password:</label>
                    <div class="relative">
                        <div
                            class="inline-flex items-center justify-center absolute left-0 top-0 h-full w-10 text-gray-400"
                        >
              <span>
                <svg
                    class="h-6 w-6"
                    fill="none"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                  <path
                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                  />
                </svg>
              </span>
                        </div>

                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="text-sm sm:text-base placeholder-gray-500 pl-10 pr-4 rounded-lg border border-gray-400 w-full py-2 focus:outline-none focus:border-indigo-400"
                            placeholder="Password"
                        />
                    </div>
                    <x-form.input-error for="password" class="mt-2"/>
                </div>


                <div class="flex flex-col mb-4">
                    <label
                        for="password"
                        class="mb-1 text-xs sm:text-sm tracking-wide text-gray-600"
                    >Password:</label>
                    <div class="relative">
                        <div
                            class="inline-flex items-center justify-center absolute left-0 top-0 h-full w-10 text-gray-400"
                        >
              <span>
                <svg
                    class="h-6 w-6"
                    fill="none"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                  <path
                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                  />
                </svg>
              </span>
                        </div>

                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            class="text-sm sm:text-base placeholder-gray-500 pl-10 pr-4 rounded-lg border border-gray-400 w-full py-2 focus:outline-none focus:border-indigo-400"
                            placeholder="Password confirmation"
                        />
                    </div>
                    <x-form.input-error for="password_confirmation" class="mt-2"/>
                </div>

                <div class="flex w-full mt-6">
                    <button
                        type="submit"
                        class="flex items-center justify-center focus:outline-none text-white text-sm sm:text-base bg-primary rounded py-2 w-full transition duration-150 ease-in"
                    >
                        <span class="mr-2 uppercase">Register</span>
                    </button>
                </div>
            </form>
        </div>
        <div class="flex justify-center items-center mt-6">
            <a
                href="{{ route('main.home') }}"
                class="inline-flex items-center font-bold text-primary hover:text-blue-700 text-sm text-center"
            >
        <span>
          <svg
              class="h-6 w-6"
              fill="none"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              viewBox="0 0 24 24"
              stroke="currentColor"
          >
            <path
                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"
            />
          </svg>
        </span>
                <span class="ml-2">Already have an account?</span>
            </a>
        </div>
    </div>
</x-layouts.main.auth>
