# Project Overview

## Purpose

**Data for Change** is a Myanmar open-data visualisation platform built during a hackathon in May 2019. It aggregates official government statistical data about Myanmar's states and regions and makes it accessible through a clean REST API and a browser-based SPA.

The platform was created to make government datasets easier for journalists, researchers, and the public to explore and compare — without needing to download raw spreadsheets or navigate complex government portals.

## Business Domain

Myanmar administrative data across six thematic categories:

| Category (English) | Category (Myanmar) | Data Included |
|---|---|---|
| Health | ကျန်းမာရေး | Hospital counts by type (government, private, traditional, etc.) |
| Demographic | လူထုအချက်အလက် | Religious population by city (Buddhist, Christian, Hindu, Muslim, Animist) |
| Agriculture | စိုက်ပျိုးရေးနှင့် မွေးမြူရေး | Livestock production volume by type (beef, pork, chicken, milk, fish) |
| Natural Disasters and Hazards | ဘဘာဝဘေးအန္တရယ်များ | Risk percentages by township (storm surge, flooding, earthquake, landslide, drought) |
| Standard of Living | လူနေမှုအဆင့်အတန်း | Household drinking water sources by type |
| Religious and Historical Sites | ဘာသာရေးနှင့် သမိုင်းဝင်အဆောင်အအုံများ | Heritage building counts and names |

## Geographic Coverage

All data is linked to Myanmar's administrative hierarchy:

```
Region / State (18)
  └── City / District (356)
        └── Township (14,429)
```

## Bilingual Content

All location names, category names, subcategory names, and variable names are stored in both **English** (`name_en`) and **Myanmar / Burmese** (`name_mm`). The API accepts a `lang` parameter (`en` or `mm`) to switch the language of returned content.

Myanmar script handling uses the `rabbit-converter/rabbit-php` library for Zawgyi ↔ Unicode conversion.

## Team

Built by **Team Novit** at a hackathon in May 2019.

## Current Status

Archived. Fully functional for local demonstration. No live deployment.
