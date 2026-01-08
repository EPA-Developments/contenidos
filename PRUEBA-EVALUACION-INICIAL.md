# 🚀 Prototipo MVP - Evaluación Inicial FHIR R4

## 📋 Resumen

Este es un **prototipo mínimo viable** para validar la integración con la API FHIR R4 de Medplum antes de escalar a las 8 métricas completas de Life's Essential 8.

## ✅ ¿Qué hace este prototipo?

### 1. **Búsqueda/Creación de Pacientes**
- Busca pacientes existentes por DNI usando identificador FHIR
- Crea nuevo recurso `Patient` si no existe
- Evita duplicados automáticamente

### 2. **Creación de Appointments**
- Agenda automáticamente un turno para el próximo jueves a las 14:00hs
- Vincula al paciente y al Dr. D'Alessandro
- Estado: `proposed` (propuesto)

### 3. **Creación de Observations (2 métricas MVP)**

| Métrica | Código LOINC | Recurso FHIR | Estado |
|---------|--------------|--------------|--------|
| **Presión Arterial** | 55284-4 | Observation (vital-signs) | ✅ Implementado |
| **Glucosa (HbA1c)** | 4548-4 | Observation (laboratory) | ✅ Implementado |

## 🧪 Cómo Probar

### Opción A: Navegador Web

1. Accede a: `https://plataforma.epa-bienestar.com.ar/evaluacion-inicial.php`

2. Completa el formulario con datos de prueba:
   ```
   Nombre Completo: Juan Pérez Test
   DNI: 12345678
   Sexo: Masculino
   Teléfono: +54 11 1234-5678
   Email: juan.test@example.com

   Presión Sistólica: 120
   Presión Diastólica: 80
   HbA1c: 5.5
   ```

3. Click en "🚀 Enviar Evaluación a API FHIR"

4. **Resultado esperado:**
   ```
   ✅ ¡Evaluación inicial registrada exitosamente!

   📋 Resultados de la integración:
   - Patient: created (ID: xxxxx-xxxxx-xxxxx)
   - Appointment: 16/01/2026 14:00 (ID: yyyyy-yyyyy-yyyyy)
   - Observations creadas:
     • Blood Pressure: 120/80 mmHg (ID: zzzzz-zzzzz-zzzzz)
     • HbA1c: 5.5% (ID: aaaaa-aaaaa-aaaaa)
   ```

5. **Validar en Medplum:**
   - Login: https://app.medplum.com/
   - Ir a: Patients → Buscar DNI "12345678"
   - Verificar: Appointment, Observations

### Opción B: Prueba con DNI Existente

1. Corre el formulario con el mismo DNI (12345678)
2. **Resultado esperado:**
   ```
   Patient: existing (ID: xxxxx-xxxxx-xxxxx)
   ```
3. Debe reutilizar el Patient existente y solo crear nuevo Appointment + Observations

### Opción C: Testing con cURL

```bash
curl -X POST https://plataforma.epa-bienestar.com.ar/evaluacion-inicial.php \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -H "X-Requested-With: XMLHttpRequest" \
  -d "nombre_completo=Juan Pérez&dni=12345678&sexo=male&telefono=+541112345678&email=juan@test.com&presion_sistolica=120&presion_diastolica=80&hba1c=5.5"
```

**Respuesta JSON esperada:**
```json
{
  "success": true,
  "message": "¡Evaluación inicial registrada exitosamente!",
  "data": {
    "patient": {
      "id": "xxxxx-xxxxx-xxxxx",
      "status": "created",
      "message": "Nuevo paciente creado"
    },
    "appointment": {
      "id": "yyyyy-yyyyy-yyyyy",
      "datetime": "16/01/2026 14:00"
    },
    "observations": [
      {
        "type": "Blood Pressure",
        "id": "zzzzz-zzzzz-zzzzz",
        "value": "120/80 mmHg"
      },
      {
        "type": "HbA1c",
        "id": "aaaaa-aaaaa-aaaaa",
        "value": "5.5%"
      }
    ]
  }
}
```

## 🔍 Validación de Recursos FHIR

### Patient Resource
```
GET https://api.epa-bienestar.com.ar/fhir/R4/Patient?identifier=http://www.renaper.gob.ar/dni|12345678
```

