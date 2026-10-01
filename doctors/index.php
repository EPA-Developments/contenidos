<?php include "../include/header.php"; ?>

<!-- Start Page Banner Area -->
<div class="page-banner-area">
    <div class="container">
        <div class="page-banner-content">
            <ul data-aos="fade-right" data-aos-delay="70" data-aos-duration="700">
                <li><a href="/">Home</a></li>
                <li>Doctors</li>
            </ul>
        </div>
    </div>
</div>
<!-- End Page Banner Area -->

<!-- Start Professional Doctors Area -->
<div class="professional-doctors-area-without-image pt-100 pb-100">
    <div class="container">
        <div class="section-title">
            <h2>We are Experienced Healthcare Professionals</h2>
        </div>
        <div class="row justify-content-center" id="doctors-container">
         <?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://emr.epa-bienestar.com.ar/apis/default/fhir/Practitioner?specialization=Cardiology',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);
curl_close($curl);

$doctors = json_decode($response, true);

if (!empty($doctors) && is_array($doctors)) {
    foreach ($doctors as $doctor) {
        ?>
        <div class="col-lg-4 col-md-6">
            <div class="professional-doctors-card">
                <div class="doctors-image">
                    <img src="<?= !empty($doctor['image']) ? $doctor['image'] : 'default-image.jpg'; ?>" 
                         title="<?= htmlspecialchars($doctor['doctor_name'] ?? 'Doctor'); ?>" 
                         alt="<?= htmlspecialchars($doctor['doctor_name'] ?? 'Doctor'); ?> - Best Cardiologist">
                </div>
                <div class="doctors-content">
                    <span>Experience: <?= htmlspecialchars($doctor['total_experience'] ?? 'N/A'); ?> + years</span><br>
                    <span>Location: <?= htmlspecialchars($doctor['unit'] ?? 'Unknown'); ?></span><br>
                    <span><?= htmlspecialchars($doctor['designation'] ?? 'Doctor'); ?></span><br>
                    <h3><a href="https://plataforma.epa-bienestar.com.ar/doctors/<?= htmlspecialchars($doctor['slug'] ?? '#'); ?>">
                        <?= htmlspecialchars($doctor['doctor_name'] ?? 'Doctor'); ?>
                    </a></h3>
                    <a href="https://plataforma.epa-bienestar.com.ar/turnos">
                        <button class="default-btn1">Book An Appointment</button>
                    </a>
                </div>
            </div>
        </div>
        <?php
    }
} else {
    echo "<p>No doctors found.</p>";
}
?>
        </div>
    </div>
</div>





<!-- End Professional Doctors Area -->
<?php include "../include/footer.php"; ?>
