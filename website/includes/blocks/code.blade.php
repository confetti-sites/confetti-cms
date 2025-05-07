<p class="js-replace-username">{!! trim($block['data']['code']) !!}</p>

@pushonce('end_of_body_replace_username')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @auth
            const username = '@username';
            @else
            const username = 'your_username';
            @endauth
            document.querySelectorAll('.js-replace-username').forEach(el => {
                el.innerHTML = el.innerHTML.replaceAll('__your_username__', username);
            });
        });
    </script>
@endpushonce
