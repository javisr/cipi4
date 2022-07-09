<div>
    <div class="sm:hidden">
        <label for="tabs" class="sr-only">Select a tab</label>
        <select id="tabs" name="tabs" class="block w-full focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md">
            <option value="/sites/{{ $site }}/edit/settings" @if(Request::is('*/settings')) selected @endif>{{ __('Setting') }}</option>
            <option value="/sites/{{ $site }}/edit/aliases" @if(Request::is('*/aliases')) selected @endif>{{ __('Aliases') }}</option>
            <option value="/sites/{{ $site }}/edit/ssl" @if(Request::is('*/ssl')) selected @endif>{{ __('SSL') }}</option>
            <option value="/sites/{{ $site }}/edit/deploy" @if(Request::is('*/deploy')) selected @endif>{{ __('Deploy') }}</option>
            <option value="/sites/{{ $site }}/edit/queue" @if(Request::is('*/queue')) selected @endif>{{ __('Queue') }}</option>
            <option value="/sites/{{ $site }}/edit/enviroment" @if(Request::is('*/enviroment')) selected @endif>{{ __('Environment') }}</option>
            <option value="/sites/{{ $site }}/edit/packages" @if(Request::is('*/packages')) selected @endif>{{ __('Packages') }}</option>
            <option value="/sites/{{ $site }}/edit/nginx" @if(Request::is('*/nginx')) selected @endif>{{ __('Nginx') }}</option>
            <option value="/sites/{{ $site }}/edit/security" @if(Request::is('*/security')) selected @endif>{{ __('Security') }}</option>
            <option value="/sites/{{ $site }}/edit/delete" @if(Request::is('*/delete')) selected @endif>{{ __('Delete') }}</option>
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

                <a href="/sites/{{ $site }}/edit/settings"
                    @if(Request::is('*/settings') || Request::is('*/edit'))
                        class="border-indigo-500 text-indigo-600 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm" aria-current="page"
                    @else
                        class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm"
                    @endif
                > {{ __('Settings') }} </a>

                <a href="/sites/{{ $site }}/edit/aliases"
                    @if(Request::is('*/aliases'))
                        class="border-indigo-500 text-indigo-600 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm" aria-current="page"
                    @else
                        class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm"
                    @endif
                > {{ __('Aliases') }} </a>

                <a href="/sites/{{ $site }}/edit/ssl"
                    @if(Request::is('*/ssl'))
                        class="border-indigo-500 text-indigo-600 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm" aria-current="page"
                    @else
                        class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm"
                    @endif
                > {{ __('SSL') }} </a>

                <a href="/sites/{{ $site }}/edit/deploy"
                    @if(Request::is('*/deploy'))
                        class="border-indigo-500 text-indigo-600 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm" aria-current="page"
                    @else
                        class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm"
                    @endif
                > {{ __('Deploy') }} </a>

                <a href="/sites/{{ $site }}/edit/queue"
                    @if(Request::is('*/queue'))
                        class="border-indigo-500 text-indigo-600 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm" aria-current="page"
                    @else
                        class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm"
                    @endif
                > {{ __('Queue') }} </a>

                <a href="/sites/{{ $site }}/edit/enviroment"
                    @if(Request::is('*/enviroment'))
                        class="border-indigo-500 text-indigo-600 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm" aria-current="page"
                    @else
                        class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm"
                    @endif
                > {{ __('Environment') }} </a>

                <a href="/sites/{{ $site }}/edit/packages"
                    @if(Request::is('*/packages'))
                        class="border-indigo-500 text-indigo-600 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm" aria-current="page"
                    @else
                        class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm"
                    @endif
                > {{ __('Packages') }} </a>

                <a href="/sites/{{ $site }}/edit/nginx"
                    @if(Request::is('*/nginx'))
                        class="border-indigo-500 text-indigo-600 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm" aria-current="page"
                    @else
                        class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm"
                    @endif
                > {{ __('Nginx') }} </a>

                <a href="/sites/{{ $site }}/edit/security"
                    @if(Request::is('*/security'))
                        class="border-indigo-500 text-indigo-600 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm" aria-current="page"
                    @else
                        class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm"
                    @endif
                > {{ __('Security') }} </a>

                <a href="/sites/{{ $site }}/edit/delete"
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
