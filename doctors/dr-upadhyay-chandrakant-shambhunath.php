<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="utf-8">
    <title>Cardiology </title>
<?php include "../include/header.php" ?>
        <!-- Start Page Banner Area -->
        <div class="page-banner-area">
            <div class="container">
                <div class="breadcrumb-section">
                <div class="container">
                  <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="/doctors/">Doctors</a></li>
                    <li class="breadcrumb-item"><span id="doctors-namee"></span></li>
                  </ul>
                </div>
              </div>
            </div>
        </div>
        <!-- End Page Banner Area -->
         <!-- Start Doctors Details Area -->
        <div class="doctors-details-area pt-100 pb-100">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-12">
                        <div class="doctors-details-image">
                            <img id="doctors-image" alt="about">
                        </div>
                    </div>

                    <div class="col-lg-9 col-md-12">
                        <div class="doctors-details-desc">
                            <div class="doctors-details-content">
                              <div class="row">
                                 <div class="col-lg-6 col-sm-12">
                                <h3 id="doctors-name"></h3>    
                                <ul class="doc-info mt-2">
                                    <li id="doctors-specialty"></li>
                                    
                                </ul>
                              </div>
                              <div class="col-lg-6 col-sm-12">
                                <img src="../images/badge.png"> <strong>Medical Registrarion Verified</strong>
                                </div>
                              </div>
                         <ul class="mb-2">
                      <li><strong>Qualification:</strong> <span id="doctors-qualification"></span></li>
                      <li><strong> Experience:</strong> <span id="doctors-experience"></span></li>
                      <li> <strong>About Doctor</strong></li>
                    </ul>
                    <p id="doctors-about"></p>
                   <div class="item d-flex align-items-center justify-content-between mb-4">
              <a href="https://plataforma.epa-bienestar.com.ar/book-appointment" class="btn btn-primary"><i class="fa fa-calendar"></i> Book Appointment</a>

              </div>
                        </div>
                    </div>
                </div>
				
				<div class="col-lg-12">
                <div class="team-details" style="background-color:#fff1ec;border-radius:20px;">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="team-details-content">
                        <div class="team-detail-title">
                          <div class="p-3">
                            <nav>
                              <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Info</button>
                                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Question &amp; Answers</button>
                              </div>
                            </nav>
                            <div class="tab-content p-3" id="nav-tabContent">
                              <div class="tab-pane fade active show" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <div class="row">
                               
                                  <div class="col-lg-4 col-md-4">
                                    <h6>
                                      <a href="javascript:void(0)">
                                        <i class="ri ri-external-link-fill"></i> Clinic </a>
                                    </h6>
                                    <p id="doctors-address"></p>
                                  </div>
                                  <div class="col-lg-4 col-md-4">
                                   <p id="doctors-timings"> </p>
                                    
                                  </div>
                                  <div class="col-lg-4 col-md-4">
                                    
                                    <h6>
                                      <i class="ri ri-bank-card-2-fill"></i> Online Fee
                                    </h6>
                                     <h6 id="doctors-fee"></h6>
                                  </div>
                                </div>
                               
                                <hr>

                                  <div class="col-lg-12 col-md-12 points">
                                    <h3 class="mt-2 mb-2">Awards and Recognitions</h3>
                                    <p id="doctors-awards"></p>
                                  </div>
                                <hr>
                                <div class="row">
                                  <div class="col-lg-6 col-md-6 points">
                                    <h3 class="mt-2 mb-2">Education</h3>
                                    <p id="doctors-education"></p>
                                  </div>
                                  <div class="col-lg-6 col-md-6 points">
                                    <h3 class="mt-2 mb-2">Memberships</h3>
                                    <p id="doctors-membership"></p>
                                  </div>
                                </div>
                                <hr>
                                <div class="row">
                                  <div class="col-lg-6 col-md-6 points">
                                    <h3 class="mt-2 mb-2">Experience</h3>
                                    <p id="doctors-experiencee"></p>
                                  </div>
                                  <div class="col-lg-6 col-md-6 points">
                                    <h3 class="mt-2 mb-2">Registrations</h3>
                                    <p id="doctors-registrations"></p>
                                  </div>
                                </div>
                 
                                
                              </div>
                              <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
				
            </div>
        </div>
		</div>
        <!-- End Doctors Details Area -->
        <script>
  // Function to fetch doctor data from API
function fetchDoctorData(doctorId) {
  fetch("https://aahassoftechsolutions.com/apis/doctors?id=" + doctorId)
    .then(response => response.json())
    .then(data => {
      if (data && Object.keys(data).length > 0) { // Check if data is not empty
        const doctor = data;

       
        console.log(doctor);

        document.getElementById("doctors-image").src = doctor.image ; 
        document.getElementById("doctors-name").innerText = doctor.doctor_name ;
        document.getElementById("doctors-namee").innerText = doctor.doctor_name ;
        document.getElementById("doctors-specialty").innerText = doctor.specialty ;
        document.getElementById("doctors-qualification").innerText = doctor.qualification ;
        document.getElementById("doctors-experience").innerText = doctor.total_experience+ "Years" ;
        document.getElementById("doctors-about").innerText = doctor.about;        
        document.getElementById("doctors-address").innerText = doctor.address_1 ;
        document.getElementById("doctors-timings").innerText = doctor.timings ;
        document.getElementById("doctors-fee").innerText = doctor.fee ;
        document.getElementById("doctors-awards").innerText = doctor.awards ;
        document.getElementById("doctors-education").innerText = doctor.education ;
        document.getElementById("doctors-membership").innerText = doctor.membership ;
        document.getElementById("doctors-experiencee").innerText = doctor.experience;
        document.getElementById("doctors-registrations").innerText = doctor.registrations ;
        
       
      } else {
        console.error("Doctor data not found or empty!");
      }
    })
    .catch(error => {
      console.error("Error fetching doctor data:", error);
    });
}


fetchDoctorData("AAHAS_CAR_074");

</script>
<?php include "../include/footer.php" ?>