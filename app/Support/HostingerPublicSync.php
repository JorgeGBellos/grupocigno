<?php

namespace App\Support;

use Illuminate\Support\Facades\File;
use Throwable;

/**
 * On Hostinger the document root is public_html/ while Laravel lives in public_html/cigno/.
 * Git deploys Vite output to cigno/public/build, but the browser reads public_html/build.
 * This keeps both trees in sync when the manifests diverge.
 */
class HostingerPublicSync
{
    public static function syncBuildIfNeeded(): void
    {
        try {
            $source = base_path('public/build');
            $target = public_path('build');

            if ($source === $target || ! is_dir($source) || ! is_file($source.DIRECTORY_SEPARATOR.'manifest.json')) {
                return;
            }

            $sourceManifest = $source.DIRECTORY_SEPARATOR.'manifest.json';
            $targetManifest = $target.DIRECTORY_SEPARATOR.'manifest.json';
            $sourceHash = md5_file($sourceManifest);
            $targetHash = is_file($targetManifest) ? md5_file($targetManifest) : '';

            if ($sourceHash === false || $sourceHash === $targetHash) {
                return;
            }

            File::ensureDirectoryExists($target);
            File::copyDirectory($source, $target);
        } catch (Throwable) {
            // Never break page rendering if sync fails on shared hosting.
        }
    }

    public static function ensureStorageLink(): void
    {
        try {
            $link = public_path('storage');
            $target = storage_path('app/public');

            if (! is_dir($target)) {
                File::ensureDirectoryExists($target);
            }

            if (is_link($link) || is_dir($link) || is_file($link)) {
                return;
            }

            if (PHP_OS_FAMILY === 'Windows') {
                return;
            }

            @symlink($target, $link);
        } catch (Throwable) {
            // Ignore link failures; File Manager / SSH can create it.
        }
    }
}
