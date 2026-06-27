# TGNC Free Deployment Plan

This project is prepared for your personal GitHub, Vercel, and free online database accounts. Do not commit real credentials.

## Free Accounts

- GitHub: push this repository to your personal GitHub account.
- Vercel: import the GitHub repository into your personal Vercel account.
- Database: create a free Neon Postgres project and copy its pooled connection string.
- Optional media storage: create a free Supabase project if you want uploaded gallery/member files stored online.

## Vercel Environment Variables

Add these in Vercel Project Settings > Environment Variables:

```env
APP_NAME=TGNC
APP_ENV=production
APP_KEY=base64:GENERATE_THIS_LOCALLY
APP_DEBUG=false
APP_URL=https://YOUR-PROJECT.vercel.app
LOG_CHANNEL=stderr
VIEW_COMPILED_PATH=/tmp/framework/views
APP_CONFIG_CACHE=/tmp/framework/cache/config.php
APP_EVENTS_CACHE=/tmp/framework/cache/events.php
APP_PACKAGES_CACHE=/tmp/framework/cache/packages.php
APP_ROUTES_CACHE=/tmp/framework/cache/routes.php
APP_SERVICES_CACHE=/tmp/framework/cache/services.php

DB_CONNECTION=pgsql
DB_URL=postgresql://USER:PASSWORD@HOST/DB?sslmode=require

SESSION_DRIVER=database
SESSION_SECURE_COOKIE=true
CACHE_STORE=database
QUEUE_CONNECTION=database
FILESYSTEM_DISK=local
```

Generate `APP_KEY` locally:

```bash
php artisan key:generate --show
```

## Database Setup

After creating the Neon database, run migrations from your local machine using the production database URL:

```bash
php artisan migrate --seed --force
```

For safety, run this only after your `.env` points to the intended Neon database.

## Notes

- Vercel does not officially support Laravel/PHP as a first-class runtime, so this uses the community `vercel-php` runtime in `vercel.json`.
- Keep uploads off Vercel's filesystem for production. Use Supabase Storage, S3, or another external storage provider before enabling real media uploads.
- The free database target is Postgres, not MySQL, because Neon has a practical free tier.
