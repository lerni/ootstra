#!/bin/bash
set -e

echo "=== Post-create script started ==="

# Install npm packages for theme
echo "Installing theme npm packages..."
cd /var/www/html/themes/default
npm install

echo "Setting up phpactor workspace trust..."
mkdir -p "$HOME/.local/share/phpactor"
printf '{\n    "/var/www/html": true\n}\n' > "$HOME/.local/share/phpactor/trust.json"

echo "=== Post-create script completed successfully ==="
