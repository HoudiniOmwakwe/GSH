# GameStakeHub Admin

A Laravel + Filament admin panel for [GameStakeHub](https://gamestakehub.com), an independent iGaming and crypto review site. Manages casinos, reviews, blog content, comparison tables, and site-wide settings behind role-based access control.

## Stack

- **Laravel 13** (PHP 8.3+)
- **Filament 5** — the admin panel itself
- **spatie/laravel-permission** — roles & permissions
- **spatie/laravel-medialibrary** — logo/image uploads
- **spatie/laravel-sluggable** — auto-generated URL slugs
- SQLite locally, MySQL/Postgres recommended for staging and production

## Modules

Casino Management · Review & Rating Management · Blog CMS · Comparison Tables · SEO (per-resource + site defaults) · Media Library · Contact Messages · User Roles & Permissions · Website Settings

## Local setup

Requires PHP 8.3+, Composer, and Node 18+.

```bash
composer run setup
```

This copies `.env.example` to `.env`, generates an app key, runs migrations, and builds frontend assets. Then seed demo data:

```bash
php artisan db:seed
```

Start the dev server:

```bash
php artisan serve
```

Visit `http://127.0.0.1:8000/admin`. The seeder creates a Super Admin account — check `database/seeders/DatabaseSeeder.php` for the seeded email, password is `password`. **Change it immediately** (`php artisan tinker`, then `$u = App\Models\User::first(); $u->password = bcrypt('...'); $u->save();`), especially before this is ever exposed publicly.

## Roles

Seeded via `RolesAndPermissionsSeeder`:

- **Super Admin** — full access to everything, including user/settings management
- **Admin** — full access except user management
- **Editor** — can create/update content (casinos, reviews, blog, comparison tables) but cannot delete anything, and has no access to settings or users
- **Support** — access limited to Contact Messages only

## Testing

```bash
php artisan test
```

Run the narrowest set that covers a change with `php artisan test --filter=testName` or a specific file path. Format PHP after any change:

```bash
vendor/bin/pint --dirty
```

## Deploying

1. **Database**: switch `DB_CONNECTION` from `sqlite` to `mysql` (or `pgsql`) in `.env` and set the connection details. SQLite's single-file database does not survive most cloud platforms' ephemeral filesystems.
2. **Environment**: set `APP_ENV=production` and `APP_DEBUG=false`. Generate a fresh `APP_KEY` for each environment — never reuse the local one.
3. **Storage**: run `php artisan storage:link` so uploaded media (casino logos, blog featured images) is publicly accessible.
4. **Build**: `composer install --no-dev --optimize-autoloader` and `npm run build`.
5. **Migrate**: `php artisan migrate --force` (never `migrate:fresh` against real data — it drops every table).
6. **Cache**: `php artisan config:cache`, `route:cache`, and `view:cache` for production performance.
7. **Queue**: `QUEUE_CONNECTION` defaults to `database`; run a queue worker (`php artisan queue:work`) if you rely on queued jobs/notifications.

Laravel Cloud (the framework's own hosting platform) and Railway are both straightforward options for a Laravel app like this one — neither requires a Dockerfile to get started. Cloudflare does not run PHP natively, so it isn't a fit for hosting this application (Cloudflare Pages/Workers serve static sites and JS/edge functions, not a traditional PHP backend); the live GameStakeHub site can still stay on Cloudflare independently of where this admin panel is hosted.

## Project structure notes

- Filament resources live under `app/Filament/Resources/`, one folder per model, each split into `Schemas/` (forms), `Tables/`, and `Pages/`.
- Every resource's authorization is backed by a `Spatie\Permission` permission (`view|create|update|delete {module}`) enforced through a matching `App\Policies\*Policy` class — Laravel's policy auto-discovery wires model policies automatically; `Media` is the one exception, registered explicitly in `AppServiceProvider` since it lives outside `App\Models`.
- Casino, Review, Blog Post, and Comparison Table slugs auto-generate from their name/title field on blur in the admin form, and again server-side via `Spatie\Sluggable` if left blank.
- `database/seeders/DemoContentSeeder.php` generates realistic fake data across every module — useful for local development, not meant to run against production.
