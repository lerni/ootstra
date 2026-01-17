#!/usr/bin/env bash
set -ex

# Wait for Docker to be ready
wait_for_docker() {
  echo "⏳ Waiting for Docker to be ready..."
  while true; do
    docker ps > /dev/null 2>&1 && break
    sleep 1
  done
  echo "✅ Docker is ready."
}

wait_for_docker

# Download DDEV images beforehand (optional but recommended)
echo "📦 Downloading DDEV images..."
ddev debug download-images || true

# Avoid errors on rebuilds
echo "🔄 Powering off any existing DDEV projects..."
ddev poweroff || true

# Start DDEV project
echo "🚀 Starting DDEV project..."
ddev start -y

# Install PHP dependencies
echo "📦 Installing Composer dependencies..."
ddev composer install

# Install npm packages
echo "📦 Installing npm packages..."
cd themes/default
# Clean install to avoid optional dependency issues in Codespaces
rm -rf node_modules package-lock.json
npm install
cd ../..

# Create phpactor directory
mkdir -p $HOME/.local/share/phpactor

# Run dev/build
echo "🔨 Building Silverstripe database..."
ddev sake db:build --flush

echo "✅ Setup complete!"
echo ""
echo "🌐 Your site is available at the forwarded ports (check PORTS tab)"
echo "📝 Admin login: admin / password"
echo ""
echo "To start Vite dev server, run: ddev npm --prefix themes/default run dev"
