@php($current = extendModel($model))

<h1 class="text-3xl font-semibold text-gray-800 mb-2">{{ $current->text('title')->max(50) }}</h1>
<div class="mt-4 mb-4 text-gray-800 font-body">@include('website.includes.blocks.index', ['model' => $current->content('description')])</div>

@php
    $taps = [];
    foreach ($current->list('tab')->columns(['title'])->sortable()->max(3)->get() as $iOs => $os) {
        $taps[$iOs]['alias'] = $os->text('alias')->min(1)->get();
        $taps[$iOs]['title'] = $os->text('title')->max(50)->get();
        foreach ($os->list('step')->columns(['title'])->sortable()->max(10)->get() as $iStep => $step) {
            $taps[$iOs]['steps'][$iStep]['id'] = $step->getId();
            $taps[$iOs]['steps'][$iStep]['title'] = $step->text('title')->max(50)->get();
            $taps[$iOs]['steps'][$iStep]['first_description'] = $this->runChild('website.includes.blocks.index', ['model' => $step->content('first_description')]);
            $taps[$iOs]['steps'][$iStep]['title_step'] = $step->text('title_step')->max(50)->get();
            $taps[$iOs]['steps'][$iStep]['example'] = $this->runChild('website.includes.blocks.index', ['model' => $step->content('example')]);
            $taps[$iOs]['steps'][$iStep]['second_description'] = $this->runChild('website.includes.blocks.index', ['model' => $step->content('second_description')]);
        }
    }
@endphp

<!-- For SEO and AI -->
<div class="hidden">
    <h1>{{ $current->text('title')->max(50) }}</h1>
    <div class="mt-4 mb-4 text-gray-800 font-body">@include('website.includes.blocks.index', ['model' => $current->content('description')])</div>
    @foreach ($taps as $os)
        <h2>{{ $os['title'] }}</h2>
        @foreach ($os['steps'] ?? [] as $iStep => $step)
            <h3>{{ $step['title'] }}</h3>
            <p>{{ $step['first_description'] }}</p>
            <p>{{ $step['title_step'] }}</p>
            <p>{{ $step['example'] }}</p>
            <p>{{ $step['second_description'] }}</p>
        @endforeach
    @endforeach
</div>

<!-- Blade: only output the component with JSON data -->
@php($current = extendModel($model))
<docs-installation-steps data-tabs="{{ json_encode($taps) }}"></docs-installation-steps>

@pushonce('end_of_body_docs_os_tab')
    <script type="module">
        import {html, reactive} from 'https://esm.sh/@arrow-js/core';

        customElements.define('docs-installation-steps', class extends HTMLElement {
            data;
            reactive;

            constructor() {
                super();
                this.data = JSON.parse(this.dataset.tabs);
                this.reactive = reactive({
                    selectedTab: this.#getCurrentOs(this.data[0]?.alias || null),
                });
            }

            connectedCallback() {
                this.reactive.$on('selectedTab', value => {
                    console.log('Selected Tab:', value);
                });

                html`
                    <!-- Navigation Tabs -->
                    <div class="flex items-center justify-center mt-4 mb-4 space-x-4 border-b border-gray-300 text-xl">
                        ${this.#putCurrentOsFirst(this.data).map(tab => html`
                            <button class="${() => `py-2 px-4 text-lg cursor-pointer ` + (this.reactive.selectedTab === tab.alias ? 'border-b-2 border-blue-500 font-semibold' : '')}"
                                    @click="${() => this.reactive.selectedTab = tab.alias}">
                                ${tab.title}
                            </button>
                        `)}
                    </div>

                    <!-- Content Panes -->
                    ${this.data.map(tab => html`
                        <div class="${() => (this.reactive.selectedTab === tab.alias ? 'block' : 'hidden') + ` space-y-8`}">
                            ${tab.steps?.map((step, idx) => html`
                                <div class="space-y-4">
                                    ${step.title ? html`
                                        <h2 class="text-2xl font-semibold text-gray-800 mb-2">${step.title}</h2>` : ''}
                                    ${step.first_description ? html`
                                        <div class="mt-4 mb-4 text-gray-800 font-body">${step.first_description}</div>` : ''}
                                    ${step.title_step ? html`
                                        <div class="flex relative py-5 w-full sm:items-center">
                                            <div class="h-full w-6 absolute inset-0 flex items-center justify-center">
                                                <div class="h-full w-1 bg-gray-200 pointer-events-none"></div>
                                            </div>
                                            <div class="shrink-0 w-6 h-6 rounded-full mt-10 sm:mt-0 inline-flex items-center justify-center bg-blue-500 text-white relative z-10 font-medium text-sm">
                                                <span>${idx + 1}</span>
                                            </div>
                                            <div class="grow pl-6 flex sm:items-center items-start flex-col sm:flex-row">
                                                <div class="grow sm:pl-6 mt-6 sm:mt-0 font-body">
                                                    <h3 class="font-semibold mb-1 text-xl">${step.title_step}</h3>
                                                    ${step.example ? html`
                                                        <div class="mt-2 text-gray-700">${step.example}</div>` : ''}
                                                </div>
                                            </div>
                                        </div>
                                    ` : ''}
                                    ${step.second_description ? html`
                                        <div class="mt-2 text-gray-700">${step.second_description}</div>` : ''}
                                </div>
                            `)}
                        </div>
                    `)}
                `(this);
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
