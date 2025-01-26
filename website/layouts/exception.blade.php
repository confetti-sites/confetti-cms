@php
    /** @var \Exception $exception */
    $message = $exception->getMessage();
    $paths = [];
    if (str_contains($message, ', called in') && str_contains($message, 'bladec')) {
        // Message is before the path (after `, called in`)
        $message = substr($message, 0, strpos($message, ', called in'));
        // Get message before `():`
        $message2 = substr($message, 0, strpos($message, '():') + 2);
        // Get message after the first `:`
        $message1 = substr($message, strpos($message, '():') + 3);
        // Path is after the `, called in`
        $path = substr($exception->getMessage(), strpos($exception->getMessage(), ', called in') + 11);
    } else {
        $message1 = null;
        $message2 = $message;
    }
    // All stack trace
    $paths = $exception->getTrace();
    foreach ($paths as $i => $item) {
        if (isset($item['file']) && str_contains($item['file'], 'bladec')) {
            $path = str_replace('.', '/', $item['file']);
            $path = preg_replace('/\/var\/www\/cache\/(.*)\w{41}\/bladec/', '$1.blade.php:$2', $path);
            $paths[$i] = $path . $item['line'];
        } else {
            unset($paths[$i]);
        }
    }
    // Random bug emoji
    $emoji = ['🦋', '🐛', '🐜', '🐝', '🐞', '🦗', '🕷', '🦟', '🦠'][rand(0, 8)];
@endphp<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <title>{{ $message1 }}</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%2210 0 100 100%22><text y=%22.90em%22 font-size=%2290%22>{{ $emoji }}</text></svg>">
    <style>
        body {
            font-family: 'Trebuchet MS', sans-serif;
            line-height: 1.5;
            word-break: break-word;
            background-color: #f8f8f8fa;
        }

        @media (max-width: 600px) {
            .hide_on_mobile {
                display: none;
            }
        }

        @keyframes blob {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            50% {
                opacity: 0.7;
            }
            100% {
                transform: scale(1);
                opacity: 0;
            }
            50% {
                opacity: 0.7;
            }
        }

        .blob {
            position: fixed;
            border-radius: 50%;
            mix-blend-mode: multiply;
            filter: blur(1rem);
        }

        .blob_1 {
            top: 5rem;
            left: -1rem;
            width: 18rem;
            height: 18rem;
            background-color: rgb(0, 255, 0);
            opacity: 0.7;
            animation: blob 5s infinite;
        }

        .blob_2 {
            top: 0;
            right: 0;
            width: 18rem;
            height: 18rem;
            background-color: rgb(255, 0, 0);
            opacity: 0;
            animation: blob 6s infinite 2s;
        }

        .blob_3 {
            bottom: -10rem;
            left: 5rem;
            width: 18rem;
            height: 18rem;
            background-color: rgb(0, 0, 255);
            opacity: 0;
            animation: blob 7s infinite 4s;
        }
    </style>
    <script>
        // Copy to clipboard
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function () {
                document.getElementById('copy_message').style.opacity = 1;
                // fade out in 5 seconds
                setTimeout(function () {
                    document.getElementById('copy_message').style.opacity = 0;
                }, 5000);
            });
        }
    </script>
</head>
<body>
<div class="blob blob_1"></div>
<div class="blob blob_2"></div>
<div class="blob blob_3"></div>
<div style="display: flex; justify-content: center; align-items: center; font-size: small;margin-top: 25%;padding: 10px;">
    <div style="border-collapse: collapse;border-left-color: gray;border-left-style: solid;border-left-width: 10px;padding-left: 30px">
        <div style="font-size: xx-large; color: rgb(159, 0, 0);">{{ $message1 }}</div>
        <div style="font-size: x-large; color: rgb(159, 0, 0); cursor: pointer; max-width: 56rem;" onclick="copyToClipboard('{{ $message2 }}');">{{ $message2 }}</div>
        <div class="hide_on_mobile" style="margin-top: 20px">
            @foreach($paths as $i => $path)
                <div class="{{ $i > 0 ? 'hide_on_mobile' : '' }}" style="font-size: x-large; color: gray; margin-top: 10px; cursor: pointer;" onclick="copyToClipboard('{{ $path }}');">{{ $path }}</div>
            @endforeach
        </div>
        <div style="margin-top: 20px;">
            <a href="/" style="font-size: x-large; color: gray; text-decoration: none;">Back to home</a>
        </div>
    </div>
    <div id="copy_message" style="margin-top: 20px; opacity: 0; font-size: x-large; color: gray;">Copied to clipboard</div>
</div>
</body>