<x-app-layout>
    <x-slot name="header">
        <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
            <div class="ml-4 mt-2">
                <h3 class="py-2 text-2xl leading-6 font-medium text-gray-900 font-black">{{ __('Edit Site') }}</h3>
            </div>
            <div class="ml-4 mt-2 flex-shrink-0">
                <a href="/sites">
                    <button type="button"
                        class="relative inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Back to Sites') }}
                    </button>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-8 py-8">

                @if (session('aliasCreated'))
                <div class="rounded-md bg-green-50 p-4 mb-4" id="aliasCreated">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm text-green-800 font-bold">{{ __('Alias ') }}{{ session('domain') }}{{ __(' has been created!') }}</h3>
                        </div>
                    </div>
                </div>
                <script>
                    setTimeout(() => {
                        $("#aliasCreated").hide(500);
                    }, 3500);
                </script>
                @endif

                @if (session('aliasDeleted'))
                <div class="rounded-md bg-green-50 p-4 mb-4" id="aliasDeleted">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm text-green-800 font-bold">{{ __('Alias ') }}{{ session('domain') }}{{ (' has been delated!') }}</h3>
                        </div>
                    </div>
                </div>
                <script>
                    setTimeout(() => {
                        $("#aliasDeleted").hide(500);
                    }, 3500);
                </script>
                @endif

                @include('sites._submenu')

                <div>
                    <form class="space-y-8" method="post" action="/sites/{{ $site }}/edit/aliases" id="editSite">
                        @csrf

                        <div class="space-y-8  sm:space-y-5">

                            <div class="sm:grid sm:grid-cols-3 sm:gap-4">
                                <label for="domain" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    {{ __('New Alias') }} </label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="text" name="domain" id="domain" autocomplete="OFF"
                                        placeholder="www.domain.com" autofocus
                                        class="block max-w-lg w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                            <div class="rounded-md bg-red-50 p-4 hidden" id="domainError">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800" id="domainErrorMessagge"></h3>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="pt-1 pb-6">
                            <div class="flex justify-end">
                                <span id="editSiteSubmit"
                                    class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 cursor-pointer">
                                    {{ __('Add Alias') }} <i class="fas fa-spinner fa-spin ml-2 hidden"
                                        id="editSiteLoading"></i>
                                </span>
                            </div>
                        </div>
                    </form>

                    <div class="flow-root mt-8">
                        <ul role="list" class="-my-5 divide-y divide-gray-200">

                            @foreach ($aliases as $alias)
                            <li class="py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $alias['domain'] }}</p>
                                    </div>
                                    <div>
                                        <form method="post" action="/sites/{{ $site }}/edit/aliases/{{ $alias['id'] }}">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center shadow-sm p-2 border border-gray-300 text-sm leading-5 font-medium text-gray-700 bg-white hover:bg-gray-50">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                            @endforeach

                        </ul>
                    </div>
                </div>

                <script>
                    function editSite() {
                        $.ajax({
                            type: 'GET',
                            url: '/ajax/checkuniquedomain/' + $('#domain').val(),
                            beforeSend: function() {
                                $('#domainError').hide();
                                $('#editSiteLoading').show();
                            },
                            success: function(data) {
                                $('#editSite').submit();
                            },
                            error: function(xhr) {
                                $('#domainErrorMessagge').html(
                                    '{{ __("The domain has already been taken on this server.") }}');
                                $('#domainError').show();
                                $('#editSiteLoading').hide();
                            }
                        });
                    }

                    $('#domain').on('input', function() {
                        if (isValidURL($('#domain').val())) {
                            $('#domainError').hide();
                        } else {
                            $('#domainErrorMessagge').html('{{ __('Wrong domain name.') }}');
                            $('#domainError').show();
                        }
                    });

                    $("#editSiteSubmit").click(function(event) {
                        if (!$('#domain').val()) {
                            $('#domainErrorMessagge').html('{{ __('The site domain is required.') }}');
                            $('#domainError').show();
                        }

                        if (isValidURL($('#domain').val())) {
                            editSite();
                        }
                    });
                </script>

            </div>
        </div>
    </div>
</x-app-layout>
