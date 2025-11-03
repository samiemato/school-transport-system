<?php include 'header.php'; 

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    
    // In a real application, you would save this to a database and/or send an email
    $success = true; // Simulating successful submission
    
    if ($success) {
        echo '<div class="alert alert-success alert-dismissible fade show mb-0 text-center" role="alert">
                Thank you for your message! We will get back to you soon.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    } else {
        echo '<div class="alert alert-danger alert-dismissible fade show mb-0 text-center" role="alert">
                There was an error sending your message. Please try again.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    }
}
?>

<!-- Page Header -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="display-5 fw-bold text-primary">Contact Us</h1>
                <p class="lead">We're here to answer any questions you may have</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Content -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 mb-5 mb-lg-0">
                <h2 class="mb-4">Send us a Message</h2>
                <form action="contact.php" method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Your Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Your Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="subject" name="subject" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Your Message</label>
                        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>
            <div class="col-lg-5">
                <h2 class="mb-4">Contact Information</h2>
                <div class="d-flex mb-4">
                    <div class="me-4">
                        <i class="fas fa-map-marker-alt fa-2x text-primary"></i>
                    </div>
                    <div>
                        <h5>Address</h5>
                        <p>123 Education Street, School District, City, 10001</p>
                    </div>
                </div>
                <div class="d-flex mb-4">
                    <div class="me-4">
                        <i class="fas fa-phone fa-2x text-primary"></i>
                    </div>
                    <div>
                        <h5>Phone</h5>
                        <p>+254 7695320640</p>
                        <p>Emergency: (+254) 184-EMER</p>
                    </div>
                </div>
                <div class="d-flex mb-4">
                    <div class="me-4">
                        <i class="fas fa-envelope fa-2x text-primary"></i>
                    </div>
                    <div>
                        <h5>Email</h5>
                        <p>info@schooltranssamino.com</p>
                        <p>support@schooltransamino.com</p>
                    </div>
                </div>
                <div class="d-flex mb-4">
                    <div class="me-4">
                        <i class="fas fa-clock fa-2x text-primary"></i>
                    </div>
                    <div>
                        <h5>Office Hours</h5>
                        <p>Monday - Friday: 7:00 AM - 7:00 PM</p>
                        <p>Saturday: 8:00 AM - 5:00 PM</p>
                        <p>Sunday: Closed</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="text-center mb-5">Find Us</h2>
                <div class="ratio ratio-16x9">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3023.621465758463!2d-74.00594938459418!3d40.71278267933057!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a1e1c2c0aab%3A0x47dcb51c74c64b33!2sEducation%20St%2C%20New%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2s!4v1622541024456!5m2!1sen!2s" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center mb-5">
                <h2 class="section-title d-inline-block">Frequently Asked Questions</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                How far in advance should I book transportation?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                We recommend booking at least 48 hours in advance for regular services. For event transportation, please book at least one week in advance to ensure availability.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                What safety measures do you have in place?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                All our drivers are thoroughly vetted, trained, and licensed. Our vehicles undergo regular maintenance and safety inspections. We also have GPS tracking in all vehicles and emergency communication systems.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                How can I track my child's vehicle?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Once you've registered and booked a service, you'll receive login credentials to our parent portal where you can track your child's vehicle in real-time.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                                What payment methods do you accept?
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                We accept all major credit cards, debit cards, and also offer the option for direct bank transfers. For regular services, we offer monthly payment plans.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFive">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive">
                                What is your cancellation policy?
                            </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                You can cancel or reschedule your booking up to 24 hours in advance without any charge. Cancellations within 24 hours may incur a partial charge depending on the service.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>