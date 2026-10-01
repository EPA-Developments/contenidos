<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title></title>
  <meta name="description" content="Stay informed with the latest health tips, expert advice, and articles on wellness, medical trends, and healthy living.">
  <meta property="og:locale" content="en_US" />
  <meta property="og:type" content="website">
  <meta property="og:title" content="Blogs">
  <meta property="og:description" content="Stay informed with the latest health tips, expert advice, and articles on wellness, medical trends, and healthy living.">
  <meta property="og:url" content="https://contenidos.segundaopinionmedica.org/blogs/">
  <meta property="og:image" content="https://contenidos.segundaopinionmedica.org/images/logo.svg">
  <meta property="og:image:width" content="219" />
  <meta property="og:image:height" content="50" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="canonical" href="https://contenidos.segundaopinionmedica.org/blogs/" />
<?php include "../include/header.php" ?>
<style>
.pagination {
    margin-top: 20px;
    text-align: center;
}

.pagination-btn {
    padding: 8px 15px;
    margin: 0 5px;
    border: 1px solid #007bff;
    color: #007bff;
    text-decoration: none;
    border-radius: 5px;
    font-size: 14px;
}

.pagination-btn:hover {
    background-color: #007bff;
    color: #fff;
}

.pagination-btn.active {
    background-color: #007bff;
    color: #fff;
    font-weight: bold;
}

</style>
        <!-- Start Page Banner Area -->
        <div class="page-banner-area">
            <div class="container">
                <div class="page-banner-content">
                    <ul data-aos="fade-right">
                        <li><a href="/">Home</a></li>
                        <li>Blogs</li>
                    </ul>
                </div>
            </div>
        </div>
		<div class="blog-area-with-color ptb-100">
    <div class="container">
        <div class="row justify-content-center">

<?php
// Credenciales de la base: fuera del repositorio (include/config.php: variable de entorno
// o epa-config.php fuera de la carpeta pública). Nunca escribirlas acá.
require_once __DIR__ . '/../include/config.php';
$servername = epa_config('DB_HOST') ?? 'localhost';
$username = epa_config('DB_USER') ?? '';
$password = epa_config('DB_PASSWORD') ?? '';
$dbname = epa_config('DB_NAME') ?? '';

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection is successful
if ($conn->connect_error) {
    // El detalle va al log: en pantalla mostraría el servidor y el usuario de la base.
    error_log('blogs/index.php: no se pudo conectar a la base: ' . $conn->connect_error);
    die('No pudimos cargar los artículos en este momento.');
}

// Set the number of records per page (set this to 100)
$records_per_page = 100;  // You can adjust this to any number you want

// Get the total number of records in the table
$sql_total = "SELECT COUNT(*) AS total FROM articles";
$result_total = $conn->query($sql_total);
$row_total = $result_total->fetch_assoc();
$total_records = $row_total['total'];

// Calculate the total number of pages
$total_pages = ceil($total_records / $records_per_page);

// Get the current page number from the URL, default to 1 if not set
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Ensure the current page is between 1 and the total number of pages
$current_page = max(1, min($total_pages, $current_page));

// Calculate the starting record for the SQL query
$start_from = ($current_page - 1) * $records_per_page;

// SQL query to select records for the current page
$sql = "SELECT * FROM articles LIMIT $start_from, $records_per_page";
$result = $conn->query($sql);

// Check if there are any rows returned
if ($result->num_rows > 0) {
    // Loop through and fetch each row
    while ($row = $result->fetch_assoc()) {
        // Access the data using the column names
        echo '
            <div class="col-lg-4 col-md-6">
                <div class="single-blog-card">
                    <div class="blog-content">
                        <h3><a href="' . $row["url"] . '">' . htmlspecialchars($row["name"]) . '</a></h3>
                    </div>
                </div>
            </div>
        ';
    }
} else {
    echo "No records found.";
}

// Close the database connection
$conn->close();
?>

        </div>
    </div>
</div>

<!-- Pagination Links -->
<div class="pagination container">
    <?php
    // Display previous page link if not on the first page
    if ($current_page > 1) {
        echo '<a href="?page=' . ($current_page - 1) . '" class="pagination-btn ">Previous</a>';
    }

    // Display page numbers
    for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $current_page) {
            echo '<a href="?page=' . $i . '" class="pagination-btn active">' . $i . '</a>';
        } else {
            echo '<a href="?page=' . $i . '" class="pagination-btn ">' . $i . '</a>';
        }
    }

    // Display next page link if not on the last page
    if ($current_page < $total_pages) {
        echo '<a href="?page=' . ($current_page + 1) . '" class="pagination-btn ">Next</a>';
    }
    ?>
</div>



        
        <!-- End Blog Area -->
<?php include "../include/footer.php" ?>
