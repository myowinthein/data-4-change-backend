# Known Limitations

These are permanent constraints or incomplete features in the original codebase. They are not bugs introduced during restoration.

---

## 1. `getAllForCompare` Only Returns Religion Data

**Location:** `app/Http/Controllers/API/DataController.php::getAllForCompare()`

The compare endpoint runs two queries — one for religion data and one for disaster data. The disaster data processing block is commented out in the original source:

```php
// $data2 = [];
// foreach ($diaster_data as $rd) { ... }
```

The function only returns the religion data. Five of the six data categories are not available in the comparison view.

**Impact:** The frontend comparison page can only compare religious demographics, not health, agriculture, disasters, living standards, or heritage data.

---

## 2. City and Year Filtering in `getAllForCompare` Not Implemented

**Location:** Same file, SQL query.

The WHERE clause filtering by city IDs and year is commented out:

```php
// WHERE rc.year = ? AND c.id IN (?)", [$year, $cityStr]
```

The endpoint always returns all cities and all years, regardless of the `cities` and `year` parameters sent in the request body.

---

## 3. Admin CSV Import Buttons Will Fail

The import panel at `/import` shows buttons to import each data category. Each button posts to a route that calls `Excel::import()` with a **hardcoded file path** relative to the application:

```php
$path = $this->root .'/health/GAD1617_M7A_Hospitals_20190514'. $this->extension;
// resolves to: storage/app/excels/health/GAD1617_M7A_Hospitals_20190514.csv
```

The source CSV files are **not included** in the repository. Clicking any import button will fail with a file-not-found error. This is expected — the panel is shown for demonstration purposes only. All data is already in the database via the SQL dump.

---

## 4. PHP 7.4 is End-of-Life

PHP 7.4 reached end-of-life in November 2022. The Docker image (`php:7.4-apache`) remains available but receives no security updates. This is acceptable for a local demo with no network exposure, but is not suitable for any public deployment.

---

## 5. Laravel 5.8 is End-of-Life

Laravel 5.8 reached end-of-life in September 2020. Upgrading to a modern Laravel version would require significant code changes and is not within the scope of this archive.

---

## 6. Frontend Requires Node 12 or 14

The `node-sass@4` package used by the frontend cannot be compiled on Node.js 16 or higher. Node 12 or 14 is required. This is a known upstream incompatibility — `node-sass` has been superseded by the `sass` (Dart Sass) package in modern projects.

To switch Node version if you have nvm:
```bash
nvm use 12
```

---

## 7. No Email Delivery

Password reset and any other email functionality will not send real emails. The mail driver is set to `log`. Check `storage/logs/laravel.log` if you need to see what would have been sent.

---

## 8. `php artisan jwt:secret` Does Not Exist

The original README instructed users to run `php artisan jwt:secret`. There is no JWT package in `composer.json`. This command does not exist and will fail. It was either a template error or left over from a project scaffold. Ignore it.

---

## 9. `religion_cities` Table Has Zero Values for Most Records

The `religion_cities` table contains 330 rows (one per city), but many of the population count columns are `0`. This reflects the original government dataset where data was available for some townships but not all cities. It is not a data import error.

---

## 10. `ProfileController` Route Registered but Controller Does Not Exist

`routes/web.php` registers `Route::resource('profiles', 'ProfileController')` but no `ProfileController` exists in the codebase. Visiting any `/profiles/*` URL will throw a class-not-found error. This route was left in from the AdminLTE package scaffolding and was never implemented.
