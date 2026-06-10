# Demo Guide

## Demo Accounts

| Role | Email | Password |
|---|---|---|
| Admin | admin@data4change.com | password |

Only one account exists. It has full admin access to the import panel.

---

## Starting the Demo

```bash
# Terminal 1 — backend
cd backend
docker compose up -d

# Terminal 2 — frontend
cd frontend
yarn dev
```

Wait ~30 seconds for MySQL to initialise, then open:
- **Frontend SPA:** http://localhost:3000
- **Admin panel:** http://localhost:8100/login

---

## Demo Workflow 1 — Data Visualisation (Frontend)

**What it shows:** The core product — browsing Myanmar statistical data by region.

1. Open http://localhost:3000
2. The main page loads a map/chart view of Myanmar data
3. Use the category selector to switch between data types (Health, Demographic, Agriculture, etc.)
4. Select a region or city to drill down
5. Switch between English and Myanmar language using the language toggle

**What to highlight:**
- Bilingual content (English ↔ Myanmar script)
- Six data categories covering real government statistics
- 18 regions, 356 cities, 14,429 townships all linked

---

## Demo Workflow 2 — Comparison View (Frontend)

**What it shows:** Side-by-side comparison of two or more cities.

1. Open http://localhost:3000/compare
2. Select two or more cities from the dropdowns
3. The charts update to show comparative data
4. Switch data categories to compare different metrics

---

## Demo Workflow 3 — Admin Import Panel (Backend)

**What it shows:** How data administrators loaded the statistical data.

1. Open http://localhost:8100/login
2. Log in with `admin@data4change.com` / `password`
3. You land on the **Import** panel at `/import`
4. The panel shows buttons to import each data category
5. Each button triggers a CSV import from a hardcoded file path

> Note: The actual CSV source files are not in the repository. The import buttons would fail with a "file not found" error if clicked. All data was already imported and saved in the SQL dump. This panel is shown to demonstrate the data pipeline workflow only.

---

## Key Pages

### Frontend (http://localhost:3000)

| Path | Page |
|---|---|
| `/` | Main overview — chart view with category/region selector |
| `/compare` | Side-by-side city comparison view |

### Backend (http://localhost:8100)

| Path | Description |
|---|---|
| `/login` | Admin login |
| `/import` | CSV import panel (requires login) |
| `/api/category/getAll` | API: all categories (public) |
| `/api/region/getAll` | API: all regions + cities (public) |

---

## Data Highlights for Demo

These are good talking points:

- **14,429 townships** — the full Myanmar administrative hierarchy
- **6 data categories** — spanning health, demographics, agriculture, disasters, living standards, heritage
- **330 city records** per data type — every city has corresponding data rows
- **508 heritage building records** — individual named buildings with location and zone
- **Bilingual** — every piece of content stored in both English and Myanmar script
- **Real government data** — sourced from official Myanmar government datasets (GAD, census data, 2016–2017 reports)
