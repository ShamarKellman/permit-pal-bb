# Barbados Highway Code

Driving theory practice test app for the Barbados Highway Code exam.

## Stack

- **Laravel 13** + PHP 8.4
- **Livewire 4** + **Flux UI 2** for reactive UI
- **Filament 5** for admin panel
- **Tailwind CSS 4**
- **Pest 4** for testing

## Features

- Practice tests at `/test` with scored results at `/test/result`
- Study mode for authenticated users (`/study`)
- Admin panel via Filament for managing questions and content

## Setup

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run build
php artisan serve
```

## Development

```bash
composer run dev   # starts Laravel + Vite together
```

## Testing

```bash
php artisan test --compact
```

## Deployment

Uses [Deployer](https://deployer.org/) — see `deploy.php` for configuration.

```bash
vendor/bin/dep deploy production
```
