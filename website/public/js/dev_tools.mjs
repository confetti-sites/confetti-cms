export class DevTools {
    static stopped = false;
    static isPolling = false;
    static endpoint = '/conf_api/confetti-cms/parser/log_stream';

    static subscribeFileChanges(
        callbackLocalFileChanged,
        callbackRemoteFileProcessed,
        errorCallback
    ) {
        this.stopped = false;
        console.info('Subscribed to file changes.');

        this.poll(
            callbackLocalFileChanged,
            callbackRemoteFileProcessed,
            errorCallback
        );

        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                console.info('Page hidden, stopping file change polling.');
                this.stop();
                return;
            }

            setTimeout(() => {
                console.info('Page visible again, resuming file change polling.');
                this.restart(
                    callbackLocalFileChanged,
                    callbackRemoteFileProcessed,
                    errorCallback
                );
            }, 300);
        });
    }

    static stop() {
        this.stopped = true;
    }

    static restart(cb1, cb2, errCb) {
        if (!this.stopped) return;

        this.stopped = false;
        this.poll(cb1, cb2, errCb);
    }

    static async poll(
        callbackLocalFileChanged,
        callbackRemoteFileProcessed,
        errorCallback
    ) {
        if (this.stopped || this.isPolling) return;

        this.isPolling = true;

        try {
            while (!this.stopped) {
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
                        const message = `Polling stopped (HTTP ${res.status})`;
                        console.error(message);
                        (errorCallback ?? console.error)(message);
                        this.stop();
                        break;
                    }

                    const data = await res.json();

                    switch (data.status) {
                        case 'file_changed':
                            callbackLocalFileChanged?.(data);
                            break;

                        case 'file_parsed':
                            callbackRemoteFileProcessed?.(data);
                            break;

                        default:
                            console.warn('Unknown status:', data.status);
                    }

                } catch (err) {
                    clearTimeout(timeout);

                    if (err?.name === 'AbortError') {
                        continue;
                    }

                    console.error('Polling error:', err);
                    (errorCallback ?? console.error)(
                        'Watcher disconnected. Run `conf watch` or refresh the page.'
                    );

                    this.stop();
                    break;
                }
            }
        } finally {
            this.isPolling = false;
            console.info('Polling fully stopped.');
        }
    }
}