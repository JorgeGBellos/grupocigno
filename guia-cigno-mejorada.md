# Guía práctica — Cigno Mejorada (para el programador)

**Idea en una frase:** no inventes nada nuevo. **Copia Cigno Ermita**, renombra a Mejorada, cambia textos/colores/imágenes según Figma, y deja Ermita intacta.

**Stack del proyecto (simple):**
- Sitio público = Laravel + Blade + Tailwind + Alpine
- Admin = Filament en `/admin`
- Livewire **no** se usa en las páginas públicas (no hace falta crearlo)

**Hoy Mejorada es solo:** `/cigno-mejorada` → página `coming-soon`.

---

## 1. Cómo está armada Ermita (tu plantilla)

Piensa Ermita como **4 capas**. Mejorada debe tener las mismas 4:

| Capa | Qué es | Dónde está en Ermita |
|------|--------|----------------------|
| **A. Páginas web** | HTML que ve el usuario | `resources/views/cigno-ermita.blade.php` + carpeta `resources/views/ermita/` + componentes `resources/views/components/ermita/` |
| **B. Rutas** | URLs | `routes/web.php` (todo lo que empieza con `/cigno-ermita`) |
| **C. Contenido editable** | Textos/fotos del CMS + habitaciones/experiencias | Admin → **CMS → Páginas** + grupo **Cigno Ermita** |
| **D. Fallback** | Textos si el CMS está apagado | `lang/es/ermita.php` y `lang/en/ermita.php` |

### Páginas que ya tiene Ermita (míralas en el navegador)

| URL | Vista |
|-----|--------|
| `/cigno-ermita` | `resources/views/cigno-ermita.blade.php` |
| `/cigno-ermita/rooms` | `resources/views/ermita/rooms.blade.php` |
| `/cigno-ermita/rooms/{slug}` | `resources/views/ermita/room-show.blade.php` |
| `/cigno-ermita/restaurant` | `resources/views/ermita/restaurant.blade.php` |
| `/cigno-ermita/daypass` | `resources/views/ermita/daypass.blade.php` |
| `/cigno-ermita/experiences` | `resources/views/ermita/experiences.blade.php` |
| `/cigno-ermita/venue` | `resources/views/ermita/venue.blade.php` |
| `/cigno-ermita/contact` | `resources/views/ermita/contact.blade.php` |

### Admin de Ermita (para entender el CMS)

1. Entra a `/admin`
2. Grupo **CMS → Páginas** → editas textos/hero/galerías de cada subpágina
3. Grupo **Cigno Ermita → Habitaciones / Experiencias** → CRUD de items repetibles

---

## 2. Regla de oro (léela 2 veces)

| ✅ Haz esto | ❌ No hagas esto |
|------------|------------------|
| Copiar archivos Ermita → versión Mejorada | Editar archivos de Ermita “para que sirvan a los dos” |
| Prefijos: `mejorada`, `Mejorada`, `cigno-mejorada` | Mezclar datos de los dos hoteles en la misma tabla/resource |
| Componentes en `components/mejorada/` | Poner `if ($hotel === 'mejorada')` dentro de `components/ermita/` |
| Colores propios (tokens Mejorada) | Usar clases `blue-ermita-*` en vistas Mejorada |
| Probar que Ermita sigue igual al final | Romper rutas o menú de Ermita |

**Decisión del proyecto:** Mejorada = **espejo de Ermita** (tablas y resources propios). **No** uses `hotel_id` en esta fase.

---

## 3. Orden de trabajo recomendado (síguelo en este orden)

Hazlo por bloques. No saltes al diseño completo sin tener la base.

### Bloque 0 — Setup local
- [ ] Clonar/abrir el proyecto
- [ ] Copiar `.env.example` → `.env` (pedir credenciales al lead; **no** subir `.env` a git)
- [ ] `composer install`
- [ ] `npm install` y `npm run build` (o `npm run dev`)
- [ ] `php artisan key:generate` (si hace falta)
- [ ] `php artisan migrate`
- [ ] `php artisan storage:link`
- [ ] `php artisan serve` → probar `/cigno-ermita` y `/admin`

### Bloque 1 — Navegación + textos base (sin diseño perfecto aún)
- [ ] Crear `lang/es/mejorada.php` y `lang/en/mejorada.php`  
  → **Copia** `lang/es/ermita.php` / `lang/en/ermita.php` y cambia textos/keys a Mejorada
- [ ] En `lang/es/nav.php` y `lang/en/nav.php` agregar labels `mejorada_*` (home, rooms, contact, etc.)
- [ ] En `config/navigation.php`:
  - [ ] Crear menú `'mejorada' => [...]` (espejo del array `'ermita'`)
  - [ ] En brands, item Mejorada: cambiar `'menu' => 'main'` por `'menu' => 'mejorada'`

