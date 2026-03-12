#!/bin/bash

set -e

SAIL="./vendor/bin/sail"

if [ ! -f ./vendor/bin/sail ]; then
  echo "Laravel Sail is not installed. Run: 'composer install'"
  exit 1
fi

if [ ! -f .env ]; then
  echo "Creating .env file"
  cp -a .env.example .env
fi

echo "Starting Laravel Sail"
$SAIL up -d

echo "Waiting for database to be ready"
until $SAIL artisan db:show >/dev/null 2>&1; do
  sleep 2
done
echo "Database is ready"

echo "Generating APP KEY"
$SAIL artisan key:generate

echo "Running migrations and seeders"
$SAIL artisan migrate --seed

echo "Checking permissions."
$SAIL artisan permissions:check

echo "Installing npm"
$SAIL npm install

echo "Building frontend"
$SAIL npm run build

echo "Setup completed! Visit http://localhost/admin/register"
echo 'To make superadmin run: ./vendor/bin/sail artisan make:superadmin email@example.com'
