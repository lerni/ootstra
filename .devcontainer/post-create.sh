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

# echo "Building ss-lang-server extension..."
# cd /var/www/html/ss-lang-server
# npm install
# npm run compile

# echo "Packaging ss-lang-server extension..."
# npx vsce package --allow-missing-repository --skip-license --allow-star-activation --baseContentUrl file:///dev/null --out silverstripe-actor-0.1.0.vsix

echo "=== Post-create script completed successfully ==="
echo "Run the 'Install SS Language Server Extension' task to install the extension"
