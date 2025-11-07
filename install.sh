#!/bin/bash

echo "Iniciando o projeto..."

composer update

if [ ! -f ".env" ]; then
    cp .env.example .env
fi

php artisan key:generate

# Abre o Sail em outra janela
osascript -e 'tell application "Terminal" to do script "cd '"$(pwd)"' && ./vendor/bin/sail up"'

# Dá um tempo pro Sail subir
sleep 10

./vendor/bin/sail artisan migrate --seed
./vendor/bin/sail artisan optimize

echo "✅ Ambiente pronto!"
