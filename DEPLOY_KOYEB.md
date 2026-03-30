# Deploy on Koyeb

This is the simplest next step if you want your Dockerized Laravel assignment online.

## What to deploy

Use the single-container image in `Dockerfile.deploy`.

Why:

- Your local `docker-compose.yml` is great for learning.
- A platform deployment is easier when the web server and PHP app are bundled into one image.
- You can connect that app to a managed MySQL database.

## Before you start

You need:

- A GitHub repo with this project
- A Koyeb account
- A MySQL database

## Deploy steps

1. Push this project to GitHub.
2. In Koyeb, create a new Web Service from your repo.
3. Choose Dockerfile deployment.
4. Point Koyeb to `Dockerfile.deploy`.
5. Set the HTTP port to `80` if Koyeb asks.
6. Add environment variables:

```env
APP_NAME=WebtoonV2
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-koyeb-url
DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_PORT=3306
DB_DATABASE=your-db-name
DB_USERNAME=your-db-user
DB_PASSWORD=your-db-password
FILESYSTEM_DISK=public
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

7. Deploy the service.
8. After it becomes healthy, open the public Koyeb URL.

## File uploads

This app stores story and category images in Laravel's public storage:

- `storage/app/public/covers`
- `storage/app/public/category_covers`

For a short classroom demo, local disk storage is okay.

For a longer-lived public deployment, use object storage later because container filesystems are often ephemeral.

## What this image does on startup

The deployment entrypoint:

1. Ensures Laravel has an `APP_KEY`
2. Creates the `public/storage` symlink
3. Runs database migrations
4. Starts Apache

## After deploy

Create your admin account from the Koyeb shell or by running an artisan command in the service container, then log in and add demo content.
