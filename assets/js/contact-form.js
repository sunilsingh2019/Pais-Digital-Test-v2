/**
 * Contact Form JavaScript
 * Handles character counting and form enhancements
 */

class ContactForm {
    constructor() {
        this.init();
    }

    init() {
        this.setupCharacterCounter();
        this.setupFormValidation();
    }

    setupCharacterCounter() {
        const messageTextarea = document.getElementById('message');
        const charCount = document.getElementById('charCount');
        
        if (messageTextarea && charCount) {
            const updateCharCount = () => {
                const count = messageTextarea.value.length;
                charCount.textContent = count;
                
                // Dynamic color feedback
                if (count > 950) {
                    charCount.style.color = 'var(--danger-color)';
                    charCount.style.fontWeight = 'bold';
                } else if (count > 800) {
                    charCount.style.color = 'var(--warning-color)';
                    charCount.style.fontWeight = '600';
                } else if (count > 10) {
                    charCount.style.color = 'var(--success-color)';
                    charCount.style.fontWeight = '500';
                } else {
                    charCount.style.color = 'var(--text-secondary)';
                    charCount.style.fontWeight = 'normal';
                }
            };
            
            messageTextarea.addEventListener('input', updateCharCount);
            updateCharCount(); // Initial count
        }
    }

    setupFormValidation() {
        const form = document.getElementById('contactForm');
        if (form) {
            // Remove any existing event listeners
            form.removeEventListener('submit', this.handleSubmit);
            
            // Add the submit handler
            form.addEventListener('submit', (e) => {
                console.log('Form submit event triggered');
                
                // Show submitting state
                this.showSubmittingState();
                
                // Let the form submit naturally - don't prevent default
                // The form will submit to the same page with POST method
            });
        }
    }

    showSubmittingState() {
        const submitBtn = document.querySelector('#contactForm button[type="submit"]');
        if (submitBtn) {
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending...';
            submitBtn.disabled = true;
            
            console.log('Submit button state changed to sending...');
        }
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    console.log('Contact form JavaScript loaded');
    new ContactForm();
}); 