### Bloque 2 — Rutas + vistas vacías (que ya no diga “coming soon”)
En `routes/web.php`, **reemplazar** la ruta `coming-soon` de Mejorada y copiar el bloque de Ermita cambiando nombres.

Ejemplo mínimo (ajusta según Figma qué páginas existen):

```php
Route::view('/cigno-mejorada', 'cigno-mejorada')->name('cigno-mejorada');
Route::view('/cigno-mejorada/rooms', 'mejorada.rooms')->name('cigno-mejorada.rooms');
Route::get('/cigno-mejorada/rooms/{slug}', [MejoradaRoomController::class, 'show'])
    ->name('cigno-mejorada.rooms.show');
Route::view('/cigno-mejorada/contact', 'mejorada.contact')->name('cigno-mejorada.contact');
// … restaurant / experiences / daypass / venue según Figma
```

- [ ] Crear `resources/views/cigno-mejorada.blade.php` (copia de `cigno-ermita.blade.php`)
- [ ] Crear carpeta `resources/views/mejorada/` con las páginas necesarias (copia de `resources/views/ermita/`)
- [ ] Crear carpeta `resources/views/components/mejorada/` (copia de `components/ermita/`)
- [ ] Renombrar en esas vistas: `x-ermita.*` → `x-mejorada.*`, rutas `cigno-ermita` → `cigno-mejorada`, textos `__('ermita.*')` → `__('mejorada.*')`

### Bloque 3 — Colores / marca
- [ ] En `resources/css/app.css` agregar tokens Mejorada (hoy Ermita usa `--color-blue-ermita-*`)
- [ ] En los componentes Mejorada, cambiar clases `blue-ermita-*` por las nuevas
- [ ] Extender `resources/views/components/home/booking-bar.blade.php` para `accent="mejorada"` (hoy solo maneja bien `ermita`)
- [ ] Contacto: usar `x-contact.form` con `accent="mejorada"` y `source="mejorada"`

### Bloque 4 — Habitaciones (backend + admin)
**Copia literal y renombra** (no reutilices las tablas de Ermita):

| Ermita (origen) | Mejorada (crear) |
|-----------------|------------------|
| `database/migrations/..._create_ermita_rooms_table.php` | nueva migración `create_mejorada_rooms_table` |
| `app/Models/ErmitaRoom.php` | `app/Models/MejoradaRoom.php` |
| `app/Http/Controllers/ErmitaRoomController.php` | `app/Http/Controllers/MejoradaRoomController.php` |
| `app/Filament/Resources/ErmitaRooms/` | `app/Filament/Resources/MejoradaRooms/` |

En el Resource Filament:
- [ ] `navigationGroup = 'Cigno Mejorada'`
- [ ] Labels: Habitaciones Mejorada
- [ ] Disco de imágenes: `cms/mejorada-rooms` (no `cms/ermita-rooms`)

- [ ] `php artisan migrate`
- [ ] Crear 1–2 habitaciones de prueba en `/admin`
- [ ] Conectar listado y detalle en las vistas Mejorada

**Experiencias:** si Figma las pide, repite el mismo espejo con `ErmitaExperience` → `MejoradaExperience`.

### Bloque 5 — CMS de páginas (textos del sitio)
Archivos a tocar (copiando el patrón Ermita):

| Archivo | Qué hacer |
|---------|-----------|
| `app/Enums/CmsPageSlug.php` | Agregar slugs tipo `cigno-mejorada-rooms`, `cigno-mejorada-contact`, etc. (ya existe stub `cigno-mejorada`) |
| `app/Cms/PageFieldDefinitions.php` | Definir campos de cada página Mejorada (espejo de métodos `ermita*Sections`) |
| `app/Support/CmsContent.php` | Agregar helpers `mejoradaRooms()`, `mejoradaExperiences()`, etc. |
| `database/seeders/CmsPageSeeder.php` | Correr seeder para que existan las filas en admin |

En las vistas, patrón a copiar de Ermita:

```php
$cms = cms(\App\Enums\CmsPageSlug::MejoradaContact); // ejemplo
$cms->text('contact.lead_1', 'mejorada.contact.lead_1');
```

- [ ] Seedear páginas CMS
- [ ] En admin, editar una página Mejorada y ver el cambio en el frontend
- [ ] Dejar `cms_enabled` en off hasta que el contenido esté listo (así usa lang como fallback)

### Bloque 6 — Figma: ajustar diferencias visuales
Aquí es donde dejas de “clonar” y empiezas a **diferenciar**:

