import {html, reactive} from 'https://esm.sh/@arrow-js/core@v1.0.0';

export class TextDemo extends HTMLElement {
    required = `->required()`;

    state = reactive({
        decorationContent: '',
        count: 0,
        required: false,
        requiredContent: '',
        default: false,
        defaultNrTyped: 0,
        bar: false,
        barNrTyped: 0,
        barTools: '',
        bold: false,
        italic: false,
        underline: false,
        alias: '',
        label: '',
        error: '',
        value: '',
    });

    constructor() {
        super();

        // clean the component
        this.innerHTML = '';

        this.state.$on('label', () => {
            this.state.alias = this.state.label.toLowerCase().replace(/ /g, '_');
        });

        this.state.$on('defaultNrTyped', () => {
            document.getElementById('brand-title').innerHTML = this.state.value;
        });

        this.#typeLabel()
    }

    connectedCallback() {
        html`
            <div class="font-body overflow-x-hidden py-8 md:pt-12">
                <div class="${() => `flex justify-center ` + (this.state.count > 0 ? 'min-h-20' : '')}">
                    <div class="text-sm md:text-base lg:text-lg xl:text-xl">
                        <div class="${() => this.state.count > 0 ? 'flex flex-col' : 'flex'}">${() => html`
                            <div>
                                <span class="text-blue-500">&lt;h1&gt;</span>
                                <span class="text-black">{{ $header->text(</span><span class="text-green-700">'${this.state.alias}'</span><span class="text-black">)</span>
                                <div class="${() => this.state.requiredContent === '' ? 'hidden' : ''}">
                                    <span class="text-black-500 pl-4">-</span><span>${() => this.state.requiredContent}</span>
                                </div>
                                <div class="${() => this.state.defaultNrTyped === 0 ? 'hidden' : ''}">
                                    <span class="pl-4 flex">
                                        <span class="text-black-500">${() => `->default(`.substring(0, this.state.defaultNrTyped)}</span>
                                        <span class="text-green-700">${()=> `'Confetti CMS'`.substring(0, this.state.defaultNrTyped  - `->default(`.length)}</span>
                                        <span class="text-black-500">${()=> `)`.substring(0, this.state.defaultNrTyped - `->default('Confetti CMS'`.length)}</span>
                                    </span>
                                </div>
                                <div class="${() => this.state.barNrTyped === 0 ? 'hidden' : ''}">
                                    <span class="pl-4 flex">
                                        <span class="text-black-500">${() => `->bar([`.substring(0, this.state.barNrTyped)}</span>
                                        <span class="text-green-500">${() => `'b'`.substring(0, this.state.barNrTyped - `->bar([`.length)}</span>
                                        <span class="text-black-500">${() => `, `.substring(0, this.state.barNrTyped - `->bar(['b'`.length)}</span>
                                        <span class="text-green-500">${() => `'i'`.substring(0, this.state.barNrTyped - `->bar(['b', `.length)}</span>
                                        <span class="text-black-500">${() => `, `.substring(0, this.state.barNrTyped - `->bar(['b', 'i'`.length)}</span>
                                        <span class="text-green-500">${() => `'u'`.substring(0, this.state.barNrTyped - `->bar(['b', 'i', `.length)}</span>
                                        <span class="text-black-500">${() => `])`.substring(0, this.state.barNrTyped - `->bar(['b', 'i', 'u'`.length)}</span>
                                    </span>
                                </div>
                                    
                                <span class="text-black">}}</span><span class="text-blue-500">&lt;/h1&gt;</span>
                            </div>
                            `}
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4 md:mt-1 mx-4 md:mx-auto md:w-2/3 min-h-32">
                <div class="text-bold text-xl mt-2 mb-4 mx-2 h-4">
                    ${() => this.state.label}
                </div>
                <div class="px-5 py-3 mx-2 text-gray-700 border-2 border-gray-400 rounded-lg bg-white font-body">
                    ${() => this.state.bar ? html`Confetti
                    <span class="${() => this.getStyle()}">CMS</span>` : this.state.value}&nbsp;</span>
                    ${() => this.state.barTools?.length >= 3 ? html`
                        <div class="absolute flex items-center space-x-1 p-1 border rounded-md w-fit bg-white">
                            <button class="${() => `font-bold py-1 px-2 rounded-sm cursor-pointer ` + (this.state.bold ? 'text-blue-600 bg-blue-100' : 'text-black hover:bg-blue-100')}" @click="${() => this.#toggleBold()}">B</button>
                            ${() => this.state.barTools?.length >= 8 ? html`
                                <button class="${() => `italic py-1 px-3 rounded-sm cursor-pointer ` + (this.state.italic ? 'text-blue-600 bg-blue-100' : 'text-black hover:bg-blue-100')}" @click="${() => this.#toggleItalic()}">I</button>` : ''}
                            ${() => this.state.barTools?.length >= 13 ? html`
                                <button class="${() => `underline py-1 px-2 rounded-sm cursor-pointer ` + (this.state.underline ? 'text-blue-600 bg-blue-100' : 'text-black hover:bg-blue-100')}" @click="${() => this.#toggleUnderline()}">U</button>` : ''}
                        </div>` : ''}
                </div>
                <p class="h-0 mx-2 mt-2 text-sm text-red-600 _error">${() => this.state.error}</p>
                <div class="font-body overflow-x-hidden py-8 md:pt-12">
                    <div class="text-sm md:text-base lg:text-lg xl:text-xl">
                        <div class="flex justify-center"><span class="text-black">Try it out yourself:</span></div>
                    </div>
                    <div class="flex mt-2 justify-center">
                        <button @click="${() => this.#toggleRequired()}" class="${() => `mx-2 my-2 p-2 text-sm leading-5 cursor-pointer border border-blue-500 rounded-md ${this.state.required ? 'bg-blue-500 text-white' : 'text-blue-500'}`}">
                            ->required()
                        </button>
                        <button @click="${() => this.#toggleDefault()}" class="${() => `mx-2 my-2 p-2 text-sm leading-5 cursor-pointer border border-blue-500 rounded-md ${this.state.default ? 'bg-blue-500 text-white' : 'text-blue-500'}`}">
                            ->default()
                        </button>
                        <button @click="${() => this.#toggleBar()}" class="${() => `mx-2 my-2 p-2 text-sm leading-5 cursor-pointer border border-blue-500 rounded-md ${this.state.bar ? 'bg-blue-500 text-white' : 'text-blue-500'}`}">
                            ->bar()
                        </button>
                    </div>
                </div>
            </div>
        `(this);
    }

