<div>
    <div class="sm:hidden">
        <label for="tabs" class="sr-only">Select a tab</label>
        <select id="tabs" name="tabs" class="block w-full focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md">
            <option value="/sites/edit/{{ $site }}/settings" @if(Request::is('*/settings')) selected @endif>{{ __('Setting') }}</option>
            <option value="/sites/edit/{{ $site }}/aliases" @if(Request::is('*/aliases')) selected @endif>{{ __('Aliases') }}</option>
            <option value="/sites/edit/{{ $site }}/ssl" @if(Request::is('*/ssl')) selected @endif>{{ __('SSL') }}</option>
            <option value="/sites/edit/{{ $site }}/repository" @if(Request::is('*/repository')) selected @endif>{{ __('Repository') }}</option>
            <option value="/sites/edit/{{ $site }}/queue" @if(Request::is('*/queue')) selected @endif>{{ __('Queue') }}</option>
            <option value="/sites/edit/{{ $site }}/enviroment" @if(Request::is('*/enviroment')) selected @endif>{{ __('Environment') }}</option>
            <option value="/sites/edit/{{ $site }}/packages" @if(Request::is('*/packages')) selected @endif>{{ __('Packages') }}</option>
            <option value="/sites/edit/{{ $site }}/nginx" @if(Request::is('*/nginx')) selected @endif>{{ __('Nginx') }}</option>
            <option value="/sites/edit/{{ $site }}/delete" @if(Request::is('*/delete')) selected @endif>{{ __('Delete') }}</option>
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
                    @if(Request::is('*/settings') || Request::is('*/'.$site))
                        class="border-indigo-500 text-indigo-600 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm" aria-current="page"
                    @else
                        class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm"
                    @endif
                > {{ __('Settings') }} </a>

                <a href="/sites/edit/{{ $site }}/aliases"
                    @if(Request::is('*/aliases'))
                        class="border-indigo-500 text-indigo-600 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm" aria-current="page"
                    @else
                        class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm"
                    @endif
                > {{ __('Aliases') }} </a>

                <a href="/sites/edit/{{ $site }}/ssl"
                    @if(Request::is('*/ssl'))
                        class="border-indigo-500 text-indigo-600 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm" aria-current="page"
                    @else
                        class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm"
                    @endif
                > {{ __('SSL') }} </a>

                <a href="/sites/edit/{{ $site }}/repository"
                    @if(Request::is('*/repository'))
                        class="border-indigo-500 text-indigo-600 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm" aria-current="page"
                    @else
                        class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm"
                    @endif
                > {{ __('Repository') }} </a>

                <a href="/sites/edit/{{ $site }}/queue"
                    @if(Request::is('*/queue'))
                        class="border-indigo-500 text-indigo-600 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm" aria-current="page"
                    @else
                        class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm"
                    @endif
                > {{ __('Queue') }} </a>

                <a href="/sites/edit/{{ $site }}/enviroment"
                    @if(Request::is('*/enviroment'))
                        class="border-indigo-500 text-indigo-600 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm" aria-current="page"
                    @else
                        class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm"
                    @endif
                > {{ __('Environment') }} </a>

                <a href="/sites/edit/{{ $site }}/packages"
                    @if(Request::is('*/packages'))
                        class="border-indigo-500 text-indigo-600 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm" aria-current="page"
                    @else
                        class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm"
                    @endif
                > {{ __('Packages') }} </a>

                <a href="/sites/edit/{{ $site }}/nginx"
                    @if(Request::is('*/nginx'))
                        class="border-indigo-500 text-indigo-600 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm" aria-current="page"
                    @else
                        class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm"
                    @endif
                > {{ __('Nginx') }} </a>

                <a href="/sites/edit/{{ $site }}/delete"
                    @if(Request::is('*/delete'))
                        class="border-indigo-500 text-indigo-600 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm" aria-current="page"
                    @else
                        class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm"
                    @endif
                > {{ __('Delete') }} </a>
            </nav>
        </div>
    </div>
</div>
