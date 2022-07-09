<x-app-layout>
    <x-slot name="header">
        <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
            <div class="ml-4 mt-2">
                <h3 class="py-2 text-2xl leading-6 font-medium text-gray-900 font-black">{{ __('Edit') }} {{ $domain }}</h3>
            </div>
            <div class="ml-4 mt-2 flex-shrink-0">
                <a href="/sites">
                    <button type="button" class="relative inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Back to Sites') }}
                    </button>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-8 py-8">

                @if (session('passwordChanged'))
                <div class="rounded-md bg-green-50 p-4 mb-2" id="passwordChanged">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm text-green-800 font-bold">{{ __('SSH Password has been changed!') }}</h3>
                            <div class="mt-2 text-sm text-green-700">
                                <div class="mb-2">
                                    <b>{{ __('New SSH Password') }}</b>
                                    <div onclick="copyInClipboard('sshPass')" style="cursor: pointer;">
                                        <span id="sshPass">{{ session('password') }}</span> <sup id="sshPass-copy"><i class="text-gray-200 text-xs fa-solid fa-clone"></i></sup>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="-mx-2 -my-1.5 flex">
                                    <button id="passwordChangedDismiss" Createtype="button" class="bg-green-50 px-2 py-1.5 rounded-md text-sm font-medium text-green-800 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-green-50 focus:ring-green-600">{{ __('Dismiss') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    $("#passwordChangedDismiss").click(function() {
                        $("#passwordChanged").hide();
                    });
                </script>
                @endif




                @if (session('databaseChanged'))
                <div class="rounded-md bg-green-50 p-4 mb-2" id="databaseChanged">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm text-green-800 font-bold">{{ __('Database Password has been changed!') }}</h3>
                            <div class="mt-2 text-sm text-green-700">
                                <div class="mb-2">
                                    <b>{{ __('New Database Password') }}</b>
                                    <div onclick="copyInClipboard('sshPass')" style="cursor: pointer;">
                                        <span id="sshPass">{{ session('password') }}</span> <sup id="sshPass-copy"><i class="text-gray-200 text-xs fa-solid fa-clone"></i></sup>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="-mx-2 -my-1.5 flex">
                                    <button id="databaseChangedDismiss" Createtype="button" class="bg-green-50 px-2 py-1.5 rounded-md text-sm font-medium text-green-800 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-green-50 focus:ring-green-600">{{ __('Dismiss') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    $("#databaseChangedDismiss").click(function() {
                        $("#databaseChanged").hide();
                    });
                </script>
                @endif

                @include('sites._submenu')

                <div class="text-center pb-4 px-4 sm:px-0">

                    <form class="space-y-16" method="post" action="/sites/{{ $site }}/edit/security/password">
                        @csrf
                        <button type="submit" class="mr-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 cursor-pointer">
                            {{ __('Reset SSH Password') }}
                        </button>
                    </form>

                    <form class="space-y-16 mb-4" method="post" action="/sites/{{ $site }}/edit/security/database">
                        @csrf
                        <button type="submit" class="mr-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 cursor-pointer">
                            {{ __('Reset Database Password') }}
                        </button>
                    </form>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>