    #typeLabel() {
        setTimeout(() => {
            // Slowly build the label as if we type it "Title Main"
            const label = 'Title Main';
            let i = 0;
            const interval = setInterval(() => {
                this.state.label = label.substring(0, i);
                i++;
                if (i > label.length) {
                    clearInterval(interval);
                }
            }, 125);

            // Slowly only remove the " Main" part of the label
            setTimeout(() => {
                let i = label.length;
                const interval = setInterval(() => {
                    this.state.label = label.substring(0, i);
                    i--;
                    if (i < ' Main'.length) {
                        clearInterval(interval);
                    }
                }, 100);
            }, 2500);
        }, 1000);
    }

    #toggleRequired() {
        const isRequired = !this.state.required
        if (isRequired) {
            const toType = `>required()`;
            this.state.requiredContent = '';
            let i = 0;
            const interval = setInterval(() => {
                this.state.requiredContent = toType.substring(0, i);
                i++;
                if (i > this.required.length || !this.state.required) {
                    clearInterval(interval);
                }
                if (!this.state.required) {
                    this.state.requiredContent = '';
                }
            }, 150);
        } else {
            this.state.requiredContent = '';
            this.state.error = '';
        }
        this.state.required = isRequired
        this.state.count = this.#countDeclarations()
        setTimeout(() => {
            this.#updateError();
        }, 1800);
    }

    #toggleDefault() {
        this.state.default = !this.state.default
        if (this.state.default) {
            const toType = `->default('Confetti CMS')`.length;
            const value = `Confetti CMS`; // green
            this.state.defaultNrTyped = 0;
            const interval = setInterval(() => {
                let iValue = this.state.defaultNrTyped - `->default(`.length;
                if (iValue <= 0) {
                    iValue = 0;
                }
                this.state.value = value.substring(0, iValue);
                this.state.defaultNrTyped++;
                if (this.state.defaultNrTyped > toType || !this.state.default) {
                    clearInterval(interval);
                }
                if (!this.state.default) {
                    this.state.defaultNrTyped = 0;
                }
                this.#updateError();
            }, 150);
        } else {
            this.state.defaultNrTyped = 0;
            this.state.value = '';
            this.#updateError();
        }
        this.state.count = this.#countDeclarations()
    }

    #toggleBar() {
        this.state.bar = !this.state.bar
        if (this.state.bar) {
            const methodPrefix = `->bar(`; // black
            const methodValue = '[\'b\', \'i\', \'u\']'; // green
            const methodSuffix = `)`; // black
            this.state.barNrTyped = 0;
            const interval = setInterval(() => {
                let iValue = this.state.barNrTyped - methodPrefix.length;
                if (iValue <= 0) {
                    iValue = 0;
                }
                this.state.barTools = methodValue.substring(0, iValue);
                this.state.barNrTyped++;
                if (this.state.barNrTyped > (methodPrefix + methodValue + methodSuffix).length || !this.state.bar) {
                    this.state.bold = true;
                    clearInterval(interval);
                }
            }, 200);
        } else {
            this.state.barTools = null;
            this.state.barNrTyped = 0;
        }
        this.state.count = this.#countDeclarations()
    }

    #toggleBold() {
        this.state.bold = !this.state.bold;
    }

    #toggleItalic() {
        this.state.italic = !this.state.italic;
    }

    #toggleUnderline() {
        this.state.underline = !this.state.underline;
    }

    #countDeclarations() {
        let count = 0;
        if (this.state.required) {
            count++;
        }
        if (this.state.default) {
            count++;
        }
        if (this.state.bar) {
            count++;
        }
        return count;
    }

    #updateError() {
        if (this.state.required && this.state.value.length === 0) {
            this.state.error = 'The title is required';
        } else {
            this.state.error = '';
        }
    }

    getStyle() {
        let result = ''

        if (this.state.bar) {
            result += ` bg-blue-200 py-1`
        }

        if (this.state.bold) {
            result += ` font-bold`
        }

        if (this.state.italic) {
            result += ` italic`
        }

        if (this.state.underline) {
            result += ` underline`
        }

        return result
    }
}
