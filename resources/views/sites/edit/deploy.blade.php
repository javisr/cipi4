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

                @include('sites._submenu')

                <form class="space-y-8" method="post" action="/sites/{{ $site }}/edit/deploy" id="editSite">
                    @csrf

                    <div class="space-y-8  sm:space-y-5">

                        <div class="mt-5 border-b border-gray-200">
                            <dl>
                                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-700"> {{ __('Preview URL') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        <div onclick="copyInClipboard('preview')" style="cursor: pointer;">
                                            <span id="preview">https://cipi-{{ Str::replace('.', '-', config('cipi.ssh_host')) }}.sslip.io/sites/{{ $site }}/deploy/{{ crc32('app.key'.$site) }}</span> <sup id="preview-copy"><i class="text-gray-200 text-xs fa-solid fa-clone"></i></sup>
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:gap-4">
                            <label for="domain" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> {{ __('Root Domain') }} </label>
                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <input type="text" name="domain" id="domain" autocomplete="OFF" placeholder="domain.com" value="{{ $domain }}" class="block max-w-lg w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>
                        <div class="rounded-md bg-red-50 p-4 hidden" id="domainError">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800" id="domainErrorMessagge"></h3>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <label for="path" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> {{ __('Web Directory') }} </label>
                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <div class="max-w-lg flex rounded-md shadow-sm">
                                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm"> /home/{{ $username }}/www </span>
                                <input type="text" name="path" id="path" autocomplete="OFF" value="{{ $path }}" class="flex-1 block w-full focus:ring-indigo-500 focus:border-indigo-500 min-w-0 rounded-none rounded-r-md sm:text-sm border-gray-300">
                            </div>
                            </div>
                        </div>
                        <div class="rounded-md bg-red-50 p-4 hidden" id="pathError">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800" id="pathErrorMessagge"></h3>
                                </div>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <label for="php" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> {{ __('PHP Version') }} </label>
                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <select id="php" name="php" class="max-w-lg block focus:ring-indigo-500 focus:border-indigo-500 w-full shadow-sm sm:max-w-xs sm:text-sm border-gray-300 rounded-md">
                                <option value="8.1">PHP 8.1</option>
                            </select>
                            </div>
                        </div>

                    </div>

                    <div class="pt-5">
                        <div class="flex justify-end">
                            <span id="editSiteSubmit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 cursor-pointer">
                                {{ __('Update') }} <i class="fas fa-spinner fa-spin ml-2 hidden" id="editSiteLoading"></i>
                            </span>
                        </div>
                    </div>
                </form>

                <script>
                    function editSite() {
                        $.ajax({
                            type: 'GET',
                            url: '/ajax/checkuniquedomain/'+$('#domain').val()+'/{{ $site }}',
                            beforeSend: function() {
                                $('#domainError').hide();
                                $('#editSiteLoading').show();
                            },
                            success: function(data) {
                                $('#editSite').submit();
                            },
                            error: function(xhr) {
                                $('#domainErrorMessagge').html('{{ __("The domain has already been taken on this server.") }}');
                                $('#domainError').show();
                                $('#editSiteLoading').hide();
                            }
                        });
                    }

                    $('#domain').on('input', function() {
                        if(isValidURL($('#domain').val())) {
                            $('#domainError').hide();
                        } else {
                            $('#domainErrorMessagge').html('{{ __("Wrong domain name.") }}');
                            $('#domainError').show();
                        }
                    });

                    $('#path').on('input', function() {
                        if(isValidPath($('#path').val())) {
                            $('#pathError').hide();
                        } else {
                            $('#pathErrorMessagge').html('{{ __("Wrong directory.") }}');
                            $('#pathError').show();
                        }
                    });

                    $("#editSiteSubmit").click(function(event) {
                        if(!$('#domain').val()) {
                            $('#domainErrorMessagge').html('{{ __("The site domain is required.") }}');
                            $('#domainError').show();
                        }

                        if(isValidURL($('#domain').val()) && isValidPath($('#path').val())) {
                            editSite();
                        }
                    });
                </script>

            </div>
        </div>
    </div>
</x-app-layout>
