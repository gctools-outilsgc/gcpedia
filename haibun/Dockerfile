FROM mcr.microsoft.com/playwright:v1.40.1-focal

WORKDIR /app

COPY . .

RUN npx playwright install-deps \
    && npx playwright install

RUN npm ci

CMD ["tail", "-f", "/dev/null"]
