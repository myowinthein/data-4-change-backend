# Archive Metadata

## Project Identity

| Field | Value |
|---|---|
| Project name | Data for Change |
| Team | Team Novit |
| Type | Hackathon project |
| Domain | Myanmar open-data / civic tech |
| Original build date | May 2019 |
| Archive date | June 2026 |
| Archive status | Complete — fully restored and verified |

## Repository

| Repo | URL |
|---|---|
| Backend | `git@github.com:myowinthein/data-4-change-backend.git` |
| Frontend | `git@gitlab.com:hackathon7814206/data-for-change/frontend.git` *(still on GitLab)* |
| Last commit (backend) | `bb07342` — "Update README.md" |
| Branch | `master` (only branch) |

## Runtime Versions (Docker)

| Component | Version |
|---|---|
| PHP | 7.4.33 |
| Apache | 2.4.54 |
| MySQL | 8.0 |
| Laravel | 5.8.17 |
| Composer | 2.x |
| Nuxt.js | 2.4.0 |
| Node.js (frontend) | 12.x |

## Database

| Field | Value |
|---|---|
| Engine | MySQL 8.0 |
| Database name | `data4change` |
| Dump file | `storage/backup/data4change_2019-05-25.sql` |
| Dump created | 2019-05-25 16:27:22 UTC |
| Dump tool | Sequel Pro 4541 (from MySQL 5.7.23) |
| Tables | 15 |
| Total rows (approx) | ~17,000 |

## Data Contents

| Table | Rows | Contents |
|---|---|---|
| regions | 18 | All Myanmar states and union territories |
| cities | 356 | Districts/cities within regions |
| townships | 14,429 | Townships within cities (with official pcodes) |
| categories | 6 | Data thematic categories |
| sub_categories | 6 | Sub-themes |
| variables | 29 | Individual metrics |
| hospital_cities | 330 | Hospital data per city |
| drinking_water_cities | 330 | Drinking water data per city |
| religion_cities | 330 | Religious demographics per city |
| diaster_cities | 330 | Disaster risk data per city |
| live_stock_cities_tables | 330 | Livestock production per city |
| heritage_building_cities | 330 | Heritage building counts per city |
| heritage_building_lists | 508 | Individual named heritage buildings |
| users | 1 | Admin account only |
| migrations | 26 | Laravel migration history |

## Files Added During Restoration (June 2026)

| File | Purpose |
|---|---|
| `Dockerfile` | PHP 7.4 Docker image definition |
| `docker-compose.yml` | Service orchestration (app + db) |
| `docker/apache/000-default.conf` | Apache virtual host config |
| `docker/php/php.ini` | PHP runtime config |
| `docker/mysql/custom.cnf` | MySQL auth and charset config |
| `docker/entrypoint.sh` | Container startup script |
| `.env` | Docker-configured environment (not committed) |
| `.dockerignore` | Docker build context exclusions |
| `docs/` | This documentation directory |

## Files Modified During Restoration (June 2026)

| File | Reason |
|---|---|
| `composer.json` | Replaced deleted package; cleaned stale config |
| `composer.lock` | Regenerated to match updated composer.json |
| `routes/web.php` | Fixed HTTP 500 on root (missing view) |
| `.env.example` | Sanitised real credentials (DB username/password) |
| `.gitignore` | Added dusk env files, OS files, IDE dirs |
| `storage/backup/data4change_2019-05-25.sql` | Nulled user remember_token (security) |

## Files Untracked from Git (June 2026)

| File | Reason |
|---|---|
| `.env.dusk.local` | Contained a real APP_KEY (security cleanup) |
| `.env.dusk.testing` | Same as above |

## Ports

| Port | Service |
|---|---|
| 8100 | Backend (Laravel API + Admin panel) |
| 3307 | MySQL (host-accessible) |
| 3000 | Frontend (separate terminal, not in Docker) |

## Demo Account

| Email | Password | Role |
|---|---|---|
| admin@data4change.com | password | Admin |

## Archive Completeness

| Item | Status |
|---|---|
| Source code | Complete |
| Database dump | Complete (2019 production export) |
| Dependencies (vendor) | Installed at Docker build time |
| Documentation | Complete (June 2026) |
| CSV source files | Not available — not in repo, presumed lost |
| Screenshots | Not captured |
| Docker setup | Complete and verified working |
