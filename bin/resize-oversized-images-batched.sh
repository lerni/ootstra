#!/usr/bin/env bash
# Runs tasks:resize-oversized-images in small batches, each as its own PHP
# process. Imagick's pixel-cache resource accounting isn't reliably released
# within a single long-running process (see memory-leak-batch-image-cache.md),
# so a single unbounded run gets progressively less reliable (rising "Failed"/
# "cache resources exhausted" counts) and risks OOM on memory-constrained
# hosts. Running many small batches - each a fresh process - avoids that.
#
# Usage:
#   bin/resize-oversized-images-batched.sh [batch-size]
#
# Env overrides (useful for remote/shared hosting):
#   PHP_BIN=/usr/local/bin/php85
#   SAKE_BIN=/home/kraftaus/public_html/0sggk/current/vendor/bin/sake
#
# Example (remote, small batches to keep peak memory low):
#   PHP_BIN=/usr/local/bin/php85 \
#   SAKE_BIN=/home/kraftaus/public_html/0sggk/current/vendor/bin/sake \
#   bin/resize-oversized-images-batched.sh 10

set -uo pipefail

BATCH_SIZE="${1:-20}"

if ! [[ "$BATCH_SIZE" =~ ^[0-9]+$ ]] || [[ "$BATCH_SIZE" -lt 1 ]]; then
    echo "ERROR: batch size must be a positive integer, got '$BATCH_SIZE'" >&2
    exit 1
fi

PROJECT_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
PHP_BIN="${PHP_BIN:-php}"
SAKE_BIN="${SAKE_BIN:-$PROJECT_ROOT/vendor/bin/sake}"
TASK="tasks:resize-oversized-images"

pass=1

while true; do
    echo "=== Batch $pass (limit=$BATCH_SIZE) ==="
    output=$("$PHP_BIN" "$SAKE_BIN" "$TASK" "limit=$BATCH_SIZE" 2>&1)
    status=$?
    echo "$output"

    if [[ $status -ne 0 ]]; then
        echo "ERROR: task exited with status $status on batch $pass (killed/OOM?). Try a smaller batch size." >&2
        exit "$status"
    fi

    if [[ "$output" =~ Done\.\ Resized:\ ([0-9]+),\ Skipped:\ ([0-9]+),\ Failed:\ ([0-9]+),\ Errors:\ ([0-9]+) ]]; then
        resized="${BASH_REMATCH[1]}"
        failed="${BASH_REMATCH[3]}"
        errors="${BASH_REMATCH[4]}"
    else
        echo "ERROR: could not find the 'Done.' summary in task output, aborting." >&2
        exit 1
    fi

    if [[ $((resized + failed + errors)) -eq 0 ]]; then
        echo "=== Done: no oversized images left to process ==="
        break
    fi

    pass=$((pass + 1))
done
