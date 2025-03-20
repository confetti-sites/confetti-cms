export class DevTools {
    /**
     * Call to localhost:8001/messages every 10 seconds with 11 second timeout
     * When we receive a message from the server, we parse handle the response
     * and call the appropriate callback function. Then we wait for the next message.
     * @param {function} callbackLocalFileChanged
     * @param {function} callbackRemoteFileProcessed
     * @param {function} errorCallback
     */
    static subscribeFileChanges(callbackLocalFileChanged, callbackRemoteFileProcessed, errorCallback) {
        const eventSource = new EventSource('http://localhost:8001/messages');

        // If the user switches tabs, the connection might break.
        document.addEventListener("visibilitychange", () => {
            eventSource.close();
            this.subscribeFileChanges(callbackLocalFileChanged, callbackRemoteFileProcessed, errorCallback);
        });

        eventSource.onerror = (error) => {
            if (eventSource.readyState === EventSource.CLOSED) {
                // EventSource is closed, due to page reload or navigation.
                return;
            }
            errorCallback('Your browser is not connected to a watcher. Start the watcher by running `conf watch` in the terminal.');
            console.error('EventSource failed. Your page may be reloaded or the watcher may have been stopped.', error);
        }

        /*
         * The event "open" will capture all events with
         */
        eventSource.addEventListener("message", (e) => {
            if (e.type !== 'message') {
                errorCallback('Error: ' + e.message);
                console.error('Error:', e);
                return;
            }

            const data = JSON.parse(e.data);
            switch (data.type) {
                case 'local_file_changed':
                    callbackLocalFileChanged(data);
                    break;
                case 'remote_file_processed':
                    callbackRemoteFileProcessed(data, eventSource);
                    break;
                case 'error':
                    console.error('Error:', data.message);
                    errorCallback(data.message);
                    break;
                default:
                    console.warn('Unknown event:', data.type);
            }
        });
    };
}

