export class DevTools {
    static endpoint = '/conf_api/confetti-cms/parser/log_stream';

    // state per subscription type
    static state = {
        // example:
        // file_changed: { stopped: false, isPolling: false }
    };

    static subscribeFileChanges(
        callbackFileChanged,
        callbackFileProcessed,
        errorCallback
    ) {
        console.info('Subscribed to file changes.');

        this.start('file_changed', callbackFileChanged, errorCallback);
        this.start('file_parsed', callbackFileProcessed, errorCallback);

        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                console.info('Page hidden, stopping file change polling.');
                this.stopAll();
                return;
            }

            setTimeout(() => {
                console.info('Page visible again, resuming file change polling.');

                this.restart('file_changed', callbackFileChanged, errorCallback);
                this.restart('file_parsed', callbackFileProcessed, errorCallback);
            }, 300);
        });
    }

    static ensureState(type) {
        if (!this.state[type]) {
            this.state[type] = {
                stopped: false,
                isPolling: false,
            };
        }
        return this.state[type];
    }

    static start(type, callback, errCb) {
        const s = this.ensureState(type);
        s.stopped = false;
        this.poll(type, callback, errCb);
    }

    static stop(type) {
        const s = this.ensureState(type);
        s.stopped = true;
    }

    static stopAll() {
        Object.keys(this.state).forEach(type => {
            this.state[type].stopped = true;
        });
    }

    static restart(type, callback, errCb) {
        const s = this.ensureState(type);

        if (!s.stopped) return;

        s.stopped = false;
        this.poll(type, callback, errCb);
    }

    static async poll(type, callback, errorCallback) {
        const s = this.ensureState(type);

        if (s.stopped || s.isPolling) return;

        s.isPolling = true;

        try {
            while (!s.stopped) {
                const controller = new AbortController();
                const timeout = setTimeout(() => controller.abort(), 11000);

                try {
                    const res = await fetch(this.endpoint, {
                        method: 'GET',
                        signal: controller.signal,
                        headers: {
                            Accept: 'application/json',
                        },
                    });

                    clearTimeout(timeout);

                    if (!res.ok) {
                        const message = `Polling stopped (HTTP ${res.status}) [${type}]`;
                        console.error(message);
                        (errorCallback ?? console.error)(message);
                        s.stopped = true;
                        break;
                    }

                    const data = await res.json();

                    if (data.status === type) {
                        callback?.(data);
                    }

                } catch (err) {
                    clearTimeout(timeout);

                    if (err?.name === 'AbortError') {
                        continue;
                    }

                    console.error(`Polling error [${type}]:`, err);
                    (errorCallback ?? console.error)(
                        'Watcher disconnected. Run `conf watch` or refresh the page.'
                    );

                    s.stopped = true;
                    break;
                }
            }
        } finally {
            s.isPolling = false;
            console.info(`Polling fully stopped [${type}].`);
        }
    }
}
