# Historical Notes

## Origin

**Data for Change** was built during a hackathon in **May 2019** by **Team Novit**.

The project was originally hosted on GitLab under the group `hackathon7814206`:
- Backend (original): `git@gitlab.com:hackathon7814206/data-for-change/backend.git`
- Frontend (original): `git@gitlab.com:hackathon7814206/data-for-change/frontend.git`

The backend was migrated to GitHub in June 2026:
- Backend (current): `git@github.com:myowinthein/data-4-change-backend.git`

## Original Stack (as documented at the time)

The original README specified these requirements:

| Tool | Version (original spec) |
|---|---|
| Apache | 2.4.41 |
| PHP | 7.3.11 |
| MySQL | 8.0.19 |
| Composer | 1.9.0 |

The original setup assumed a local LAMP stack with virtual hosts:
- `data4change.local` (web panel)
- `data4change.local/api` (API)

Neither virtual host is needed with the current Docker setup.

## Original Installation Steps (now outdated — do not follow)

The original README instructed:

```shell
composer install
php artisan migrate:refresh --seed
php artisan jwt:secret      # ← WRONG: no JWT package was installed
php artisan storage:link
```

**Why these are wrong today:**
- `migrate:refresh --seed` would wipe the database (seeder only creates the admin user, all statistical data would be lost)
- `php artisan jwt:secret` will fail — there is no JWT package in `composer.json`; this was either a copy-paste error or left over from a template

## Original Admin Credentials

The original README listed `admin@data4change.com` / `password` as the admin login. These credentials are preserved in the SQL dump and remain valid.

## Data Sources

The statistical data loaded into the database came from official Myanmar government datasets:

- `GAD1617_M7A_Hospitals_20190514` — General Administration Department, hospital data 2016-17
- `CS14_DrinkingWater_20190510` — Census/survey drinking water data
- `DisasterRiskClimate_20190514` — Natural disaster risk data
- `GAD1617_M8D_HeritageBuildings_20190513` — Heritage buildings data

The source CSV files are not included in the repository. All data was imported during the hackathon and preserved in the SQL dump at `storage/backup/data4change_2019-05-25.sql`, generated on 25 May 2019 using Sequel Pro (MySQL 5.7 at the time).

## Database Name Discrepancy

The original `.env.example` specified `DB_DATABASE=data_4_change` (with underscores). The actual running application used `data4change` (no underscores), as confirmed by the SQL dump header. The Docker setup uses `data4change` to match the dump.

## Git History

The last commits were made in late May 2019:

```
bb07342  Update README.md
54261c4  Update README.md
e0ff2ba  Upload New File
3a28ecb  Add new directory
52447e2  Add README.md
```

The repository has been dormant since then. The `master` branch is the only branch.

## Hackathon Context

This appears to have been a civic-tech or data journalism hackathon focused on Myanmar open data. The project demonstrates a full-stack approach to making government statistics accessible — the admin panel for importing raw government CSV files, and the frontend SPA for public visualisation.

The Burmese language support and Myanmar-specific geographic hierarchy (regions → cities → townships with official pcodes) suggest the team had local knowledge of Myanmar administrative data structures.
