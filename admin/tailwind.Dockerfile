FROM alpine:3.21 as development-cmd

WORKDIR /src
COPY . .

RUN apk update
RUN apk add curl libstdc++ libgcc

RUN curl -sLO https://github.com/tailwindlabs/tailwindcss/releases/download/v4.0.0/tailwindcss-linux-arm64-musl
RUN chmod +x tailwindcss-linux-arm64-musl
RUN mv tailwindcss-linux-arm64-musl /bin/tailwindcss

LABEL trigger_restart_1h="true"
LABEL for_development_only="true"

CMD /bin/tailwindcss \
-i /src/assets/css/tailwind.css \
-c /src/tailwind.config.js \
-o /var/resources/admin__tailwind/tailwind.output.css \
--watch \
--verbose
