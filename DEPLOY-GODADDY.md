# Publicar Cigno en GoDaddy (cPanel, solo Administrador de archivos)

SQLite. Sin SSH y sin terminal. PHP **8.3** obligatorio (Laravel 13).

El sitio publico queda en `public_html`. La aplicacion queda en una carpeta `cigno` **al lado** de `public_html`, no mezclada con las imagenes. Un archivo `setup.php` crea el `.env`, la base, las tablas, el enlace de `storage` y el usuario del panel `/admin`.

## 1. En tu PC

En la carpeta del proyecto:

```powershell
composer install
npm run build
.\scripts\pack-godaddy.ps1
```

Eso genera:

- `deploy/godaddy-app.zip` — Laravel, `vendor/` y, si existe, tu `database/database.sqlite`
- `deploy/godaddy-public.zip` — lo que ve el navegador, mas `index.php` y `setup.php`

El script imprime un **token**. Guardalo. No subas tu `.env` local: el setup crea uno de produccion.

Los videos no van en el ZIP (`VIDEOS_ENABLED=false`). Si mas adelante los quieres, sube solo los archivos nuevos a `public_html/videos` y en `cigno/.env` pon `VIDEOS_ENABLED=true`.

## 2. En cPanel, antes de subir

1. **MultiPHP** o **Select PHP Version** del dominio: **PHP 8.3**.
2. En esa misma pantalla, deja activos `pdo_sqlite` y `sqlite3`.
3. Anota la carpeta raiz de la cuenta. En el Administrador de archivos es el nivel donde ves `public_html`. Suele ser `/home/tuUsuario`.

Si el plan no ofrece PHP 8.3, este proyecto no arranca.

## 3. Subir la aplicacion

1. Administrador de archivos → entra a la carpeta que **contiene** `public_html` (un nivel arriba).
2. Crea la carpeta `cigno`.
3. Entra a `cigno`.
4. Cargar → `deploy/godaddy-app.zip`.
5. Click derecho en el ZIP → **Extract**. Los archivos (`artisan`, `app`, `vendor`, `database`…) deben quedar **dentro** de `cigno`, no dentro de otra subcarpeta.
6. Borra el ZIP.

Permisos (click derecho → Change Permissions), aplicados a carpetas:

- `cigno/storage` → **755** (si luego falla la escritura, **775**)
- `cigno/bootstrap/cache` → **755**
- `cigno/database` → **755**

## 4. Subir lo publico

1. Entra a `public_html`.
2. Si ahi ya hay un sitio, descarga una copia o renombra la carpeta antes de seguir. Extract **mezcla** archivos.
3. Cargar → `deploy/godaddy-public.zip` → Extract en `public_html`.
4. Tienes que ver `index.php`, `setup.php`, `.htaccess`, `build/`, `images/`, `js/`, `css/`.
5. Borra el ZIP.

`index.php` no es el de Laravel pelon: busca la app en `../cigno` y usa `public_html` como carpeta publica.

## 5. Abrir el setup (una sola vez)

En el navegador:

```text
https://tu-dominio.com/setup.php?token=EL-TOKEN-QUE-IMPRIMIO-EL-SCRIPT
```

El setup hace esto:

- comprueba PHP 8.3
- crea `database/database.sqlite` si no venia en el ZIP
- escribe `cigno/.env` (produccion, `APP_DEBUG=false`, URL del dominio, SQLite con ruta absoluta)
- corre las migraciones
- si la base esta vacia, carga paginas CMS y habitaciones
- crea el enlace `public_html/storage` → `cigno/storage/app/public` (archivos del panel)
- limpia cache de vistas

Despues, en esa misma pagina, escribe nombre, correo y contraseña (minimo 8). Ese es el acceso a:

```text
https://tu-dominio.com/admin
```

Cuando el home y `/admin` abran, pulsa **Borrar setup.php**. Si el boton falla, borralo tu en el Administrador de archivos. No lo dejes publicado.

