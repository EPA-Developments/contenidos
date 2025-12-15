<?php include "include/header.php" ?>

<style>
.thank-you-area {
    padding: 100px 0;
    text-align: center;
    background-color: #f7f9fc; /* Fondo claro para destacar el contenido */
}

.thank-you-content {
    background: #ffffff;
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    max-width: 700px;
    margin: 0 auto;
}

.thank-you-content h1 {
    color: #4CAF50; /* Verde de éxito */
    font-size: 3.0rem;
    margin-bottom: 20px;
}

.thank-you-content p {
    font-size: 1.1rem;
    color: #555;
    margin-bottom: 30px;
}

.thank-you-icon {
    font-size: 6rem;
    color: #4CAF50;
    animation: scale-up 0.5s ease-out;
}

.back-home-btn {
    display: inline-block;
    background-color: #007bff; /* Azul para el botón principal */
    color: white;
    padding: 12px 25px;
    text-decoration: none;
    border-radius: 50px;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

.back-home-btn:hover {
    background-color: #0056b3;
}

/* Animación para el icono de éxito */
@keyframes scale-up {
    0% { transform: scale(0); opacity: 0; }
    80% { transform: scale(1.1); }
    100% { transform: scale(1); opacity: 1; }
}
</style>

<div class="thank-you-area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="thank-you-content">
                    
                    <div class="thank-you-icon">
                        <i class="fas fa-check-circle"></i> 
                    </div>
                    
                    <h1>¡Mensaje Enviado con Éxito!</h1>
                    
                    <p>
                        Apreciamos que te hayas puesto en contacto con nosotros. Tu consulta ha sido recibida y nuestro equipo de EPA Bienestar la revisará.
                    </p>
                    <p>
                        Te responderemos a la brevedad posible a la dirección de correo electrónico que nos proporcionaste.
                    </p>
                    
                    <div style="margin: 30px 0;">
                        
                    </div>
                    
                    <a href="/" class="default-btn back-home-btn">
                        Volver a la Página Principal
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "include/footer.php" ?>
