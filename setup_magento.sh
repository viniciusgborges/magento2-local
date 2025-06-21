#!/bin/bash
set -e

# Directory where Magento will be installed
MAGENTO_DIR="src"

if [ ! -d "$MAGENTO_DIR" ]; then
  mkdir "$MAGENTO_DIR"
fi

# Check for composer
# Check for Composer
if ! command -v composer >/dev/null 2>&1; then
  echo "Composer is required but not installed. Install Composer and rerun this script." >&2
  exit 1
fi

# Check for Docker
if ! command -v docker >/dev/null 2>&1; then
  echo "Docker is required but not installed. Install Docker and rerun this script." >&2
  exit 1
fi

# Check for Magento authentication
if [ ! -f "$HOME/.composer/auth.json" ]; then
  cat >&2 <<EOE
Magento authentication keys not found.
Create \$HOME/.composer/auth.json with your repo.magento.com credentials as described in the Magento documentation.
EOE
  exit 1
fi

# Download Magento if not present
if [ ! -f "$MAGENTO_DIR/bin/magento" ]; then
  composer create-project --repository-url=https://repo.magento.com/ magento/project-community-edition "$MAGENTO_DIR"
fi

cd "$MAGENTO_DIR"

# Deploy sample data
php bin/magento sampledata:deploy

# Install Magento
php bin/magento setup:install \
  --base-url=http://localhost \
  --db-host=db \
  --db-name=magento \
  --db-user=magento \
  --db-password=magento \
  --backend-frontname=admin \
  --admin-firstname=Admin \
  --admin-lastname=User \
  --admin-email=admin@example.com \
  --admin-user=admin \
  --admin-password=Admin123 \
  --language=en_US \
  --currency=USD \
  --timezone=UTC \
  --use-rewrites=1
