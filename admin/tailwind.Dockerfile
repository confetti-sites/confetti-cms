FROM alpine:3.21 as development-cmd

RUN apk update
RUN apk add curl libstdc++ libgcc

RUN curl -sLO https://github.com/tailwindlabs/tailwindcss/releases/download/v4.2.1/tailwindcss-linux-x64-musl
RUN chmod +x tailwindcss-linux-x64-musl
RUN mv tailwindcss-linux-x64-musl /bin/tailwindcss

LABEL trigger_restart_1h="true"
LABEL for_development_only="true"

RUN echo "Watching for changes in /src/admin/public/css/tailwind.css and /src/admin/tailwind.config.js"

CMD /bin/tailwindcss \
-input /src/admin/public/css/tailwind.css \
--config /src/admin/tailwind.config.js \
--output /var/resources/tailwind.output.css \
--cwd /src \
--watch \
--verbose


