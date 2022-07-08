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
                                    return '<a href="/sites/edit/'+row["site"]+'"><b class="text-indigo-700">'+row["domain"]+'</b></a>';
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
