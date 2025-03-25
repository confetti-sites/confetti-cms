@php
$currentContentId = rtrim(str_replace('/admin', '', request()->uri()), '/');
if ($currentContentId === '') {
    $currentContentId = '/model';
}
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">

    <title>Admin</title>

    <link rel="stylesheet" href="/resources/admin__tailwind/tailwind.output.css"/>
    <script src="/admin/assets/js/thema.js" defer></script>
    <link rel="icon" type="image/png" sizes="32x32" href="/website/assets/favicon/favicon-32x32.png">
</head>

<body class="text-gray-700 overflow-hidden">
    @guest()
        @include('website.includes.auth.login')
    @else
        @can('admin')
            <div class="flex h-screen">
                <!-- Desktop sidebar -->
                <aside class="z-20 shrink-0 hidden w-64 overflow-y-auto dark:bg-gray-800 md:block">
                    @include('admin.left_menu', [$currentContentId])
                </aside>

                <!-- Mobile sidebar -->
                <div class="js-menu-click-away hidden fixed inset-0 z-10 flex items-end bg-gray-200 bg-opacity-50 sm:items-center sm:justify-center"></div>
                <aside class="js-menu hidden fixed inset-y-0 z-20 shrink-0 w-64 mt-16 overflow-y-auto dark:bg-gray-800 md:hidden">
                    @include('admin.left_menu', [$currentContentId])
                </aside>

                <div class="flex flex-col flex-1">
                    @include('admin.header', [$currentContentId])
                    <main class="h-full pb-96 overflow-y-auto">
                        @include('admin.middle', [$currentContentId])
                    </main>
                </div>
            </div>
            @include('admin.status_bar')
        @else
            <div class="flex items-center justify-center w-full h-screen bg-gray-50">
                You are not allowed to access this page. Go back to&nbsp;<a href="/" class="underline">the home page</a>
                <span>&nbsp;or <a onclick="document.cookie = 'access_token=; Max-Age=0;';location.reload()" class="underline cursor-pointer">retry to login</a>.</span>
            </div>
        @endcan
    @endguest
    @stack('style_*')
    @pushonce('end_of_body_menu')
        <script>
            // Toggle menu visibility
            const menuToggle = document.getElementById('menu-toggle');
            const menu = document.getElementsByClassName('js-menu')[0];
            const menuClickAway = document.getElementsByClassName('js-menu-click-away')[0];

            menuToggle?.addEventListener('click', () => {
                menu.classList.toggle('hidden');
                menuClickAway.classList.toggle('hidden');
            });
        </script>
    @endpushonce
    @if(config('environment.options.dev_tools'))
    @pushonce('end_of_body_dev_tools')
        <script type="module" defer>
            // With this script, the page will reload when a file is changed
            // We use /website because the website also needs this
            import {DevTools} from "/website/assets/js/dev_tools.mjs";

            DevTools.subscribeFileChanges(
                (event) => {
                    window.dispatchEvent(new CustomEvent('state', {
                        detail: {
                            id: 'local_file_changed',
                            state: 'loading',
                            title: event.message,
                        }
                    }));
                },
                (event, eventSource) => {
                    window.dispatchEvent(new CustomEvent('state', {
                        detail: {
                            id: 'local_file_changed',
                            state: 'success',
                            title: event.message,
                        }
                    }));
                    // Prevent error because the event source is closed due the reload
                    eventSource.close();
                    // Reload the page
                    document.location.reload();
                },
                (message) => {
                    window.dispatchEvent(new CustomEvent('state', {
                        detail: {
                            id: 'local_file_changed',
                            state: 'error',
                            title: message,
                        }
                    }));
                }
            );
        </script>
    @endpushonce
    @endif
    @stack('boot_end_of_body_*')
    @stack('end_of_body_*')
</body>
</html>
















