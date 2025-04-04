@pushonce('end_of_body_edit_mode')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            /**
             * Add edit buttons when pressed Shift
             */
            document.querySelectorAll('[class^="js-edit:"]').forEach(el => {
                const id = el.classList[0].split(':')[1];
                const button = document.createElement('a');
                button.href = '/admin' + id;
                button.innerHTML = '<button class="js-edit-button absolute z-200 w-[60px] h-[40px] -mb-[40px] bg-blue-500 hover:bg-blue-700 text-white text-sm font-semibold cursor-pointer rounded shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-110">Edit</button>';
                button.style.display = 'none';
                el.insertBefore(button, el.firstChild);

                // Show the button when Shift is pressed
                document.addEventListener('keydown', function (event) {
                    if (event.shiftKey) {
                        button.style.display = 'block';
                    }
                });

                // Hide the button when Shift is released
                document.addEventListener('keyup', function (event) {
                    if (event.key === 'Shift') {
                        button.style.display = 'none';
                    }
                });
            });

            /**
             * Create a channel and listen for content changes in the admin
             */
            new BroadcastChannel('cms').addEventListener('message', (event) => {
                if (event.data === 'content_published') {
                    location.reload();
                }
            });
        });
    </script>
@endpushonce
