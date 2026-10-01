# Biblioteca CKM-LE8

Contenidos en español alineados con la **guía 2026 AHA/ACC/ADA/ASN del síndrome
cardiovascular-renal-metabólico (Ndumele)** y con **Life's Essential 8** de la AHA, para
reutilizar en todo el ecosistema: la App y el Dashboard, Recepción y el **Plan Bienestar
100 Días®** de Segunda Opinión Médica (SOM). (Este archivo no se publica: el `.htaccess`
de la raíz bloquea los `.md`.)

## Estructura

| Archivo | Qué es |
|---|---|
| `articulos/<slug>.php` | Los **datos** de un artículo: devuelve un array (título, resumen, puntos clave, secciones, métricas LE8, estadíos CKM, fuentes). No se sirve (`articulos/.htaccess`). |
| `<slug>.php` | La página: carga la plantilla y muestra el artículo (`/biblioteca/<slug>`). |
| `_biblioteca.php` | Plantilla, metadatos (JSON-LD `MedicalWebPage`), bloque de turnos de SOM y conversión a catálogo / FHIR. |
| `index.php` | Portada de la biblioteca (`/biblioteca/`). |
| `catalogo.php` | El catálogo para el ecosistema (ver abajo). |

### Agregar un artículo

1. Copiar un archivo de `articulos/` con el nuevo `slug` y completar los datos. `tipo`:
   `ckm`, `le8`, `condicion`, `programa` o `evidencia`. `le8`: claves de
   `biblioteca_le8()`. `ckm`: estadíos 0–4 a los que aplica. Cada afirmación clínica, con su
   fuente en `fuentes` (cita + DOI).
2. Crear `<slug>.php` con las dos líneas de las otras páginas.
3. Sumarlo a `sitemap.xml`.

Los umbrales clínicos son **los mismos que usa SOM** (repo `recepcionistas`,
`src/config/ckm.ts`): si cambian ahí, se actualizan acá.

## Catálogo (reutilización en el ecosistema)

```
GET /biblioteca/catalogo                     JSON propio
GET /biblioteca/catalogo?formato=fhir        Bundle FHIR R4 (collection) de DocumentReference
Filtros (se combinan): ?le8=presion  ?ckm=2  ?tipo=evidencia
```

- Incluye los artículos de `/biblioteca` y las 11 páginas de Life's Essential 8 en español
  que ya existían en la raíz (`life-essential-8-es`, `le8-*-es`).
- **FHIR R4**: un `DocumentReference` por contenido. `category` con el tipo
  (`http://epa-bienestar.com.ar/fhir/CodeSystem/content-category`), la métrica LE8
  (`…/le8-metrica`, con su código LOINC validado) y el estadío CKM (`…/estadio-ckm`);
  `content.attachment.url` = la página; `docStatus` = `preliminary` mientras la revisión
  médica esté pendiente, `final` cuando se aprueba.
- Usos: el Dashboard muestra el material de la métrica LE8 más baja del paciente
  (`?le8=`); el Plan Bienestar 100 Días, el de su estadío (`?ckm=`); Recepción puede
  sugerir un artículo en Mensajes.

## Turnos

Cada página lleva el bloque de turnos de SOM (`include/som-turnos.php`): WhatsApp a
Recepción con el título del artículo ya escrito, o el portal con `utm_source=contenidos` y
`utm_campaign=biblioteca-<slug>` (origen del paciente en el CRM de SOM).

## Gobernanza

Todo contenido médico se publica con **revisión pendiente** hasta que lo firma el equipo
médico de SOM (Dr. Alejandro Barbagelata y Dr. Alejandro Sergio D'Alessandro). Para
aprobar un artículo, agregar a sus datos:

```php
'revision' => ['estado' => 'aprobado', 'equipo' => 'Equipo médico de Segunda Opinión Médica', 'fecha' => 'AAAA-MM-DD'],
```

Salud convencional: guías AHA/ACC, ADA, KDIGO y USPSTF; sin parámetros de medicina
funcional.

## Páginas reemplazadas

Los artículos de tipo `evidencia` reemplazan 224 páginas viejas de `blogs/` sobre
suplementos, «antioxidantes» y remedios caseros (sin respaldo en las guías). Cada
artículo lista en `reemplaza` las URLs que reemplaza, y el `.htaccess` las redirige (301).
