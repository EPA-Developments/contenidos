<?php include "include/header.php" ?>
        <!-- Start Page Banner Area -->
        <div class="page-banner-area">
            <div class="container">
                <div class="page-banner-content">
                    <ul data-aos="fade-right" data-aos-delay="70" data-aos-duration="700">
                        <li><a href="/">Home</a></li>
                        <li>Doctors One</li>
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
                 <div class="row justify-content-center">

<?php
$servername = "13.235.191.177";
$username = "mhcpanel_docdb";
$password = "ki@mo#roi";
$dbname = "mhcpanel_docdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * from doctors 
WHERE speciality='cardiologists' and status='Active'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
   
    echo '      
    
                 
               
                    <div class="col-lg-4 col-md-6">
                        <div class="professional-doctors-card">
                            <div class="doctors-image">
                                <img src="https://bestcardiologists.in'. $row["imgurl1"].'" alt="'. $row["name"].'">
                            </div>
                            <div class="doctors-content">
                                <span>'. $row["designation"].'</span>
                                <h3>'. $row["name"].'</h3>
                            </div>
                        </div>
                      </div>
                    
               
             

                    '
                    ;
  }
} else {
  echo "0 results";
}
$conn->close();
?>
  </div>
</div>
     </div>
            
          
        
        <!-- End Professional Doctors Area -->
<?php include "include/footer.php" ?>