### Appointment Resource
```
GET https://api.epa-bienestar.com.ar/fhir/R4/Appointment?patient=Patient/{patient_id}
```

### Observations
```
GET https://api.epa-bienestar.com.ar/fhir/R4/Observation?patient=Patient/{patient_id}&code=55284-4
GET https://api.epa-bienestar.com.ar/fhir/R4/Observation?patient=Patient/{patient_id}&code=4548-4
```

## ✅ Criterios de Éxito del MVP

| Criterio | Estado | Notas |
|----------|--------|-------|
| Autenticación OAuth2 funciona | ⏳ Por validar | Token de Medplum |
| Patient se crea correctamente | ⏳ Por validar | Con identificador DNI |
| Patient existente se encuentra | ⏳ Por validar | No duplica |
| Appointment se crea | ⏳ Por validar | Con participantes |
| Observation Presión Arterial | ⏳ Por validar | LOINC 55284-4 |
| Observation HbA1c | ⏳ Por validar | LOINC 4548-4 |
| Formulario HTML funciona | ⏳ Por validar | Validación JS |
| Manejo de errores | ⏳ Por validar | Try-catch + mensajes |

## 🐛 Posibles Errores y Soluciones

### Error 401: Unauthorized
```
Causa: Token de Medplum inválido o expirado
Solución: Verificar CLIENT_ID y CLIENT_SECRET en líneas 15-16
```

### Error 400: Bad Request
```
Causa: Estructura FHIR inválida
Solución: Revisar JSON de recurso, validar con FHIR Validator
```

### Error 404: Patient not found
```
Causa: DNI no existe y creación falló
Solución: Verificar endpoint /Patient y permisos del proyecto
```

## 📊 Métricas de Complejidad

| Componente | LOC | Complejidad | Tiempo Dev |
|------------|-----|-------------|------------|
| Patient functions | ~150 | 🟢 Baja | 2h |
| Appointment function | ~80 | 🟢 Baja | 1h |
| Observations (2) | ~200 | 🟡 Media | 2h |
| Formulario HTML | ~400 | 🟢 Baja | 1h |
| **TOTAL** | **~830** | **🟢 Baja** | **6h** |

## 🎯 Próximos Pasos (Post-MVP)

Una vez validado el MVP:

### Fase 1: Expandir Observations (6 métricas restantes)
- IMC (calculado de peso/altura)
- Colesterol no-HDL
- Actividad Física
- Dieta (score MEPA)
- Sueño
- Nicotina

### Fase 2: Calcular Score Life's Essential 8
- Algoritmos de puntuación 0-100
- RiskAssessment resource
- Dashboard de resultados

### Fase 3: Integración completa
- Goals personalizados
- CarePlan estructurado
- Seguimiento longitudinal

## 📝 Notas Técnicas

### Códigos LOINC Utilizados
- **55284-4**: Blood pressure systolic and diastolic
- **8480-6**: Systolic blood pressure (componente)
- **8462-4**: Diastolic blood pressure (componente)
- **4548-4**: Hemoglobin A1c/Hemoglobin.total in Blood

### Sistema de Identificadores
- DNI: `http://www.renaper.gob.ar/dni`
- Tags: `http://epa-bienestar.com.ar/tags`

### Timezone
- Todas las fechas en: `America/Argentina/Buenos_Aires`
- Formato: ISO 8601 (date('c'))

---

## ❓ Preguntas Frecuentes

**P: ¿Por qué solo 2 métricas en el MVP?**
R: Para validar la integración FHIR antes de escalar. Presión y Glucosa son las más críticas y simples.

**P: ¿Qué pasa si el DNI ya existe?**
R: Se reutiliza el Patient existente y solo se crea nuevo Appointment + Observations.

**P: ¿Los Appointments son automáticos?**
R: Sí, se agenda automáticamente para el próximo jueves 14:00hs. En producción sería con selección de fecha.

**P: ¿Dónde están las otras 6 métricas?**
R: Se agregarán después de validar este MVP. El código está modularizado para fácil expansión.

---

**Creado:** 2026-01-08
**Versión:** 1.0 MVP
**Estado:** 🟡 Pendiente de testing
