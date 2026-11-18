# Guía: cuándo encender el switch CMS

## Regla corta

`lang/` + assets públicos son el **fallback**. El toggle **Conectar CMS al frontend** (`cms_enabled`) solo debe activarse cuando esa página ya tiene el contenido que quieres mostrar (o al menos los campos críticos).

- **OFF:** el sitio ignora el JSON CMS y usa lang / rutas de media por defecto.
- **ON:** cada campo **lleno** sustituye al frontend; los **vacíos** siguen el fallback.

## Página CMS vs catálogo CRUD

| Tipo | Dónde se edita | Ejemplos |
|------|----------------|----------|
| Página CMS | Menú **Páginas CMS** + switch | Home, hotel home, barrio, ofertas, venue, daypass, contact… |
| Catálogo CRUD | Menú propio (sin switch de página, pero el listado del hotel respeta el switch de la página “Habitaciones/Experiencias”) | Habitaciones Ermita/Mejorada, Experiencias Ermita/Mejorada, Prensa, Tiendita |

Para habitaciones y experiencias: publica filas en el CRUD **y** enciende el switch de la página CMS correspondiente (`cigno-*-rooms` / `cigno-*-experiences`). Si el switch está OFF o no hay filas publicadas → lang.

## Orden recomendado al activar

1. Seed / import de datos (`php artisan db:seed` o `php artisan cms:import-lang {slug}`).
2. Revisar en admin (ES/EN + medios en pestaña Español).
3. Previsualizar en el sitio con switch aún OFF (debe verse el fallback).
4. Encender switch **solo en esa página**.
5. Smoke de esa URL en ES y EN.

## Import rápido desde lang

```bash
php artisan cms:import-lang cigno-ermita-offers
php artisan cms:import-lang cigno-ermita-barrio --enable
php artisan cms:import-lang cigno-mejorada-offers --force
```

- Sin `--enable`: solo rellena textos/repeaters vacíos.
- Con `--enable`: además activa `cms_enabled`.
- Con `--force`: sobrescribe valores ya guardados.

Medios (imágenes/videos) **no** se importan desde lang; súbelos en admin o deja el fallback de asset.

## No encender todo el mismo día

Activa página a página cuando el contenido esté listo. Dejar OFF es seguro: el sitio sigue con lang.
