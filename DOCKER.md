# Docker Guide

This project now includes a simple Docker setup so you can learn the moving pieces while deploying a Laravel app.

## What is included

- `Dockerfile`: Builds one app image for Laravel with PHP 8.2, Composer dependencies, and Vite assets.
- `docker-compose.yml`: Starts three services together:
  - `app`: PHP-FPM running Laravel
  - `web`: Nginx serving the Laravel `public` folder
  - `db`: MySQL for application data
- `.env.docker.example`: Docker-friendly environment values
- `docker/app/entrypoint.sh`: Generates the app key and runs migrations when the app container starts
- Uploaded files are kept in a named Docker volume so they survive container rebuilds

## Why this layout is useful

- Nginx handles incoming HTTP requests.
- PHP-FPM executes Laravel's PHP code.
- MySQL stores your data.
- Docker Compose connects them on the same private network.
- The containers use files baked into the images, which is closer to real deployment and avoids local-environment conflicts.

This is close to how many real deployments are structured, just smaller and easier to understand.

## First run

1. Build and start the containers:
   ```bash
   docker compose up --build
   ```
2. Open the app at `http://localhost:8080`
3. Stop everything with:
   ```bash
   docker compose down
   ```

## Useful commands

If your local `.env` is set up for Laragon or SQLite, Docker can still use the values from `.env.docker.example` because those values are passed into the containers directly.

Run the app in the background:

```bash
docker compose up --build -d
```

Run Laravel commands inside the app container:

```bash
docker compose exec app php artisan about
docker compose exec app php artisan migrate:status
```

Open a shell in the app container:

```bash
docker compose exec app sh
```

Remove containers and the database volume:

```bash
docker compose down -v
```

## Learning the process

When you run `docker compose up --build`, Docker does this:

1. Builds the Laravel app image from `Dockerfile`
2. Installs PHP dependencies with Composer
3. Builds frontend assets with Vite
4. Starts MySQL
5. Starts the Laravel app container
6. Generates `APP_KEY` and runs migrations
7. Starts Nginx and exposes the site on port `8080`

## Notes for deployment

- For a real server, you would usually change passwords in `.env.docker.example`.
- You may want to add a queue worker service later if the app starts using background jobs heavily.
- For classroom/demo use, this setup is enough to understand containerized deployment.
- Story and category uploads are stored in a shared Docker volume mounted at Laravel's `storage/app/public`.
