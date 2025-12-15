
							<div class="article-leave-comment" id="book-an-appointment">
                                 <form action="" class="contact-form-wrap" onsubmit="submitForm(); return false;" method="post" autocomplete="off" id="dateForm">
								<h4>Book An Appointment</h4>
                                    <div class="row justify-content-center">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group mb-4">
                                                <label>Enter Name*</label>
                                                <input type="text" name="name" class="form-control" pattern="[a-zA-Z\s]*" maxlength="20" title="only characters are allowed" placeholder="Enter your Name" oninput="checkRepeatingCharacters(this)"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group mb-4">
                                                <label>Your Phone</label>
                                                <input type="tel" class="form-control" maxlength="10" pattern="[6789][0-9]{9}" name="phone" id="phone" required placeholder="Phone Number*" title="only numbers are allowed"> 
                                            </div>
                                        </div>
										
										<div class="col-lg-12 col-md-12">
                                            <div class="form-group mb-4">
                                                <label>Location</label>
                                                <input type="text" name="branch" class="form-control" placeholder="Enter your location" required="" />
                                    <input type="hidden" id="department" name="department" value="Cardiology" />
                                    <input type="hidden" id="source" name="source" value="website" />
                                    <input type="hidden" id="campaignid" name="campaignid" value="OTHERWEBS" />
                                    <input type="hidden" id="sourceUrl" name="url">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <button type="submit" class="default-btn">Send A Message</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </aside>
                    </div>


<script>
document.addEventListener("DOMContentLoaded", function () {
  // Ensure the input element exists before setting its value
  const sourceUrlInput = document.getElementById("sourceUrl");
  if (sourceUrlInput) {
    sourceUrlInput.value = window.location.href; // Capture current page URL
  } else {
    console.error("sourceUrl input not found in the DOM.");
  }
});


  // Function to validate name input for consecutive repeating characters
  function checkRepeatingCharacters(input) {
    const value = input.value.toLowerCase(); // Case-insensitive
    const consecutiveRepeatsRegex = /([a-z])\1{2,}/; // Matches three or more consecutive letters
    if (consecutiveRepeatsRegex.test(value)) {
      alert("Please enter a name without consecutive repeating characters.");
      input.value = "";
    }
  }

  // Function to handle phone validation on blur
  $(function () {
    $("#phone").on("blur", function () {
      const phone = $(this).val();
      if (/^(\d)\1{9}$/.test(phone)) {
        alert("Enter a valid phone number with different digits.");
        $(this).val("").focus();
      }
    });
  });

// Function to handle form submission via fetch
function submitForm() {
    var formData = new FormData(document.getElementById('dateForm'));
    fetch('https://www.medicoverhospitals.in/apis/landing-pages-api', {
        method: 'POST',
        body: new URLSearchParams(formData),
        redirect: 'follow'
    })
    .then(response => {
        console.log('Fetch response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            alert("You have been successfully submitted.");
            window.top.location.href = 'https://plataforma.epa-bienestar.com.ar/thank-you'; 
        } else {
            if (data.error) {
                alert(data.message);
            } else {
                console.error('Database insertion error:', data.message);
                alert('An error occurred. Please try againnn.');
            }
        }
    })
    .catch(error => {
       
            // Clear all form input values
    const form = document.getElementById("dateForm");
    form.querySelectorAll("input").forEach(input => input.value = "");

    // Show success message (even if there's an error, based on your code)
    //alert("You have been successfully submitted.");

    // Redirect to the thank-you page
    window.top.location.href = 'https://plataforma.epa-bienestar.com.ar/thank-you';
    });
}


</script>