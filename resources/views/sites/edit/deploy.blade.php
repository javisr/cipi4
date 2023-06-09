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


                @if (session('deployUpdated'))
                <div class="rounded-md bg-green-50 p-4 mb-2" id="deployUpdated">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm text-green-800 font-bold">{{ __('Site deploy configuration has been updated!') }}</h3>
                        </div>
                    </div>
                </div>
                <script>
                    setTimeout(() => {
                        $("#deployUpdated").hide(500);
                    }, 3500);
                </script>
                @endif


                @include('sites._submenu')

                <form class="space-y-8" method="post" action="/sites/{{ $site }}/edit/deploy" id="deploySite">
                    @csrf
                    <input type="hidden" name="deploy" id="deployField">

                    <div class="space-y-8  sm:space-y-5">

                        <div class="mt-5 border-b border-gray-200">
                            <dl>
                                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-700"> {{ __('Deploy Webhook') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        <div onclick="copyInClipboard('preview')" style="cursor: pointer;">
                                            <span id="preview">https://cipi-{{ Str::replace('.', '-', config('cipi.ssh_host')) }}.sslip.io/sites/{{ $site }}/deploy/{{ crc32('app.key'.$site) }}</span> <sup id="preview-copy"><i class="text-gray-200 text-xs fa-solid fa-clone"></i></sup>
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                            <label for="repo" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> {{ __('Repositoy') }} </label>
                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <div class="max-w-lg flex rounded-md shadow-sm">
                                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm"><i class="fa-brands fa-github mr-2"></i> github.com/</span>
                                    <input type="text" name="repo" id="repo" autocomplete="OFF" placeholder="username/project" value="{{ $repo }}" class="flex-1 block w-full focus:ring-indigo-500 focus:border-indigo-500 min-w-0 rounded-none rounded-r-md sm:text-sm border-gray-300">
                                </div>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <label for="branch" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> {{ __('Branch') }} </label>
                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <div class="max-w-lg flex rounded-md shadow-sm">
                                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm"><i class="fa-solid fa-code-branch"></i></span>
                                    <input type="text" name="branch" id="branch" autocomplete="OFF" placeholder="develop" value="{{ $branch }}" class="flex-1 block w-full focus:ring-indigo-500 focus:border-indigo-500 min-w-0 rounded-none rounded-r-md sm:text-sm border-gray-300">
                                </div>
                            </div>
                        </div>

                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <label for="deploy" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> {{ __('Deploy Script') }} </label>
                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <div class="max-w-lg flex rounded-md shadow-sm">
                                    <div id="deploy" name="deploy" class="rounded-md" style="width: 100%; height: 220px;">{{ $deploy }}</div>
                                    <script>
                                        var editor = ace.edit("deploy");
                                        editor.setTheme("ace/theme/monokai");
                                        editor.getSession().setMode("ace/mode/sh");
                                        editor.getSession().on('change', function() {
                                            $('#deployField').val(editor.getSession().getValue());
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>


                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                            <label for="key" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"> {{ __('Deploy Key') }} </label>
                            <div class="mt-1 sm:mt-0 sm:col-span-2">
                                <div class="max-w-lg flex rounded-md">
                                    <div onclick="copyInClipboard('key', false)" style="cursor: pointer;">
                                        <span id="key" name="key" class="rounded-md" style="width: 100%; height: 220px; font-size: 8px;"><i class="fas fa-spinner fa-spin ml-2" style="font-size: 18px" id="keyLoading"></i></span></span> <span id="key-copy"><i class="text-gray-200 text-xs fa-solid fa-clone"></i></sup>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pt-5">
                            <div class="flex justify-end">
                                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 cursor-pointer">
                                    {{ __('Update') }} <i class="fas fa-spinner fa-spin ml-2 hidden" id="deploySiteLoading"></i>
                                </button>
                            </div>
                        </div>

                    </div>

                </form>

                <script>
                    $.ajax({
                        type: 'GET',
                        url: '/ajax/getdeploykey/{{ $username }}',
                        success: function(data) {
                            $('#key').empty();
                            $('#key').html(data);
                        },
                        error: function(xhr) {
                            $('#key').empty();
                            $('#key').html(data);
                        }
                    });
                </script>

            </div>
        </div>
    </div>
</x-app-layout>
