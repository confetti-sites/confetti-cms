@php($current = extendModel($model))

<h1 class="text-3xl font-semibold text-gray-800 mb-2">Installation</h1>

<div class="mt-4 mb-8 text-gray-800 font-body">Confetti is a powerful tool for building and managing websites with ease. Follow the steps below to get started. Keep in mind that you don't need to install PHP or an HTTP server to use Confetti.</div>

@php($current = extendModel($model))
<docs-installation-steps-v2 data-tabs="{{ json_encode([
    [
        'alias' => 'macos',
        'title' => 'macOS (Homebrew)',
        'steps' => [
            [
                'link_title' => 'Join the Waitlist',
                'link' => '/waiting-list',
            ],
            [
                'title_step' => 'Install Confetti:',
                'example' => 'brew tap confetti-cms/homebrew-client && brew install conf',
            ],
            [
                'title_step' => 'Clone the project repository:',
                'example' => 'cd ~ && git clone git@github.com:confetti-sites/__your_repo__.git',
            ],
            [
                'title_step' => 'Move into the project directory:',
                'example' => 'cd ~/__your_repo__',
            ],
        ],
    ],
    [
        'alias' => 'windows',
        'title' => 'Windows (Scoop, PowerShell)',
        'steps' => [
            [
                'link_title' => 'Join the Waitlist',
                'link' => '/waiting-list',
            ],
            [
                'title_step' => 'Install Confetti:',
                'example' => 'scoop bucket add org https://github.com/confetti-cms/scoop-conf.git && scoop install confetti-cms/scoop-conf',
            ],
            [
                'title_step' => 'Clone the project repository:',
                'example' => 'cd ~ && git clone git@github.com:confetti-sites/__your_repo__.git',
            ],
            [
                'title_step' => 'Move into the project directory:',
                'example' => 'cd ~\\__your_repo__',
            ],
        ],
    ],
]) }}" @guest data-guest="true" @else data-guest="false" @endguest></docs-installation-steps-v2>

<div class="mt-12 mb-4 text-gray-800 font-body">
    <discussion>
        <div class="markdown-heading"><h2 class="heading-element">Running your Project</h2><a id="user-content-running-your-project" class="anchor" aria-label="Permalink: Running your Project" href="#running-your-project"><span aria-hidden="true" class="octicon octicon-link"></span></a></div>
        <div class="markdown-heading"><h3 class="heading-element">Start Watching Changes</h3><a id="user-content-start-watching-changes" class="anchor" aria-label="Permalink: Start Watching Changes" href="#start-watching-changes"><span aria-hidden="true" class="octicon octicon-link"></span></a></div>
        <p>Whenever you want to work on your website, run the following command to start watching for changes. This runs the site remotely and updates it automatically as you edit.</p>
        <div class="highlight highlight-source-shell"><pre>conf watch</pre></div>
        <p>This command keeps the project running and applies updates as you work.</p>
        <div class="markdown-heading"><h3 class="heading-element">Stop Watching</h3><a id="user-content-stop-watching" class="anchor" aria-label="Permalink: Stop Watching" href="#stop-watching"><span aria-hidden="true" class="octicon octicon-link"></span></a></div>
        <p>When you're done working, you can stop the watcher by pressing <code>Control</code> + <code>C</code>.</p>
        <div class="markdown-heading"><h2 class="heading-element">Recommended Editor</h2><a id="user-content-recommended-editor" class="anchor" aria-label="Permalink: Recommended Editor" href="#recommended-editor"><span aria-hidden="true" class="octicon octicon-link"></span></a></div>
        <p>We recommend using PhpStorm for development, as it provides full autocomplete support for all Confetti functionalities by default, including PHP in Blade files. Visual Studio Code (VS Code) lacks this feature, making PhpStorm a more efficient choice for working with Confetti projects.</p>
        <p>That's it! You're now ready to start building and managing your website with Confetti.</p>
    </discussion>
</div>

