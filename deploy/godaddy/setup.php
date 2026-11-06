<?php

/**
 * Instalador web para cPanel (solo Administrador de archivos).
 * Subelo a public_html, abrelo una vez y BORRALO al terminar.
 *
 * Antes de subirlo, cambia el token de abajo.
 */
$setupToken = 'CAMBIA-ESTE-TOKEN';

header('X-Robots-Tag: noindex, nofollow');
header('Cache-Control: no-store');

function setup_h(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function setup_fail(string $message, int $status = 500): void
{
    http_response_code($status);
    echo '<!doctype html><meta charset="utf-8"><title>Setup</title><body style="font-family:sans-serif;max-width:40rem;margin:2rem auto">';
    echo '<h1>Setup</h1><p>'.setup_h($message).'</p></body>';
    exit;
}

$token = (string) ($_POST['token'] ?? $_GET['token'] ?? '');

if ($setupToken === 'CAMBIA-ESTE-TOKEN' || strlen($setupToken) < 16) {
    setup_fail('Edita deploy/godaddy/setup.php y cambia $setupToken por una frase larga antes de subirlo.', 403);
}

if (! hash_equals($setupToken, $token)) {
    http_response_code(403);
    echo '<!doctype html><meta charset="utf-8"><title>Setup</title><body style="font-family:sans-serif;max-width:40rem;margin:2rem auto">';
    echo '<h1>Cigno — setup</h1><p>Token incorrecto.</p>';
    echo '<form method="post"><input type="password" name="token" placeholder="Token" required style="width:100%;padding:.6rem">';
    echo '<button style="margin-top:.8rem;padding:.6rem 1rem">Entrar</button></form></body>';
    exit;
}

if (PHP_VERSION_ID < 80300) {
    setup_fail('Este proyecto necesita PHP 8.3 o superior. En cPanel abre MultiPHP / Select PHP Version y elige 8.3. Ahora hay '.PHP_VERSION.'.');
}

$publicPath = __DIR__;
$candidates = [
    dirname(__DIR__).'/cigno',
    dirname(__DIR__, 2).'/cigno',
    $publicPath.'/cigno',
];

$laravelRoot = null;

foreach ($candidates as $candidate) {
    if (is_file($candidate.'/vendor/autoload.php') && is_file($candidate.'/artisan')) {
        $laravelRoot = $candidate;
        break;
    }
}

if ($laravelRoot === null) {
    setup_fail('No encontre la carpeta cigno (con vendor/ y artisan) al lado de public_html ni dentro de ella.');
}

if (($_POST['action'] ?? '') === 'delete') {
    @unlink(__FILE__);
    echo '<!doctype html><meta charset="utf-8"><title>Setup</title><body style="font-family:sans-serif;max-width:40rem;margin:2rem auto">';
    echo '<h1>Listo</h1><p>setup.php se elimino. Entra al sitio y a /admin.</p></body>';
    exit;
}

$steps = [];

$ok = function (string $label, string $detail = '') use (&$steps): void {
    $steps[] = ['ok' => true, 'label' => $label, 'detail' => $detail];
};

$bad = function (string $label, string $detail = '') use (&$steps): void {
    $steps[] = ['ok' => false, 'label' => $label, 'detail' => $detail];
};

foreach ([
    $laravelRoot.'/storage/app/public',
    $laravelRoot.'/storage/framework/cache/data',
    $laravelRoot.'/storage/framework/sessions',
    $laravelRoot.'/storage/framework/views',
    $laravelRoot.'/storage/logs',
    $laravelRoot.'/bootstrap/cache',
    $laravelRoot.'/database',
] as $dir) {
    if (! is_dir($dir) && ! @mkdir($dir, 0775, true) && ! is_dir($dir)) {
        $bad('Carpetas', 'No pude crear '.$dir);
    }
}

foreach ([
    $laravelRoot.'/storage',
    $laravelRoot.'/bootstrap/cache',
    $laravelRoot.'/database',
] as $dir) {
    @chmod($dir, 0775);
}

$sqlite = $laravelRoot.'/database/database.sqlite';

if (! is_file($sqlite)) {
    if (@touch($sqlite)) {
        $ok('SQLite', 'Se creo database/database.sqlite');
    } else {
        $bad('SQLite', 'No pude crear '.$sqlite.'. En el Administrador de archivos pon permisos 755 o 775 a la carpeta database.');
    }
} else {
    $ok('SQLite', 'Ya existia database/database.sqlite');
}

@chmod($sqlite, 0664);

$insideWebRoot = str_starts_with(realpath($laravelRoot) ?: $laravelRoot, realpath($publicPath) ?: $publicPath);

if ($insideWebRoot) {
    $deny = $laravelRoot.'/.htaccess';
    $denyBody = <<<'HTA'
<IfModule mod_authz_core.c>
    Require all denied
</IfModule>
<IfModule !mod_authz_core.c>
    Deny from all
</IfModule>
HTA;
    if (@file_put_contents($deny, $denyBody) !== false) {
        $ok('Proteccion', 'cigno esta dentro del sitio publico. Se escribio .htaccess para bloquear el acceso HTTP.');
    } else {
        $bad('Proteccion', 'cigno esta dentro de public_html y no pude escribir .htaccess. Muevela fuera, al lado de public_html.');
    }
} else {
    $ok('Ubicacion', 'La app esta fuera del document root.');
}

$envPath = $laravelRoot.'/.env';
$scheme = (! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$appUrl = $scheme.'://'.($_SERVER['HTTP_HOST'] ?? 'localhost');

if (! is_file($envPath)) {
    $example = $laravelRoot.'/.env.example';
    $env = is_file($example) ? (string) file_get_contents($example) : '';
    $key = 'base64:'.base64_encode(random_bytes(32));
    $env = preg_replace('/^APP_ENV=.*/m', 'APP_ENV=production', $env) ?? $env;
    $env = preg_replace('/^APP_DEBUG=.*/m', 'APP_DEBUG=false', $env) ?? $env;
    $env = preg_replace('/^APP_URL=.*/m', 'APP_URL='.$appUrl, $env) ?? $env;
    $env = preg_replace('/^APP_KEY=.*/m', 'APP_KEY='.$key, $env) ?? $env;
    $env = preg_replace('/^LOG_LEVEL=.*/m', 'LOG_LEVEL=error', $env) ?? $env;
    $env = preg_replace('/^QUEUE_CONNECTION=.*/m', 'QUEUE_CONNECTION=sync', $env) ?? $env;
    $env = preg_replace('/^FILESYSTEM_DISK=.*/m', 'FILESYSTEM_DISK=public', $env) ?? $env;
    $env = preg_replace('/^VIDEOS_ENABLED=.*/m', 'VIDEOS_ENABLED=false', $env) ?? $env;
    $env = preg_replace('/^#?\s*DB_DATABASE=.*/m', '', $env) ?? $env;
    $env = rtrim($env)."\nDB_DATABASE=".$sqlite."\n";

    if (@file_put_contents($envPath, $env) !== false) {
        $ok('.env', 'Creado para produccion, SQLite y '.$appUrl);
    } else {
        $bad('.env', 'No pude escribir '.$envPath);
    }
} else {
    $ok('.env', 'Ya existia. No lo reemplace.');
}

@chmod($envPath, 0640);

$results = [];
$adminNote = '';

if (is_file($laravelRoot.'/vendor/autoload.php') && is_file($envPath) && is_file($sqlite)) {
    try {
        require $laravelRoot.'/vendor/autoload.php';
        $app = require $laravelRoot.'/bootstrap/app.php';
        $app->usePublicPath($publicPath);

        $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
        $kernel->bootstrap();

        $migrate = Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        $migrateOut = trim(Illuminate\Support\Facades\Artisan::output());
        if ($migrate === 0) {
            $ok('Migraciones', $migrateOut !== '' ? $migrateOut : 'OK');
        } else {
            $bad('Migraciones', $migrateOut !== '' ? $migrateOut : 'artisan migrate fallo');
        }

        $hasUsers = Illuminate\Support\Facades\Schema::hasTable('users')
            && Illuminate\Support\Facades\DB::table('users')->count() > 0;

        if (! $hasUsers) {
            $seed = Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
            $seedOut = trim(Illuminate\Support\Facades\Artisan::output());
            if ($seed === 0) {
                $ok('Contenido inicial', 'CMS, habitaciones y usuario base.');
            } else {
                $bad('Contenido inicial', $seedOut !== '' ? $seedOut : 'db:seed fallo');
            }
        } else {
            $ok('Contenido inicial', 'La base ya tenia usuarios. No se volvio a sembrar.');
        }

        $link = $publicPath.'/storage';
        $target = $laravelRoot.'/storage/app/public';
        $linked = false;

        if (is_link($link)) {
            $linked = true;
            $ok('Storage', 'El enlace public_html/storage ya existia.');
        } elseif (is_dir($link)) {
            $bad('Storage', 'public_html/storage ya es una carpeta real. Borrala en el Administrador de archivos y vuelve a abrir este setup.');
        } else {
            $linked = @symlink($target, $link);

            if (! $linked && function_exists('exec')) {
                $cmd = 'ln -s '.escapeshellarg($target).' '.escapeshellarg($link);
                @exec($cmd, $unused, $code);
                $linked = $code === 0 && (is_link($link) || is_dir($link));
            }

            if ($linked) {
                $ok('Storage', 'Enlace creado: public_html/storage → storage/app/public. El panel ya puede guardar archivos.');
            } else {
                $bad('Storage', 'El hosting bloqueo symlink. En el Administrador de archivos crea un enlace simbolico de public_html/storage hacia '.$target);
            }
        }

        Illuminate\Support\Facades\Artisan::call('view:clear');
        Illuminate\Support\Facades\Artisan::call('config:clear');
        Illuminate\Support\Facades\Artisan::call('route:clear');
        $ok('Cache', 'Vistas, config y rutas limpias.');

        $name = trim((string) ($_POST['admin_name'] ?? ''));
        $email = trim((string) ($_POST['admin_email'] ?? ''));
        $password = (string) ($_POST['admin_password'] ?? '');

        if (($_POST['action'] ?? '') === 'admin') {
            if (! filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 8 || $name === '') {
                $bad('Panel', 'Nombre, correo valido y contraseña de al menos 8 caracteres.');
            } else {
                $user = App\Models\User::query()->first();

                if ($user) {
                    $user->forceFill([
                        'name' => $name,
                        'email' => $email,
                        'password' => $password,
                        'email_verified_at' => now(),
                    ])->save();
                } else {
                    App\Models\User::query()->create([
                        'name' => $name,
                        'email' => $email,
                        'password' => $password,
                        'email_verified_at' => now(),
                    ]);
                }

                $ok('Panel', 'Usuario listo. Entra en '.$appUrl.'/admin');
                $adminNote = $email;
            }
        }
    } catch (Throwable $e) {
        $bad('Laravel', $e->getMessage());
    }
}

$failed = array_filter(
    $steps,
    fn (array $step): bool => $step['ok'] === false && $step['label'] !== 'Panel'
);

?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">
    <title>Setup Cigno</title>
    <style>
        body { font-family: Georgia, serif; background: #f6f1e8; color: #1c1c1c; margin: 0; }
        main { max-width: 42rem; margin: 2rem auto; padding: 0 1rem 3rem; }
        h1 { font-weight: normal; }
        li { margin: .7rem 0; }
        .ok { color: #1d6b3a; }
        .bad { color: #8d2a2a; }
        form { display: grid; gap: .6rem; margin-top: 1rem; }
        input { font: inherit; padding: .55rem .7rem; border: 1px solid #c9bfb0; }
        button { font: inherit; padding: .6rem 1rem; background: #bc9142; color: white; border: 0; cursor: pointer; }
        code { font-family: ui-monospace, monospace; font-size: .9em; }
    </style>
</head>
<body>
<main>
    <h1>Setup Cigno</h1>
    <p>PHP <?= setup_h(PHP_VERSION) ?> · app en <code><?= setup_h($laravelRoot) ?></code></p>
    <ul>
        <?php foreach ($steps as $step): ?>
            <li class="<?= $step['ok'] ? 'ok' : 'bad' ?>">
                <strong><?= setup_h($step['label']) ?>:</strong>
                <?= nl2br(setup_h($step['detail'])) ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <?php if ($failed === []): ?>
        <h2>Usuario del panel</h2>
        <p>El panel queda en <a href="/admin">/admin</a>. Define el acceso. Si ya habia un usuario, se actualiza el primero.</p>
        <?php if ($adminNote !== ''): ?>
            <p class="ok">Puedes entrar con <?= setup_h($adminNote) ?>.</p>
        <?php endif; ?>
        <form method="post">
            <input type="hidden" name="token" value="<?= setup_h($token) ?>">
            <input type="hidden" name="action" value="admin">
            <input name="admin_name" placeholder="Nombre" required value="<?= setup_h((string) ($_POST['admin_name'] ?? 'Admin')) ?>">
            <input name="admin_email" type="email" placeholder="Correo" required value="<?= setup_h((string) ($_POST['admin_email'] ?? '')) ?>">
            <input name="admin_password" type="password" placeholder="Contraseña (min. 8)" required minlength="8">
            <button type="submit">Guardar usuario del panel</button>
        </form>

        <h2>Cierra el instalador</h2>
        <p>Cuando el sitio y /admin abran, borra este archivo. Si lo dejas, cualquiera con el token puede volver a entrar.</p>
        <form method="post">
            <input type="hidden" name="token" value="<?= setup_h($token) ?>">
            <input type="hidden" name="action" value="delete">
            <button type="submit">Borrar setup.php</button>
        </form>
    <?php else: ?>
        <p>Corrige los pasos en rojo y vuelve a abrir esta pagina con el mismo token.</p>
    <?php endif; ?>
</main>
</body>
</html>
