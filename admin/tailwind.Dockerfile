FROM alpine:3.21 as development-cmd

RUN apk update
RUN apk add curl libstdc++ libgcc

RUN curl -sLO https://github.com/tailwindlabs/tailwindcss/releases/download/v4.0.0/tailwindcss-linux-arm64-musl
RUN chmod +x tailwindcss-linux-arm64-musl
RUN mv tailwindcss-linux-arm64-musl /bin/tailwindcss

LABEL trigger_restart_1h="true"
LABEL for_development_only="true"

WORKDIR /src

# Move /src/admin/tailwind.config.js to /src/tailwind.config.js, so we can see the pkg files
RUN mv /src/admin/tailwind.config.js /src/tailwind.config.js

CMD /bin/tailwindcss \
-i /src/admin/public/css/tailwind.css \
-c /src/tailwind.config.js \
-o /var/resources/tailwind.output.css \
--watch \
--verbose
