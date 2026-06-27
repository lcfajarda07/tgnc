# TGNC Church Management System

Premium public website and branch-aware church management system for **THE GOOD NEWS OF CHRIST GLOBAL MINISTRIES**.

## Local Development

```bash
composer install
npm install
php artisan migrate --seed
npm run dev
php artisan serve --host=127.0.0.1 --port=8000 --no-reload
```

Open:

- Public site: http://127.0.0.1:8000
- Admin login: http://127.0.0.1:8000/login

Seeded admin:

- Email: `admin@tgnc.local`
- Password: `password`

## Stack

- Laravel 12
- React + Inertia
- Tailwind CSS
- Spatie Permission
- Spatie Media Library
- Laravel Excel
- Laravel DomPDF

## Free Deployment

Use your personal GitHub and Vercel accounts, plus a free Neon Postgres database. See [DEPLOYMENT_FREE.md](DEPLOYMENT_FREE.md).
