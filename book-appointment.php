<?php include "include/header.php" ?>
        <!-- Start Page Banner Area -->
        <div class="page-banner-area">
  <div class="container">
    <div class="page-banner-content">
      <ul data-aos="fade-right" data-aos-delay="70" data-aos-duration="700">
        <li><a href="/">Home</a></li>
        <li>Book an Appointment</li>
      </ul>
    </div>
  </div>
</div>
        <!-- End Page Banner Area -->
        <!-- Start Contact Area -->
        <div class="contact-area ptb-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="contact-form-wrap">
                            <h3>Book Appointment Now</h3>
                            <form action="" class="row justify-content-center" onsubmit="submitForm(); return false;" method="post" autocomplete="off" id="dateForm">
    <div class="form-group col-lg-6">
        <label>Your Name</label>
        <input type="text" name="name" class="form-control" pattern="[a-zA-Z\s]*" maxlength="20" 
               title="only characters are allowed" placeholder="Enter your Name" oninput="checkRepeatingCharacters(this)" required />
        <div class="help-block with-errors"></div>
    </div>

    <div class="form-group col-lg-6">
        <label>Your Email</label>
        <input type="email" name="mail_Id" class="form-control" required 
               data-error="Please enter your email" placeholder="Enter your email" />
        <div class="help-block with-errors"></div>
    </div>

    <div class="form-group col-lg-6">
        <label>Phone Number</label>
        <div class="position-relative">
            <input type="tel" class="form-control" maxlength="10" pattern="12345678890"
                   name="phone" id="phone" required placeholder="Phone Number*" 
                   title="only numbers are allowed" />
        </div>
        <div class="help-block with-errors"></div>
    </div>

    <div class="form-group col-lg-6">
        <label>Location</label>
        <input type="text" name="branch" class="form-control" placeholder="Enter your location" required />
        <input type="hidden" id="department" name="department" value="plataforma.epa-bienestar.com.ar" />
        <input type="hidden" id="source" name="source" value="website" />
<!--         <input type="hidden" id="campaignid" name="campaignid" value="OTHERWEBS" /> -->
        <input type="hidden" id="url" name="url" value="https://plataforma.epa-bienestar.com.ar/book-appointment" />
        <div class="help-block with-errors"></div>
    </div>

    <div class="form-group col-12 col-sm-7 col-md-8 col-lg-5 mb-0 pt-3">
        <button type="submit" class="default-btn">Book Appointment</button>
    </div>
</form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Contact Area -->

<script>

/**
 * CÓDIGO JAVASCRIPT ACTUALIZADO PARA BOOK-APPOINTMENT.PHP
 * Reemplazar el código existente en el formulario
 * 
 * Este código envía los datos del formulario a Google Apps Script
 * que luego los guarda en Google Sheets y crea recursos FHIR
 */

// ==================== CONFIGURACIÓN ====================
// Reemplazar con tu URL de Google Apps Script después del deployment
const GOOGLE_APPS_SCRIPT_URL = "https://script.google.com/macros/s/AKfycbzDkNf8wmluNoe6WiRkDV1X2IirrWTRkY-NyilThzy4/exec";

// ==================== VALIDACIONES ====================

/**
 * Valida nombre para caracteres repetidos consecutivos
 */
function checkRepeatingCharacters(input) {
  const value = input.value.toLowerCase();
  const consecutiveRepeatsRegex = /([a-z])\1{2,}/;
  
  if (consecutiveRepeatsRegex.test(value)) {
    alert("Por favor ingrese un nombre sin caracteres repetidos consecutivos.");
    input.value = "";
  }
}

/**
 * Validación de teléfono al perder foco
 * Formato argentino: 11 + 8 dígitos (código de área Buenos Aires)
 */
$(function () {
  $("#phone").on("blur", function () {
    const phone = $(this).val();
    
    // Si está vacío, es válido (campo opcional)
    if (!phone) {
      return;
    }
    
    // Verificar formato: debe empezar con 11 y tener 12 dígitos en total
    if (!/^11\d{8}$/.test(phone)) {
      alert("El número de teléfono debe comenzar con 11 y tener 12 dígitos en total (ej: 1145678901).");
      $(this).val("").focus();
      return;
    }
    
    // Verificar que no todos los dígitos después del 11 sean iguales
    const remainingDigits = phone.substring(2);
    if (/^(\d)\1{7}$/.test(remainingDigits)) {
      alert("Ingrese un número de teléfono válido con dígitos diferentes.");
      $(this).val("").focus();
    }
  });
});

// ==================== ENVÍO DEL FORMULARIO ====================

/**
 * Función principal de envío del formulario
 */
function submitForm() {
  // Mostrar indicador de carga
  showLoadingIndicator();
  
  // Obtener datos del formulario
  const formData = new FormData(document.getElementById('dateForm'));
  
  // Convertir FormData a objeto JSON
  const jsonData = {};
  formData.forEach((value, key) => {
    jsonData[key] = value;
  });
  
  // Log para debugging (comentar en producción)
  console.log('Enviando datos:', jsonData);
  
  // Enviar a Google Apps Script
  fetch(GOOGLE_APPS_SCRIPT_URL, {
    method: 'POST',
    mode: 'no-cors', // Importante para Google Apps Script
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(jsonData)
  })
  .then(response => {
    // Con no-cors, no podemos leer la respuesta
    // Asumimos éxito si no hay error de red
    console.log('Solicitud enviada exitosamente');
    hideLoadingIndicator();
    
    // Limpiar formulario
    document.getElementById("dateForm").reset();
    
    // Mostrar mensaje de éxito
    showSuccessMessage();
    
    // Redirigir después de 2 segundos
    setTimeout(() => {
      window.top.location.href = 'thank-you';
    }, 2000);
  })
  .catch(error => {
    console.error('Error al enviar:', error);
    hideLoadingIndicator();
    
    // Incluso con error, redirigir (comportamiento actual)
    // Puedes cambiar esto para mostrar un mensaje de error
    setTimeout(() => {
      window.top.location.href = 'thank-you';
    }, 1000);
  });
}

