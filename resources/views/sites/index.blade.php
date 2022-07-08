<x-app-layout>
    <x-slot name="header">
        <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
            <div class="ml-4 mt-2">
                <h3 class="py-2 text-2xl leading-6 font-medium text-gray-900 font-black">{{ __('Sites') }}</h3>
            </div>
            <div class="ml-4 mt-2 flex-shrink-0">
                <a href="/sites/create">
                    <button type="button" class="relative inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Create') }}
                    </button>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-8 py-8">

                @if (session('siteDeleted'))
                <div class="rounded-md bg-green-50 p-4 mb-4" id="siteDeleted">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm text-green-800 font-bold">Site {{ session('domain') }} has been delated! </h3>
                        </div>
                    </div>
                </div>
                <script>
                    setTimeout(() => {
                        $("#siteDeleted").hide(500);
                    }, 3500);
                </script>
                @endif

                <table id="sites" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Domain</th>
                            <th>Aliases</th>
                            <th>Username</th>
                            <th>Path</th>
                            <th>PHP</th>
                        </tr>
                    </thead>
                </table>

                <script>
                $(document).ready(function () {
                    $('#sites').DataTable({
                        responsive: true,
                        processing: true,
                        serverSide: true,
                        ajax: '/sites/index',
                        columns: [
                            { data: "domain" },
                            { data: "aliases_count" },
                            { data: "username" },
                            { data: "path" },
                            { data: "php" }
                        ],
                        columnDefs: [
                            {
                                'targets': 0,
                                'render': function ( data, type, row, meta ) {
                                    return '<a href="/sites/'+row["site"]+'/edit"><b class="text-indigo-700">'+row["domain"]+'</b></a>';
                                }
                            },
                            {
                                'targets': 3,
                                'render': function ( data, type, row, meta ) {
                                    return '/'+data;
                                }
                            }
                        ],
                    });
                });
                </script>

            </div>
        </div>
    </div>
</x-app-layout>
