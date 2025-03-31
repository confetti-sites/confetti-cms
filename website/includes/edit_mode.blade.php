@pushonce('end_of_body_edit_mode')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            document.querySelectorAll('[class^="js-edit:"]').forEach(el => {
                const id = el.classList[0].split(':')[1];
                const button = document.createElement('a');
                button.href = '/admin' + id;
                button.innerHTML = '<button class="absolute z-200 w-[60px] h-[40px] -mb-[40px] bg-blue-500 hover:bg-blue-700 text-white text-sm font-semibold cursor-pointer rounded shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110">Edit</button>';
                button.style.display = 'none'; // Initially hidden
                el.insertBefore(button, el.firstChild);

                // Show/hide button based on Alt key press
                document.addEventListener('keydown', function (event) {
                    if (event.altKey) button.style.display = 'block';
                });

                document.addEventListener('keyup', function (event) {
                    if (!event.altKey) button.style.display = 'none';
                });
            });

            // Create a channel and listen for messages
            new BroadcastChannel('cms').addEventListener('message', (event) => {
                console.log("Received message", event.data);
                if (event.data === 'content_published') {
                    location.reload();
                }
            });
        });
    </script>
@endpushonce
