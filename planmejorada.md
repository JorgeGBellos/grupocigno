# Plan de integración — CIGNO Mejorada

**Proyecto:** Cigno Hoteles (Laravel 13 + Filament 5 + Tailwind 4 + Alpine)  
**Objetivo de la semana:** levantar el sitio modular de **Cigno Mejorada** dentro de la misma app, sin romper Grupo ni Ermita.  
**Estado actual:** `/cigno-mejorada` apunta a `coming-soon` (`routes/web.php`). Existe stub CMS `CmsPageSlug::Mejorada` con campos genéricos `hotelSections()`.

**Recursos (completar):**
- Figma: `[PEGA AQUÍ TU LINK DE FIGMA]`
- Drive / assets: `[PEGA AQUÍ TU LINK DE DRIVE]`

**Referencia obligatoria a clonar (no reinventar):** el módulo Ermita ya resuelto en este repo.

---

## 0. Inventario rápido del código actual (lo que ya existe)

| Área | Ermita (referencia) | Mejorada (hoy) |
|------|---------------------|----------------|
| Rutas | `/cigno-ermita/*` en `routes/web.php` | Solo `Route::view('/cigno-mejorada', 'coming-soon')` |
| Menú hotel | `config/navigation.php` → key `ermita` | Brand tab existe; `menu` = `main` (incorrecto a largo plazo) |
| Vistas | `resources/views/ermita/*` + `resources/views/components/ermita/*` | No hay |
| Lang | `lang/es/ermita.php`, `lang/en/ermita.php` | No hay |
| CMS pages | `cigno-ermita`, `cigno-ermita-rooms`, … | Solo `cigno-mejorada` (stub) |
| Models | `ErmitaRoom`, `ErmitaExperience` | — |
| Filament | Grupo nav **Cigno Ermita** (`ErmitaRoomResource`, `ErmitaExperienceResource`, `VenueInquiryResource`) | — |
| Tokens CSS | `--color-blue-ermita-*` en `resources/css/app.css` | Tokens `medium-green-*` / `green-*` ya existen (candidatos) |

---

## 1. Arquitectura sugerida (basada en el código actual)

### 1.1 Models / DB — **NO unificar con `hotel_id` en esta fase**

**Decisión Tech Lead:** seguir el patrón **por hotel = tablas y models dedicados**, igual que Ermita.

| Opción | Veredicto | Motivo |
|--------|-----------|--------|
| Agregar `hotel_id` a `ermita_rooms` / unificar | ❌ No esta semana | Rompe Filament actual (`ErmitaRoomResource`), scopes, seeders y naming; mezcla datos en admin |
| Models nuevos espejo (`MejoradaRoom`, etc.) | ✅ **Elegida** | Aislamiento, mismo shape que `app/Models/ErmitaRoom.php` y `ErmitaExperience.php`, cero riesgo en Ermita |
| Trait compartido `HasLocalizedJson` / `HasHotelMedia` | ✅ Opcional | Extraer helpers comunes **sin** fusionar tablas |

**Models a crear (espejo Ermita):**

```
app/Models/MejoradaRoom.php          ← espejo de ErmitaRoom
app/Models/MejoradaExperience.php    ← espejo de ErmitaExperience (si Figma lo pide)
```

**Reutilizar (no duplicar tablas):**

- `CmsPage` + `CmsPageSlug` + `PageFieldDefinitions` + `cms()` / `CmsContent` — ampliar enum y field defs.
- `ContactLead` — ya tiene `source`; usar `source = 'mejorada'` en el form (como Ermita).
- `VenueInquiry` — si Mejorada tiene venue: agregar filtro/columna `hotel` (ya existe `hotel` default `cigno-ermita` en `venue_inquiries`) y resource Filament filtrado o segundo listado.

**Cuándo reconsiderar `hotel_id`:** solo si un 3er hotel fuerza CRUD idéntico y el equipo acepta una migración grande + Cluster Filament multi-tenant. No es el objetivo de esta semana.

### 1.2 Filament / CMS — espejo del grupo **Cigno Ermita**

Hoy Ermita queda así (no tocar salvo bugs):

```
CMS
  Páginas (CmsPageResource)          ← incluye slugs Ermita + stub Mejorada
  Artículos de prensa / Tiendita / Leads

Cigno Ermita
  Habitaciones Ermita                ← ErmitaRoomResource
  Experiencias Ermita                ← ErmitaExperienceResource
  Consultas venue                    ← VenueInquiryResource (view-only)
```

**Propuesta para Mejorada (paralelo, sin mezclar):**

