# Magento 2 Docker Setup

This repository contains a minimal setup script and Docker configuration for running Magento 2 Open Source with sample data. These instructions assume you have Composer, Docker and Docker Compose installed and internet access to download Magento packages and container images.

## Requirements

- Composer
- Docker & Docker Compose
- Magento repository access keys (for Composer authentication)

## Setup Steps

1. Add your Magento authentication keys to `~/.composer/auth.json` as shown in [Magento docs](https://devdocs.magento.com/guides/v2.4/install-gde/prereq/connect-auth.html).
2. Run `./setup_magento.sh` to download Magento 2, deploy sample data and perform the initial installation. This step requires internet access.
3. Start the containers with `docker compose up -d`.
4. Access the storefront at `http://localhost` and the admin at `http://localhost/admin`.

## Files

- `setup_magento.sh` – Script to install Magento 2 with sample data into the `src/` directory.
- `docker-compose.yml` – Defines the PHP web container and a MariaDB database.
- `Dockerfile` – Builds a PHP 8.2 environment with required extensions and Composer.

Make sure to run these steps on a machine with network connectivity, as the containers and Magento packages need to be downloaded.
