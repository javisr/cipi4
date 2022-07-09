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

                @if (session('siteUpdated'))
                <div class="rounded-md bg-green-50 p-4 mb-2" id="siteUpdated">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm text-green-800 font-bold">{{ __('Site settings have been updated!') }}</h3>
                        </div>
                    </div>
                </div>
                <script>
                    setTimeout(() => {
                        $("#siteUpdated").hide(500);
                    }, 3500);
                </script>
                @endif

                @if (session('siteCreated'))
                <div class="rounded-md bg-green-50 p-4 mb-2" id="siteCreated">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm text-green-800 font-bold">{{ __('Site has been created!') }}</h3>
                            <div class="mt-2 text-sm text-green-700">
                                <div class="mb-2">
                                    <b>{{ __('SSH Connection') }}</b>
                                    <div onclick="copyInClipboard('sshConn')" style="cursor: pointer;">
                                        <span id="sshConn">ssh {{ $username.'@'.config('cipi.ssh_host') }}</span> <sup id="sshConn-copy"><i class="text-gray-200 text-xs fa-solid fa-clone"></i></sup>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <b>{{ __('SSH Password') }}</b>
                                    <div onclick="copyInClipboard('sshPass')" style="cursor: pointer;">
                                        <span id="sshPass">{{ session('userPwd') }}</span> <sup id="sshPass-copy"><i class="text-gray-200 text-xs fa-solid fa-clone"></i></sup>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <b class="mt-1">{{ __('File Database Configuration in .env file') }}</b>
                                    <div onclick="copyInClipboard('dbEnv', false)" style="cursor: pointer;">
                                        <textarea rows="6" id="dbEnv" style="min-width: 275px" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full text-xs border-gray-300 rounded-md cursor-pointer">DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE={{ $username }}
DB_USERNAME={{ $username }}
DB_PASSWORD={{ session('dbPwd') }}</textarea><label for="dbEnv" class="block text-xs font-medium text-gray-500 cursor-pointer">{{ __('Click to copy it!') }}</label>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <b>{{ __('Database Connection URL') }}</b>
                                    <div onclick="copyInClipboard('dbConnUrl', false)" style="cursor: pointer;">
                                        <textarea rows="3" id="dbConnUrl" style="min-width: 275px" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full text-xs border-gray-300 rounded-md cursor-pointer">mysql+ssh://{{ $username.'@'.config('cipi.ssh_host') }}/{{ $username }}:{{ session('dbPwd') }}@127.0.0.1/{{ $username }}</textarea>
                                        <label for="dbConnUrl" class="block text-xs font-medium text-gray-500 cursor-pointer">{{ __('Click to copy it!') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="-mx-2 -my-1.5 flex">
                                    <button id="siteCreatedDismiss" Createtype="button" class="bg-green-50 px-2 py-1.5 rounded-md text-sm font-medium text-green-800 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-green-50 focus:ring-green-600">{{ __('Dismiss') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    $("#siteCreatedDismiss").click(function() {
                        $("#siteCreated").hide();
                    });
                </script>
                @endif

                @include('sites._submenu')

                <form class="space-y-8" method="post" action="/sites/{{ $site }}/edit/settings" id="editSite">
                    @csrf

                    <div class="space-y-8  sm:space-y-5">

                        <div class="mt-5 border-b border-gray-200">
                            <dl>
                                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-700"> {{ __('Preview URL') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        <div onclick="copyInClipboard('preview')" style="cursor: pointer;">
                                            <span id="preview">https://{{ crc32($username) }}-{{ Str::replace('.', '-', config('cipi.ssh_host')) }}.sslip.io</span> <sup id="preview-copy"><i class="text-gray-200 text-xs fa-solid fa-clone"></i></sup>
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