```
CMS
  Páginas
    · Ermita — Inicio / Habitaciones / Restaurante / …  (existentes)
    · Mejorada — Inicio / Habitaciones / …              (nuevos slugs)

Cigno Mejorada                         ← navigationGroup nuevo
  Habitaciones Mejorada                ← MejoradaRoomResource
  Experiencias Mejorada                ← MejoradaExperienceResource (si aplica)
  Consultas venue Mejorada             ← filtrar VenueInquiry donde hotel = cigno-mejorada
                                       (o scope en el resource existente)
```

**Regla de oro admin:** un editor de Ermita no debe ver ni editar filas de Mejorada en el mismo table. Por eso **resources separados**, no un solo `RoomResource` con select de hotel.

**Chrome de página (textos, CTAs, galerías, hero):** viven en `CmsPage.content` JSON vía `app/Cms/PageFieldDefinitions.php` + toggle `cms_enabled`, igual que Ermita (`ermitaHomeSections()`, etc.).

**Entidades repetibles (rooms / experiences):** models + Filament CRUD, consumidos por `CmsContent::mejoradaRooms()` / `mejoradaExperiences()` (espejo de `ermitaRooms()` en `app/Support/CmsContent.php`).

---

## 2. Tareas de Backend y CMS (Filament)

### 2.1 Enum / CMS pages

- [ ] Extender `app/Enums/CmsPageSlug.php`:
  - Renombrar label de `Mejorada` → `Mejorada — Inicio` (mantener value `cigno-mejorada`).
  - Agregar casos (ajustar nombres a lo que confirme Figma):
    - `MejoradaRooms = 'cigno-mejorada-rooms'`
    - `MejoradaRestaurant` / `MejoradaGastronomy` (si aplica)
    - `MejoradaExperiences`
    - `MejoradaDaypass` (si aplica)
    - `MejoradaVenue` (si aplica)
    - `MejoradaContact`
- [ ] Actualizar `app/Cms/PageFieldDefinitions.php`:
  - `CmsPageSlug::Mejorada` → `mejoradaHomeSections()` (dejar de usar `hotelSections()` stub).
  - Métodos nuevos: `mejoradaRoomsSections()`, `mejoradaContactSections()`, etc.
  - Fallbacks apuntando a `mejorada.*` (lang), no a `ermita.*`.
- [ ] Ejecutar / ampliar `database/seeders/CmsPageSeeder.php` (ya itera `CmsPageSlug::cases()`).
- [ ] Extender `app/Support/CmsContent.php` con `mejoradaRooms()`, `mejoradaRoomTeasers()`, `mejoradaExperiences()` (copiar patrón Ermita + lang fallback).

### 2.2 Migraciones

- [ ] `database/migrations/XXXX_create_mejorada_rooms_table.php`  
  Shape = `ermita_rooms` (`slug`, `sort_order`, `is_published`, JSON i18n, `people`, `beds`, `exclusive`, `image`).
- [ ] `database/migrations/XXXX_create_mejorada_experiences_table.php` (si Figma lo requiere)  
  Shape = `ermita_experiences`.
- [ ] **No modificar** `create_ermita_rooms_table.php` / `create_ermita_experiences_table.php`.
- [ ] Opcional: índice/filtro documentado en `venue_inquiries.hotel` (`cigno-mejorada`); no hace falta migración si la columna ya existe (`2026_09_09_000001_create_venue_inquiries_table.php`).
- [ ] Opcional: si Contact necesita campos extra Mejorada, preferir keys en CMS page; no tocar schema de `contact_leads` salvo necesidad real.

### 2.3 Models

- [ ] `app/Models/MejoradaRoom.php` (copiar API de `ErmitaRoom`: scopes `published`/`ordered`, `localized*`, `imageUrl` / path helper).
- [ ] `app/Models/MejoradaExperience.php` (si aplica).
- [ ] Controllers:
  - [ ] `app/Http/Controllers/MejoradaRoomController.php` (espejo `ErmitaRoomController`).
  - [ ] Reutilizar `VenueInquiryController` con `hotel = cigno-mejorada` **o** `MejoradaVenueInquiryController` delgado.

### 2.4 Filament Resources / Pages

- [ ] `app/Filament/Resources/MejoradaRooms/`  
  `MejoradaRoomResource`, `Schemas/MejoradaRoomForm`, `Tables/MejoradaRoomsTable`, Pages List/Create/Edit.  
  `navigationGroup = 'Cigno Mejorada'`, `navigationSort = 1`.
