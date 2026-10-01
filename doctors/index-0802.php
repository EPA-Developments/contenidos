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
            <!-- Doctors will be loaded here dynamically -->
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
    $.ajax({
        url: 'http://3.110.90.102/apis/domain-doctors.php',
        method: 'GET',
        dataType: 'json',
        cache: false, // Prevents caching issues
        data: { specialization: 'Cardiology' },
        success: function(response) {
            let output = '';

            if (response.error) {
                output = `<p>${response.error}</p>`; 
            } else if (response.message) {
                output = `<p>${response.message}</p>`; 
            } else {
                response.forEach(function(doctor) {
                    output += `
                        <div class="col-lg-4 col-md-6">
                            <div class="professional-doctors-card">
                                <div class="doctors-image">
                                    <img src="${doctor.image || 'default-image.jpg'}" 
                                         title="${doctor.doctor_name}" 
                                         alt="${doctor.doctor_name} - Best Cardiologist">
                                </div>
                                <div class="doctors-content">
                                    <span>Experience: ${doctor.total_experience || 'N/A'} + years</span><br>
                                    <span>Location: ${doctor.unit || 'Unknown'}</span><br>
                                    <span>${doctor.designation || 'Doctor'}</span><br>
                                    <h3><a href="https://plataforma.epa-bienestar.com.ar/doctors/${doctor.slug || '#'}">${doctor.doctor_name}</a></h3>
                                    <a href="https://plataforma.epa-bienestar.com.ar/turnos">
                                        <button class="default-btn1">Book An Appointment</button>
                                    </a>
                                </div>
                            </div>
                        </div>`;
                });
            }
            $('#doctors-container').html(output);
        },
        error: function(xhr, status, error) {
            console.log("Error Status:", status);
            console.log("Error Details:", error);
            console.log("Response Text:", xhr.responseText);
            $('#doctors-container').html('<p>Failed to load data. Please try again.</p>');
        }
    });
});

</script>



<!-- End Professional Doctors Area -->
<?php include "../include/footer.php"; ?>
