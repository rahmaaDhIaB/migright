# MigRight

MigRight is a humanitarian case-management platform for migrants. People in need — or someone acting on their behalf — submit requests from a mobile app **without creating an account**, and a back office lets administrators triage those requests and route them to partner organizations for handling.

Three kinds of requests are supported:

- **Assistance demands** — a request for help, submitted by the concerned person or by someone else.
- **Lost-person reports** — a missing person (or group), with region, nationality, age group, gender, and last known location.
- **Testimonies** — anonymous or identified accounts, with optional file or **voice-message** attachments.

This repository contains the Laravel back end: the public REST API consumed by the mobile app (Expo / React Native, separate repository) and the Blade-based admin & partner back office.

## How a case flows

```
mobile app (anonymous, tracked by phone number)
        │  submit demand (+ files / voice message)
        ▼
   [pending] ──► admin triages ──► assigned to a partner organisation
                                       │  (email notification, decision opened as "awaiting")
                                       ▼
                          partner marks treated / not treated
                              (comment + supporting file)
                                       │
                                       ▼
                     admin closes the case ("clôture", final comment)
                                       │
                                       ▼
                push notification sent to the applicant's device(s)
```

Applicants can cancel a demand at any point, choosing from a configurable list of cancellation reasons.

## Main features

- **Public API (~24 endpoints)** for submitting, updating, tracking, and cancelling demands, plus news, services directory, and configuration — documented with OpenAPI/Swagger (`/api/documentation`).
- **Polymorphic demand core** — the three request types share one `Demand` model (status, cancellation, attachments, type tags) via a `morphTo` relation.
- **Admin back office** — server-side DataTables for 12 modules (demands, news, services, categories, regions, types, users, cancellation reasons, privacy policy…), an analytics dashboard (per-region, per-month, per-type charts), and news publishing with push notification broadcast.
- **Partner back office** — partners see only the cases assigned to them and record their decisions with comments and evidence files.
- **Role-based access** — `admin` and `partner` back-office roles enforced by middleware; mobile users are anonymous (device/phone-number based).
- **Push notifications** via Expo on news publication and demand status changes; **email notifications** to partners on assignment.
- **Bilingual** (French/English) UI and `Accept-Language`-driven API responses.

## Tech

- PHP 8.2 / Laravel 11, MySQL
- Laravel Sanctum, Yajra DataTables, L5-Swagger (OpenAPI), Expo Server SDK, Intervention Image
- Blade + Vite for the back office

## Getting started

```bash
composer install
cp .env.example .env         # set DB_* credentials
php artisan key:generate
php artisan migrate
php artisan storage:link
npm install && npm run dev
php artisan serve
```

The back office lives at `/` (login required); the API under `/api`; interactive API docs at `/api/documentation`.

## Tests

```bash
php artisan test
```

Feature tests cover the back-office authorization rules: admin-only routes, partner scoping of assigned cases, and decision ownership.

## Known limitations

Honest notes on debt that is still here:

- Demand workflow logic is still duplicated across the three demand controllers (assignment has been extracted to `App\Services\DemandAssignmentService`; treatment/closure has not yet).
- Uploaded files keep their client-supplied names (prefixed with a timestamp) rather than randomized ones.
- Rich-text fields (news, privacy policy) are rendered unescaped and rely on trusted admin input; no HTML sanitization is applied.
- The API exposes demands by sequential id and phone number without authentication — acceptable only behind the current mobile-app usage pattern, and the top candidate for the next hardening pass.
