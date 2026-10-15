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

1. Repo en GitHub (privado) y push de `main`.
2. En hPanel: **Websites → Manage → Advanced → Git** → conectar GitHub.
3. Activar auto-deploy al directorio `cigno` (Cursor/MCP: `hosting_git_update-auto-deployment-settings`).
4. Subir `deploy/hostinger/index.php` como `public_html/index.php`.
5. Copiar el `.env` de producción a `public_html/cigno/.env` (desde el antiguo `../cigno/.env` si existía).
6. Asegurar `VIDEOS_ENABLED=true` y `APP_URL=https://lightyellow-okapi-798142.hostingersite.com` en ese `.env`.
7. Tras el primer deploy: `php artisan migrate --force`, `view:clear`, `config:cache`.

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
