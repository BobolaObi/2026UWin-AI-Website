<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-2">
                    <p>{{ __("You're viewing the admin dashboard.") }}</p>
                    <p class="text-sm text-gray-600">
                        {{ __('Logged in as:') }} {{ Auth::user()->email }}
                    </p>
                    <div>
                        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('admin.events.index') }}">
                            {{ __('Manage events') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
