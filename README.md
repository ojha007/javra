Step to run the application:
composer install
cp .env.example .env
php artisan key:generate
database setup 
php artisan migrate
php artisan db:seed
php artisan queue:work 
Credentials can be found inside the DatabaseSeeder.php.
