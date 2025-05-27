/**
 * Pais Digital Landing Page - Advanced JavaScript
 * Features: Form validation, animations, scroll effects, particles, and more
 */

class PaisDigitalApp {
    constructor() {
        this.init();
        this.bindEvents();
        this.initAnimations();
        this.initParticles();
        this.initProgressBar();
    }

    init() {
        // Initialize app state
        this.isScrolling = false;
        this.scrollTimeout = null;
        this.particles = [];
        this.formSubmitting = false;
        
        // Cache DOM elements
        this.navbar = document.querySelector('.navbar');
        this.heroSection = document.querySelector('.hero-section');
        this.contactForm = document.getElementById('contactForm');
        
        console.log('🚀 Pais Digital App Initialized');
    }

    bindEvents() {
        // Scroll events
        window.addEventListener('scroll', this.throttle(this.handleScroll.bind(this), 16));
        
        // Form events
        if (this.contactForm) {
            this.contactForm.addEventListener('submit', this.handleFormSubmit.bind(this));
            this.initRealTimeValidation();
        }
        
        // Resize events
        window.addEventListener('resize', this.throttle(this.handleResize.bind(this), 250));
        
        // Page load events
        window.addEventListener('load', this.handlePageLoad.bind(this));
        
        // Smooth scrolling for anchor links
        this.initSmoothScrolling();
        
        // Keyboard navigation
        document.addEventListener('keydown', this.handleKeyboard.bind(this));
    }

    // Scroll Effects
    handleScroll() {
        const scrollY = window.scrollY;
        
        // Navbar scroll effect
        if (this.navbar) {
            if (scrollY > 50) {
                this.navbar.classList.add('scrolled');
            } else {
                this.navbar.classList.remove('scrolled');
            }
        }
        
        // Update progress bar
        this.updateProgressBar();
        
        // Parallax effect for hero section
        if (this.heroSection && scrollY < window.innerHeight) {
            const parallaxSpeed = 0.5;
            this.heroSection.style.transform = `translateY(${scrollY * parallaxSpeed}px)`;
        }
        
        // Animate elements on scroll
        this.animateOnScroll();
        
        // Handle scroll state
        this.isScrolling = true;
        clearTimeout(this.scrollTimeout);
        this.scrollTimeout = setTimeout(() => {
            this.isScrolling = false;
        }, 150);
    }

    // Progress Bar
    createProgressBar() {
        const progressBar = document.createElement('div');
        progressBar.className = 'progress-bar';
        progressBar.style.width = '0%';
        document.body.appendChild(progressBar);
        return progressBar;
    }

    updateProgressBar() {
        const scrollHeight = document.documentElement.scrollHeight - window.innerHeight;
        const scrolled = (window.scrollY / scrollHeight) * 100;
        this.progressBar.style.width = `${Math.min(scrolled, 100)}%`;
    }

    // Animation System
    initAnimations() {
        // Add animation classes to elements
        const animatedElements = document.querySelectorAll('.intro-section h2, .intro-section p, .service-list li, .form-container');
        animatedElements.forEach(el => {
            el.classList.add('animate-on-scroll');
        });
        
        // Initial animation check
        this.animateOnScroll();
    }

    animateOnScroll() {
        const elements = document.querySelectorAll('.animate-on-scroll');
        const windowHeight = window.innerHeight;
        
        elements.forEach(element => {
            const elementTop = element.getBoundingClientRect().top;
            const elementVisible = 150;
            
            if (elementTop < windowHeight - elementVisible) {
                element.classList.add('visible');
            }
        });
    }

    // Particle System
    initParticles() {
        if (this.heroSection) {
            const particlesContainer = document.createElement('div');
            particlesContainer.className = 'particles-container';
            this.heroSection.appendChild(particlesContainer);
            
            this.createParticles(particlesContainer);
        }
    }

    createParticles(container) {
        const particleCount = 50;
        
        for (let i = 0; i < particleCount; i++) {
            setTimeout(() => {
                this.createParticle(container);
            }, i * 200);
        }
        
        // Continuously create new particles
        setInterval(() => {
            if (this.particles.length < particleCount) {
                this.createParticle(container);
            }
        }, 3000);
    }

