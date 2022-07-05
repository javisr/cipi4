<x-app-layout>
    <x-slot name="header">
        <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
            <div class="ml-4 mt-2">
                <h3 class="py-2 text-2xl leading-6 font-medium text-gray-900 font-black">{{ __('Settings') }}</h3>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 sm:px-20 bg-white">
                <div class="py-2">
                    <span class="h-12 w-auto">
                        <div class="text-xl">
                            Panel Url
                        </div>
                        <div class="text-3xl">
                            <div onclick="copyInClipboard('url')" style="cursor: pointer;">
                                <span id="url">{{ config('app.url') }}/panel</span> <sup id="url-copy"><i class="text-gray-200 text-sm fa-solid fa-clone"></i>
                            </div>
                        </div>
                    </span>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                TO DO
            </div>
        </div>
    </div>
</x-app-layout>
