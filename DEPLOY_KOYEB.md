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
- A Cloudinary account for image uploads

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
CLOUDINARY_CLOUD_NAME=your-cloudinary-cloud-name
CLOUDINARY_API_KEY=your-cloudinary-api-key
CLOUDINARY_API_SECRET=your-cloudinary-api-secret
```

7. Deploy the service.
8. After it becomes healthy, open the public Koyeb URL.

## File uploads

This app now uploads story and category images to Cloudinary.

- The database stores the returned image URL
- It also stores the Cloudinary public ID so replacements and deletes can clean up old assets
- This avoids relying on Koyeb's ephemeral local disk for image uploads

## What this image does on startup

The deployment entrypoint:

1. Ensures Laravel has an `APP_KEY`
2. Creates the `public/storage` symlink
3. Runs database migrations
4. Starts Apache

## After deploy

Run migrations, create your admin account from the Koyeb shell or by running an artisan command in the service container, then log in and add demo content.
