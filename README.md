
---

# RSS Parser Project

This project is an RSS feed parser that fetches, parses, and stores posts from an RSS feed in a Laravel application. The RSS feed is parsed periodically based on a cron job, and the data is saved to a database.

## Requirements

- Docker
- Docker Compose

## Installation and Setup

### 1. Clone the repository

Clone the repository to your local machine:

```bash
git clone https://github.com/ihor-ribak/laravel-rss-parser.git
cd laravel-rss-parser
```

### 2. Build the Docker containers

To set up the project environment, build and start the Docker containers:

```bash
make up
```

This will:

- Install dependencies using `composer install`
- Set appropriate permissions
- Set up cron jobs for the application

### 3. Access the application

Once the containers are running, the application will be accessible via your browser at `http://localhost:8080`.

### 4. Environment Configuration

Ensure that the `.env` file contains the following configurations:

- Set up your database connection from `docker-compose.yml` file.
- Set the RSS feed URL in the `.env` file:

```env
LIFE_HACKER_RSS_URL=https://lifehacker.com/rss
```

### 5. Generate the Application Key

Before running migrations, you need to generate the application key. Run the following command:

```bash
make key
```

This will generate a unique application key for your Laravel app.

### 6. Run database migrations

To run the database migrations:

```bash
make migrate
```

### 7. Seed the database with test data

To seed the database with test data:

```bash
make seed
```

### 8. Cron Job Configuration

The application uses Laravel's built-in scheduler to fetch and parse RSS feeds every 5 minutes. This is configured through a cron job in the Docker container.

### 9. Swagger Documentation

The Swagger documentation for the API is automatically generated. You can access it at:

```text
http://localhost:8080/api/documentation
```

## Commands

### Parse RSS Feed

The `rss:parse` command fetches the latest RSS feed and saves the data to the database.

To manually run the RSS parsing:

```bash
docker compose exec rss_app php artisan rss:parse
```
