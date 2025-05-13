@if(!empty($block['data']['text']))
@php
$text = $block['data']['text'];
// Ensure link is open in new tab
$text = str_replace('<a ', '<a target="_blank" ', $text);
// Replace <a with <a class="tailwind-classes"
$text = str_replace('<a ', '<a class="text-blue-500 hover:underline" ', $text);
@endphp
<p class="pt-3 font-body text-pretty">{!! $text !!}</p>
@endif