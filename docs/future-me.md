# Future Me — Recovery Warnings

If you are reading this years from now trying to restore this project, here is what you need to know.

---

## The Single Most Important Thing

**The SQL dump is everything.** It is at:

```
storage/backup/data4change_2019-05-25.sql
```

This file contains all 14,429 townships, all 356 cities, all 18 regions, all categories, variables, and domain data. If you lose this file, the statistical data is gone. There are no CSV source files in the repository to reimport from.

Do not run `php artisan migrate:refresh --seed`. The seeder only creates the admin user — it does not restore the data.

---

## The Composer Package Problem

`davejamesmiller/laravel-breadcrumbs` was deleted from GitHub. It cannot be installed. The project now uses `diglactic/laravel-breadcrumbs` as a drop-in replacement. This is already in `composer.json` and `composer.lock` — do not change it back.

If you ever try to use the original lock file from git history and see a 404 error for `davejamesmiller`, that is why. Use the current `composer.lock`.

---

## The PackageManifest Patch

Laravel 5.8.17 is incompatible with Composer 2's `installed.json` format. The fix is already applied in the `Dockerfile` as a `sed` command. If you ever regenerate the vendor directory from scratch without rebuilding the Docker image, `php artisan` will fail with `Undefined index: name` in `PackageManifest.php`.

The fix must be baked into the Docker image, not applied manually. Always use `docker compose build` to create the image — do not run `composer install` directly on the host.

---

## PHP Version

This project **requires PHP 7.x**. Your host machine almost certainly has a newer PHP. Do not try to run `php artisan` or `composer install` on the host — use Docker.

The image is `php:7.4-apache`. As of 2026, this image still exists on Docker Hub but receives no updates. If Docker Hub ever removes it, you will need to find a PHP 7.4 base image from another registry (or build your own from source).

---

## Vendor Management

The PHP `vendor/` directory is created by Docker at runtime — it is not committed to git and should not be. If `vendor/` exists on disk from a previous run and you rebuild the Docker image, delete it first:

```bash
rm -rf vendor/
docker compose build
docker compose up -d
```

If you skip the delete and just rebuild, the container entrypoint will see `vendor/` as "already present" and skip copying the freshly built version. This will leave you with stale or unpatched vendor files.

---

## Database Volume

The MySQL data lives in a Docker named volume called `backend_db_data`. This is separate from the project files. If you delete this volume, MySQL will reinitialise and reimport the SQL dump automatically on next `docker compose up`. This is safe.

If you see `Access denied for user 'data4change'`, it almost always means the volume has credentials from a different session. Delete and recreate:

```bash
docker compose down
docker volume rm backend_db_data
docker compose up -d
```

---

## The Frontend

The frontend is a **separate git repository**. It is not inside this backend repo. Look for it at `../frontend` relative to the backend, or at `git@gitlab.com:hackathon7814206/data-for-change/frontend.git` (still on GitLab).

The frontend is not managed by `docker-compose.yml`. Run it separately:

```bash
cd ../frontend
yarn dev  # or: node v12 required
```

The frontend's `.env` must contain `baseURL=http://localhost:8100/api`. Without this, all API calls will fail.

---

## Node Version for Frontend

`node-sass@4` (used by the frontend) requires Node.js 12 or 14. It will not compile on Node 16+. Use `nvm use 12` if needed.

---

## What Does Not Work Intentionally

- Import buttons in the admin panel — CSV files are not in the repo
- Password reset emails — mail driver is `log`, nothing is sent
- `getAllForCompare` API — only returns religion data, the rest is commented out
- `/profiles/*` routes — ProfileController was never implemented
- `php artisan jwt:secret` — no JWT package, ignore this from old README

---

## Quick Sanity Check

After starting, run these to confirm everything is working:

```bash
# Should return 18 regions
curl "http://localhost:8100/api/region/getAll?lang=en" | python3 -c "import sys,json; d=json.load(sys.stdin); print(len(d['data']), 'regions')"

# Should return 6 categories
curl "http://localhost:8100/api/category/getAll?lang=en" | python3 -c "import sys,json; d=json.load(sys.stdin); print(len(d['data']), 'categories')"

# Should return HTTP 200
curl -o /dev/null -w "%{http_code}" http://localhost:8100/login
```
