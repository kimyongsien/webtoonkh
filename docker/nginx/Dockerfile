FROM node:22-alpine AS frontend_builder
WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY resources ./resources
COPY public ./public
COPY vite.config.js postcss.config.js tailwind.config.js ./
RUN npm run build

FROM nginx:1.27-alpine
WORKDIR /var/www/html

COPY public ./public
COPY --from=frontend_builder /app/public/build ./public/build
RUN mkdir -p /var/www/html/storage/app/public \
    && ln -sfn /var/www/html/storage/app/public /var/www/html/public/storage
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
