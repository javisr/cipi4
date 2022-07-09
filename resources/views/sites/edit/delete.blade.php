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

                @include('sites._submenu')

                <form class="space-y-8" method="post" action="/sites/{{ $site }}/delete" id="deleteSite">
                    @csrf

                    <div class="max-w-sm mx-auto pb-4 px-4 sm:px-0">
                        <div class="flow-root mt-6">
                            <ul role="list" class="-my-5 divide-y divide-gray-200">
                                <li class="py-5">
                                    <div class="relative focus-within:ring-2 focus-within:ring-indigo-500">
                                        <h3 class="text-md font-semibold text-gray-900">
                                            <span class="absolute inset-0" aria-hidden="true"></span>
                                                {{ __('Are you sure to delete this site and all its aliases?') }}
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-600 line-clamp-2">{{ __('Please type the root domain of this site ') }}(<b>{{ $domain }}</b>){{ __(' to confirm its deletion from server:') }}</p>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="mt-2">
                            <div>
                                <input type="text" name="delete" id="delete" autocomplete="OFF" autofocus class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                    </div>

                    <div class="pt-1 pb-5">
                        <div class="flex justify-center">
                            <button type="submit" id="deleteSiteSubmit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 cursor-pointer">
                                {{ __('Delete') }} <i class="fas fa-spinner fa-spin ml-2 hidden" id="editSiteLoading"></i>
                            </button>
                        </div>
                    </div>

                </form>

                <script>
                    $('#deleteSite').submit(function() {
                        return ($('#delete').val() == '{{ $domain }}')
                    });
                </script>

            </div>
        </div>
    </div>
</x-app-layout>
