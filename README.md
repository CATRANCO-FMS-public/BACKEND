# How to run the laravel backend

## Instructions

To get started with the laravel backend, follow these steps: (use Command Prompt or CMD)

```sh
# Clone the repository
git clone https://github.com/CATRANCO-Fleet-Management-System/laravel-backend-deploy.git

# Go the the Directory
cd laravel-backend-deploy

# Open the IDE
code .

# Install composer
composer install

# decrypt the .env
php artisan env:decrypt --force --key=base64:0rPEg5jGaTu42J4qqE3vTy1MpMsFDy2CxvtDI8eaHrQ=

# Open XAMPP Control Panel
start the apache and mysql

# Migrate the database
php artisan migrate

# Seed the database
php artisan db:seed

# Run the backend
e.g. php artisan serve --host=192.168.1.102 --port=8000 (if naa nay front end)
php artisan serve (back-end testing api client)