- [ ] Comparar Figma Mejorada vs lo que ya copiaste de Ermita
- [ ] Cambiar layout/spacing/orden de secciones solo donde Figma difiera
- [ ] Meter assets en `public/images/mejorada/` (no pises `public/images/ermita/`)
- [ ] Mobile: revisar cada página en ancho chico (menú, hero, cards, formularios)

### Bloque 7 — Formularios (si Figma los pide)
- [ ] Contacto: mismo flujo global `POST /contact` con `source=mejorada` (ver cómo lo hace Ermita)
- [ ] Venue (si aplica): reutilizar `VenueInquiryController` enviando `hotel = cigno-mejorada`
- [ ] En admin: filtrar consultas por hotel o crear resource “Consultas Mejorada”

### Bloque 8 — QA (obligatorio antes de entregar)
- [ ] `/` (Grupo) sigue bien
- [ ] `/cigno-ermita` y subpáginas siguen bien
- [ ] `/cigno-mejorada` y subpáginas nuevas funcionan
- [ ] Admin Ermita no muestra/edita datos de Mejorada y viceversa
- [ ] Desktop + mobile

---

## 4. Truco de productividad: “Find & Replace con cerebro”

Cuando copies una carpeta Ermita → Mejorada, busca y cambia con cuidado:

| Buscar | Reemplazar |
|--------|------------|
| `Ermita` | `Mejorada` |
| `ermita` | `mejorada` |
| `cigno-ermita` | `cigno-mejorada` |
| `x-ermita.` | `x-mejorada.` |
| `blue-ermita` | (token de color Mejorada) |
| `ermita_rooms` | `mejorada_rooms` |
| `Cigno Ermita` | `Cigno Mejorada` |

Luego **abre el archivo y revisa** que no hayas roto un comentario o un path compartido (`x-layouts.app`, `x-home.booking-bar`, etc. esos SÍ se reutilizan).

### Qué SÍ se reutiliza (no copies)
- `resources/views/components/layouts/app.blade.php`
- `x-home.peek-carousel`
- `x-home.booking-bar` (solo añades accent Mejorada)
- `x-contact.form`
- Modelos compartidos: `CmsPage`, `ContactLead`, `VenueInquiry`

---

## 5. Checklist “¿qué páginas hago?” (según Figma)

Marca con el lead / Figma qué aplica a Mejorada:

- [ ] Home
- [ ] Habitaciones (listado + detalle)
- [ ] Restaurante / gastronomía
- [ ] Daypass
- [ ] Experiencias
- [ ] Venue / eventos
- [ ] Contacto (+ gracias)

**Si Figma no tiene una página que Ermita sí tiene:** no la copies. Menos código = menos bugs.

---

## 6. Dudas frecuentes

**¿Tengo que saber Filament a fondo?**  
No. Copia la carpeta `app/Filament/Resources/ErmitaRooms/` completa, renombra clases/archivos, cambia `navigationGroup` y el `model`. Filament auto-descubre resources.

**¿Dónde pongo textos?**  
1. Primero en `lang/*/mejorada.php` (siempre).  
2. Después, si el cliente editará desde admin, wirea CMS con `cms()` como Ermita.

**¿Puedo tocar Ermita para “arreglar algo compartido”?**  
Solo si es un bug real compartido (layout, booking-bar genérico). Si es diseño de hotel, ve a `components/mejorada/`.

**¿Hay Livewire para el sitio?**  
No en público. No crees `app/Livewire` para esto.

---

## 7. Archivos ancla (ábreolos cuando te pierdas)

1. Rutas Ermita: `routes/web.php`
2. Home Ermita: `resources/views/cigno-ermita.blade.php`
3. Componentes: `resources/views/components/ermita/`
4. Menú: `config/navigation.php`
5. Model habitación: `app/Models/ErmitaRoom.php`
6. Admin habitaciones: `app/Filament/Resources/ErmitaRooms/ErmitaRoomResource.php`
7. CMS fields: `app/Cms/PageFieldDefinitions.php`
8. Colores: `resources/css/app.css`

---

## 8. Recursos de diseño (completar)

- Figma: `[PEGAR LINK]`
- Assets Drive: `[PEGAR LINK]`

---

## Entregable esperado

Al terminar, el lead debería poder:

1. Abrir `/cigno-mejorada` y navegar el menú del hotel
2. Entrar a `/admin` → grupo **Cigno Mejorada** y gestionar habitaciones (y lo que aplique)
3. Editar textos desde **CMS → Páginas** (slugs Mejorada)
4. Confirmar que **Grupo** y **Ermita** no se rompieron

Si algo no está en Figma, pregunta antes de inventarlo. Si está en Ermita y Figma lo pide igual, **cópialo**.
