# Go-live checklist (Hostinger)

1. Push `main` and wait for Git auto-deploy into `public_html/cigno`.
2. Run sync (SSH):
   ```bash
   bash ~/domains/lightyellow-okapi-798142.hostingersite.com/public_html/cigno/deploy/hostinger/sync-public.sh
   ```
3. `.env` en `cigno/`: `APP_URL=https://…`, `VIDEOS_ENABLED=true`, `APP_DEBUG=false`.
4. Subir videos slug-safe a `public_html/videos/` (al menos):
   - `home-hero.mp4`, `ermita-home.mp4`, `mejorada-home.mp4`
   - `agua.mp4`, `padel.mp4`
   - `experience-gastro.mp4`, `experience-spa.mp4`, `experience-barrio.mp4`
   - `ermita-barrio.mp4`, `destination.mp4`, `restaurante.mp4`, `mejorada-restaurant.mp4`, `Cocina.mp4`, `bata.mp4`
5. Verificar `https://…/storage` (symlink → `cigno/storage/app/public`) y un upload de prueba desde Filament.
6. Smoke: `/`, `/cigno-ermita`, `/cigno-mejorada`, daypass, experiences, offers, barrio, venue, `/admin/login`.
7. Seed catálogos si hace falta:
   ```bash
   php artisan db:seed --class=ErmitaRoomSeeder
   php artisan db:seed --class=ErmitaExperienceSeeder
   php artisan db:seed --class=MejoradaExperienceSeeder
   ```
8. Encender `cms_enabled` solo en páginas con contenido cargado (ver [CMS-SWITCH-GUIDE.md](CMS-SWITCH-GUIDE.md)).
9. Opcional: `php artisan cms:import-lang {slug}` antes de activar una página.