@pushonce('end_of_body_docs_os_tab_installation')
    <script type="module">
        import {html, reactive} from 'https://esm.sh/@arrow-js/core@1';

        customElements.define('docs-installation-steps-v2', class extends HTMLElement {
            data;
            state;

            constructor() {
                super();
                this.data = JSON.parse(this.dataset.tabs);
                this.state = reactive({
                    selectedTab: this.#getCurrentOs(this.data[0]?.alias || null),
                });

                if (this.dataset.guest === 'false') {
                    this.data = this.data.map(tab => {
                        return {
                            ...tab,
                            steps: tab.steps?.filter((_, idx) => idx !== 0) || [],
                        };
                    });
                    }
            }

            connectedCallback() {
                html`
<div class="flex items-center justify-center mt-4 mb-12 space-x-4 border-b border-gray-300 text-xl">
    ${() => this.#putCurrentOsFirst(this.data).map((tab) => html`
    <button class="${() => `py-2 px-4 text-lg cursor-pointer ` + (this.state.selectedTab === tab.alias ? 'border-b-2 border-blue-500 font-semibold' : '')}"
            @click="${() => this.state.selectedTab = tab.alias}">
        ${tab.title}
    </button>
    `)}
</div>

${this.data.map(tab => html`
<div class="${() => this.state.selectedTab === tab.alias ? 'block' : 'hidden'}">
    ${tab.steps?.map((step, idx) => html`
        <div class="js-replace-username space-y-4">
            ${this.#filled(step.title) ? html`
                <h2 class="my-3 text-2xl font-semibold font-body">${step.title}</h2>` : ''}
            ${this.#filled(step.first_description) ? html`
                <div class="mt-4 mb-4 text-gray-800 font-body">${step.first_description}</div>` : ''}
            ${this.#filled(step.title_step) || this.#filled(step.link) ? html`
                <div class="flex relative py-5 w-full sm:items-center">
                    <div class="h-full w-6 absolute inset-0 flex items-center justify-center">
                        <div class="h-full w-1 bg-gray-200 pointer-events-none"></div>
                    </div>
                    <div class="shrink-0 w-6 h-6 rounded-full mt-10 sm:mt-0 inline-flex items-center justify-center bg-blue-500 text-white relative z-10 font-medium text-sm">
                        <span>${idx + 1}</span>
                    </div>
                    ${this.#filled(step.title_step) ? html`
                    <div class="grow pl-6 flex sm:items-center items-start flex-col sm:flex-row">
                        <div class="grow sm:pl-6 mt-6 sm:mt-0 font-body">
                            <h3 class="font-body mb-1 text-xl">${step.title_step}</h3>
                            ${this.#filled(step.example) ? html`
                                <div class="bg-gray-100 rounded px-2 py-2 my-2 text-sm">
                                    <pre class="whitespace-pre-wrap m-0 px-1 overflow-visible text-base">${step.example}</pre>
                                </div>
                            ` : ''}
                        </div>
                    </div>` : ''}
                    ${this.#filled(step.link) ? html`
                    <div class="pl-6 pt-6 sm:pl-12 sm:pt-0">
                        <a href="${step.link}" class="float-right justify-between px-3 py-2 m-2 ml-0 text-sm leading-5 cursor-pointer text-blue-500 border border-blue-500 hover:bg-blue-500 hover:text-white rounded-md">${step.link_title}</a>
                    </div>` : ''}
                </div>
            ` : ''}
            ${this.#filled(step.second_description) ? html`
                <div class="mt-2 text-gray-700">${step.second_description}</div>` : ''}
        </div>
    `)}
</div>
`)}`(this);
            }

            #filled(value) {
                return value !== null && value !== undefined && value !== '';
            }

            #getCurrentOs(def) {
                let current = def;
                const userAgent = navigator.userAgent;
                if (userAgent.indexOf('Mac') > -1) {
                    current = 'macos';
                } else if (userAgent.indexOf('Windows') > -1) {
                    current = 'windows';
                } else if (userAgent.indexOf('Linux') > -1) {
                    current = 'linux';
                }
                return current;
            }

            #putCurrentOsFirst(data) {
                const currentOs = this.#getCurrentOs(data[0]?.alias || null);
                const currentTab = data.find(tab => tab.alias === currentOs);
                if (currentTab) {
                    data = data.filter(tab => tab.alias !== currentOs);
                    data.unshift(currentTab);
                }
                return data;
            }
        });
    </script>
@endpushonce

@pushonce('end_of_body_replace_username')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @auth
            const username = '@username';
            @else
            const username = 'your_repo';
            @endauth
            document.querySelectorAll('.js-replace-username').forEach(el => {
                el.innerHTML = el.innerHTML.replaceAll('__your_repo__', username);
            });
        });
    </script>
@endpushonce
