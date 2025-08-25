# TrackTik Integration API

This project provides a Laravel-based API that can be run in two ways:
- **With Docker** (isolated environment)
- **Without Docker** (using your local PHP, Composer, and MySQL setup)

The app integrates with TrackTik and includes a database-driven queue worker for background jobs.

## Prerequisites
**If running with Docker:**
- [Docker](https://docs.docker.com/get-docker/) and [Docker Compose](https://docs.docker.com/compose/install/) installed on your machine.

**If running without Docker:**
- PHP >= 8.1
- [Composer](https://getcomposer.org/)
- MySQL


## Project Structure
- `Dockerfile`: Defines the PHP/Apache environment with Supervisor for the Laravel app and queue worker.
- `docker-compose.yml`: Configures the multi-container setup (app, MySQL, phpMyAdmin).
- `apache-config.conf`: Apache configuration for Laravel.
- `supervisord.conf`: Supervisor configuration to manage Apache and the queue worker.

## Setup Instructions

**Option 1: Run with Docker**
1. **Clone the Repository**
   ```bash
   git clone https://github.com/ArditaU/tracktik-integration-api.git
   cd tracktik-integration-api
   ```

2. **Copy the Environment File**
   ```bash
   cp .env.example .env
   ```

3. **Start Docker Containers**
   ```bash
   docker-compose up -d
   ```
   This starts:
   - Laravel app (with Apache and queue worker) on `http://localhost:8000`
   - MySQL database (accessible internally via `mysql` hostname)
   - phpMyAdmin on `http://localhost:8080`

4. **Run Database Migrations**
   Create the necessary tables, including the `jobs` table for the queue:
   ```bash
   docker-compose run --rm app php artisan migrate
   ```

5. **Run Queue Worker**
   To start queue run this command:
   ```bash
   docker-compose run --rm app php artisan queue:work
   ```

6. **Stop and Clean Up**
   Stop containers:
   ```bash
   docker-compose stop
   ```
   Remove containers and volumes (to reset MySQL data):
   ```bash
   docker-compose down -v
   ```

**Option 2: Run without Docker (Local Setup)**
1. **Clone the Repository**
   ```bash
   git clone https://github.com/ArditaU/tracktik-integration-api.git
   cd tracktik-integration-api
   ```
2. **Install Dependencies**
   ```bash
   composer install
   ```
3. **Copy the Environment File**
   ```bash
   cp .env.example .env
   ```
4. **Run Database Migrations**
   ```bash
    php artisan migrate
   ```
5. **Start the Laravel Development Server**
   ```bash
    php artisan serve
   ```
**App will be available at http://localhost:8000**

6. **Run Queue Worker**
   ```bash
    php artisan queue:work
   ```