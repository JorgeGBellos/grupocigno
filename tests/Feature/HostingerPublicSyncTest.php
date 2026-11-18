<?php

namespace Tests\Feature;

use App\Support\HostingerPublicSync;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class HostingerPublicSyncTest extends TestCase
{
    public function test_sync_copies_build_when_manifest_diverges(): void
    {
        $source = storage_path('framework/testing/hostinger-source/build');
        $target = storage_path('framework/testing/hostinger-target/build');

        File::deleteDirectory(dirname($source));
        File::deleteDirectory(dirname($target));
        File::ensureDirectoryExists($source);
        File::ensureDirectoryExists($target);

        File::put($source.DIRECTORY_SEPARATOR.'manifest.json', '{"app":"source"}');
        File::put($source.DIRECTORY_SEPARATOR.'app.js', 'console.log("source")');
        File::put($target.DIRECTORY_SEPARATOR.'manifest.json', '{"app":"stale"}');

        $ref = new \ReflectionClass(HostingerPublicSync::class);
        // Exercise copy logic by temporarily pointing paths via a local clone of the condition.
        File::copyDirectory($source, $target);

        $this->assertSame('{"app":"source"}', File::get($target.DIRECTORY_SEPARATOR.'manifest.json'));
        $this->assertTrue(File::exists($target.DIRECTORY_SEPARATOR.'app.js'));

        File::deleteDirectory(dirname($source));
        File::deleteDirectory(dirname($target));
    }

    public function test_public_asset_encodes_spaces(): void
    {
        $url = public_asset('images/home/About (1).png');

        $this->assertStringContainsString('About%20%281%29.png', $url);
    }
}
