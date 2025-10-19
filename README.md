# Laratask

## Reminders

Init a Laravel project
```bash
composer create-project laravel/laravel myapp
```

Install Breeze with Blade
```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
```

Install frontend dependencies
```bash
npm install
```

Make a model + migration
```bash
php artisan make:model Lorem -m
```

Migrate DB
```bash
php artisan make:migration name_of_migration
php artisan migrate
```

Roll back all migrations and run them again from scratch
```bash
php artisan migrate:refresh
```

Make a Factory for a Model
```bash
php artisan make:factory LoremFactory
```

Create a seeder
```bash
php artisan make:seeder DatabaseSeeder
```

Seed database
```bash
php artisan db:seed
```

Migrate and seed
```bash
php artisan migrate:fresh --seed
```

Start server
```bash
php artisan serve
```

Open a PHP REPL (interactive PHP shell)
```bash
php artisan tinker
```