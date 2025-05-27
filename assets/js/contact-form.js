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
            form.addEventListener('submit', (e) => {
                // Add any additional client-side validation here
                this.showSubmittingState();
            });
        }
    }

    showSubmittingState() {
        const submitBtn = document.querySelector('#contactForm button[type="submit"]');
        if (submitBtn) {
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="loading"></span> Sending...';
            submitBtn.disabled = true;
            
            // Re-enable after 5 seconds as fallback
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 5000);
        }
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new ContactForm();
}); 