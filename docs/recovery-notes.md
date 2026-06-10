# Recovery Notes

These are the fixes applied during restoration in June 2026. Read this before touching dependencies, the Dockerfile, or the database.

---

## Fix 1 — Replaced Deleted Composer Package

**Problem:** `davejamesmiller/laravel-breadcrumbs` (required at version `5.x`) was fully deleted from GitHub. Both the zipball API and the git repository return HTTP 404. Packagist still lists the package but proxies all download requests back to the dead GitHub URLs.

**Impact:** `composer install` failed every time, blocking the entire Docker build.

**Fix:** Replaced with `diglactic/laravel-breadcrumbs: ^5.0` — the official successor package. The original maintainer transferred the project to Diglactic. In version 5.x, the PHP namespace is preserved as `DaveJamesMiller\Breadcrumbs\*` for backward compatibility. No application code changes were required.

**Files changed:**
- `composer.json` — `require` section updated
- `composer.lock` — regenerated using a throwaway `composer:2` Docker container with `--no-install --ignore-platform-reqs`

**Version installed:** `diglactic/laravel-breadcrumbs 5.3.2`

---

## Fix 2 — Laravel 5.8.17 + Composer 2 Incompatibility

**Problem:** Laravel 5.8.17's `PackageManifest::build()` reads `vendor/composer/installed.json` and iterates over it directly. In Composer 1, `installed.json` was a plain array of packages. In Composer 2, it became an object with a `packages` key wrapping the array. Laravel 5.8.17 never received this fix (it was backported in 5.8.36). Every `php artisan` call failed with:

```
In PackageManifest.php line 122:
Undefined index: name
```

**Fix:** A one-line `sed` patch applied in the Dockerfile during image build, after the vendor install step:

```dockerfile
RUN sed -i \
    's/\$packages = json_decode(\$this->files->get(\$path), true);/\$installed = json_decode(\$this->files->get(\$path), true); \$packages = \$installed["packages"] ?? \$installed;/' \
    /opt/vendor_bootstrap/laravel/framework/src/Illuminate/Foundation/PackageManifest.php
```

This is the same fix that was shipped in Laravel 5.8.36. It adds `$packages = $installed["packages"] ?? $installed` — if the key exists (Composer 2), unwrap it; otherwise use the array directly (Composer 1).

**Files changed:** `Dockerfile`

---

## Fix 3 — Missing Root View

**Problem:** `routes/web.php` had `Route::get('/', fn() => view('imports'))` but the view file `resources/views/imports.blade.php` was never created. Every visit to `/` returned HTTP 500.

**Fix:** Changed the root route to redirect to `/login`, which leads to the admin panel. This matches the intended flow — the root was always just an entry point to the admin.

**Files changed:** `routes/web.php`

---

## Fix 4 — Stale Docker Volume Credentials

**Problem:** During initial Docker bringup attempts, a volume named `backend_db_data` was created with a different set of MySQL credentials (from a failed `docker compose -p data4change` session). When the correct compose file started a new `backend-db-1` container, MySQL refused connections because the persisted data directory had the old credentials baked in. MySQL ignores env vars after first initialisation.

**Fix:** Deleted the stale volume (`docker volume rm backend_db_data`) and restarted. MySQL reinitialised from scratch, importing the SQL dump and creating the `data4change` user with the correct password.

**This is a known Docker + MySQL pattern.** If you ever see `Access denied for user 'data4change'` and you haven't changed passwords, delete the volume and restart.

---

## Fix 5 — Stale `preferred-install` in composer.json

**Problem:** An earlier troubleshooting attempt ran `composer config preferred-install.davejamesmiller/laravel-breadcrumbs source` inside the Docker container, which wrote directly to the project's `composer.json`. This left an unexpected `config.preferred-install` map in the file.

**Fix:** Cleaned up the `config.preferred-install` section in `composer.json` to a single `"preferred-install": "dist"` string.

---

## Fix 6 — Vendor Pre-Installation Strategy

**Problem:** The standard approach of running `composer install` at container startup failed because:
1. GitHub package URLs are dead (Fix 1)
2. `--prefer-dist` blocked source fallback
3. Each container restart attempted a fresh install, causing repeated failures and crash loops

**Fix:** Vendor is now installed at **Docker image build time** into `/opt/vendor_bootstrap/` inside the image. The entrypoint copies this to `/var/www/html/vendor/` on first boot only. This means:
- No network access needed at runtime
- No repeated install attempts on restart
- Build-time failures are caught immediately

**Important:** If you rebuild the Docker image, delete `vendor/` from the host project directory first:
```bash
rm -rf vendor/
docker compose build
docker compose up -d
```
Otherwise the entrypoint sees `vendor/` as "already present" and skips the copy, leaving stale files on disk.

---

## Security Cleanup (Step 2, June 2026)

Performed alongside restoration:

| Item | Action |
|---|---|
| `DB_USERNAME=myowin` in `.env.example` | Replaced with placeholder |
| `DB_PASSWORD=b!Nn%4X$xC73pj` in `.env.example` | Replaced with placeholder |
| `APP_KEY=base64:toGjV6...` in `.env.dusk.local` and `.env.dusk.testing` | Replaced with placeholder; files untracked from git |
| `remember_token` in SQL dump users row | Nulled out |
