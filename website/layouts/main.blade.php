<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('head_title')</title>
    <meta name="description" content="@yield('head_title') @yield('head_description')">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @auth()
        <link rel="stylesheet" href="/assets/container_name=website%2Ftailwind/tailwind.output.css?only_dev_to_refresh_css={{ time() }}"/>
    @else
        <link rel="stylesheet" href="/assets/container_name=website%2Ftailwind/tailwind.output.css"/>
    @endauth
    <link rel="stylesheet" href="/website/public/css/fonts.css"/>
    <link rel="icon" type="image/png" sizes="32x32" href="/website/public/favicon/favicon-32x32.png">
    @stack('style_*')
</head>
<body class="text-lg overflow-x-hidden">
@include('website.includes.header')

@yield('content')

@php($target = newRoot(new \model\footer)->selectFile('template')->match(['/website/includes/footers/*.blade.php'])->required()->default('/website/includes/footers/footer_small.blade.php'))
@include($target->getView(), ['model' => $target])

{{-- Admin users can see the edit buttons when they are logged in, so they can easily edit the content of the page. --}}
{{--@auth()--}}
{{--@include('website.includes.edit_mode')--}}
{{--@endauth--}}
@include('website.includes.dev_tools')
@stack('end_of_body_*')

</body>
</html>
