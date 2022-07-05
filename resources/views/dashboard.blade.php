<x-app-layout>
    <x-slot name="header">
        <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
            <div class="ml-4 mt-2">
                <h3 class="py-2 text-2xl leading-6 font-medium text-gray-900 font-black">{{ __('Dashboard') }}</h3>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <div class="p-6 sm:px-20 bg-white">
                    <div class="py-2">
                        <span class="h-12 w-auto">
                            <div class="text-xl">
                                Server IP
                            </div>
                            <div class="text-3xl">
                                <div onclick="copyInClipboard('ip')" style="cursor: pointer;">
                                    <span id="ip">{{ config('cipi.ssh_host') }}</span> <sup id="ip-copy"><i class="text-gray-200 text-sm fa-solid fa-clone"></i>
                                </div>
                            </div>
                        </span>
                    </div>
                </div>

                <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-3">
                    <div class="p-8">
                        <div class="flex items-center">
                            <i class="text-3xl text-indigo-300 fa-solid fa-microchip"></i>
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">CPU</div>
                        </div>
                        <div class="ml-12">
                            <div class="mt-2 text-5xl text-gray-500">
                                100%
                            </div>
                        </div>
                    </div>

                    <div class="p-8">
                        <div class="flex items-center">
                            <i class="text-3xl text-indigo-300 fa-solid fa-memory"></i>
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">RAM</div>
                        </div>
                        <div class="ml-12">
                            <div class="mt-2 text-5xl text-gray-500">
                                100%
                            </div>
                        </div>
                    </div>

                    <div class="p-8">
                        <div class="flex items-center">
                            <i class="text-3xl text-indigo-300 fa-solid fa-hard-drive"></i>
                            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">HDD</div>
                        </div>
                        <div class="ml-12">
                            <div class="mt-2 text-5xl text-gray-500">
                                100%
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