- [ ] `app/Filament/Resources/MejoradaExperiences/` (si aplica).
- [ ] Venue inquiries Mejorada:
  - [ ] Opción A: filtrar `VenueInquiryResource` con tabs/scopes por `hotel`, **o**
  - [ ] Opción B: `MejoradaVenueInquiries/MejoradaVenueInquiryResource` view-only (más claro para el equipo).
- [ ] Confirmar que `CmsPageForm` ya soporta `type => gallery` (`multiple` + `reorderable`) — reutilizar sin cambios.
- [ ] Media directories: `cms/cigno-mejorada`, `cms/mejorada-rooms` (no mezclar con `cms/cigno-ermita*`).

### 2.5 Lang / nav config

- [ ] Crear `lang/es/mejorada.php` y `lang/en/mejorada.php` (fallback cuando `cms_enabled = false`).
- [ ] Ampliar `lang/es/nav.php` y `lang/en/nav.php` con keys `mejorada_*` (home, rooms, contact, …).
- [ ] Actualizar `config/navigation.php`:
  - [ ] Agregar array `'mejorada' => [...]` (espejo de `'ermita'`).
  - [ ] En `brands`, item Mejorada: `'menu' => 'mejorada'` (hoy apunta a `main`).

---

## 3. Tareas de Frontend (TALL Stack)

> **Nota stack real:** el sitio público es **Blade + Alpine + Tailwind**. Livewire se usa vía **Filament** en `/admin`. No inventar Livewire pages públicas salvo necesidad clara; preferir Blade components como Ermita.

### 3.1 Rutas (`routes/web.php`)

Reemplazar el `coming-soon` y agregar (ajustar a IA de Figma):

```php
// Ejemplo objetivo (espejo Ermita)
Route::view('/cigno-mejorada', 'cigno-mejorada')->name('cigno-mejorada');
Route::view('/cigno-mejorada/rooms', 'mejorada.rooms')->name('cigno-mejorada.rooms');
Route::get('/cigno-mejorada/rooms/{slug}', [MejoradaRoomController::class, 'show'])
    ->name('cigno-mejorada.rooms.show');
Route::view('/cigno-mejorada/contact', 'mejorada.contact')->name('cigno-mejorada.contact');
// … restaurant / experiences / daypass / venue según Figma
```

Checklist:

- [ ] Homepage Mejorada
- [ ] Rooms index + show
- [ ] Resto de páginas confirmadas en Figma
- [ ] Contact (+ thank-you) con `x-contact.form` `accent="mejorada"` `source="mejorada"`
- [ ] Venue POST (si aplica) con `hotel = cigno-mejorada`
- [ ] **No renombrar** rutas Ermita existentes

### 3.2 Estructura de vistas sugerida

```
resources/views/
  cigno-mejorada.blade.php                 ← homepage (como cigno-ermita.blade.php)
  mejorada/
    rooms.blade.php
    room-show.blade.php
    contact.blade.php
    contact-thank-you.blade.php
    … (restaurant, experiences, daypass, venue)
  components/mejorada/
    hero.blade.php
    button.blade.php                       ← variants con tokens Mejorada
    rooms-section.blade.php
    room-card.blade.php
    amenities-section.blade.php
    story-section.blade.php
    location-section.blade.php
    …
  components/layouts/
    header.blade.php                       ← ya soporta menuKey; verificar branch Mejorada
    hotel-menu.blade.php                   ← reutilizar
    footer-hotel.blade.php                 ← pasar $items del menú mejorada
```

Assets:

```
public/images/mejorada/
  hero/, rooms/, restaurant/, icons/, …
```

Checklist UI:

- [ ] Homepage compuesta por sections `x-mejorada.*` (no reutilizar `x-ermita.*` con overrides frágiles).
- [ ] Reutilizar **solo** piezas genéricas: `x-home.peek-carousel`, `x-home.booking-bar` (con `locked-hotel="cigno-mejorada"` + `accent="mejorada"`), `x-layouts.app`, `x-contact.form`.
- [ ] Booking: extender `resources/views/components/home/booking-bar.blade.php` para accent Mejorada (hoy mira `ermita` → `blue-ermita-300`).
- [ ] Tipografía: usar clases globales `type-h1`, `type-b2`, etc. de `resources/css/app.css` (ya responsive).

### 3.3 Tokens / CSS

- [ ] Definir en `resources/css/app.css` tokens de marca Mejorada, p.ej.:

```css
--color-blue-mejorada-100: …;   /* o medium-green si Figma lo confirma */
--color-blue-mejorada-300: …;
--color-blue-mejorada-500: …;
```

- [ ] Documentar en design-system (`resources/views/design-system.blade.php`) swatches Mejorada.
- [ ] **Prohibido** reutilizar `blue-ermita-*` en vistas Mejorada (salvo excepción de Figma).

