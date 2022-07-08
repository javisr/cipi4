<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
        <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.dataTables.min.css" />

        @livewireStyles

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>

        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <script src="{{ mix('js/app.js') }}" defer></script>

        <style>
        .dataTables_length select {
            padding-right: 2.5rem !important;
        }
        table.dataTable.dtr-inline.collapsed>tbody>tr>td.dtr-control, table.dataTable.dtr-inline.collapsed>tbody>tr>th.dtr-control {
            position: relative;
            padding-left: 30px;
            cursor: pointer;
        }
        table.dataTable.dtr-inline.collapsed>tbody>tr.parent>td.dtr-control:before, table.dataTable.dtr-inline.collapsed>tbody>tr.parent>th.dtr-control:before {
            content: "-";
        }
        table.dataTable.dtr-inline.collapsed>tbody>tr>td.dtr-control:before, table.dataTable.dtr-inline.collapsed>tbody>tr>th.dtr-control:before {
            top: 33%;
            left: 5px;
            height: 1em;
            width: 1em;
            margin-top: -5px;
            display: block;
            position: absolute;
            color: #fff;
            box-sizing: content-box;
            text-align: center;
            text-indent: 0 !important;
            font-family: monospace;
            line-height: 1em;
            content: "+";
            background-color: #000;
        }
        </style>


    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts

        <script>
            function copyInClipboard(element) {
                var tempCopyField = document.createElement("textarea");
                document.body.appendChild(tempCopyField);
                elementText = $('#'+element).html();
                $('#'+element+'-copy').hide();
                $('#'+element).html("<span style=\"color: gray;\">Copied to clipboard!<span>");
                tempCopyField.value = elementText;
                tempCopyField.select();
                document.execCommand("copy");
                document.body.removeChild(tempCopyField);
                setTimeout(function() {
                    $('#'+element).html(elementText);
                    $('#'+element+'-copy').show();
                }, 225);
            }

            function isValidURL(string) {
                var res = string.match(/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g);
                return (res !== null)
            };

            function isValidPath(string) {
                if(string == '') {
                    console.log('qui');
                    return true;
                }

                if(string.includes('//')) {
                    return null;
                }

                if (string.substr(-1) === '/') {
                    return null;
                }

                var res = string.match(/^[a-z0-9\/\-\_]+$/g);
                return (res !== null)
            }
        </script>
    </body>
</html>
