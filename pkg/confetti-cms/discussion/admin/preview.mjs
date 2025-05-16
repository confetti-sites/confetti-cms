// noinspection GrazieInspection

export default class {
    id;
    value;

    /**
     * @param {string} id
     * @param {any} value
     * @param component {object}
     * For example:
     * {
     *     "url": "https://github.com/confetti-cms/community/discussions/1",
     *     "discussion": {
     *         "repository_url": "https://api.github.com/repos/confetti-cms/community",
     *         "html_url": "https://github.com/confetti-cms/community/discussions/1",
     *         "id": 7493776,
     *         "node_id": "D_kwDONQNvK84AcliQ",
     *         "number": 1,
     *         "title": "Image",
     *         "body": "<p>The content</p>\n",
     *         "reactions": {...},
     *     }
     * }
     */
    constructor(id, value, component) {
        this.id = id;
        this.value = value;
    }

    toHtml() {
        let result;
        if (this.value.error) {
            result = `${this.value.error}`;
        } else if (!this.value.discussion || !this.value.discussion.title) {
            result = `No title`;
        } else {
            result = `${this.value.discussion.title}`;
        }

        return `<span id="${this.id}" class="p-3 line-clamp-2">${result}</span>`;
    }
}
