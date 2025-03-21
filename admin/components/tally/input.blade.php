@php /** @var \App\Components\BoolComponent $model */ @endphp
        <!--suppress HtmlUnknownTag -->
<tally-component
        data-id="{{ $model->getId() }}"
        data-label="{{ $model->getComponent()->getLabel() }}"
        data-decorations='{{ json_encode($model->getComponent()->getDecorations()) }}'
        data-original="{{ json_encode($model->get()) }}"
        data-component="{{ json_encode($model->getComponent()) }}"
        data-service_api="{{ getServiceApi() }}"
></tally-component>

@pushonce('end_of_body_tally_component')
    <script type="module">
        import {Toolbar} from '/admin/assets/js/editor.mjs';
        import {Storage} from '/admin/assets/js/admin_service.mjs';
        import {IconUndo, IconMarker, IconTableWithHeadings} from 'https://esm.sh/@codexteam/icons';
        import {html, reactive} from 'https://esm.sh/@arrow-js/core';

        customElements.define('tally-component', class extends HTMLElement {
            id
            label
            original = {
                share_link: '',
                embed_url: '',
                admin_url: '',
                title: '',
            }
            data = {
                value: {
                    share_link: '',
                    embed_url: '',
                    admin_url: '',
                    title: '',
                },
                error: null,
            }
            decorations = {
                required: {default: false},
            }
            serviceApi = null

            constructor() {
                super();
                this.id = this.dataset.id;
                this.label = this.dataset.label;
                this.original = JSON.parse(this.dataset.original);
                this.decorations = JSON.parse(this.dataset.decorations);
                this.data = reactive({
                    value: Storage.getFromLocalStorage(this.id) || this.original || null,
                    error: null,
                });
                this.serviceApi = this.dataset.service_api;
            }

            connectedCallback() {
                this.data.$on('value', value => {
                    Storage.removeLocalStorageComponent(this.id);
                    if (value?.share_link !== this.original?.share_link &&
                        value?.admin_url !== this.original?.admin_url &&
                        value?.embed_url !== this.original?.embed_url &&
                        value?.title !== this.original?.title
                    ) {
                        Storage.saveLocalStorageModel(this.id, value, this.dataset.component);
                    }
                    window.dispatchEvent(new CustomEvent('local_content_changed'));
                });

                html`
                    <label class="block text-bold text-xl mt-8 mb-4">${this.label}</label>
                    <div class="w-full md:flex md:gap-4">
                        <div class="${() => `w-full ` + (this.isValid() ? `md:w-1/3` : ``)}">
                            <input class="${() => `appearance-none pr-5 pl-3 py-3 w-full bg-gray-50 border-2 outline-hidden text-gray-900 rounded-lg block ` + (this.data.value === this.original ? `border-gray-200` : `border-emerald-300`)}"
                                   name="${this.id}"
                                   value="${() => this.data.value?.share_link ?? ''}"
                                   placeholder="https://tally.so/r/..."
                                   @input="${e => this.#storeChange(e.target.value)}"/>

                            <!-- Title -->
                            ${() => this.isValid() ? html`
                                <div class="border-1 border-gray-300 rounded-lg p-3 mt-2">
                                    <p class="mt-2 mb-4 mx-2 text-emerald-800 text-xl">${this.data.value?.title}</p>
                                    <div class="flex space-x-4">
                                        <a href="${this.data.value?.admin_url + '/edit'}" target="_blank" class="w-full px-1 py-3 flex items-center justify-center text-sm font-medium leading-5 text-white bg-emerald-700 hover:bg-emerald-800 border border-transparent rounded-md">
                                            Edit
                                        </a>
                                        <a href="${this.data.value?.admin_url}" target="_blank" class="w-full px-1 py-3 flex items-center justify-center text-sm font-medium leading-5 text-white bg-emerald-700 hover:bg-emerald-800 border border-transparent rounded-md">
                                            Details
                                        </a>
                                    </div>
                                </div>
                            ` : html``}

                            <!-- Error -->
                            ${() => this.data.error ? html`<p class="mt-2 text-red-500">${this.data.error}</p>` : html``}

                            <!-- Help -->
                            ${() => !this.isValid() ? html`
                                <h3 class="text-lg font-semibold mt-4">How to set up a Tally form?</h3>
                                <ol class="mt-2 text-gray-500 list-decimal pl-4">
                                    <li>Go to
                                        <a href="https://tally.so/signup" target="_blank" class="text-blue-500 underline">Tally</a> and create an account.
                                    </li>
                                    <li>Create a
                                        <a href="https://tally.so/forms/create" target="_blank" class="text-blue-500 underline">new form</a> or open an
                                        <a href="https://tally.so/dashboard" target="_blank" class="text-blue-500 underline">existing form</a>.
                                    </li>
                                    <li>Go to the "Publish" section or the "Share" tab.</li>
                                    <li>Copy the link under the "Share Link" section.</li>
                                    <li>Paste the link into the input above.</li>
                                </ol>
                            ` : html``}
                        </div>
                        <div class="${() => `relative w-full mt-4 md:mt-0 md:w-2/3 h-[300px] md:h-auto -z-1 ` + (this.isValid() ? `` : `hidden`) }">
                            <div class="absolute inset-0 z-10 h-full w-full"></div>
                            <iframe data-tally-src="" class="overflow-hidden rounded-xl" style="transform: scale(0.50); transform-origin: 0 0;"  height="200%" width="200%" scrolling="no"></iframe>
                        </div>
                    </div>
                `(this);

                new Toolbar(this).init([
                        {
                            label: 'Remove unpublished changes',
                            icon: IconUndo,
                            closeOnActivate: true,
                            onActivate: async () => {
                                this.querySelector('input').value = this.original;
                                this.querySelector('input').dispatchEvent(new Event('change'));
                                this.data.value = this.original || null;
                            }
                        },
                        {
                            label: 'Edit form',
                            icon: IconMarker,
                            closeOnActivate: true,
                            onActivate: () => window.open(this.data.value?.admin_url + '/edit', '_blank'),
                            disabled: !this.data.value?.admin_url,
                        },
                        {
                            label: 'Open form details',
                            icon: IconTableWithHeadings,
                            closeOnActivate: true,
                            onActivate: () => window.open(this.data.value?.admin_url + '/summary', '_blank'),
                            disabled: !this.data.value?.admin_url,
                        },
                    ],
                );

                // When not saved yet, we need to save
                // some value (with component) to show it in the list
                if (this.data.value === null) {
                    Storage.saveComponent(this.id, this.dataset.component);
                }

                this.validateAndInit(this.data.value?.share_link);
            }

            validateAndInit(shareUrl) {
                if (!shareUrl) {
                    if (this.decorations.required?.required) {
                        this.data.error = 'Please enter a link to a Tally form.';
                    } else {
                        this.data.error = null;
                    }
                    this.data.value = null;
                    return false;
                }

                if (!shareUrl?.startsWith('https://tally.so/r/') || shareUrl.length < 23 || shareUrl.length > 26) {
                    this.data.error = 'The link should start with "https://tally.so/r/" and be followed by a unique identifier. For example: "https://tally.so/r/123456".';
                    return false;
                }

                // Set admin url: e.g. https://tally.so/forms/wQ8LDG
                let adminUrl = shareUrl.replace('https://tally.so/r/', 'https://tally.so/forms/');
                // Convert share url to a embed url so we don't got cors errors
                let embedUrl = shareUrl.replace('https://tally.so/r/', 'https://tally.so/embed/');
                let byPassCors = this.serviceApi + '/confetti-cms/content/bypass_cors?url=' + encodeURIComponent(embedUrl);

                // Check if the url is valid
                fetch(byPassCors)
                    .then(response => {
                        if (!response.ok && response.status === 404) {
                            this.data.error = 'You can\'t save the form. The form is probably still in draft mode. <a href="' + adminUrl + '/edit" target="_blank" class="text-blue-500 active:text-blue-800 underline">Go to the form</a> and publish it. When you have published the form, <button class="text-blue-500 active:text-blue-800 underline cursor-pointer" onclick="this.closest(\'tally-component\').validateAndInit(\''+shareUrl+'\')">click here to retry</button>.';
                            return;
                        } else if (!response.ok) {
                            this.data.error = 'The link is not valid. Please check if the link is correct and try again.';
                            return;
                        }
                        return response.text();
                    })
                    .then(responseBody => {
                        if (!responseBody) return;

                        let match = responseBody.match(/<script id="__NEXT_DATA__" type="application\/json">(.+?)<\/script>/s);
                        if (match && match[1]) {
                            let jsonData = JSON.parse(match[1]); // Converteer de JSON-string naar een object
                            let title = jsonData.props?.pageProps?.name; // Haal de naam eruit

                            this.data.value = {
                                share_link: shareUrl,
                                embed_url: embedUrl,
                                admin_url: adminUrl,
                                title: title,
                            }
                            this.data.error = null;

                            // Reload Tally
                            this.querySelector('iframe').src = embedUrl;
                        } else {
                            console.error("NEXT_DATA not found in the form page.");
                            this.data.error = 'Can\'t fetch the title of the form. Please try again later. (The developer can check the console for more information.)';
                        }
                    })
                    .catch((e) => {
                        console.error('Unexpected error occurred.', e);
                        this.data.error = 'Unexpected error occurred. Please try again later. (The developer can check the console for more information.)';
                    });

                return true;
            }

            /**
             * @returns {boolean}
             */
            isValid() {
                return this.data.value?.share_link && this.data.value?.title && this.data.error === null;
            }

            #storeChange(shareUrl) {
                // Convert all possible urls to the share url. Just to make it convenient for the user.
                shareUrl = shareUrl
                    .replace('https://tally.so/forms/', 'https://tally.so/r/')
                    .replace('https://tally.so/embed/', 'https://tally.so/r/');

                // Remove /summary or /share at the end of the url in case it's there
                shareUrl = shareUrl.replace(/\/(summary|share|edit)$/, '');

                this.validateAndInit(shareUrl);
            }
        });
    </script>

@endpushonce