<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Laboratory Information Management System</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="{{ asset('admin_assets\img\photos\icontitle.png') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('depan_assets/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('depan_assets/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('depan_assets/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('depan_assets/lib/twentytwenty/twentytwenty.css') }}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('depan_assets/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('depan_assets/css/style.css') }}" rel="stylesheet">
</head>

<body>


    <!-- Topbar Start -->
    <div class="container-fluid bg-light ps-5 pe-0 d-none d-lg-block">
        <div class="row gx-0">
            <div class="col-md-6 text-center text-lg-start mb-2 mb-lg-0">
                <div class="d-inline-flex align-items-center">
                    <small class="py-2"><i class="far fa-clock text-primary me-2"></i>Opening Hours: 24 Hours </small>
                </div>
            </div>
            <div class="col-md-6 text-center text-lg-end">
                <div class="position-relative d-inline-flex align-items-center bg-primary text-white top-shape px-5">
                    <div class="me-3 pe-3 border-end py-2">
                        <p class="m-0"><i class="fa fa-envelope-open me-2"></i>selfira.arum@timahindustri.com</p>
                    </div>
                    <div class="py-2">
                        <p class="m-0"><i class="fa fa-phone-alt me-2"></i>+62 12345678</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow-sm px-5 py-3 py-lg-0">
        <a href="index.html" class="navbar-brand p-0">
            <img src="{{ asset('depan_assets/img/timah.png') }}" alt="DentCare Logo" style="height: 65px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="index.html" class="nav-item nav-link active">Home</a>

            </div>
        
            <a href="{{ route('login') }}" class="btn btn-primary pyS-2 px-4 ms-3">Login</a>
        </div>
    </nav>
    <!-- Navbar End -->


    <!-- Full Screen Search Start -->
    <div class="modal fade" id="searchModal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content" style="background: rgba(9, 30, 62, .7);">
                <div class="modal-header border-0">
                    <button type="button" class="btn bg-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center justify-content-center">
                    <div class="input-group" style="max-width: 600px;">
                        <input type="text" class="form-control bg-transparent border-primary p-3" placeholder="Type search keyword">
                        <button class="btn btn-primary px-4"><i class="bi bi-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Full Screen Search End -->


    <!-- Carousel Start -->
    <div class="container-fluid p-0">
        <div id="header-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="w-100" src="{{ asset('depan_assets/img/carousel-1.jpg') }}" alt="Image">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3" style="max-width: 900px;">
                            <h5 class="text-white text-uppercase mb-3 animated slideInDown">Streamline Your Lab Operations</h5>
                            <h1 class="display-1 text-white mb-md-4 animated zoomIn">Power Your Lab with Smart LIMS Solutions</h1>
                            <a href="{{ route('login') }}" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Login</a>
                            <a href="{{ route('register') }}" class="btn btn-secondary py-md-3 px-md-5 animated slideInRight">Register</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="w-100" src="{{ asset('depan_assets/img/carousel-2.jpg') }}" alt="Image">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3" style="max-width: 900px;">
                            <h5 class="text-white text-uppercase mb-3 animated slideInDown">Efficient Lab Management Starts Here</h5>
                            <h4 class="display-1 text-white mb-md-4 animated zoomIn">Simplify, Automate with Our LIMS Technology</h4>
                            <a href="{{ route('login') }}" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Login</a>
                            <a href="{{ route('register') }}" class="btn btn-secondary py-md-3 px-md-5 animated slideInRight">Register</a>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#header-carousel"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <!-- Carousel End -->


    <!-- Banner Start -->



    <!-- About Start -->
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-7">
                    <div class="section-title mb-4">
                        <h5 class="position-relative d-inline-block text-primary text-uppercase">About Us</h5>
                        <h1 class="display-5 mb-0">PT Timah Industri</h1>
                    </div>
                    <h4 class="text-body fst-italic mb-4">From <span style="color: green;">Green</span> Metal to <span style="color: green;">Green</span> Chemical</h4>

                    <p class="mb-4">
                    The company was founded on June 18, 1998 with shares of PT Timah Tbk of 99.99% and PT Timah Investasi Mineral of 0.01%.
 
 The establishment of the company was intended as an expansion of the business of PT Timah Tbk, which is a merger of several mining and smelting operational support divisions under the coordination of PT Timah Tbk, which includes: Workshop and Construction, Warehouse, PLTD (Electricity Power), Transportation Sea (Seafright), Metal Casting Plant and Oxygen Plant (Casting Plant & Oxygent Plant).
                    </p>
                    <div class="row g-3">
    <div class="col-12 wow zoomIn" data-wow-delay="0.3s">
        <h4 class="text-primary fw-bold">
            <i class="fa fa-lightbulb text-warning me-2"></i> Our Motto
        </h4>
        <h5 class="text-dark">3 E: "Effective, Efficient, and Excellence" in all Company Aspect</h5>
    </div>