## 6. Comprobar

- Home abre sin error 500.
- `/admin` muestra el login de Filament y entras con el correo que acabas de guardar.
- En el panel, sube una imagen de prueba. Tiene que verse en el sitio (eso confirma el enlace `storage`).

## Si algo falla

**500 al abrir el home.** En `cigno/storage/logs/laravel.log` esta el motivo. Lo mas comun: PHP distinto de 8.3, o `vendor/` no quedo dentro de `cigno`.

**El setup dice que no encuentra cigno.** El ZIP se extrajo un nivel de mas. `artisan` tiene que estar en `cigno/artisan`, no en `cigno/grupocigno/artisan`.

**No pude crear el enlace storage.** Algunos planes bloquean `symlink`. El propio setup lo intenta tambien con `ln -s`. Si aun falla, en el Administrador de archivos (si tu plan muestra “Create symbolic link”) enlaza `public_html/storage` a la ruta completa de `cigno/storage/app/public`.

**SQLite no se crea.** Permisos de la carpeta `cigno/database` en 775 y vuelve a abrir el setup.

**El dominio addon no usa `public_html` directo.** En Dominios, mira la raiz del documento. `cigno` debe ser hermana de esa carpeta. `index.php` tambien busca `cigno` un nivel mas arriba.

**No subas** `node_modules`, `.git`, ni el `.env` de tu PC. La cola queda en `sync`: no hace falta cron para los formularios.

## Actualizar (sitio ya publicado — solo reemplazar archivos)

Usa esto si `cigno/` y `public_html/` ya existen y solo quieres subir Mirai Core, gtag y los cambios de UI.

### No toques / no borres

- `cigno/.env`
- `cigno/database/database.sqlite`
- `cigno/storage/` (archivos subidos desde el panel)
- `public_html/storage` (el enlace)
- `public_html/videos/` (si ya hay videos)

### A. En tu PC

```powershell
composer install
npm run build
.\scripts\pack-godaddy.ps1
```

Quedan `deploy/godaddy-app.zip` y `deploy/godaddy-public.zip`.

Opcion mas segura si el ZIP completo te da miedo: sube solo las carpetas/archivos de la lista B y C (sin sobrescribir `.env` ni sqlite).

### B. Actualizar la app (`cigno/`)

1. En el Administrador de archivos, entra a `cigno/`.
2. Sube `godaddy-app.zip` a una carpeta temporal, por ejemplo `cigno/_update/`, y extráelo ahí.
3. Copia/sobrescribe **desde** `_update` **hacia** `cigno` estas carpetas (Merge / Replace):
   - `app/`
   - `bootstrap/` (excepto no toques si tienes algo custom; normalmente ok)
   - `config/`
   - `lang/`
   - `resources/`
   - `routes/`
   - `vendor/` (si el ZIP lo trae; si no cambió composer, puedes saltarlo)
   - `composer.json`, `composer.lock`, `artisan`
4. **No** copies encima: `.env`, `database/database.sqlite`, ni vacíes `storage/`.
5. Borra `cigno/_update/` y el ZIP.

Si prefieres ir a mano (sin ZIP), sube al menos:

```text
cigno/config/navigation.php          (Habitaciones → /rooms, NO bookingstep1)
cigno/config/booking.php
cigno/config/services.php
cigno/routes/web.php
cigno/resources/views/components/layouts/app.blade.php
cigno/resources/views/components/layouts/header.blade.php
cigno/resources/views/home.blade.php
cigno/resources/views/ermita/rooms.blade.php
cigno/resources/views/ermita/room-show.blade.php
cigno/resources/views/mejorada/rooms.blade.php
cigno/resources/views/mejorada/room-show.blade.php
cigno/resources/views/components/ermita/hero.blade.php
cigno/resources/views/components/mejorada/hero.blade.php
cigno/resources/views/components/mirai/          (carpeta nueva)
cigno/resources/views/components/home/club-section.blade.php
cigno/resources/views/components/home/story-section.blade.php
cigno/lang/es/home.php
cigno/lang/en/home.php
cigno/lang/es/ermita.php
cigno/lang/en/ermita.php
cigno/lang/es/mejorada.php
cigno/lang/en/mejorada.php
```

