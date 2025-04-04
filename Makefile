# Start all the services (build and run containers)
up:
	docker compose up -d --build

# Stop all the services and remove containers
down:
	docker compose down

# Restart all the services (stop and start again with rebuild)
restart:
	docker compose down && docker compose up -d --build

# Install Composer dependencies
install:
	docker compose exec rss_app composer install --optimize-autoloader

# Generate application key
key:
	docker compose exec rss_app php artisan key:generate

# Run database migrations
migrate:
	docker compose exec rss_app php artisan migrate

# Seed the database with test data
seed:
	docker compose exec rss_app php artisan db:seed

# Enter the container's bash shell
bash:
	docker compose exec rss_app bash
