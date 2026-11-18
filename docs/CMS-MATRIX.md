# Matriz CMS ↔ Frontend

Fuente de verdad por defecto: `lang/` + assets en `public/`.  
Por página: switch `cms_enabled` en Filament. ON = campos CMS llenos; vacío = fallback lang/asset.

## Tipos de edición

| Tipo | Dónde | Ejemplos |
|------|--------|----------|
| Página CMS | Menú por slug (`/admin/cms-pages/{slug}`) | Home, hoteles, daypass, legal |
| Catálogo CRUD | Resources Filament | Habitaciones, Experiencias, Prensa, Tienda |
| Solo lectura | Resources | Contact leads, Venue inquiries |

## Páginas CMS

| Slug | Ruta | Fallback lang | Notas |
|------|------|---------------|-------|
| `home` | `/` | `lang/*/home.php` | Sin club teaser (vive en `/cigno-club`) |
| `contact` | `/contact` | `contact.*` | |
| `club` | `/cigno-club` | `club.*` | |
| `press` | `/press` | + `PressArticle` CRUD | |
| `shop` | `/shop` | + `ShopItem` CRUD | |
| `cocina-vidente` | `/cocina-vidente` | | |
| `cigno-ermita` | `/cigno-ermita` | `ermita.*` | + rooms teasers |
| `cigno-ermita-barrio` | `/cigno-ermita/barrio` | `ermita.barrio.*` | |
| `cigno-ermita-offers` | `/cigno-ermita/offers` | + repeater items | |
| `cigno-ermita-rooms` | `/cigno-ermita/rooms` | + `ErmitaRoom` CRUD | |
| `cigno-ermita-restaurant` | `/cigno-ermita/restaurant` | | |
| `cigno-ermita-daypass` | `/cigno-ermita/daypass` | | |
| `cigno-ermita-experiences` | `/cigno-ermita/experiences` | + `ErmitaExperience` CRUD | |
| `cigno-ermita-venue` | `/cigno-ermita/venue` | + spaces repeater | |
| `cigno-ermita-contact` | `/cigno-ermita/contact` | | |
| `cigno-mejorada` | `/cigno-mejorada` | `mejorada.*` | |
| `cigno-mejorada-barrio` | `/cigno-mejorada/barrio-mejorada` | | |
| `cigno-mejorada-offers` | `/cigno-mejorada/offers` | + repeater items | |
| `cigno-mejorada-rooms` | `/cigno-mejorada/rooms` | + `MejoradaRoom` CRUD | |
| `cigno-mejorada-restaurant` | `/cigno-mejorada/restaurant` | | |
| `cigno-mejorada-daypass` | `/cigno-mejorada/daypass` | | |
| `cigno-mejorada-experiences` | `/cigno-mejorada/experiences` | + `MejoradaExperience` CRUD | |
| `cigno-mejorada-venue` | `/cigno-mejorada/venue` | + spaces repeater | |
| `cigno-mejorada-contact` | `/cigno-mejorada/contact` | | |
| `legal-notice` / `cookies-policy` / `cookie-settings` | rutas legal | `pages.*` | |

## Cuándo encender el switch

1. Seed/importar contenido o rellenar campos clave.
2. Activar `cms_enabled` solo en esa página.
3. Verificar fallback: vaciar un campo y confirmar que vuelve el texto de `lang/`.
