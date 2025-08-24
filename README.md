# TrackTik Integration API (Docker Setup)

This project provides a Dockerized Laravel application with a MySQL database and a database-driven queue worker, managed using Docker Compose. The setup includes a web server (Apache), MySQL, a Laravel queue worker, and an optional phpMyAdmin service for database management.

## Prerequisites
- [Docker](https://docs.docker.com/get-docker/) and [Docker Compose](https://docs.docker.com/compose/install/) installed on your machine.
- Git to clone the repository.

## Project Structure
- `Dockerfile`: Defines the PHP/Apache environment with Supervisor for the Laravel app and queue worker.
- `docker-compose.yml`: Configures the multi-container setup (app, MySQL, phpMyAdmin).
- `apache-config.conf`: Apache configuration for Laravel.
- `supervisord.conf`: Supervisor configuration to manage Apache and the queue worker.

## Setup Instructions

1. **Clone the Repository**
   ```bash
   git clone https://github.com/ArditaU/tracktik-integration-api.git
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

5. **Run Queue**
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
