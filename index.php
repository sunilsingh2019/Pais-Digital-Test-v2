<?php
// Include the email handler and process form BEFORE any HTML output
require_once 'includes/email-handler.php';

// Check for success parameter from redirect
$success = isset($_GET['success']) && $_GET['success'] == '1';

if (!$success && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize the contact form handler and process form
    $contactForm = new ContactFormHandler();
    $contactForm->processForm();
    $errors = $contactForm->getErrors();
    $success = $contactForm->isSuccess();
    $formData = $contactForm->getFormData();
} else {
    // If showing success from redirect or GET request, initialize empty form data
    $errors = [];
    $formData = [
        'fullName' => '',
        'email' => '',
        'phone' => '',
        'country' => '',
        'message' => ''
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pais Digital - Digital Excellence & Innovation</title>
    <meta name="description" content="Transform your business with cutting-edge digital solutions. Pais Digital delivers innovative web development, digital marketing, and technology services that drive growth.">
    <meta name="keywords" content="digital transformation, web development, digital marketing, SEO, e-commerce, technology solutions, Pais Digital">
    <meta name="author" content="Pais Digital">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://paisdigital.com.au/">
    <meta property="og:title" content="Pais Digital - Digital Excellence & Innovation">
    <meta property="og:description" content="Transform your business with cutting-edge digital solutions and innovative technology services.">
    <meta property="og:image" content="https://www.paisdigital.com.au/wp-content/uploads/2020/06/pd-logo-resized.png.webp">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://paisdigital.com.au/">
    <meta property="twitter:title" content="Pais Digital - Digital Excellence & Innovation">
    <meta property="twitter:description" content="Transform your business with cutting-edge digital solutions and innovative technology services.">
    <meta property="twitter:image" content="https://www.paisdigital.com.au/wp-content/uploads/2020/06/pd-logo-resized.png.webp">
    
    <!-- Preconnect for performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico">
    
    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "Pais Digital",
        "url": "https://paisdigital.com.au",
        "logo": "https://www.paisdigital.com.au/wp-content/uploads/2020/06/pd-logo-resized.png.webp",
        "description": "Digital excellence and innovation services including web development, digital marketing, and technology solutions."
    }
    </script>
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <div class="navbar-brand-container d-flex align-items-center">
                <img src="https://www.paisdigital.com.au/wp-content/uploads/2020/06/pd-logo-resized.png.webp" 
                     alt="Pais Digital Logo" class="logo">
                <h1 class="navbar-brand ms-3">Digital Innovation</h1>
            </div>
            
            <!-- Mobile menu button -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Navigation menu -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#hero">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section" id="hero">
        <!-- Floating Elements -->
        <div class="hero-floating-elements">
            <div class="floating-shape"></div>
            <div class="floating-shape"></div>
            <div class="floating-shape"></div>
            <div class="floating-shape"></div>
        </div>
        
        <div class="hero-content">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-lg-10 col-xl-9">
                        <h1 class="hero-title">Transform Your Digital Future</h1>
                        <p class="hero-subtitle">Empowering businesses with cutting-edge digital solutions, innovative web development, and strategic technology services that drive measurable growth and success in the digital age.</p>
                        <div class="hero-cta">
                            <a href="#contact" class="btn btn-hero-primary btn-lg">
                                <i class="fas fa-rocket me-2"></i>Start Your Project
                            </a>
                            <a href="#services" class="btn btn-hero-secondary btn-lg">
                                <i class="fas fa-arrow-down me-2"></i>Explore Services
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Overview Section -->
    <section class="intro-section section-padding" id="services">
        <div class="container">
            <!-- Main Services Content -->
            <div class="row align-items-center mb-5">
                <div class="col-lg-6 order-lg-2 mb-4 mb-lg-0">
                    <div class="intro-image interactive-card">
                        <!-- SVG illustration will be displayed here via CSS background -->
                    </div>
                </div>
                <div class="col-lg-6 order-lg-1">
                    <div class="animate-on-scroll">
                        <h2 class="text-primary-brand mb-4">Digital Solutions That Drive Results</h2>
                        <p class="lead mb-4">At Pais Digital, we transform your digital presence with comprehensive solutions tailored to your unique business needs. Our expert team delivers innovative strategies that connect you with your audience and drive measurable results.</p>
                        <p class="mb-4">From responsive web design to strategic digital marketing campaigns, we provide end-to-end services that help your business thrive in the competitive digital landscape. Partner with us to unlock your digital potential and stay ahead of the curve.</p>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="service-list">
                                    <li>Custom Web Development</li>
                                    <li>Digital Marketing Strategy</li>
                                    <li>SEO & Content Optimization</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="service-list">
                                    <li>E-commerce Solutions</li>
                                    <li>Brand Identity & Design</li>
                                    <li>24/7 Technical Support</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <a href="#contact" class="btn btn-primary">
                                <i class="fas fa-comments me-2"></i>Discuss Your Project
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Features Section -->
    <section class="features-section" id="about">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-10 mx-auto">
                    <h2 class="animate-on-scroll">Why Choose Pais Digital?</h2>
                    <p class="lead animate-on-scroll">We combine technical expertise with creative innovation to deliver digital solutions that exceed expectations and drive business growth.</p>
                </div>
            </div>
            
            <div class="features-grid">
                <div class="feature-card animate-on-scroll">
                    <div class="feature-icon">
                        <i class="fas fa-code"></i>
                    </div>
                    <h4>Modern Development</h4>
                    <p>Cutting-edge technologies and frameworks to build scalable, performant web applications that stand the test of time and deliver exceptional user experiences.</p>
                </div>
                
                <div class="feature-card animate-on-scroll">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h4>Growth-Focused</h4>
                    <p>Data-driven strategies that deliver measurable results and sustainable business growth through proven methodologies and continuous optimization.</p>
                </div>
                
                <div class="feature-card animate-on-scroll">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h4>Expert Team</h4>
                    <p>Experienced professionals dedicated to delivering excellence in every project with personalized attention, support, and industry expertise.</p>
                </div>
                
                <div class="feature-card animate-on-scroll">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h4>Mobile-First Design</h4>
                    <p>Responsive designs that look and perform beautifully across all devices, ensuring optimal user experience everywhere your customers are.</p>
                </div>
                
                <div class="feature-card animate-on-scroll">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h4>Security First</h4>
                    <p>Enterprise-grade security measures and best practices to protect your digital assets, customer data, and business reputation.</p>
                </div>
                
                <div class="feature-card animate-on-scroll">
                    <div class="feature-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h4>Fast Delivery</h4>
                    <p>Agile development processes that ensure timely delivery without compromising on quality, attention to detail, or project requirements.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <footer class="footer-section section-padding" id="contact">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-8">
                    <div class="form-container">
                        <div class="text-center mb-5">
                            <h2 class="text-primary-brand mb-4">Ready to Transform Your Business?</h2>
                            <p class="lead text-secondary-brand">Get in touch with our team to discuss your project and discover how we can help you achieve your digital goals. Let's build something amazing together.</p>
                        </div>
                        
                        <?php if ($success): ?>
                            <div class="alert alert-success animate-on-scroll" role="alert">
                                <h4 class="alert-heading">
                                    <i class="fas fa-check-circle me-2"></i>Thank you for reaching out!
                                </h4>
                                <p class="mb-3">Your message has been sent successfully. Our team at Pais Digital will get back to you within 24 hours to discuss your digital needs and how we can help transform your business.</p>
                                <hr>
                                <p class="mb-0">
                                    <small>
                                        <i class="fas fa-info-circle me-1"></i>
                                        We typically respond to inquiries within 2-4 hours during business hours.
                                    </small>
                                </p>
                            </div>
                        <?php else: ?>
                            <?php if (isset($errors['general'])): ?>
                                <div class="alert alert-danger animate-on-scroll" role="alert">
                                    <h4 class="alert-heading">
                                        <i class="fas fa-exclamation-triangle me-2"></i>Email Delivery Issue
                                    </h4>
                                    <p class="mb-0"><?php echo htmlspecialchars($errors['general']); ?></p>
                                </div>
                            <?php endif; ?>
                            
                            <form method="POST" id="contactForm" novalidate class="needs-validation">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label for="fullName" class="form-label">
                                            <i class="fas fa-user me-1"></i>Full Name *
                                        </label>
                                        <input type="text" 
                                               class="form-control <?php echo isset($errors['fullName']) ? 'is-invalid' : ''; ?>" 
                                               id="fullName" 
                                               name="fullName" 
                                               value="<?php echo htmlspecialchars($formData['fullName']); ?>" 
                                               required
                                               autocomplete="name"
                                               placeholder="Enter your full name">
                                        <?php if (isset($errors['fullName'])): ?>
                                            <div class="form-error"><?php echo htmlspecialchars($errors['fullName']); ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">
                                            <i class="fas fa-envelope me-1"></i>Email Address *
                                        </label>
                                        <input type="email" 
                                               class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : ''; ?>" 
                                               id="email" 
                                               name="email" 
                                               value="<?php echo htmlspecialchars($formData['email']); ?>" 
                                               required
                                               autocomplete="email"
                                               placeholder="your.email@example.com">
                                        <?php if (isset($errors['email'])): ?>
                                            <div class="form-error"><?php echo htmlspecialchars($errors['email']); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="row g-4 mt-1">
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">
                                            <i class="fas fa-phone me-1"></i>Phone Number *
                                        </label>
                                        <input type="tel" 
                                               class="form-control <?php echo isset($errors['phone']) ? 'is-invalid' : ''; ?>" 
                                               id="phone" 
                                               name="phone" 
                                               value="<?php echo htmlspecialchars($formData['phone']); ?>" 
                                               required
                                               autocomplete="tel"
                                               placeholder="+1 (555) 123-4567">
                                        <?php if (isset($errors['phone'])): ?>
                                            <div class="form-error"><?php echo htmlspecialchars($errors['phone']); ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="country" class="form-label">
                                            <i class="fas fa-globe me-1"></i>Country *
                                        </label>
                                        <select class="form-select <?php echo isset($errors['country']) ? 'is-invalid' : ''; ?>" 
                                                id="country" 
                                                name="country" 
                                                required>
                                            <option value="">Select your country</option>
                                            <option value="australia" <?php echo ($formData['country'] === 'australia') ? 'selected' : ''; ?>>🇦🇺 Australia</option>
                                            <option value="new-zealand" <?php echo ($formData['country'] === 'new-zealand') ? 'selected' : ''; ?>>🇳🇿 New Zealand</option>
                                            <option value="other" <?php echo ($formData['country'] === 'other') ? 'selected' : ''; ?>>🌍 Other</option>
                                        </select>
                                        <?php if (isset($errors['country'])): ?>
                                            <div class="form-error"><?php echo htmlspecialchars($errors['country']); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <label for="message" class="form-label">
                                        <i class="fas fa-comment-dots me-1"></i>Tell us about your project *
                                    </label>
                                    <textarea class="form-control <?php echo isset($errors['message']) ? 'is-invalid' : ''; ?>" 
                                              id="message" 
                                              name="message" 
                                              rows="6" 
                                              required
                                              maxlength="1000"
                                              placeholder="Describe your digital needs, project goals, timeline, and budget. What challenges are you facing? What are your objectives? The more details you provide, the better we can help you."><?php echo htmlspecialchars($formData['message']); ?></textarea>
                                    <div class="form-text d-flex justify-content-between align-items-center">
                                        <span>
                                            <i class="fas fa-info-circle me-1"></i>
                                            Be specific about your requirements for a more accurate proposal
                                        </span>
                                        <span id="charCount">0</span>/1000 characters
                                    </div>
                                    <?php if (isset($errors['message'])): ?>
                                        <div class="form-error"><?php echo htmlspecialchars($errors['message']); ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="text-center mt-5">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-paper-plane me-2"></i>Send Message
                                    </button>
                                    <p class="mt-3 text-muted small">
                                        <i class="fas fa-lock me-1"></i>
                                        Your information is secure and will never be shared with third parties.
                                    </p>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Footer Bottom -->
            <div class="row mt-5 pt-5 border-top">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                        <img src="https://www.paisdigital.com.au/wp-content/uploads/2020/06/pd-logo-resized.png.webp" 
                             alt="Pais Digital Logo" style="height: 40px;" class="me-3">
                        <div>
                            <h5 class="mb-1 text-primary-brand">Pais Digital</h5>
                            <p class="mb-0 text-secondary-brand small">Digital Excellence & Innovation</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="mb-2 text-primary-brand fw-semibold">&copy; 2024 Pais Digital. All rights reserved.</p>
                    <p class="mb-0 text-secondary-brand small">Transforming Businesses Through Digital Innovation</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script src="assets/js/main.js?v=<?php echo time(); ?>"></script>
    
    <!-- Contact Form JavaScript -->
    <script src="assets/js/contact-form.js?v=<?php echo time(); ?>"></script>
</body>
</html> 