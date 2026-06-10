# API Reference

Base URL: `http://localhost:8100/api`

All endpoints are **public** — no authentication required.
All endpoints accept a `lang` parameter: `en` (default) or `mm` (Myanmar).
CORS is open to all origins.

---

## GET /api/category/getAll

Returns all data categories with their subcategories and variables.

**Query parameters:**

| Parameter | Type | Default | Description |
|---|---|---|---|
| `lang` | string | `en` | Language for name fields (`en` or `mm`) |

**Example:**
```bash
curl "http://localhost:8100/api/category/getAll?lang=en"
```

**Response:**
```json
{
  "data": [
    {
      "id": "199aeeca-c468-41ad-8ef3-6089f9cb3645",
      "name": "Agriculture",
      "sub_categories": [
        {
          "id": "...",
          "name": "Live Stock",
          "variables": [
            { "id": "...", "name": "Beef Production (ton)", "eagerLoader": "beef" },
            { "id": "...", "name": "Pork Production (ton)", "eagerLoader": "pork" }
          ]
        }
      ]
    }
  ]
}
```

---

## GET /api/subcategory/getAll

Returns all subcategories with their variables (flat list, not nested under categories).

**Query parameters:** `lang`

---

## GET /api/region/getAll

Returns all regions with their cities.

**Query parameters:**

| Parameter | Type | Default | Description |
|---|---|---|---|
| `lang` | string | `en` | Language for name fields |
| `isDivisonOnly` | string | `false` | If `"true"`, returns only region names (no cities) |

**Example:**
```bash
curl "http://localhost:8100/api/region/getAll?lang=en"
```

**Response:**
```json
{
  "data": [
    {
      "id": "...",
      "name": "Ayeyarwady",
      "cities": [
        { "id": "...", "name": "Hinthada", "pcode": "MMR013" }
      ]
    }
  ]
}
```

---

## POST /api/data/getAllForOverall

Returns statistical data for selected variables, filtered by cities and year. Used by the main overview chart.

**Request body (JSON):**

| Field | Type | Description |
|---|---|---|
| `lang` | string | `en` or `mm` |
| `variables` | array of UUIDs | Variable IDs to fetch (from `/api/category/getAll`) |
| `cities` | array of UUIDs | City IDs to filter (from `/api/region/getAll`) |
| `year` | string | Year string e.g. `"2016"` |

**Example:**
```bash
curl -X POST http://localhost:8100/api/data/getAllForOverall \
  -H "Content-Type: application/json" \
  -d '{
    "lang": "en",
    "variables": ["<variable-uuid>"],
    "cities": ["<city-uuid>"],
    "year": "2016"
  }'
```

**Response structure:**
```json
{
  "data": [
    {
      "category": { "id": "...", "name": "Health" },
      "subCategory": [
        {
          "subCat": { "id": "...", "name": "Number of Hospitals" },
          "variable_city": {
            "noh": [
              {
                "id": "...",
                "name": "Number of Hospitals",
                "city_name": "Hinthada",
                "value": "12"
              }
            ]
          }
        }
      ]
    }
  ]
}
```

---

## POST /api/data/getAllForCompare

Returns comparative data across cities and regions. Currently returns **religion/demographic data only** (disaster data section is commented out in the source — see [limitations.md](limitations.md)).

**Request body (JSON):**

| Field | Type | Description |
|---|---|---|
| `lang` | string | `en` or `mm` |
| `cities` | array of UUIDs | City IDs (currently ignored — returns all cities) |
| `year` | string | Year string (currently ignored — returns all years) |

**Example:**
```bash
curl -X POST http://localhost:8100/api/data/getAllForCompare \
  -H "Content-Type: application/json" \
  -d '{"lang": "en", "cities": [], "year": ""}'
```

**Response structure:**
```json
{
  "<region-uuid>": [
    {
      "region": { "id": "...", "name": "Shan (North)" },
      "city_name": "Pangsang",
      "Animist": 0,
      "Buddhist": 0,
      "Christian": 0,
      "Hindu": 0,
      "Muslim": 0
    }
  ]
}
```

---

## Notes

- The `eagerLoader` field on variables maps to the relationship method names on the `Variable` model (e.g., `"beef"` → `Variable::beefs()`)
- All IDs are UUIDs — fetch them from `/api/category/getAll` and `/api/region/getAll` before using the data endpoints
- The `/api/v1/` route group exists but contains no implemented endpoints
- City and year filtering in `getAllForCompare` is incomplete (WHERE clause is commented out in source)
