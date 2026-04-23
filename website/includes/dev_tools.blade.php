@if(\App\Helpers::devTools())
    @pushonce('end_of_body_dev_tools')
        <dev-tools></dev-tools>
        <script type="module">
            // With this script, the page will reload when a file is changed
            // We use /website because the website also needs this
            import {DevTools} from "/website/public/js/dev_tools.mjs";
            import {html, reactive} from 'https://esm.sh/@arrow-js/core@1.0.0-alpha.10';

            customElements.define('dev-tools', class extends HTMLElement {
                data

                constructor() {
                    super();
                    this.data = reactive({
                        error: null,
                        info: null,
                    });
                    this.#subscribeFileChanges();
                }

                connectedCallback() {
                    // Generate a bar at the bottom of the page, showing when this.error is set
                    html`${() => this.data.error ? html`
                        <div class="fixed bottom-0 left-0 w-full bg-red-500 text-white text-center p-2 z-200">
                            <span>${() => this.data.error}</span>
                        </div>` : ``}
                        ${() => this.data.info ? html`
                        <div class="fixed bottom-0 left-0 w-full bg-blue-500 text-white text-center p-2 z-200">
                            <span>${() => this.data.info}</span>
                        </div>` : ``}
                    `(this);
                }


                #subscribeFileChanges = () => {
                    DevTools.subscribeFileChanges(
                        (event) => {
                            // Change title of the page
                            document.title = event.message;
                            this.data.error = null;
                            console.info(event.message);
                            this.data.info = event.message;
                        },
                        (event, eventSource) => {
                            console.error(event.message);
                            // Change title of the page
                            document.title = event.message;
                            // Reload the page
                            document.location.reload();
                            document.title = "🔄 " + event.message;
                            this.data.error = null;
                            this.data.info = event.message;
                        },
                        (message) => {
                            console.error(message);
                            this.data.error = message;
                            this.data.info = null;
                            document.title = "⚠️ " + message;
                        }
                    );
                }
            });
        </script>
    @endpushonce
@endif