    createParticle(container) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        
        // Random properties
        const size = Math.random() * 4 + 2;
        const left = Math.random() * 100;
        const animationDuration = Math.random() * 10 + 10;
        const delay = Math.random() * 5;
        
        particle.style.cssText = `
            width: ${size}px;
            height: ${size}px;
            left: ${left}%;
            animation-duration: ${animationDuration}s;
            animation-delay: ${delay}s;
        `;
        
        container.appendChild(particle);
        this.particles.push(particle);
        
        // Remove particle after animation
        setTimeout(() => {
            if (particle.parentNode) {
                particle.parentNode.removeChild(particle);
                this.particles = this.particles.filter(p => p !== particle);
            }
        }, (animationDuration + delay) * 1000);
    }

    // Advanced Form Validation
    handleFormSubmit(e) {
        if (this.formSubmitting) {
            e.preventDefault();
            return;
        }
        
        const formData = new FormData(this.contactForm);
        const errors = this.validateForm(formData);
        
        // Clear previous errors
        this.clearFormErrors();
        
        if (Object.keys(errors).length > 0) {
            e.preventDefault(); // Only prevent submission if there are errors
            this.displayFormErrors(errors);
            this.shakeForm();
            return;
        }
        
        // If no errors, show loading state and allow natural form submission
        this.showSubmittingState();
        // Don't prevent default - let the form submit naturally
    }

    showSubmittingState() {
        this.formSubmitting = true;
        const submitButton = this.contactForm.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending...';
            submitButton.disabled = true;
        }
    }

    validateForm(formData) {
        const errors = {};
        const data = Object.fromEntries(formData);
        
        // Advanced validation rules - updated to match PHP field names
        const validationRules = {
            fullName: {
                required: true,
                minLength: 2,
                pattern: /^[a-zA-Z\s\'-]+$/,
                message: 'Please enter a valid full name (letters and spaces only)'
            },
            email: {
                required: true,
                pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                message: 'Please enter a valid email address'
            },
            phone: {
                required: true,
                pattern: /^[\+]?[0-9\s\-\(\)]{8,}$/,
                message: 'Please enter a valid phone number (minimum 8 digits)'
            },
            country: {
                required: true,
                message: 'Please select a country'
            },
            message: {
                required: true,
                minLength: 10,
                maxLength: 1000,
                message: 'Message must be between 10 and 1000 characters'
            }
        };
        
        Object.keys(validationRules).forEach(field => {
            const rule = validationRules[field];
            const value = data[field]?.trim() || '';
            
            if (rule.required && !value) {
                errors[field] = `${this.capitalizeFirst(field.replace(/([A-Z])/g, ' $1'))} is required`;
                return;
            }
            
            if (value && rule.minLength && value.length < rule.minLength) {
                errors[field] = rule.message || `Minimum ${rule.minLength} characters required`;
                return;
            }
            
            if (value && rule.maxLength && value.length > rule.maxLength) {
                errors[field] = rule.message || `Maximum ${rule.maxLength} characters allowed`;
                return;
            }
            
            if (value && rule.pattern && !rule.pattern.test(value)) {
                errors[field] = rule.message || 'Invalid format';
                return;
            }
        });
        
        return errors;
    }

    initRealTimeValidation() {
        const inputs = this.contactForm.querySelectorAll('input, select, textarea');
        
        inputs.forEach(input => {
            input.addEventListener('blur', () => {
                this.validateField(input);
            });
            
            input.addEventListener('input', this.debounce(() => {
                this.validateField(input);
            }, 500));
        });
    }

    validateField(field) {
        const formData = new FormData();
        formData.append(field.name, field.value);
        
        const errors = this.validateForm(formData);
        const fieldError = errors[field.name];
        
        // Clear previous error
        this.clearFieldError(field);
        
        if (fieldError) {
            this.displayFieldError(field, fieldError);
        } else {
            this.markFieldValid(field);
        }
    }

    clearFormErrors() {
        const errorElements = this.contactForm.querySelectorAll('.form-error');
        const invalidFields = this.contactForm.querySelectorAll('.is-invalid');
        
        errorElements.forEach(el => el.remove());
        invalidFields.forEach(el => el.classList.remove('is-invalid'));
    }

    clearFieldError(field) {
        const existingError = field.parentNode.querySelector('.form-error');
        if (existingError) {
            existingError.remove();
        }
        field.classList.remove('is-invalid');
    }

    displayFormErrors(errors) {
        Object.keys(errors).forEach(fieldName => {
            const field = this.contactForm.querySelector(`[name="${fieldName}"]`);
            if (field) {
                this.displayFieldError(field, errors[fieldName]);
            }
        });
    }

    displayFieldError(field, message) {
        field.classList.add('is-invalid');
        
        const errorDiv = document.createElement('div');
        errorDiv.className = 'form-error';
        errorDiv.textContent = message;
        
        field.parentNode.appendChild(errorDiv);
    }

    markFieldValid(field) {
        field.classList.remove('is-invalid');
        field.classList.add('is-valid');
        
        setTimeout(() => {
            field.classList.remove('is-valid');
        }, 2000);
    }

    async simulateFormSubmission(formData) {
        // This function is no longer used - keeping for compatibility
        return new Promise((resolve) => {
            setTimeout(resolve, 2000);
        });
    }

    showSuccessMessage() {
        const alert = document.createElement('div');
        alert.className = 'alert alert-success';
        alert.innerHTML = `
            <h4 class="alert-heading">Thank you for reaching out!</h4>
            <p>Your message has been sent successfully. Our team at Pais Digital will get back to you within 24 hours.</p>
        `;
        
        this.contactForm.parentNode.insertBefore(alert, this.contactForm);
        this.contactForm.style.display = 'none';
        
        // Scroll to success message
        alert.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    showErrorMessage(message) {
        const alert = document.createElement('div');
        alert.className = 'alert alert-danger';
        alert.innerHTML = `<p>${message}</p>`;
        
        this.contactForm.parentNode.insertBefore(alert, this.contactForm);
        
        setTimeout(() => {
            alert.remove();
        }, 5000);
    }

    shakeForm() {
        this.contactForm.style.animation = 'shake 0.5s ease-in-out';
        setTimeout(() => {
            this.contactForm.style.animation = '';
        }, 500);
    }

    // Smooth Scrolling
    initSmoothScrolling() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', (e) => {
                e.preventDefault();
                const target = document.querySelector(anchor.getAttribute('href'));
                
                if (target) {
                    const offsetTop = target.offsetTop - 80; // Account for fixed navbar
                    
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }

    // Keyboard Navigation
    handleKeyboard(e) {
        // ESC key to close any modals or reset form
        if (e.key === 'Escape') {
            this.clearFormErrors();
        }
        
        // Ctrl/Cmd + Enter to submit form
        if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
            if (document.activeElement.closest('#contactForm')) {
                this.contactForm.dispatchEvent(new Event('submit'));
            }
        }
    }

    // Responsive Handling
    handleResize() {
        // Recalculate animations and layouts
        this.animateOnScroll();
        
        // Adjust particle count based on screen size
        const isMobile = window.innerWidth < 768;
        if (isMobile && this.particles.length > 20) {
            // Remove excess particles on mobile
            this.particles.slice(20).forEach(particle => {
                if (particle.parentNode) {
                    particle.parentNode.removeChild(particle);
                }
            });
            this.particles = this.particles.slice(0, 20);
        }
    }

    handlePageLoad() {
        // Add loaded class for any load-specific animations
        document.body.classList.add('loaded');
        
        // Initialize any third-party libraries here
        this.initLazyLoading();
    }

    initLazyLoading() {
        // Simple lazy loading for images
        const images = document.querySelectorAll('img[data-src]');
        
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });
            
            images.forEach(img => imageObserver.observe(img));
        }
    }

    // Utility Functions
    throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }

    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    capitalizeFirst(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    // Initialize Progress Bar
    initProgressBar() {
        this.progressBar = this.createProgressBar();
    }
}

// CSS for shake animation
const shakeCSS = `
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
    20%, 40%, 60%, 80% { transform: translateX(5px); }
}
`;

// Add shake animation CSS
const style = document.createElement('style');
style.textContent = shakeCSS;
document.head.appendChild(style);

// Initialize app when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        new PaisDigitalApp();
    });
} else {
    new PaisDigitalApp();
}

// Export for potential module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = PaisDigitalApp;
} 