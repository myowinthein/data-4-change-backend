# Architecture

## System Overview

Two separate repositories. The backend serves a REST API and an admin panel. The frontend is a client-side SPA that calls the API from the browser.

```
Browser
  │
  ├── GET http://localhost:3000        → Nuxt SPA (frontend repo)
  │         │
  │         └── axios calls → http://localhost:8100/api/*
  │
  └── GET http://localhost:8100        → Laravel (backend repo)
            ├── /login                → AdminLTE admin panel
            ├── /import               → CSV data import (auth required)
            └── /api/*                → JSON REST API (public)
```

## Backend Stack

| Layer | Technology | Version |
|---|---|---|
| Language | PHP | 7.4.33 (container) |
| Framework | Laravel | 5.8.17 |
| Web server | Apache | 2.4.54 |
| Database | MySQL | 8.0 |
| Admin UI | AdminLTE (acacha package) | 6.0 |
| Excel/CSV import | Maatwebsite/Excel | 3.1 |
| CORS | barryvdh/laravel-cors | 0.11.3 |
| Breadcrumbs | diglactic/laravel-breadcrumbs | 5.3.2 |
| Burmese script | rabbit-converter/rabbit-php | dev-master |
| Containerisation | Docker + Docker Compose | — |

## Frontend Stack

| Layer | Technology | Version |
|---|---|---|
| Framework | Nuxt.js | 2.4.0 |
| Mode | SPA (client-side only) | — |
| UI components | Element UI, Bootstrap-Vue | — |
| Charts | ECharts via v-charts | — |
| i18n | nuxt-i18n | English + Myanmar |
| HTTP client | axios (@nuxtjs/axios) | — |
| Node.js | 12.x (required — see Limitations) | — |

## Docker Architecture

```
docker-compose.yml (backend repo)
  ├── app  (backend-app-1)
  │     Image:   backend-app  [php:7.4-apache]
  │     Port:    8100 → 80
  │     Volume:  .:/var/www/html  (project files)
  │     Depends: db (service_healthy)
  │     Restart: on-failure
  │
  └── db   (backend-db-1)
        Image:   mysql:8.0
        Port:    3307 → 3306
        Volume:  backend_db_data:/var/lib/mysql
                 ./storage/backup/data4change_2019-05-25.sql  → init dump
                 ./docker/mysql/custom.cnf  → native password auth
        Health:  mysqladmin ping every 5s

Frontend: started separately — not in this compose file.
```

## Data Model

```
regions          (18 rows)   — Myanmar states and union territories
  └── cities     (356 rows)  — Districts / cities within regions
        └── townships (14,429 rows) — Townships within cities

categories       (6 rows)    — Top-level data themes
  └── sub_categories (6 rows) — Sub-themes within categories
        └── variables (29 rows) — Individual measurable metrics

Data tables (330 rows each — one per city per year):
  hospital_cities
  drinking_water_cities
  religion_cities
  diaster_cities
  live_stock_cities_tables
  heritage_building_cities
  heritage_building_lists   (508 rows — individual building records)
```

All primary keys are UUIDs (`char(36)`).

## API Flow

```
GET /api/category/getAll?lang=en
  → CategoryController::getAll()
  → Category::with('subCategories.variables')
  → CategoryResource collection

GET /api/region/getAll?lang=en
  → RegionController::getAll()
  → Region::with(['cities'])
  → RegionResource collection

POST /api/data/getAllForOverall
  Body: { lang, variables: [uuid,...], cities: [uuid,...], year: "YYYY" }
  → DataController::getAllForOverall()
  → Dynamic eager-loading across 6 domain tables via Variable::eagerLoader

POST /api/data/getAllForCompare
  Body: { lang, cities: [uuid,...], year: "YYYY" }
  → DataController::getAllForCompare()
  → Raw SQL joins across religion_cities (disaster section is unfinished — see Limitations)
```

## Authentication

- **Admin panel** (`/login`, `/import`): Laravel session auth. Single admin account seeded via SQL dump.
- **API** (`/api/*`): No authentication required. All endpoints are public.
- **API v1 group** (`/api/v1/*`): Defined in routes but empty — no protected endpoints implemented.

## CORS

Wildcard (`*`) — all origins, methods, and headers allowed. Configured in `config/cors.php`.

## Admin CSV Import Flow

```
Admin logs in → /import panel
  → selects a data category
  → clicks import button (POST /import/{category})
  → ImportController reads hardcoded CSV path from storage/app/excels/...
  → Maatwebsite/Excel parses CSV
  → Import class maps rows to Eloquent models
  → Data inserted into the corresponding *_cities table
```

CSV files are NOT included in the repository. The SQL dump at `storage/backup/data4change_2019-05-25.sql` already contains all imported data.
