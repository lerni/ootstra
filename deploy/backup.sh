#!/bin/bash
# backup.sh — Silverstripe: daily DB dump + incremental asset snapshots
# Cron: 0 3 * * * /home/USERNAME/scripts/backup.sh >> /home/USERNAME/backups/backup.log 2>&1

set -euo pipefail

# ── Configuration ────────────────────────────────────────────────────────────
SERVER_USER="UUSSEERRrr"          # login / home dir name (see deploy/config.php)
WEBDIR="public_html"            # web root dir under /home/$SERVER_USER
APP_DIR="0liver"    # deployment folder (DEP_DEPLOY_LIVE_PATH basename)


ENV_FILE="/home/${SERVER_USER}/${WEBDIR}/${APP_DIR}/current/.env"
# Point directly to shared/ — assets live here permanently, independent of the current-symlink
ASSETS_SOURCE="/home/${SERVER_USER}/${WEBDIR}/${APP_DIR}/shared/public/assets/"
BACKUP_ROOT="/home/${SERVER_USER}/backups_cms"
DB_RETENTION=90     # days of DB dumps to keep
ASSETS_RETENTION=90 # daily asset snapshots to keep

# ── Load DB credentials from .env ────────────────────────────────────────────
if [ ! -f "${ENV_FILE}" ]; then
    echo "[$(date -u +%Y-%m-%dT%H:%M:%SZ)] ERROR: .env not found at ${ENV_FILE}" >&2
    exit 1
fi
source <(grep -E "^SS_DATABASE_(SERVER|PORT|USERNAME|PASSWORD|NAME)" "${ENV_FILE}" | sed 's/"//g')

# ── Prepare ───────────────────────────────────────────────────────────────────
DB_DIR="${BACKUP_ROOT}/db"
ASSETS_DIR="${BACKUP_ROOT}/assets"
mkdir -p "${DB_DIR}" "${ASSETS_DIR}"

TODAY=$(date -u +%Y-%m-%d)
echo "[$(date -u +%Y-%m-%dT%H:%M:%SZ)] === Backup start ${TODAY} ==="

# ── DB dump ───────────────────────────────────────────────────────────────────
DB_FILE="${DB_DIR}/${TODAY}.sql.gz"
mysqldump \
    -h "${SS_DATABASE_SERVER}" \
    -P "${SS_DATABASE_PORT:-3306}" \
    -u "${SS_DATABASE_USERNAME}" \
    -p"${SS_DATABASE_PASSWORD}" \
    --single-transaction \
    --quick \
    "${SS_DATABASE_NAME}" | gzip > "${DB_FILE}"
chmod 600 "${DB_FILE}"
echo "[$(date -u +%Y-%m-%dT%H:%M:%SZ)] DB dump: $(du -sh "${DB_FILE}" | cut -f1)"

# Rotate: remove dumps older than $DB_RETENTION days
find "${DB_DIR}" -name "*.sql.gz" -type f -mtime +${DB_RETENTION} -delete

# ── Incremental asset snapshot (rsync --link-dest) ────────────────────────────
SNAPSHOT="${ASSETS_DIR}/${TODAY}"
YESTERDAY="${ASSETS_DIR}/$(date -d "yesterday" +%Y-%m-%d)"

if [ -d "${SNAPSHOT}" ]; then
    echo "[$(date -u +%Y-%m-%dT%H:%M:%SZ)] Asset snapshot already exists, skipping"
else
    RSYNC_OPTS=(-a --delete)
    if [ -d "${YESTERDAY}" ]; then
        RSYNC_OPTS+=(--link-dest="${YESTERDAY}")
    fi

    STATS=$(rsync "${RSYNC_OPTS[@]}" --stats "${ASSETS_SOURCE}" "${SNAPSHOT}/" \
        | grep "Number of regular files transferred" | awk '{print $NF}')
    echo "[$(date -u +%Y-%m-%dT%H:%M:%SZ)] Asset snapshot: ${STATS:-0} files changed"
fi

# Rotate: keep only $ASSETS_RETENTION most recent snapshots (name-sorted = date-sorted)
find "${ASSETS_DIR}" -maxdepth 1 -type d -name "????-??-??" | sort | head -n -${ASSETS_RETENTION} | xargs -r rm -rf

echo "[$(date -u +%Y-%m-%dT%H:%M:%SZ)] === Backup complete ==="

# ── Offsite sync via restic (uncomment once Hetzner BX11 is set up) ─────────────
# restic deduplicates + compresses + encrypts — only changed chunks are transferred.
# Both db/ and assets/ go into one repo; 90-day history costs only incremental space.
#
# One-time setup (run manually):
#   export RESTIC_PASSWORD='choose-a-strong-passphrase'
#   ~/bin/restic -r sftp:uXXXXXX@uXXXXXX.your-storagebox.de:cms-backups init
#
# Daily (add to this script or a separate backup-offsite.sh):
# export RESTIC_PASSWORD='your-passphrase'
# export RESTIC_REPOSITORY='sftp:uXXXXXX@uXXXXXX.your-storagebox.de:cms-backups'
# ~/bin/restic backup "${DB_DIR}/" "${ASSETS_SOURCE}"
# ~/bin/restic forget --keep-daily 90 --keep-monthly 24 --prune
