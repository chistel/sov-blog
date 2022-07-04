<div class="md:grid md:grid-cols-3 md:gap-6">
    <x-general.section-title>
        <x-slot name="title">
            {{ __('Update Password') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </x-slot>
    </x-general.section-title>
    <div class="mt-5 md:mt-0 md:col-span-2">
        <form action="{{ route('main.account.manage.password-post') }}" method="post">
            @csrf
            <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                <div class="flex flex-col space-y-4 md:space-y-0 md:flex-row md:space-x-4 mb-4">

                    <div class="w-full">
                        <x-form.label for="currentPassword" value="{{ __('Current Password') }}"
                                      class="font-semibold mb-3"/>
                        <x-form.input id="currentPassword" type="password" class="mt-1 block w-full"
                                      name="currentPassword" autocomplete="current-password"
                                      placeholder="Current password"/>
                        <x-form.input-error for="currentPassword" class="mt-2"/>
                    </div>

                    <div class="w-full">
                        <x-form.label for="password" value="{{ __('New Password') }}" class="font-semibold mb-3"/>
                        <x-form.input id="password" type="password" class="mt-1 block w-full"
                                      name="password" autocomplete="new-password" placeholder="New password"/>
                        <x-form.input-error for="password" class="mt-2"/>
                    </div>
                </div>
                <div class="flex flex-col mb-4">
                    <x-form.label for="password_confirmation" value="{{ __('Confirm Password') }}"
                                  class="font-semibold mb-3"/>
                    <x-form.input id="password_confirmation" type="password" class="mt-1 block w-full"
                                  name="password_confirmation" autocomplete="new-password"
                                  placeholder="Confirm new password"/>
                    <x-form.input-error for="password_confirmation" class="mt-2"/>
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
