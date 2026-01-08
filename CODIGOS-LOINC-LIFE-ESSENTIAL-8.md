# 🔬 Códigos LOINC Validados para Life's Essential 8™

**Fecha de validación:** 2026-01-08
**Revisión:** 1.0
**Estado:** ✅ Validado y listo para implementación

---

## ⚠️ HALLAZGO CRÍTICO

**No existe una guía oficial de implementación FHIR para Life's Essential 8™**

Tras búsqueda exhaustiva en:
- [LOINC.org](https://loinc.org)
- [HL7 FHIR Implementation Guides](https://www.hl7.org/fhir/)
- [American Heart Association Publications](https://www.ahajournals.org/doi/10.1161/CIR.0000000000001078)
- US Core Implementation Guide

**Conclusión:** Los códigos LOINC para Life's Essential 8™ deben extraerse de recursos FHIR estándar existentes (Observation, Vital Signs) utilizando códigos individuales validados para cada componente.

---

## 📊 Tabla Completa de Códigos LOINC

| # | Métrica Life's Essential 8™ | Código LOINC Principal | Nombre LOINC | Tipo | Estado |
|---|----------------------------|------------------------|--------------|------|--------|
| **1** | **Calidad de la Dieta** | No existe código único | Mediterranean Eating Pattern (MEPA) | Custom | ⚠️ Ver alternativas |
| **2** | **Actividad Física** | 82290-8 | Frequency of moderate to vigorous aerobic physical activity | Observation | ✅ Validado |
| **3** | **Exposición a Nicotina** | 72166-2 | Tobacco smoking status | Observation | ✅ Validado |
| **4** | **Duración del Sueño** | 93832-4 | Sleep duration | Observation | ✅ Validado |
| **5** | **Índice de Masa Corporal (IMC)** | 39156-5 | Body mass index (BMI) [Ratio] | Vital Signs | ✅ Validado |
| **6** | **Lípidos en Sangre** | 43396-1 | Cholesterol non HDL [Mass/volume] in Serum or Plasma | Laboratory | ✅ Validado |
| **7** | **Glucosa en Sangre** | 4548-4 | Hemoglobin A1c/Hemoglobin.total in Blood | Laboratory | ✅ Validado |
| **8** | **Presión Arterial** | 55284-4 | Blood pressure systolic and diastolic | Vital Signs | ✅ Validado |

---

## 🔍 Detalles por Métrica

### 1️⃣ Calidad de la Dieta 🥗

**❌ NO EXISTE código LOINC único para MEPA**

#### Alternativas de Implementación:

**Opción A: QuestionnaireResponse (Recomendado)**
```json
{
  "resourceType": "QuestionnaireResponse",
  "questionnaire": "http://epa-bienestar.com.ar/Questionnaire/MEPA",
  "status": "completed",
  "item": [
    {
      "linkId": "mepa-score",
      "text": "Mediterranean Eating Pattern for Americans Score",
      "answer": [
        {
          "valueInteger": 12
        }
      ]
    }
  ]
}
```

**Opción B: Observation con código custom**
```json
{
  "resourceType": "Observation",
  "code": {
    "coding": [{
      "system": "http://epa-bienestar.com.ar/CodeSystem/le8-metrics",
      "code": "diet-quality-mepa",
      "display": "Diet Quality - MEPA Score"
    }],
    "text": "Mediterranean Eating Pattern for Americans Score"
  },
  "valueInteger": 12,
  "referenceRange": [{
    "low": {"value": 0},
    "high": {"value": 16}
  }]
}
```

**Códigos LOINC relacionados (no específicos para MEPA):**
- **75305-3**: Nutrition status
- **75283-2**: Food and nutrition history panel
- **81663-7**: Diet [Type]

**Fuentes:**
- [MEPA Screener - Rush University](https://www.rushu.rush.edu/sites/default/files/_Rush%20PDFs%20and%20Files/College%20of%20Health%20Sciences/tangney-mepa-screener-2022.pdf)
- [LOINC Nutrition Status](https://loinc.org/75305-3/)

---

### 2️⃣ Actividad Física 🏃

**✅ Código Principal: 82290-8**

#### Detalles:
- **Nombre:** Frequency of moderate to vigorous aerobic physical activity
- **Unidad:** minutos/semana (min/week)
- **Rango AHA:** 150 min/semana (mínimo), 300 min/semana (óptimo)
- **Categoría:** Observation
- **Sistema:** http://loinc.org

#### Códigos Complementarios (Exercise Vital Sign - EVS):

| Código LOINC | Nombre | Uso |
|--------------|--------|-----|
| **89574-8** | Exercise Vital Sign (EVS) | Panel completo |
| **89555-7** | Days per week of moderate to strenuous physical activity | Días/semana |
| **68516-4** | Average minutes per day of exercise | Minutos/día |
| **82290-8** | Total minutes per week (producto de 89555-7 × 68516-4) | **Usar este** |

#### Implementación Recomendada:

**Si tienes minutos/semana directos:**
```json
{
  "resourceType": "Observation",
  "status": "final",
  "category": [{
    "coding": [{
      "system": "http://terminology.hl7.org/CodeSystem/observation-category",
      "code": "activity"
    }]
  }],
  "code": {
    "coding": [{
      "system": "http://loinc.org",
      "code": "82290-8",
      "display": "Frequency of moderate to vigorous aerobic physical activity"
    }]
  },
  "valueQuantity": {
    "value": 150,
    "unit": "min/week",
    "system": "http://unitsofmeasure.org",
    "code": "min/wk"
  }
}
```

**Si calculas desde días × minutos:**
```json
{
  "resourceType": "Observation",
  "status": "final",
  "code": {
    "coding": [{
      "system": "http://loinc.org",
      "code": "89574-8",
      "display": "Exercise Vital Sign (EVS)"
    }]
  },
  "component": [
    {
      "code": {
        "coding": [{
          "system": "http://loinc.org",
          "code": "89555-7"
        }]
      },
      "valueQuantity": {
        "value": 5,
        "unit": "days/week"
      }
    },
    {
      "code": {
        "coding": [{
          "system": "http://loinc.org",
          "code": "68516-4"
        }]
      },
      "valueQuantity": {
        "value": 30,
        "unit": "min/day"
      }
    }
  ],
  "derivedFrom": [
    {
      "type": "Observation",
      "display": "Calculated: 5 days × 30 min = 150 min/week"
    }
  ]
}
```

**Fuentes:**
- [LOINC 82290-8](https://loinc.org/82290-8)
- [HL7 FHIR Physical Activity IG](https://build.fhir.org/ig/HL7/physical-activity/measures.html)
- [LOINC 68516-4](https://loinc.org/68516-4)

---

### 3️⃣ Exposición a Nicotina 🚭

**✅ Código Principal: 72166-2**

#### Detalles:
- **Nombre:** Tobacco smoking status
- **Tipo:** Coded value (códigos estándar CDC)
- **Categoría:** Social History
- **Sistema:** http://loinc.org

#### Códigos de Respuesta (Answer List LL2201-3):

| Código SNOMED CT | Display | Puntos LE8™ |
|------------------|---------|-------------|
| 266919005 | Never smoker | 100 |
| 8517006 | Ex-smoker (>5 años) | 75 |
| 8517006 | Ex-smoker (1-5 años) | 50 |
| 428041000124106 | Current some day smoker | 25 |
| 449868002 | Current every day smoker | 0 |
| 77176002 | Smoker - current status unknown | 0 |

#### Implementación:

```json
{
  "resourceType": "Observation",
  "status": "final",
  "category": [{
    "coding": [{
      "system": "http://terminology.hl7.org/CodeSystem/observation-category",
      "code": "social-history"
    }]
  }],
  "code": {
    "coding": [{
      "system": "http://loinc.org",
      "code": "72166-2",
      "display": "Tobacco smoking status"
    }]
  },
  "valueCodeableConcept": {
    "coding": [{
      "system": "http://snomed.info/sct",
      "code": "266919005",
      "display": "Never smoker"
    }]
  }
}
```

#### Extensión para Exposición Pasiva:

Life's Essential 8™ requiere capturar exposición pasiva (penalidad -20 puntos). **No hay código LOINC específico**, usar extension:

```json
{
  "extension": [{
    "url": "http://epa-bienestar.com.ar/fhir/StructureDefinition/secondhand-smoke-exposure",
    "valueBoolean": false
  }]
}
```

**Fuentes:**
- [LOINC 72166-2](https://loinc.org/72166-2)
- [LOINC Answer List LL2201-3](https://loinc.org/LL2201-3)

---

### 4️⃣ Duración del Sueño 💤

**✅ Código Principal: 93832-4**

#### Detalles:
- **Nombre:** Sleep duration
- **Unidad:** horas por día (h/day)
- **Rango AHA Adultos:** 7-9 horas = 100 puntos
- **Categoría:** Observation (History & Physical)
- **Sistema:** http://loinc.org
- **Añadido:** LOINC version 2.67

#### Implementación:

```json
{
  "resourceType": "Observation",
  "status": "final",
  "category": [{
    "coding": [{
      "system": "http://terminology.hl7.org/CodeSystem/observation-category",
      "code": "vital-signs"
    }]
  }],
  "code": {
    "coding": [{
      "system": "http://loinc.org",
      "code": "93832-4",
      "display": "Sleep duration"
    }]
  },
  "valueQuantity": {
    "value": 7.5,
    "unit": "h",
    "system": "http://unitsofmeasure.org",
    "code": "h"
  },
  "interpretation": [{
    "coding": [{
      "system": "http://terminology.hl7.org/CodeSystem/v3-ObservationInterpretation",
      "code": "N",
      "display": "Normal"
    }]
  }],
  "referenceRange": [{
    "low": {"value": 7, "unit": "h"},
    "high": {"value": 9, "unit": "h"},
    "text": "Adults: 7-9 hours per night"
  }]
}
```

#### Rangos por Edad (Life's Essential 8™):

| Edad | Rango Óptimo | Código de referencia |
|------|--------------|----------------------|
| 4-12 meses | 12-16 h | Infants |
| 1-2 años | 11-14 h | Toddlers |
| 3-5 años | 10-13 h | Preschool |
| 6-12 años | 9-12 h | School Age |
| 13-18 años | 8-10 h | Teens |
| **Adultos** | **7-9 h** | **Adults** |

**Fuentes:**
- [LOINC 93832-4](https://loinc.org/93832-4)

---

### 5️⃣ Índice de Masa Corporal (IMC) ⚖️

**✅ Código Principal: 39156-5**

#### Detalles:
- **Nombre:** Body mass index (BMI) [Ratio]
- **Fórmula:** peso (kg) / altura² (m²)
- **Unidad:** kg/m²
- **Rango AHA:** <25 = 100 puntos, ≥40 = 0 puntos
- **Categoría:** Vital Signs
- **Sistema:** http://loinc.org

#### Códigos Complementarios:

| Código LOINC | Nombre | Uso |
|--------------|--------|-----|
| **39156-5** | Body mass index (BMI) [Ratio] | **Usar este (calculado o medido)** |
| 29463-7 | Body weight | Peso corporal (nuevo estándar) |
| 3141-9 | Body weight Measured | Peso corporal (código antiguo) |
| 8302-2 | Body height | Altura corporal |

#### Implementación:

**Opción A: BMI directo (recomendado si ya calculado)**
```json
{
  "resourceType": "Observation",
  "status": "final",
  "category": [{
    "coding": [{
      "system": "http://terminology.hl7.org/CodeSystem/observation-category",
      "code": "vital-signs"
    }]
  }],
  "code": {
    "coding": [{
      "system": "http://loinc.org",
      "code": "39156-5",
      "display": "Body mass index (BMI) [Ratio]"
    }]
  },
  "valueQuantity": {
    "value": 24.5,
    "unit": "kg/m2",
    "system": "http://unitsofmeasure.org",
    "code": "kg/m2"
  }
}
```

**Opción B: Calcular desde Peso + Altura**
```php
function createBMIObservation($patientId, $weight, $height) {
    // Weight en kg, Height en metros
    $bmi = $weight / ($height * $height);

    $observation = [
        'resourceType' => 'Observation',
        'status' => 'final',
        'code' => [
            'coding' => [[
                'system' => 'http://loinc.org',
                'code' => '39156-5',
                'display' => 'Body mass index (BMI) [Ratio]'
            ]]
        ],
        'subject' => ['reference' => "Patient/{$patientId}"],
        'effectiveDateTime' => date('c'),
        'valueQuantity' => [
            'value' => round($bmi, 1),
            'unit' => 'kg/m2',
            'system' => 'http://unitsofmeasure.org',
            'code' => 'kg/m2'
        ],
        'derivedFrom' => [
            ['reference' => 'Observation/' . $weightObsId],
            ['reference' => 'Observation/' . $heightObsId]
        ]
    ];

    return createObservation($observation);
}
```

**Fuentes:**
- [LOINC 39156-5](https://loinc.org/39156-5/)
- [LOINC 29463-7 Body Weight](https://loinc.org/29463-7)
- [LOINC 8302-2 Body Height](https://loinc.org/8302-2)

---

### 6️⃣ Lípidos en Sangre (Colesterol no-HDL) 🩸

**✅ Código Principal: 43396-1**

#### Detalles:
- **Nombre:** Cholesterol non HDL [Mass/volume] in Serum or Plasma
- **Fórmula:** Colesterol Total - Colesterol HDL
- **Unidad:** mg/dL
- **Rango AHA:** <130 mg/dL = 100 puntos
- **Categoría:** Laboratory
- **Sistema:** http://loinc.org

#### ⚠️ IMPORTANTE: NO confundir con:
- **13457-7**: Cholesterol in LDL (es LDL, no non-HDL)

#### Códigos Relacionados:

| Código LOINC | Nombre | Uso |
|--------------|--------|-----|
| **43396-1** | **Cholesterol non HDL** | **Usar este para Life's Essential 8™** |
| 2093-3 | Cholesterol [Mass/volume] in Serum or Plasma | Colesterol Total |
| 2085-9 | Cholesterol in HDL [Mass/volume] in Serum or Plasma | HDL (bueno) |
| 13457-7 | Cholesterol in LDL [Mass/volume] (calculated) | LDL (calculado) |

#### Implementación:

**Opción A: non-HDL directo**
```json
{
  "resourceType": "Observation",
  "status": "final",
  "category": [{
    "coding": [{
      "system": "http://terminology.hl7.org/CodeSystem/observation-category",
      "code": "laboratory"
    }]
  }],
  "code": {
    "coding": [{
      "system": "http://loinc.org",
      "code": "43396-1",
      "display": "Cholesterol non HDL [Mass/volume] in Serum or Plasma"
    }]
  },
  "valueQuantity": {
    "value": 125,
    "unit": "mg/dL",
    "system": "http://unitsofmeasure.org",
    "code": "mg/dL"
  }
}
```

**Opción B: Calcular desde Total - HDL**
```php
function createNonHDLObservation($patientId, $totalChol, $hdlChol) {
    $nonHDL = $totalChol - $hdlChol;

    $observation = [
        'resourceType' => 'Observation',
        'status' => 'final',
        'category' => [[
            'coding' => [[
                'system' => 'http://terminology.hl7.org/CodeSystem/observation-category',
                'code' => 'laboratory'
            ]]
        ]],
        'code' => [
            'coding' => [[
                'system' => 'http://loinc.org',
                'code' => '43396-1',
                'display' => 'Cholesterol non HDL [Mass/volume] in Serum or Plasma'
            ]]
        ],
        'subject' => ['reference' => "Patient/{$patientId}"],
        'effectiveDateTime' => date('c'),
        'valueQuantity' => [
            'value' => $nonHDL,
            'unit' => 'mg/dL',
            'system' => 'http://unitsofmeasure.org',
            'code' => 'mg/dL'
        ],
        'note' => [[
            'text' => "Calculated: Total Cholesterol ({$totalChol}) - HDL ({$hdlChol}) = {$nonHDL} mg/dL"
        ]]
    ];

    return createObservation($observation);
}
```

**Fuentes:**
- [LOINC 43396-1](https://loinc.org/43396-1)
- [LOINC 13457-7 (LDL - NO usar)](https://loinc.org/13457-7)

---

### 7️⃣ Glucosa en Sangre (HbA1c) 📊

**✅ Código Principal: 4548-4** (Ya implementado en MVP)

#### Detalles:
- **Nombre:** Hemoglobin A1c/Hemoglobin.total in Blood
- **Unidad:** % (porcentaje)
- **Rango AHA:** <5.7% sin diabetes = 100 puntos
- **Categoría:** Laboratory
- **Sistema:** http://loinc.org

#### Implementación:

```json
{
  "resourceType": "Observation",
  "status": "final",
  "category": [{
    "coding": [{
      "system": "http://terminology.hl7.org/CodeSystem/observation-category",
      "code": "laboratory"
    }]
  }],
  "code": {
    "coding": [{
      "system": "http://loinc.org",
      "code": "4548-4",
      "display": "Hemoglobin A1c/Hemoglobin.total in Blood"
    }]
  },
  "valueQuantity": {
    "value": 5.5,
    "unit": "%",
    "system": "http://unitsofmeasure.org",
    "code": "%"
  },
  "interpretation": [{
    "coding": [{
      "system": "http://terminology.hl7.org/CodeSystem/v3-ObservationInterpretation",
      "code": "N",
      "display": "Normal"
    }]
  }],
  "referenceRange": [{
    "high": {"value": 5.7, "unit": "%"},
    "text": "Normal: <5.7%"
  }, {
    "low": {"value": 5.7, "unit": "%"},
    "high": {"value": 6.4, "unit": "%"},
    "text": "Prediabetes: 5.7-6.4%"
  }, {
    "low": {"value": 6.5, "unit": "%"},
    "text": "Diabetes: ≥6.5%"
  }]
}
```

**Fuentes:**
- [LOINC 4548-4](https://loinc.org/4548-4)

---

### 8️⃣ Presión Arterial 🩺

**✅ Código Principal: 55284-4** (Ya implementado en MVP)

#### Detalles:
- **Nombre:** Blood pressure systolic and diastolic
- **Componentes:** Sistólica (8480-6) + Diastólica (8462-4)
- **Unidad:** mmHg
- **Rango AHA:** <120/80 sin medicación = 100 puntos
- **Categoría:** Vital Signs
- **Sistema:** http://loinc.org

#### Implementación:

```json
{
  "resourceType": "Observation",
  "status": "final",
  "category": [{
    "coding": [{
      "system": "http://terminology.hl7.org/CodeSystem/observation-category",
      "code": "vital-signs"
    }]
  }],
  "code": {
    "coding": [{
      "system": "http://loinc.org",
      "code": "55284-4",
      "display": "Blood pressure systolic and diastolic"
    }]
  },
  "subject": {"reference": "Patient/{patientId}"},
  "effectiveDateTime": "2026-01-08T10:30:00-03:00",
  "component": [
    {
      "code": {
        "coding": [{
          "system": "http://loinc.org",
          "code": "8480-6",
          "display": "Systolic blood pressure"
        }]
      },
      "valueQuantity": {
        "value": 120,
        "unit": "mmHg",
        "system": "http://unitsofmeasure.org",
        "code": "mm[Hg]"
      }
    },
    {
      "code": {
        "coding": [{
          "system": "http://loinc.org",
          "code": "8462-4",
          "display": "Diastolic blood pressure"
        }]
      },
      "valueQuantity": {
        "value": 80,
        "unit": "mmHg",
        "system": "http://unitsofmeasure.org",
        "code": "mm[Hg]"
      }
    }
  ]
}
```

**Fuentes:**
- [LOINC 55284-4](https://loinc.org/55284-4)
- [LOINC 8480-6 Systolic](https://loinc.org/8480-6)

---

## 📋 Resumen de Implementación

### ✅ Códigos LOINC Listos para Usar (7/8)

| Métrica | LOINC | PHP Function | Complejidad |
|---------|-------|--------------|-------------|
| Presión Arterial | 55284-4 | `createBloodPressureObservation()` | 🟢 Baja (implementado) |
| Glucosa HbA1c | 4548-4 | `createHbA1cObservation()` | 🟢 Baja (implementado) |
| IMC | 39156-5 | `createBMIObservation()` | 🟢 Baja |
| Colesterol no-HDL | 43396-1 | `createNonHDLObservation()` | 🟡 Media (puede requerir cálculo) |
| Actividad Física | 82290-8 | `createPhysicalActivityObservation()` | 🟢 Baja |
| Sueño | 93832-4 | `createSleepDurationObservation()` | 🟢 Baja |
| Nicotina | 72166-2 | `createSmokingStatusObservation()` | 🟡 Media (códigos SNOMED CT) |
| **Dieta** | **N/A** | `createDietQualityQuestionnaireResponse()` | **🟠 Media-Alta** |

### ⚠️ Dieta: Solución Alternativa

**Recomendación:** Usar **QuestionnaireResponse** con MEPA score custom

```php
function createMEPAQuestionnaireResponse($patientId, $mepaScore) {
    $questionnaire = [
        'resourceType' => 'QuestionnaireResponse',
        'questionnaire' => 'http://epa-bienestar.com.ar/Questionnaire/MEPA',
        'status' => 'completed',
        'subject' => ['reference' => "Patient/{$patientId}"],
        'authored' => date('c'),
        'item' => [
            [
                'linkId' => 'mepa-total-score',
                'text' => 'MEPA Total Score (0-16)',
                'answer' => [['valueInteger' => $mepaScore]]
            ]
        ]
    ];

    // Create QuestionnaireResponse
    $token = getMedplumToken();
    $ch = curl_init(MEDPLUM_BASE_URL . '/QuestionnaireResponse');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($questionnaire));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $token,
        'Content-Type: application/fhir+json'
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 201 || $httpCode === 200) {
        $result = json_decode($response, true);
        return $result['id'];
    }

    throw new Exception('Error creating MEPA QuestionnaireResponse');
}
```

---

## 🎯 Recomendaciones Finales

### Para Implementación Opción B (8 métricas completas):

1. **✅ Usar códigos LOINC validados:** 7 de 8 métricas tienen códigos estándar
2. **⚠️ Dieta (MEPA):** Implementar con QuestionnaireResponse custom
3. **🔗 Vincular con RiskAssessment:** Crear recurso para score total LE8™
4. **📊 Dashboard:** Generar visualización con 8 gráficos de progreso
5. **🏷️ Tags:** Usar `life-essential-8` en todos los recursos para fácil búsqueda

### Estructura FHIR Recomendada:

```
Patient (DNI: 12345678)
├── Appointment (Evaluación Inicial)
├── 8 × Observations (LOINC codes)
│   ├── Blood Pressure (55284-4) ✅
│   ├── HbA1c (4548-4) ✅
│   ├── BMI (39156-5)
│   ├── Non-HDL Cholesterol (43396-1)
│   ├── Physical Activity (82290-8)
│   ├── Sleep Duration (93832-4)
│   └── Smoking Status (72166-2)
├── QuestionnaireResponse (MEPA Diet Score)
└── RiskAssessment (Life's Essential 8™ Total Score: 0-100)
```

---

## 📚 Referencias Completas

### Documentación Oficial:
- [Life's Essential 8 - AHA Circulation 2022](https://www.ahajournals.org/doi/10.1161/CIR.0000000000001078)
- [LOINC Official Database](https://loinc.org)
- [HL7 FHIR R4 Specification](https://www.hl7.org/fhir/)
- [US Core Implementation Guide](http://hl7.org/fhir/us/core/)

### Códigos LOINC Específicos:
- [82290-8 Physical Activity](https://loinc.org/82290-8)
- [93832-4 Sleep Duration](https://loinc.org/93832-4)
- [72166-2 Tobacco Smoking](https://loinc.org/72166-2)
- [39156-5 BMI](https://loinc.org/39156-5/)
- [43396-1 Non-HDL Cholesterol](https://loinc.org/43396-1)
- [4548-4 HbA1c](https://loinc.org/4548-4)
- [55284-4 Blood Pressure](https://loinc.org/55284-4)

### MEPA Diet Assessment:
- [MEPA Screener - Rush University](https://www.rushu.rush.edu/sites/default/files/_Rush%20PDFs%20and%20Files/College%20of%20Health%20Sciences/tangney-mepa-screener-2022.pdf)
- [MEPA Validation Study - PubMed](https://pubmed.ncbi.nlm.nih.gov/28168764/)

---

**Documento validado y listo para implementación de Opción B (8 métricas completas)**

✅ **Estado:** Aprobado para desarrollo
📅 **Próximo paso:** Implementar 6 funciones adicionales en `evaluacion-inicial.php`
