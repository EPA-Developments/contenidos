<div class="professional-doctors-area-without-image pt-100 pb-100">
            <div class="container">
                <div class="section-title">
                    <h2>We are Experienced Healthcare Professionals</h2>
                </div>
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
WHERE speciality='$speciality' and status='Active'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
   
	echo '		
    
                 <div class="row justify-content-center">
                	<div class="col-lg-4 col-md-6">
                        <div class="professional-doctors-card">
                            <div class="doctors-image">
                                <a href="'. $row["profile"].'"><img src="'. $row["imgurl"].'" alt="'. $row["name"].'"></a>
                            </div>
                            <div class="doctors-content">
                                <span>'. $row["designation"].'</span>
                                <h3>
                                    <a href="'. $row["profile"].'">'. $row["name"].'</a>
                                </h3>
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
			
            <!--  <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="pagination-area">
                            <a href="#" class="prev page-numbers"><i class="ri-arrow-left-s-line"></i></a>
                            <span class="page-numbers current" aria-current="page">1</span>
                            <a href="#" class="page-numbers">2</a>
                            <a href="#" class="page-numbers">3</a>
                            <a href="#" class="page-numbers">4</a>
                            <span>...</span>
                            <a href="#" class="page-numbers">5</a>
                            <a href="#" class="next page-numbers"><i class="ri-arrow-right-s-line"></i></a>
                        </div>
                    </div> -->
                </div>
     </div>
        
			<!-- End -->
		