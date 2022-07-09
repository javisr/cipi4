<x-app-layout>
    <x-slot name="header">
        <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
            <div class="ml-4 mt-2">
                <h3 class="py-2 text-2xl leading-6 font-medium text-gray-900 font-black">{{ __('Edit Site') }}</h3>
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

                @if (session('sslGenerated'))
                <div class="rounded-md bg-green-50 p-4 mb-2" id="sslGenerated">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm text-green-800 font-bold">{{ __('SSL certificates will be generated in the next minutes.') }}</h3>
                        </div>
                    </div>
                </div>
                <script>
                    setTimeout(() => {
                        $("#sslGenerated").hide(500);
                    }, 3500);
                </script>
                @endif

                @include('sites._submenu')

                <form class="space-y-8" method="post" action="/sites/{{ $site }}/edit/ssl" id="sslSite">
                    @csrf

                    <div class="max-w-sm mx-auto pb-4 px-4 sm:px-0">
                        <div class="flow-root mt-6">
                            <ul role="list" class="-my-5 divide-y divide-gray-200">
                                <li class="py-5">
                                    <div class="relative focus-within:ring-2 focus-within:ring-indigo-500">
                                        <h3 class="text-md font-semibold text-gray-900">
                                            <span class="absolute inset-0" aria-hidden="true"></span>
                                                {{ __('Do you want generate free LetsEncrypt Certificates for your site and its aliases?') }}
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-600 line-clamp-2">{{ __('Before to proceed, be sure that DNS configurations of the domains and subdomains (root domain and all its aliases) correctly point to this server.') }}</p>
                                    </div>
                                </li>
                            </ul>
                        </div>

                    </div>

                    <div class="pt-1 pb-5">
                        <div class="flex justify-center">
                            <button type="submit" id="sslSiteSubmit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 cursor-pointer">
                                {{ __('Require Certificates') }}
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
