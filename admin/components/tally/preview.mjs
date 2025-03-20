// noinspection GrazieInspection

export default class {
    id;
    value;

    /**
     * @param {string} id
     * @param {any} value
     * For example:
     * {
     *     "share_link": "https://tally.so/r/wQ8LDQ",
     *     "embed_url": "https://tally.so/embed/wQ8LDQ",
     *     "admin_url": "https://tally.so/forms/wQ8LDQ",
     *     "title": "Newsletter"
     * }
     * @param component {object}
     * For example:
     * {
     *   "decorations": {                     |
     *     "label": {                         |
     *      ^^^^^                             | The name of the decoration method
     *        "label": "Choose your template" |
     *         ^^^^^                          | The name of the parameter
     *                  ^^^^^^^^^^^^^^^^^^^^  | The value given to the parameter
     *     }
     *   },
     *   "key": "/model/view/features/select_file_basic/value-",
     *   "source": {"directory": "view/features", "file": "select_file_basic.blade.php", "from": 5, "line": 2, "to": 28},
     * }
     */
    constructor(id, value, component) {
        this.value = value;
    }

    toHtml() {
        return `
            <div class="flex items-center justify-between pt-3 pb-3 pl-3 pr-4 sm:pr-0">
                ${this.value ? ` 
                <div class="line-clamp-2">${this.value.title}</div>
                <a href="${this.value.admin_url}" target="_blank" class="px-2 py-1 text-sm font-medium leading-5 cursor-pointer text-white bg-emerald-700 hover:bg-emerald-800 border border-transparent rounded-md whitespace-nowrap">Tally</a>
                ` : 'Not provided'}
            </div>`;
    }
}
