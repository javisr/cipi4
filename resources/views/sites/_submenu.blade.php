<div>
    <div class="sm:hidden">
        <label for="tabs" class="sr-only">Select a tab</label>
        <select id="tabs" name="tabs" class="block w-full focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md">
            <option value="/sites/edit/{{ $site }}/settings" @if(Request::is('*/settings')) selected @endif>Setting</option>
            <option value="/sites/edit/{{ $site }}/aliases" @if(Request::is('*/aliases')) selected @endif>Aliases</option>
            <option value="/sites/edit/{{ $site }}/ssl" @if(Request::is('*/ssl')) selected @endif>SSL</option>
            <option value="/sites/edit/{{ $site }}/deployment" @if(Request::is('*/deployment')) selected @endif>Deployment</option>
            <option value="/sites/edit/{{ $site }}/queue" @if(Request::is('*/queue')) selected @endif>Queue</option>
            <option value="/sites/edit/{{ $site }}/enviroment" @if(Request::is('*/enviroment')) selected @endif>Environment</option>
            <option value="/sites/edit/{{ $site }}/packages" @if(Request::is('*/packages')) selected @endif>Packages</option>
            <option value="/sites/edit/{{ $site }}/nginx" @if(Request::is('*/nginx')) selected @endif>Nginx</option>
            <option value="/sites/edit/{{ $site }}/destroy" @if(Request::is('*/destroy')) selected @endif>Destroy</option>
        </select>
        <script>
            $('#tabs').change(function() {
                location.replace($(this).val());
            });
        </script>
    </div>
    <div class="hidden sm:block">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex" aria-label="Tabs">

                <a href="/sites/edit/{{ $site }}/settings"
                    @if(Request::is('*/settings'))
                        class="border-indigo-500 text-indigo-600 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm" aria-current="page"
                    @else
                        class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm"
                    @endif
                > Settings </a>

                <a href="/sites/edit/{{ $site }}/aliases"
                    @if(Request::is('*/aliases'))
                        class="border-indigo-500 text-indigo-600 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm" aria-current="page"
                    @else
                        class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm"
                    @endif
                > Aliases </a>

                <a href="/sites/edit/{{ $site }}/ssl"
                    @if(Request::is('*/ssl'))
                        class="border-indigo-500 text-indigo-600 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm" aria-current="page"
                    @else
                        class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm"
                    @endif
                > SSL </a>

                <a href="/sites/edit/{{ $site }}/deployment"
                    @if(Request::is('*/deployment'))
                        class="border-indigo-500 text-indigo-600 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm" aria-current="page"
                    @else
                        class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm"
                    @endif
                > Deployment </a>

                <a href="/sites/edit/{{ $site }}/queue"
                    @if(Request::is('*/queue'))
                        class="border-indigo-500 text-indigo-600 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm" aria-current="page"
                    @else
                        class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm"
                    @endif
                > Queue </a>

                <a href="/sites/edit/{{ $site }}/enviroment"
                    @if(Request::is('*/enviroment'))
                        class="border-indigo-500 text-indigo-600 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm" aria-current="page"
                    @else
                        class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm"
                    @endif
                > Environment </a>

                <a href="/sites/edit/{{ $site }}/packages"
                    @if(Request::is('*/packages'))
                        class="border-indigo-500 text-indigo-600 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm" aria-current="page"
                    @else
                        class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm"
                    @endif
                > Packages </a>

                <a href="/sites/edit/{{ $site }}/nginx"
                    @if(Request::is('*/nginx'))
                        class="border-indigo-500 text-indigo-600 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm" aria-current="page"
                    @else
                        class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm"
                    @endif
                > Nginx </a>

                <a href="/sites/edit/{{ $site }}/destroy"
                    @if(Request::is('*/destroy'))
                        class="border-indigo-500 text-indigo-600 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm" aria-current="page"
                    @else
                        class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm"
                    @endif
                > Destroy </a>
            </nav>
        </div>
    </div>
</div>
