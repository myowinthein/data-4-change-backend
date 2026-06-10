# Data for Change — Backend

Myanmar open-data platform built at a hackathon in May 2019 by **Team Novit**.
Exposes national government statistics (health, demographics, agriculture, disasters, living standards, heritage) via a REST API consumed by a Nuxt SPA frontend.

---

## Quick Start

```bash
# 1. Build and start backend (PHP 7.4 + MySQL 8.0 via Docker)
docker compose up -d

# 2. Start frontend in a separate terminal (from the frontend repo)
cd ../frontend
yarn dev
```

| Service | URL |
|---|---|
| Backend API + Admin | http://localhost:8100 |
| Frontend SPA | http://localhost:3000 |
| MySQL (host access) | localhost:3307 |

**Admin login:** `admin@data4change.com` / `password`

> First `docker compose up` takes ~30 seconds for MySQL to initialise and import the SQL dump.

---

## Documentation

| Doc | Contents |
|---|---|
| [docs/overview.md](docs/overview.md) | Project purpose, business domain, data categories |
| [docs/architecture.md](docs/architecture.md) | System design, data model, request flow |
| [docs/setup.md](docs/setup.md) | Full verified setup instructions |
| [docs/demo.md](docs/demo.md) | Demo accounts, workflows, screenshots guide |
| [docs/api.md](docs/api.md) | All REST API endpoints with request/response examples |
| [docs/integrations.md](docs/integrations.md) | External dependencies and service stubs |
| [docs/recovery-notes.md](docs/recovery-notes.md) | Fixes applied during restoration (read before touching anything) |
| [docs/historical-notes.md](docs/historical-notes.md) | Original project context, team, hackathon background |
| [docs/limitations.md](docs/limitations.md) | Known incomplete features and permanent constraints |
| [docs/future-me.md](docs/future-me.md) | Warnings and advice for restoring this years from now |
| [docs/archive-metadata.md](docs/archive-metadata.md) | Versions, dates, file inventory, archive status |

---

## Repository

- **Backend:** `git@github.com:myowinthein/data-4-change-backend.git`
- **Frontend:** `git@gitlab.com:hackathon7814206/data-for-change/frontend.git` *(separate repo, still on GitLab)*
