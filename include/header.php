        <meta charset="utf-8">
        <link rel="icon" type="image/x-icon" href="https://plataforma.epa-bienestar.com.ar/favicon.ico" sizes="32x32">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="robots" content="index, follow" />
        <link rel="stylesheet" href="https://plataforma.epa-bienestar.com.ar/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://plataforma.epa-bienestar.com.ar/css/aos.css">
        <link rel="stylesheet" href="https://plataforma.epa-bienestar.com.ar/css/animate.min.css">
        <link rel="stylesheet" href="https://plataforma.epa-bienestar.com.ar/css/meanmenu.css">
        <link rel="stylesheet" href="https://plataforma.epa-bienestar.com.ar/css/remixicon.css">
        <link rel="stylesheet" href="https://plataforma.epa-bienestar.com.ar/css/odometer.min.css">
        <link rel="stylesheet" href="https://plataforma.epa-bienestar.com.ar/css/owl.carousel.min.css">
        <link rel="stylesheet" href="https://plataforma.epa-bienestar.com.ar/css/owl.theme.default.min.css">
		<link rel="stylesheet" href="https://plataforma.epa-bienestar.com.ar/css/jquery.mCustomScrollbar.min.css">
        <link rel="stylesheet" href="https://plataforma.epa-bienestar.com.ar/css/jquery-ui.min.css">
        <link rel="stylesheet" href="https://plataforma.epa-bienestar.com.ar/css/magnific-popup.min.css">
        <link rel="stylesheet" href="https://plataforma.epa-bienestar.com.ar/css/fancybox.min.css">
        <link rel="stylesheet" href="https://plataforma.epa-bienestar.com.ar/css/selectize.min.css">
        <link rel="stylesheet" href="https://plataforma.epa-bienestar.com.ar/css/style.css">
        <link rel="stylesheet" href="https://plataforma.epa-bienestar.com.ar/css/navbar.css">
        <link rel="stylesheet" href="https://plataforma.epa-bienestar.com.ar/css/footer.css">
        <link rel="stylesheet" href="https://plataforma.epa-bienestar.com.ar/css/responsive.css">
		<!-- <script type='text/javascript' src='https://plataforma.epa-bienestar.com.ar/js/jquery-3.6.0.min.js'></script> -->
        <script src="https://plataforma.epa-bienestar.com.ar/js/jquery.min.js"></script>
<?php
$url = $_SERVER['REQUEST_URI'];
$escaped_url = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
?>
<!-- Alternate Language Links -->
<?php
$languages = [
    "x-default" => "",
    "hi" => "/hi",
    "ar" => "/ar",
    "fr" => "/fr",
    "bn" => "/bn",
    "sw" => "/sw",
    "te" => "/te",
    "ur" => "/ur",
    "mr" => "/mr",
    "ta" => "/ta",
    "ml" => "/ml",
    "so" => "/so",
    "kn" => "/kn",
    "pl" => "/pl",
    "ru" => "/ru",
    "it" => "/it",
    "es" => "/es",
    "de" => "/de",
    "fa" => "/fa",
    "ha" => "/ha",
    "am" => "/am",
    "pt" => "/pt",
    "tr" => "/tr"
];

