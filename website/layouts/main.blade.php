<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('head_title')</title>
    <meta name="description" content="@yield('head_title') @yield('head_description')">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/resources/website__tailwind/tailwind.output.css"/>
    <link rel="stylesheet" href="/website/assets/css/fonts.css"/>
    <link rel="icon" type="image/png" sizes="32x32" href="/website/assets/favicon/favicon-32x32.png">
    @stack('style_*')
</head>
<body class="text-lg overflow-x-hidden">
@include('website.includes.header')

@yield('content')

@php($target = newRoot(new \model\footer)->selectFile('template')->match(['/website/includes/footers/*.blade.php'])->required()->default('/website/includes/footers/footer_small.blade.php'))
@include($target->getView(), ['model' => $target])

@auth()
@include('website.includes.edit_mode')
@endauth
@include('website.includes.dev_tools')
@stack('end_of_body_*')

<script>
    // Obfuscated email parts
    const part1 = '&#114;&#101;&#105;&#110;&#100;&#101;&#114;&#116;&#118;&#101;&#116;&#116;&#101;&#114;';
    const part2 = '&#64;';
    const part3 = '&#103;&#109;&#97;&#105;&#108;&#46;&#99;&#111;&#109;';

    // Decode and render the email
    const email = part1 + part2 + part3;
    document.querySelectorAll('.js-contact-e').forEach(el => {
        el.textContent = email.replace(/&#(\d+);/g, (_, dec) => String.fromCharCode(dec));
    });
</script>
</body>
</html>

