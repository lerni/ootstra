# Devcontainer Setup

This project supports two devcontainer configurations:

## Local Development (Current Setup)
**File:** `devcontainer.json`

Runs **inside** an existing DDEV container using the `.ddev-docker-compose-full.yaml` configuration.

**How it works:**
- Uses your locally running DDEV instance
- All extensions and tools run inside DDEV's web container
- Direct access to all DDEV services
- Faster startup (DDEV already running)

**Usage:**
```bash
# Start DDEV first
ddev start

# Then open in VSCode
# Command Palette → "Dev Containers: Reopen in Container"
```

## GitHub Codespaces
**File:** `devcontainer.codespaces.json`

Runs DDEV **from scratch** using docker-in-docker.

**How it works:**
- Starts with a base Debian image
- Installs Docker and DDEV via features
- Runs setup script to initialize project
- DDEV router not available (Codespaces handles routing)

**Usage:**
1. Open repository in GitHub
2. Click "Code" → "Codespaces" → "Create codespace"
3. Wait for `setup_project.sh` to complete
4. Access site via forwarded ports

## Key Differences

| Feature | Local | Codespaces |
|---------|-------|------------|
| DDEV Start | Manual (`ddev start`) | Automatic (setup script) |
| DDEV Router | Used | Not used (ports forwarded) |
| Vite Port | `web_extra_exposed_ports` | Direct port exposure |
| Speed | Fast (reuses containers) | Slower (fresh install) |
| Network | Local | GitHub infrastructure |

## Vite Configuration

**Local:** Uses DDEV's `web_extra_exposed_ports` for clean routing

**Codespaces:** Uses `docker-compose.vite-codespaces.yaml` for direct port exposure (loaded conditionally via `#CODESPACES` suffix)

## Switching Between Setups

The project detects the environment automatically:
- `devcontainer.json` → used by VSCode locally
- `devcontainer.codespaces.json` → must be renamed to `devcontainer.json` for Codespaces OR create via GitHub UI

To use Codespaces configuration:
```bash
# Temporarily rename for Codespaces
mv .devcontainer/devcontainer.json .devcontainer/devcontainer.local.json
mv .devcontainer/devcontainer.codespaces.json .devcontainer/devcontainer.json

# Commit and push to test in Codespaces
```

To restore local setup:
```bash
mv .devcontainer/devcontainer.json .devcontainer/devcontainer.codespaces.json
mv .devcontainer/devcontainer.local.json .devcontainer/devcontainer.json
```