foreach ($languages as $hreflang => $path) {
    echo '<link rel="alternate" hreflang="' . $hreflang . '" href="https://plataforma.epa-bienestar.com.ar' . $path . $escaped_url . '" />' . PHP_EOL;
}
?>
<style>
.others-options {display: flex;gap: 20px;align-items: center;flex-wrap: nowrap;}
.gt_selector {background-color: #C5C5C5 !important;color: white !important;border: none !important;padding: 10px 16px !important;border-radius: 5px !important;cursor: pointer !important;font-size: 16px !important;        text-align: center !important;min-width: 160px;}
.gt_selector:hover {background-color: #393939 !important;}
.gt_switcher_wrapper{position:static !important;}
.default-btn {display: inline-block;padding: 10px 16px;border-radius: 5px;font-size: 16px;text-align: center;cursor: pointer;text-decoration: none;}
</style>
    </head>
    <body>
        <div class="navbar-area">
            <div class="main-responsive-nav">
                <div class="container">
                    <div class="main-responsive-menu">
                        <div class="logo">
                            <a href="https://plataforma.epa-bienestar.com.ar">
                            <img src="https://plataforma.epa-bienestar.com.ar/images/logo.svg" class="black-logo" alt="image" width="40px" height="40px";>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-navbar">
                <div class="container-fluid">
                    <nav class="navbar navbar-expand-md navbar-light">
                        <a class="navbar-brand" href="https://plataforma.epa-bienestar.com.ar">
                            <img src="https://plataforma.epa-bienestar.com.ar/images/logo.svg" class="black-logo" alt="image";>
                        </a>
                        <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                            <ul class="navbar-nav m-auto">
                                <li class="nav-item"><a href="https://plataforma.epa-bienestar.com.ar" class="nav-link active">Home</a></li>
								<li class="nav-item"><a href="https://plataforma.epa-bienestar.com.ar/doctors/" class="nav-link">Doctors</a></li>
                                <li class="nav-item"><a href="#" class="nav-link">Services <i class="ri-arrow-down-s-line"></i></a>
                                    <ul class="dropdown-menu">
                                        <li class="nav-item"><a href="https://plataforma.epa-bienestar.com.ar/procedures/" class="nav-link">Treatments & Procedures </a></li>
                                        <li class="nav-item"><a href="https://plataforma.epa-bienestar.com.ar/tests-screenings/" class="nav-link">Tests & Screenings </a></li>
                                    </ul>
                                </li>
								<li class="nav-item"><a href="#" class="nav-link">Care & Conditions <i class="ri-arrow-down-s-line"></i></a>
                                    <ul class="dropdown-menu">
                                        <li class="nav-item"><a href="https://plataforma.epa-bienestar.com.ar/diseases/" class="nav-link">Diseases </a></li>
                                        <li class="nav-item"><a href="https://plataforma.epa-bienestar.com.ar/symptoms/" class="nav-link">Symptom </a></li>
                                    </ul>
                                </li>
                                <li class="nav-item"><a href="https://plataforma.epa-bienestar.com.ar/life-essential-8-es.php" class="nav-link">Life Essential 8</a></li>
                                <li class="nav-item"><a href="https://plataforma.epa-bienestar.com.ar/biblioteca/" class="nav-link">Biblioteca CKM</a></li>
								<li class="nav-item"><a href="https://docs.google.com/forms/d/e/1FAIpQLSdhYiPSN56wuZ5OCYR6N3QB6-IFnrRkYzrK365ZR6TqfZ77IQ/viewform?usp=header" class="nav-link" target="_blank">Contact</a></li>
                            </ul>
                            <div class="others-options d-flex align-items-center" style="display: flex; gap: 20px;">  
							<!-- Book Appointment Button -->
							<div class="option-item">
								<a href="https://plataforma.epa-bienestar.com.ar/turnos" class="default-btn">Pedir turno</a>
							</div>

							<!-- GTranslate Wrapper Styled as a Button -->
							<div class="option-item">
								<div class="gtranslate_wrapper"></div>
							</div>
						</div>

						<!-- GTranslate Settings -->
						<script>
							window.gtranslateSettings = {"default_language": "en","url_structure": "sub_directory","languages": ["en", "te", "mr", "ta", "kn", "hi", "pa", "ur", "ml", "bn", "gu"],"wrapper_selector": ".gtranslate_wrapper",        "horizontal_position": "right","vertical_position": "top"};
						</script>

						<!-- GTranslate Script -->
						<script src="https://cdn.gtranslate.net/widgets/latest/dropdown.js"></script>
						</div>
                    </nav>
                </div>
            </div>
            <div class="others-option-for-responsive">
                <div class="container">
                    <div class="dot-menu">
                        <div class="inner">
                            <div class="circle circle-one"></div>
                            <div class="circle circle-two"></div>
                            <div class="circle circle-three"></div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="option-inner">
                            <div class="others-options d-flex align-items-center">
                                <div class="option-item">
                                    <div class="option-item">
										<div class="gtranslate_wrapper"></div>
									</div>
                                </div>
                                <div class="option-item">
                                    <a href="https://plataforma.epa-bienestar.com.ar/turnos" class="default-btn">Pedir turno</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		
