# Publicación a Hostinger (Cigno)

Sitio: https://lightyellow-okapi-798142.hostingersite.com/  
Cuenta: `u620697284` · metadata en `.hostinger/site.json`

## Por qué era lento

`public/` pesa ~450 MB (sobre todo `videos/`). Subir todo el sitio a mano en cada cambio reenvía media que casi nunca cambia.

## Arquitectura en el servidor

```text
public_html/                    ← document root (no cambiar)
  index.php                     ← deploy/hostinger/index.php (apunta a ./cigno)
  images/  videos/  build/ ...  ← assets públicos (videos FUERA de Git)
  cigno/                        ← Laravel (Git auto-deploy + composer install)
    .env                        ← solo en el servidor
    app/ resources/ vendor/ ...
```

Laravel usa `usePublicPath(public_html)` para que `/images`, `/videos` y `/build` sigan en la raíz.

## Setup una sola vez

1. Repo en GitHub y push de `main` (`https://github.com/JorgeGBellos/grupocigno`).
2. Auto-deploy (elige **una**):
   - **Webhook (activo):** GitHub → Settings → Webhooks →  
     `https://webhooks.hostinger.com/deploy/54634d55737d1ea54f374ccb696d9b08` (eventos `push`).  
     Hostinger ya tiene el repo clonado en `public_html/cigno`.
   - **GitHub App (opcional):** en hPanel **Websites → Manage → Advanced → Git** conectar la cuenta;  
     luego MCP `hosting_git_update-auto-deployment-settings` (directory `cigno`, branch `main`).  
     Hoy no hay instalación activa en la API (`hosting_git_list-installations` = `[]`).
3. `public_html/index.php` = `deploy/hostinger/index.php` (bootstrap `./cigno` + `usePublicPath`).
4. Copiar `.env` y, si usas SQLite, `database/database.sqlite` desde el antiguo sibling `../cigno/`  
   (script: `deploy/hostinger/fix-env.sh`). Nunca commits de `.env`.
5. Asegurar `VIDEOS_ENABLED=true` y `APP_URL=https://lightyellow-okapi-798142.hostingersite.com`.
6. Tras el primer deploy: `php artisan migrate --force`, `view:clear`, `config:cache`  
   (PHP CLI: `/opt/alt/php83/usr/bin/php`; ver `deploy/hostinger/composer-bootstrap.sh`).

**Repo privado:** la deploy key RSA de Hostinger es de 2048 bits y GitHub la rechaza (≥3072).  
Mientras no haya GitHub App en hPanel, deja el repo **público** o usa un token/App.

## Publish diario (rápido)

```powershell
.\scripts\publish.ps1 -Message "Describe el cambio"
```

Eso hace `npm run build`, commit y `git push`. Hostinger despliega el código a `public_html/cigno`.

**No** vuelvas a subir los videos salvo que hayan cambiado.

### Si cambió el CSS/JS

Tras el auto-deploy, copia `cigno/public/build/` → `public_html/build/` (File Manager o MCP), o deja que el script/MCP lo sincronice.

### Si hay migraciones

En el servidor, dentro de `cigno/`:

```bash
php artisan migrate --force
php artisan view:clear
php artisan config:cache
```

## Qué no hacer

- No uses `hosting_deploy-js-application` (esto es PHP Laravel, no Node).
- No subas un ZIP de todo `public/` en cada release.
- No commits de `.env` ni de `public/videos/`.
