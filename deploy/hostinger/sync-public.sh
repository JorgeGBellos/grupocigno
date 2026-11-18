#!/bin/bash
# Sync Laravel public artifacts into Hostinger document root (public_html).
# Run from SSH / cron after Git auto-deploy:
#   bash public_html/cigno/deploy/hostinger/sync-public.sh
set -euo pipefail

CIGNO_ROOT="$(cd "$(dirname "$0")/../.." && pwd)"
PUBLIC_HTML="$(cd "$CIGNO_ROOT/.." && pwd)"

for candidate in /opt/alt/php83/usr/bin/php /opt/alt/php84/usr/bin/php php83 php; do
  if command -v "$candidate" >/dev/null 2>&1 || [ -x "$candidate" ]; then
    PHP="$candidate"
    break
  fi
done
PHP="${PHP:-php}"

cd "$CIGNO_ROOT"

echo "==> migrate"
$PHP artisan migrate --force

echo "==> sync build -> $PUBLIC_HTML/build"
mkdir -p "$PUBLIC_HTML/build"
rsync -a --delete "$CIGNO_ROOT/public/build/" "$PUBLIC_HTML/build/"

echo "==> storage link -> $PUBLIC_HTML/storage"
if [ -L "$PUBLIC_HTML/storage" ] || [ -e "$PUBLIC_HTML/storage" ]; then
  rm -rf "$PUBLIC_HTML/storage"
fi
ln -sfn "$CIGNO_ROOT/storage/app/public" "$PUBLIC_HTML/storage"

# Keep Filament/Vite published assets available under document root when present.
if [ -d "$CIGNO_ROOT/public/css" ]; then
  mkdir -p "$PUBLIC_HTML/css"
  rsync -a "$CIGNO_ROOT/public/css/" "$PUBLIC_HTML/css/"
fi
if [ -d "$CIGNO_ROOT/public/js" ]; then
  mkdir -p "$PUBLIC_HTML/js"
  rsync -a "$CIGNO_ROOT/public/js/" "$PUBLIC_HTML/js/"
fi
if [ -d "$CIGNO_ROOT/public/fonts" ]; then
  mkdir -p "$PUBLIC_HTML/fonts"
  rsync -a "$CIGNO_ROOT/public/fonts/" "$PUBLIC_HTML/fonts/"
fi

echo "==> clear caches"
$PHP artisan view:clear || true
$PHP artisan config:clear || true
$PHP artisan route:clear || true
$PHP artisan config:cache || true

echo "OK: public_html synced (build + storage + filament assets)"
date > "$CIGNO_ROOT/storage/logs/hostinger-sync-public.done"
