<div class="md:grid md:grid-cols-3 md:gap-6">
    <x-general.section-title>
        <x-slot name="title">
            {{ __('Profile Information') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Update your account\'s profile information and email address.') }}
        </x-slot>
    </x-general.section-title>
    <div class="mt-5 md:mt-0 md:col-span-2">
    <form action="{{ route('main.account.manage.basic') }}" method="post">
        @csrf
        <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
            <div class="flex flex-col space-y-4 md:space-y-0 md:flex-row md:space-x-4 mb-4">

                <div class="w-full">
                    <label for="first_name" class="mb-1 text-xs sm:text-sm tracking-wide text-gray-600">First
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
                            value="{{ auth('user')->user()->firstName }}"
                            class="text-sm sm:text-base placeholder-gray-500 pl-10 pr-4 rounded-lg border border-gray-400 w-full py-2 focus:outline-none focus:border-indigo-400"
                            placeholder="First name"
                        />
                    </div>
                    <x-form.input-error for="firstName" class="mt-2"/>
                </div>

                <div class="w-full">
                    <label for="last_name" class="mb-1 text-xs sm:text-sm tracking-wide text-gray-600">Last
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
                            id="lastName"
                            type="text"
                            name="lastName"
                            value="{{ auth('user')->user()->lastName }}"
                            class="text-sm sm:text-base placeholder-gray-500 pl-10 pr-4 rounded-lg border border-gray-400 w-full py-2 focus:outline-none focus:border-indigo-400"
                            placeholder="Last name"
                        />
                    </div>
                    <x-form.input-error for="lastName" class="mt-2"/>
                </div>
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
                        value="{{ auth('user')->user()->email }}"
                        class="text-sm sm:text-base placeholder-gray-500 pl-10 pr-4 rounded-lg border border-gray-400 w-full py-2 focus:outline-none focus:border-indigo-400"
                        placeholder="E-Mail Address"
                    />
                </div>
                <x-form.input-error for="email" class="mt-2"/>
            </div>
        </div>
        <div
            class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
            <x-form.primary-button>
                {{ __('Save') }}
            </x-form.primary-button>
        </div>
    </form>
    </div>
</div>