/**
 * Alternativa: Envío con mode: 'cors' (requiere configurar CORS en Apps Script)
 * Descomentar si configuras CORS en Google Apps Script
 */
function submitFormWithCORS() {
  showLoadingIndicator();
  
  const formData = new FormData(document.getElementById('dateForm'));
  const jsonData = {};
  formData.forEach((value, key) => {
    jsonData[key] = value;
  });
  
  fetch(GOOGLE_APPS_SCRIPT_URL, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(jsonData)
  })
  .then(response => response.json())
  .then(data => {
    console.log('Respuesta del servidor:', data);
    hideLoadingIndicator();
    
    if (data.success) {
      document.getElementById("dateForm").reset();
      showSuccessMessage();
      
      setTimeout(() => {
        window.top.location.href = 'thank-you';
      }, 2000);
    } else {
      showErrorMessage(data.message || 'Error al procesar la solicitud');
    }
  })
  .catch(error => {
    console.error('Error:', error);
    hideLoadingIndicator();
    showErrorMessage('Error de conexión. Por favor intente nuevamente.');
  });
}

// ==================== FUNCIONES DE UI ====================

/**
 * Muestra indicador de carga
 */
function showLoadingIndicator() {
  const submitButton = document.querySelector('button[type="submit"]');
  if (submitButton) {
    submitButton.disabled = true;
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
  }
}

/**
 * Oculta indicador de carga
 */
function hideLoadingIndicator() {
  const submitButton = document.querySelector('button[type="submit"]');
  if (submitButton) {
    submitButton.disabled = false;
    submitButton.innerHTML = 'Book Appointment';
  }
}

/**
 * Muestra mensaje de éxito
 */
function showSuccessMessage() {
  // Opción 1: Alert simple
  alert("✅ Su solicitud de cita ha sido registrada exitosamente.\n\nNos pondremos en contacto con usted pronto.");
  
  // Opción 2: Mensaje personalizado en la página (descomentar si prefieres esto)
  /*
  const successMsg = document.createElement('div');
  successMsg.className = 'alert alert-success';
  successMsg.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; padding: 20px; background: #28a745; color: white; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);';
  successMsg.innerHTML = `
    <strong>✅ ¡Éxito!</strong><br>
    Su solicitud de cita ha sido registrada.<br>
    Redirigiendo...
  `;
  document.body.appendChild(successMsg);
  
  setTimeout(() => {
    successMsg.remove();
  }, 3000);
  */
}

/**
 * Muestra mensaje de error
 */
function showErrorMessage(message) {
  alert("❌ " + message);
  
  // Opción alternativa con mensaje en la página
  /*
  const errorMsg = document.createElement('div');
  errorMsg.className = 'alert alert-danger';
  errorMsg.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; padding: 20px; background: #dc3545; color: white; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);';
  errorMsg.innerHTML = `
    <strong>❌ Error</strong><br>
    ${message}
  `;
  document.body.appendChild(errorMsg);
  
  setTimeout(() => {
    errorMsg.remove();
  }, 5000);
  */
}

// ==================== VALIDACIONES ADICIONALES ====================

/**
 * Validación de email en tiempo real
 */
$(function() {
  $('input[name="mail_Id"]').on('blur', function() {
    const email = $(this).val();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    if (email && !emailRegex.test(email)) {
      alert("Por favor ingrese un email válido.");
      $(this).focus();
    }
  });
});

/**
 * Prevenir envío múltiple del formulario
 */
let formSubmitting = false;

function submitFormWithProtection() {
  if (formSubmitting) {
    console.log("Formulario ya está siendo enviado...");
    return false;
  }
  
  formSubmitting = true;
  submitForm();
  
  // Resetear después de 5 segundos por si falla
  setTimeout(() => {
    formSubmitting = false;
  }, 5000);
  
  return false;
}

// ==================== TRACKING Y ANALYTICS (OPCIONAL) ====================

/**
 * Función para trackear el envío del formulario
 * Descomentar y configurar si usas Google Analytics o similar
 */
function trackFormSubmission(data) {
  // Google Analytics 4
  if (typeof gtag !== 'undefined') {
    gtag('event', 'form_submit', {
      'event_category': 'Appointment',
      'event_label': 'Book Appointment Form',
      'value': 1
    });
  }
  
  // Facebook Pixel
  if (typeof fbq !== 'undefined') {
    fbq('track', 'Schedule');
  }
  
  // Google Tag Manager
  if (typeof dataLayer !== 'undefined') {
    dataLayer.push({
      'event': 'appointmentBooked',
      'formLocation': data.branch,
      'formSource': data.source
    });
  }
}

// ==================== INICIALIZACIÓN ====================

/**
 * Verificar que el script URL esté configurado
 */
document.addEventListener('DOMContentLoaded', function() {
  if (GOOGLE_APPS_SCRIPT_URL.includes('AKfycbzDkNf8wmluNoe6WiRkDV1X2IirrWTRkY-NyilThzy4')) {
    console.warn('⚠️ ADVERTENCIA: Debes configurar GOOGLE_APPS_SCRIPT_URL con tu URL de Google Apps Script');
  }
});

/**
 * Agregar listener para prevenir envíos accidentales
 */
document.getElementById('dateForm')?.addEventListener('submit', function(e) {
  e.preventDefault();
  submitForm();
  return false;
});

</script>

<?php include "include/footer.php" ?>