</div>


                  
                </div>
                <div class="col-lg-5" style="min-height: 500px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute w-100 h-100 rounded wow zoomIn" data-wow-delay="0.9s" src="{{ asset('depan_assets/img/depan.jpg') }}" style="object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


<!-- Appointment Start -->
<div class="container-fluid bg-primary bg-appointment my-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <div class="row gx-5 align-items-center">
            <div class="col-lg-6 py-5">
                <div class="py-5">
                    <h1 class="display-5 text-white mb-4">Laboratory Information Management System</h1>
                    <p class="text-white mb-0">What is a LIMS? A Laboratory Information Management System (LIMS) is software that allows you to effectively manage samples and associated data. By using a LIMS, your lab can automate workflows, integrate instruments, and manage samples and associated information.</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="appointment-form d-flex justify-content-center align-items-center wow zoomIn" data-wow-delay="0.2s" style="height: 100%; padding: autopx;">
                    <img src="{{ asset('depan_assets/img/lims.png') }}" alt="Appointment Image" class="img-fluid rounded" style="max-width: 100%; height: auto; max-height: auto;">
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Appointment End -->


    <!-- Service Start -->
    <div class="container-fluid py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <!-- Section Header -->
        <div class="row g-5 mb-5">
            <div class="col-lg-5 wow zoomIn" data-wow-delay="0.3s" style="min-height: 400px;">
                <div class="twentytwenty-container position-relative h-100 rounded overflow-hidden shadow-sm">
                    <img class="position-absolute w-100 h-100" src="{{ asset('depan_assets/img/tinchemical.jpg') }}" style="object-fit: cover;">
                    <img class="position-absolute w-100 h-100" src="{{ asset('depan_assets/img/tinsolder.jpg') }}" style="object-fit: cover;">
                </div>
            </div>
            <div class="col-lg-7">
                <div class="section-title mb-5">
                    <h5 class="position-relative d-inline-block text-primary text-uppercase">Our Products</h5>
                    <h1 class="display-5 mb-0">Tin Chemical and Tin Solder</h1>
                    <p class="text-muted">Discover our range of high-quality Tin Chemical and Tin Solder products designed to meet the highest industrial standards. We provide reliable solutions for various applications, ensuring efficiency and durability.</p>
                </div>
                <div class="row g-5">
                    <div class="col-md-6 service-item wow zoomIn" data-wow-delay="0.6s">
                        <div class="rounded-top overflow-hidden shadow-sm">
                            <img class="img-fluid" src="{{ asset('depan_assets/img/mt620.jpg') }}" alt="BANKASTAB® MT-620">
                        </div>
                        <div class="position-relative bg-light rounded-bottom text-center p-4">
                            <h5 class="m-0">BANKASTAB® MT-620</h5>
                        </div>
                    </div>
                    <div class="col-md-6 service-item wow zoomIn" data-wow-delay="0.9s">
                        <div class="rounded-top overflow-hidden shadow-sm">
                            <img class="img-fluid" src="{{ asset('depan_assets/img/top207.jpg') }}" alt="TIN ONE PACK TOP® 207">
                        </div>
                        <div class="position-relative bg-light rounded-bottom text-center p-4">
                            <h5 class="m-0">TIN ONE PACK TOP® 207</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Products -->
        <div class="row g-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="col-lg-7">
                <div class="row g-5">
                    <div class="col-md-6 service-item wow zoomIn" data-wow-delay="0.3s">
                        <div class="rounded-top overflow-hidden shadow-sm">
                            <img class="img-fluid" src="{{ asset('depan_assets/img/banka307.jpg') }}" alt="BANKAESA 307">
                        </div>
                        <div class="position-relative bg-light rounded-bottom text-center p-4">
                            <h5 class="m-0">BANKAESA 307</h5>
                        </div>
                    </div>
                    <div class="col-md-6 service-item wow zoomIn" data-wow-delay="0.6s">
                        <div class="rounded-top overflow-hidden shadow-sm">
                            <img class="img-fluid" src="{{ asset('depan_assets/img/bankaesasnpb.jpg') }}" alt="BANKAESA SnPb6040">
                        </div>
                        <div class="position-relative bg-light rounded-bottom text-center p-4">
                            <h5 class="m-0">BANKAESA SnPb6040</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 service-item wow zoomIn" data-wow-delay="0.9s">
                <div class="position-relative bg-primary rounded h-100 d-flex flex-column align-items-center justify-content-center text-center p-4 shadow-sm">
                    <h3 class="text-white mb-3">Learn More About Our Products</h3>
                    <p class="text-white mb-3">Visit our official website for detailed information:</p>
                    <a href="https://www.timahindustri.com/product" class="btn btn-light text-primary fw-bold px-4 py-2 rounded">Visit Website</a>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Service End -->



    <!-- Newsletter Start -->
    <div class="container-fluid position-relative pt-5 wow fadeInUp" data-wow-delay="0.1s" style="z-index: 1;">

    </div>
    <!-- Newsletter End -->
    

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light py-5 wow fadeInUp" data-wow-delay="0.3s" style="margin-top: -75px;">
        <div class="container pt-5">
            <div class="row g-5 pt-4">
                <div class="col-lg-3 col-md-6">
                    <h3 class="text-white mb-4">Quick Links</h3>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-light mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Home</a>
                        <!-- <a class="text-light mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>About Us</a>
                        <a class="text-light mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Our Services</a>
                        <a class="text-light mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Latest Blog</a>
                        <a class="text-light" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Contact Us</a> -->
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h3 class="text-white mb-4">Popular Links</h3>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-light mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Home</a>
                        <!-- <a class="text-light mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>About Us</a>
                        <a class="text-light mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Our Services</a>
                        <a class="text-light mb-2" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Latest Blog</a>
                        <a class="text-light" href="#"><i class="bi bi-arrow-right text-primary me-2"></i>Contact Us</a> -->
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h3 class="text-white mb-4">Get In Touch</h3>
                    <p class="mb-2"><i class="bi bi-geo-alt text-primary me-2"></i>Jl. Eropa I Kav. A3 Kawasan Industri Krakatau I, Kel. Kotasari, Kec.Gerogol,
                                    Kota Cilegon, Provinsi Banten - Indonesia
                                    Kode Pos: 42436</p>
                    <p class="mb-2"><i class="bi bi-envelope-open text-primary me-2"></i>selfira.arum@timahindustri.com</p>
                    <p class="mb-0"><i class="bi bi-telephone text-primary me-2"></i>+62 12345678</p>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h3 class="text-white mb-4">Follow Us</h3>
                    <div class="d-flex">
                        <a class="btn btn-lg btn-primary btn-lg-square rounded me-2" href="#"><i class="fab fa-twitter fw-normal"></i></a>
                        <a class="btn btn-lg btn-primary btn-lg-square rounded me-2" href="#"><i class="fab fa-facebook-f fw-normal"></i></a>
                        <a class="btn btn-lg btn-primary btn-lg-square rounded me-2" href="#"><i class="fab fa-linkedin-in fw-normal"></i></a>
                        <a class="btn btn-lg btn-primary btn-lg-square rounded" href="#"><i class="fab fa-instagram fw-normal"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid text-light py-4" style="background: #051225;">
        <div class="container">
            <div class="row g-0">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-md-0">&copy; <a class="text-white border-bottom" href="#">LIMS</a>. PT Timah Industri</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="mb-0">Designed by <a class="text-white border-bottom" href="https://www.instagram.com/diieal/?locale=gb&hl=am-et">diieal</a></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('depan_assets/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('depan_assets/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('depan_assets/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('depan_assets/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('depan_assets/lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('depan_assets/lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('depan_assets/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('depan_assets/lib/twentytwenty/jquery.event.move.js') }}"></script>
    <script src="{{ asset('depan_assets/lib/twentytwenty/jquery.twentytwenty.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('depan_assets/js/main.js') }}"></script>
</body>

</html>