Tras subir `config/`, borra `cigno/bootstrap/cache/config.php` si existe (o corre `php artisan config:clear` en el servidor). Si no, el menú puede seguir leyendo el `url => /bookingstep1` viejo.

### C. Actualizar lo publico (`public_html/`)

1. Entra a `public_html/`.
2. Sube y sobrescribe (o extrae el ZIP public con cuidado):

```text
public_html/.htaccess                   (rewrites Mirai: /bookingstep1 → .html)
public_html/core-variables.css          (nuevo Mirai)
public_html/bookingstep1.html           (nuevo)
public_html/bookingstep2.html
public_html/bookingstep3.html
public_html/signup.html
public_html/profile.html
public_html/build/                      (tras npm run build)
public_html/images/home/experiences-*.png   (si aún no están)
public_html/images/ermita/rooms/            (si aplica)
public_html/images/mejorada/rooms/
```

Mirai navega a `/bookingstep1?restoUrl=...` **sin** `.html`. Sin el `.htaccess` actualizado, Apache manda esa URL a Laravel y “rompe”. Con el rewrite, sirve `bookingstep1.html` y conserva la query string.

3. No reemplaces `index.php` a menos que sepas que es el de GoDaddy (apunta a `../cigno`). Si tu `index.php` actual ya funciona, déjalo.
4. No borres `storage` ni `videos`.

### D. Editar el `.env` del servidor (File Manager → Edit)

Abre `cigno/.env` y asegúrate de tener (añade lo que falte):

```env
GOOGLE_ANALYTICS_ID=G-478YGR6D9Q
BOOKING_IDCHAIN=522722
BOOKING_MEJORADA_MIRAI_ID=100380967
BOOKING_ERMITA_MIRAI_ID=100378202
```

Guarda. No hace falta volver a correr `setup.php` si no hay migraciones nuevas.

### E. Limpiar caches (sin SSH)

Opcion A — sube un one-shot y bórralo después:

1. Copia `deploy/godaddy/setup.php` a `public_html/clear-cache.php` **solo si** ya cambiaste el `$setupToken` y lo usas una vez… Mejor: crea en `cigno/` un archivo `clear-once.php`:

```php
<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
Illuminate\Support\Facades\Artisan::call('view:clear');
Illuminate\Support\Facades\Artisan::call('config:clear');
Illuminate\Support\Facades\Artisan::call('route:clear');
echo 'OK';
```

2. En cPanel → MultiPHP INI / Cron, o desde el navegador **no** (ese archivo no debe ser web). Sin SSH, la forma más simple: en File Manager borra a mano si existen:

```text
cigno/bootstrap/cache/config.php
cigno/bootstrap/cache/routes-*.php
cigno/storage/framework/views/*.php
```

(deja los `.gitignore` de esas carpetas).

### F. Comprobar

1. `https://tudominio.com/` — finder Mirai en el hero, gtag en el código fuente.
2. `/cigno-ermita` y `/cigno-mejorada` — finder con hotel preseleccionado.
3. `https://tudominio.com/bookingstep1.html` — página Mirai (`rates`), **no** el home.
4. Beneficios — fondo dorado, texto/íconos negros.
5. Avisa a Mirai la URL de `bookingstep1.html`.

### Nota sobre el buscador

Al buscar, Mirai puede seguir mandando a `cignohotel.com`: eso lo controla su configuración de la cadena, no tu cPanel. El finder en tu dominio solo queda “listo” cuando ellos apunten el entorno a tu URL.
