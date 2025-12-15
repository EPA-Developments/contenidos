
    <form method="POST" action="">
            <?php
            // Database connection
            $link = mysqli_connect("13.235.191.177", "mhcpanel_docdb", "ki@mo#roi", "mhcpanel_docdb");

            if ($link === false) {
                die("ERROR: Could not connect. " . mysqli_connect_error());
            }

            // Fetch distinct locations
            $locationQuery = "SELECT DISTINCT location FROM doctors WHERE speciality='cardiologists' AND status='Active'";
            $selectedLocation = isset($_POST['location']) ? $_POST['location'] : '';
            $experienceQuery = "";

            // Fetch experiences for the selected location
            if ($selectedLocation) {
                $experienceQuery = "SELECT DISTINCT experience FROM doctors WHERE speciality='cardiologists' AND location = '$selectedLocation' ORDER BY CAST(experience AS UNSIGNED) ASC";
            }

            $locations = mysqli_query($link, $locationQuery);
            $experiences = $selectedLocation ? mysqli_query($link, $experienceQuery) : null;
            ?>
                <div class="row align-items-center justify-content-center mt-0 mb-4">
            <!-- Location Filter -->
            <div class="col-lg-3 col-md-3 col-sm-6 mt-2">
                
                    <select id="locationFilter" name="location" class="form-control" onchange="this.form.submit()">
                        <option value="">Select Location</option>
                        <?php
                        if ($locations && mysqli_num_rows($locations) > 0) {
                            while ($row = mysqli_fetch_assoc($locations)) {
                                $loc = lcfirst($row["location"]);
                                $selected = ($loc == $selectedLocation) ? 'selected' : '';
                                echo '<option value="' . $loc . '" ' . $selected . '>' . ucfirst($row["location"]) . '</option>';
                            }
                        } else {
                            echo '<option value="">No locations available</option>';
                        }
                        ?>
                    </select>
             
            </div>

            <!-- Experience Filter -->
            <div class="col-lg-3 col-md-3 col-sm-6 mt-2">
        
                    <select id="experienceFilter" name="experience" class="form-control" onchange="this.form.submit()">
                        <option value="">Select Experience</option>
                        <?php
                        if ($selectedLocation && $experiences && mysqli_num_rows($experiences) > 0) {
                            while ($row = mysqli_fetch_assoc($experiences)) {
                                $formattedExperience = $row["experience"] . '+ years';
                                $selectedExperience = ($row["experience"] == $selectedExperience) ? 'selected' : '';
                                echo '<option value="' . $row["experience"] . '" ' . $selectedExperience . '>' . $formattedExperience . '</option>';
                            }
                        } else {
                            echo '<option value="">first select location</option>';
                        }
                        ?>
                    </select>
         
            </div>

            <?php
            // Free result sets
            if (isset($locations)) mysqli_free_result($locations);
            if (isset($experiences)) mysqli_free_result($experiences);
            ?>
            </div>
            </form>
        
    


<script>
    document.querySelector('#locationFilter').addEventListener('change', function () {
        resetExperienceFilter();

        this.form.submit();
    });

    document.querySelector('#experienceFilter').addEventListener('change', function () {
        this.form.submit();
    });

    // Function to reset the experience filter when the location changes
    function resetExperienceFilter() {
        var locationFilter = document.querySelector('#locationFilter').value;
        var experienceFilter = document.querySelector('#experienceFilter');

        if (!locationFilter) {
            experienceFilter.innerHTML = '<option value="">Select Experience</option>';
        } else {
            fetchExperiences(locationFilter);
        }
    }

    // Function to fetch experiences based on selected location
    function fetchExperiences(location) {
        var experienceFilter = document.querySelector('#experienceFilter');
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "index.php?location=" + location + "&action=fetch_experiences", true);
        xhr.onload = function () {
            if (xhr.status == 200) {
                var data = JSON.parse(xhr.responseText);
                experienceFilter.innerHTML = '<option value="">Select Experience</option>';
                data.forEach(function (experience) {
                    experienceFilter.innerHTML += '<option value="' + experience + '">' + experience + '+ years</option>';
                });
            }
        };
        xhr.send();
    }

    // Fetch experiences when the page loads if location is selected
    if (document.querySelector('#locationFilter').value) {
        fetchExperiences(document.querySelector('#locationFilter').value);
    }
</script>