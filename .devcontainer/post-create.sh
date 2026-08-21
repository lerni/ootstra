#!/bin/bash
set -e

echo "=== Post-create script started ==="

# Install npm packages for theme
echo "Installing theme npm packages..."
cd /var/www/html/themes/default
npm ci --prefer-offline --no-audit --no-fund

echo "Setting up phpactor workspace trust..."
mkdir -p "$HOME/.local/share/phpactor"
printf '{\n    "/var/www/html": true\n}\n' > "$HOME/.local/share/phpactor/trust.json"

# opencode CLI has no apt/Debian package - install via npm instead of webimage_extra_packages
echo "Installing opencode CLI..."
npm install -g opencode-ai

echo "=== Post-create script completed successfully ==="
