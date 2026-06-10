# External Integrations

## Summary

This project has **no live external service dependencies** for basic local operation. All third-party integrations are either inactive, stubbed, or handled locally.

---

## Mail

| Setting | Value |
|---|---|
| Driver | `log` |
| Behaviour | All emails written to `storage/logs/laravel.log` — nothing is sent |

Password reset emails will not be delivered. This is acceptable for a local demo — log in directly with `admin@data4change.com` / `password`.

---

## Pusher (WebSockets)

| Setting | Value |
|---|---|
| Status | Not used |
| Config | Empty keys in `.env` |

The Pusher config stubs are in `.env` but no application code uses Pusher. Broadcasting driver is set to `log`.

---

## Redis

| Setting | Value |
|---|---|
| Status | Not used |
| Config | `127.0.0.1:6379` in `.env` |

Cache and session drivers are set to `file`. Redis is referenced in `.env` but not running in Docker and not called by any application code.

---

## AWS S3

| Setting | Value |
|---|---|
| Status | Not used |
| Config | Empty keys in `.env` |

File storage uses the local `file` driver. No S3 integration is implemented.

---

## Mailtrap

The original `.env.example` referenced `smtp.mailtrap.io` as a mail host. This was for the original hackathon development environment. Current setup uses `MAIL_DRIVER=log` — no Mailtrap account is needed.

---

## Frontend CDN Dependencies

The Nuxt frontend loads several assets from public CDNs at page load time. An internet connection is needed to render correctly:

| Resource | Source |
|---|---|
| html2canvas | cdnjs.cloudflare.com |
| lodash | cdnjs.cloudflare.com |
| Google Fonts (Roboto) | fonts.googleapis.com |
| FontAwesome | use.fontawesome.com |

Without internet access, fonts and icons will fall back to browser defaults. Core functionality is unaffected.

---

## Burmese Font Conversion

The `rabbit-converter/rabbit-php` library handles Zawgyi ↔ Unicode conversion for Myanmar script. This runs entirely server-side with no external calls.

---

## No Payment, OAuth, Analytics, or Firebase

None of these are integrated. The project has no payment processing, no OAuth login, no analytics tracking, and no Firebase usage.