### 3.4 Alpine / JS

- [ ] Reutilizar `peekCarousel` existente (usado en Ermita rooms/experiences).
- [ ] No meter JS global que asuma selectores Ermita.
- [ ] Formularios: mismo patrón Alpine mínimo que `venue-form` / contact.

---

## 4. Consideraciones de código (estándar del repo)

### 4.1 Aislamiento estricto

| Hacer | No hacer |
|-------|----------|
| Prefijos `mejorada` / `cigno-mejorada` / `Mejorada*` | Contaminar `ermita.php` lang con keys Mejorada |
| Components en `components/mejorada/` | `@if hotel === mejorada` dentro de `components/ermita/*` |
| Filament group **Cigno Mejorada** | Un solo Resource con select hotel |
| `cms(CmsPageSlug::Mejorada*)` | Hardcodear textos solo en Blade sin fallback lang |
| Assets en `public/images/mejorada/` | Sobrescribir `public/images/ermita/` |

### 4.2 CMS / frontend contract

1. Lang (`mejorada.php`) = **fallback** siempre.  
2. Activar `cms_enabled` en admin solo cuando el contenido esté cargado.  
3. Views: `$cms->text('key', 'mejorada.key')`, `$cms->asset(...)`, `$cms->gallery(...)`.  
4. Listados rooms/experiences: helpers en `CmsContent`, no queries Eloquent sueltas en Blade.

### 4.3 Filament v5 (obligatorio)

- Schemas/Tables en clases dedicadas (como `ErmitaRoomForm`).
- Actions desde `Filament\Actions\*`.
- `recordActions()`, no `actions()` legacy.
- Icons: `Heroicon::Outlined*`.
- No `->navigate(false)` hacks ni `--no-verify` en git.

### 4.4 QA / no-regresión

Antes de merge:

- [ ] Smoke Grupo: `/`, `/press`, `/shop`, `/contact`, `/cigno-club`
- [ ] Smoke Ermita: `/cigno-ermita`, rooms show, restaurant, daypass, venue, contact, admin CRUD rooms
- [ ] Smoke Mejorada: homepage + rooms + contact (+ resto Figma)
- [ ] Admin: editar página Ermita no altera contenido Mejorada y viceversa
- [ ] Mobile: tipografía `type-*` + menú hotel 1-col (ya corregido en header)

### 4.5 Orden de trabajo recomendado (esta semana)

1. [ ] Tokens CSS + `lang/*/mejorada.php` mínimo + `config/navigation.php` menú Mejorada  
2. [ ] `CmsPageSlug` + `PageFieldDefinitions` + seeder  
3. [ ] Migraciones + models + Filament Rooms  
4. [ ] Homepage Blade + sections (Figma above-the-fold primero)  
5. [ ] Rooms index/show wired a CMS  
6. [ ] Resto de páginas Figma + contact/venue  
7. [ ] Assets Drive → `public/images/mejorada/`  
8. [ ] QA no-regresión + activar `cms_enabled` por página  

---

## 5. Decisiones abiertas (resolver con Figma / negocio)

- [ ] ¿Mejorada tiene Daypass / Venue / Restaurant propios o subset?
- [ ] Color primario exacto (¿`medium-green-*` existente o nueva paleta?)
- [ ] ¿Mismo motor de booking Cloudbeds con hotel lock `cigno-mejorada`?
- [ ] ¿Experiencias compartidas con Ermita o catálogo separado? → **default: separado** (`MejoradaExperience`)
- [ ] Completar links Figma + Drive arriba

---

## 6. Glosario de archivos ancla

| Propósito | Path |
|-----------|------|
| Rutas | `routes/web.php` |
| Nav brands/menus | `config/navigation.php` |
| CMS slugs | `app/Enums/CmsPageSlug.php` |
| Field defs admin | `app/Cms/PageFieldDefinitions.php` |
| Runtime CMS | `app/Support/CmsContent.php`, `app/Support/helpers.php` |
| Ermita rooms (plantilla) | `app/Models/ErmitaRoom.php`, `app/Filament/Resources/ErmitaRooms/` |
| Homepage Ermita | `resources/views/cigno-ermita.blade.php` |
| Sections Ermita | `resources/views/components/ermita/` |
| Tokens | `resources/css/app.css` |
| Booking accent | `resources/views/components/home/booking-bar.blade.php` |

---

**Firma de arquitectura:** Mejorada = **módulo espejo de Ermita** (tablas, Filament group, views, lang, CMS slugs propios). Sin `hotel_id` transversal esta semana. Cero cambios breaking en Grupo/Ermita.
