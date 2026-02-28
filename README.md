# Windsor AI Club Website

This repo is now a Laravel app at the repository root.

## Run locally

```bash
php artisan serve
```

Open `http://127.0.0.1:8000/`.

## Default admin (local)

Set these in your `.env`, then run `php artisan migrate --seed` (or `composer setup`):

- `DEFAULT_ADMIN_EMAIL`
- `DEFAULT_ADMIN_PASSWORD`

Then log in at `/login` and open `/admin`.

## Pages

- `/` (home)
- `/events`
- `/leaders`
- `/join`

Legacy `.html` URLs (like `/events.html`) 301-redirect to the new routes.

## Legacy archive

The pre-Laravel static site (including the old PHP admin folder) is archived in `archive/legacy-static-site-2026-02-27/`.
