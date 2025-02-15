<?php 
    include 'Assets/includes/db_connect.php';
    // Fetch job listings
    $sql = "SELECT * FROM jobs ORDER BY date_posted DESC LIMIT 5";
    $result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Recruit Portal</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- AOS Animation CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <!-- css -->
    <link rel="stylesheet" href="Assets/css/style.css">
</head>
<body>
    <!-- Navigation Bar -->
    <?php include 'Assets/includes/navbar.php' ?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Welcome to Recruit Portal</h1>
            <p>Connecting talents and opportunities worldwide</p>
            <a href="signup.php" class="btn btn-primary btn-lg mt-3">Join Now</a>
        </div>

    </section>
    <!-- Latest Job Listings -->
    <section class="py-5 schcon" style="">
       <div class="container mt-4">
           <h2 class="text-center mb-5">Find Your Dream Job</h2>
           
           <!-- Search Input -->
           <div class="row mt-5">
               <div class="col-md-8 mx-auto">
                   <input type="text" id="jobSearch" class="form-control" placeholder="Search for jobs (e.g., Web Developer, Google, New York)">
               </div>
           </div>

           <!-- Results Container -->
           <div class="mt-4" id="jobResults">
               <p class="text-muted text-center text-white">Start typing to search for jobs...</p>
           </div>
       </div>
   </section>

    

    <!-- Features Section -->
    <section class="features py-5">
        <div class="container">
            <h2 class="text-center mb-5" data-aos="fade-up">Why Choose Us?</h2>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-right">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="Assets/images/kaitlyn-baker-vZJdYl5JVXY-unsplash.jpg" class="card-img-top img-fluid" alt="Find Jobs">
                        <div class="card-body text-center">
                            <h4 class="card-title">Discover Jobs</h4>
                            <p class="card-text">Find job opportunities tailored to your skills and goals.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="Assets/images/dylan-gillis-KdeqA3aTnBY-unsplash.jpg" class="card-img-top img-fluid" alt="Recruit Talents">
                        <div class="card-body text-center">
                            <h4 class="card-title">Hire Top Talents</h4>
                            <p class="card-text">Discover and hire the best professionals for your needs.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-left">
                    <div class="card border-0 shadow-sm h-100">
                        <img src="Assets/images/fabio-oyXis2kALVg-unsplash.jpg" class="card-img-top img-fluid" alt="Secure Platform">
                        <div class="card-body text-center">
                            <h4 class="card-title">Secure Platform</h4>
                            <p class="card-text">Your data is protected with state-of-the-art security measures.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="cta text-center text-white py-5">
        <div class="container">
            <h2 class="mb-3">Start Your Journey with Us</h2>
            <p>Join thousands of professionals and recruiters on our platform.</p>
            <a href="signup.php" class="btn btn-light btn-lg">Sign Up Today</a>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'Assets/includes/footer.php' ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        // Initialize AOS animations
        AOS.init();
    </script>

    <script>
        $(document).ready(function() {
            $("#jobSearch").on("keyup", function() {
                var query = $(this).val().trim();

                if (query.length > 1) {
                    $.ajax({
                        url: "search_jobs.php",
                        type: "GET",
                        data: { query: query },
                        success: function(data) {
                            $("#jobResults").html(data);
                        }
                    });
                } else {
                    $("#jobResults").html('<p class="text-muted text-center">Start typing to search for jobs...</p>');
                }
            });
        });
    </script>
</body>
</html>
