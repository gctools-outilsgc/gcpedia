FROM mcr.microsoft.com/playwright:v1.44.0-jammy

WORKDIR /app

COPY ./node_modules node_modules
COPY load-tests/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]


