<?php
$pageTitle = $data['title'] ?? 'Contact Us';
$bodyClass = 'site-page contact-page';
$navActive = 'contact';
$stylesheets = ['/public/css/home.css', '/public/css/contact.css'];
require __DIR__ . '/../includes/header.php';
?>

<main class="contact-main">
    <div class="contact-container">
        <div class="contact-header">
            <h1 class="contact-title">Contact Us</h1>
            <p class="contact-subtitle">Have questions? We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
        </div>

        <div class="contact-layout">
            <div class="contact-info">
                <div class="contact-info-card">
                    <div class="contact-info-item">
                        <span class="material-symbols-outlined" aria-hidden="true">location_on</span>
                        <div>
                            <h3>Address</h3>
                            <p>123 Education Street, Learning City, LC 12345</p>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <span class="material-symbols-outlined" aria-hidden="true">phone</span>
                        <div>
                            <h3>Phone</h3>
                            <p>+1 (555) 123-4567</p>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <span class="material-symbols-outlined" aria-hidden="true">email</span>
                        <div>
                            <h3>Email</h3>
                            <p>support@edustream.com</p>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <span class="material-symbols-outlined" aria-hidden="true">schedule</span>
                        <div>
                            <h3>Working Hours</h3>
                            <p>Mon - Fri: 9:00 AM - 6:00 PM</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="contact-form-wrapper">
                <?php if (!empty($data['errors']['general'])): ?>
                    <div class="contact-alert contact-alert--error">
                        <span class="material-symbols-outlined" aria-hidden="true">error</span>
                        <?= htmlspecialchars($data['errors']['general']) ?>
                    </div>
                <?php endif; ?>

                <?php if ($data['success']): ?>
                    <div class="contact-alert contact-alert--success">
                        <span class="material-symbols-outlined" aria-hidden="true">check_circle</span>
                        Thank you for your message! We'll get back to you soon.
                    </div>
                <?php endif; ?>

                <form class="contact-form" id="contactForm" method="POST" action="<?= htmlspecialchars(BASE_URL) ?>/contact" novalidate>
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($data['csrf_token'] ?? '') ?>">

                    <div class="form-group" id="group-name">
                        <label class="form-label" for="name">Full Name</label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            class="form-input" 
                            value="<?= htmlspecialchars($data['old']['name'] ?? '') ?>"
                            placeholder="Enter your full name"
                            autocomplete="name"
                            required
                            minlength="2"
                            maxlength="100"
                        >
                        <span class="form-error" id="error-name"></span>
                    </div>

                    <div class="form-group" id="group-email">
                        <label class="form-label" for="email">Email Address</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-input" 
                            value="<?= htmlspecialchars($data['old']['email'] ?? '') ?>"
                            placeholder="your@email.com"
                            autocomplete="email"
                            required
                            minlength="5"
                            maxlength="255"
                        >
                        <span class="form-error" id="error-email"></span>
                    </div>

                    <div class="form-group" id="group-subject">
                        <label class="form-label" for="subject">Subject</label>
                        <input 
                            type="text" 
                            id="subject" 
                            name="subject" 
                            class="form-input" 
                            value="<?= htmlspecialchars($data['old']['subject'] ?? '') ?>"
                            placeholder="How can we help you?"
                            autocomplete="off"
                            required
                            minlength="5"
                            maxlength="200"
                        >
                        <span class="form-error" id="error-subject"></span>
                    </div>

                    <div class="form-group" id="group-message">
                        <label class="form-label" for="message">Message</label>
                        <textarea 
                            id="message" 
                            name="message" 
                            class="form-input form-textarea" 
                            placeholder="Tell us more about your inquiry..."
                            autocomplete="off"
                            required
                            minlength="10"
                            maxlength="5000"
                            rows="6"
                        ><?= htmlspecialchars($data['old']['message'] ?? '') ?></textarea>
                        <div class="form-char-count">
                            <span id="char-count">0</span> / 5000 characters
                        </div>
                        <span class="form-error" id="error-message"></span>
                    </div>

                    <button type="submit" class="contact-btn">
                        <span class="material-symbols-outlined" aria-hidden="true">send</span>
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
(function() {
    'use strict';

    var form = document.getElementById('contactForm');
    if (!form) return;

    // Character counter
    var messageField = document.getElementById('message');
    var charCount = document.getElementById('char-count');
    if (messageField && charCount) {
        charCount.textContent = messageField.value.length;
        messageField.addEventListener('input', function() {
            charCount.textContent = messageField.value.length;
            
            // Color coding for character count
            var len = messageField.value.length;
            if (len > 4500) {
                charCount.style.color = '#dc2626';
            } else if (len > 4000) {
                charCount.style.color = '#ca8a04';
            } else {
                charCount.style.color = 'var(--color-secondary)';
            }
        });
    }

    function showError(fieldId, message) {
        var group = document.getElementById('group-' + fieldId);
        var error = document.getElementById('error-' + fieldId);
        var input = document.getElementById(fieldId);
        if (group) group.classList.add('form-group--error');
        if (error) error.textContent = message;
        if (input) input.classList.add('form-input--error');
    }

    function clearError(fieldId) {
        var group = document.getElementById('group-' + fieldId);
        var error = document.getElementById('error-' + fieldId);
        var input = document.getElementById(fieldId);
        if (group) group.classList.remove('form-group--error');
        if (error) error.textContent = '';
        if (input) input.classList.remove('form-input--error');
    }

    function clearAllErrors() {
        ['name', 'email', 'subject', 'message'].forEach(function(field) {
            clearError(field);
        });
    }

    function validateEmail(email) {
        var re = /^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/;
        return re.test(email);
    }

    function validateName(name) {
        var re = /^[a-zA-ZÀ-ỹ\s\.]+$/u;
        return re.test(name);
    }

    function validate() {
        clearAllErrors();
        var isValid = true;

        var name = document.getElementById('name');
        var email = document.getElementById('email');
        var subject = document.getElementById('subject');
        var message = document.getElementById('message');

        // Name validation
        if (!name.value.trim()) {
            showError('name', 'Name is required.');
            isValid = false;
        } else if (name.value.trim().length < 2) {
            showError('name', 'Name must be at least 2 characters.');
            isValid = false;
        } else if (!validateName(name.value.trim())) {
            showError('name', 'Name can only contain letters, spaces, and periods.');
            isValid = false;
        }

        // Email validation
        if (!email.value.trim()) {
            showError('email', 'Email is required.');
            isValid = false;
        } else if (!validateEmail(email.value.trim())) {
            showError('email', 'Please enter a valid email address.');
            isValid = false;
        }

        // Subject validation
        if (!subject.value.trim()) {
            showError('subject', 'Subject is required.');
            isValid = false;
        } else if (subject.value.trim().length < 5) {
            showError('subject', 'Subject must be at least 5 characters.');
            isValid = false;
        }

        // Message validation
        if (!message.value.trim()) {
            showError('message', 'Message is required.');
            isValid = false;
        } else if (message.value.trim().length < 10) {
            showError('message', 'Message must be at least 10 characters.');
            isValid = false;
        }

        return isValid;
    }

    // Real-time validation on blur
    var fields = ['name', 'email', 'subject', 'message'];
    
    fields.forEach(function(fieldId) {
        var input = document.getElementById(fieldId);
        if (!input) return;

        input.addEventListener('blur', function() {
            clearError(fieldId);
            var value = input.value.trim();

            switch(fieldId) {
                case 'name':
                    if (!value) {
                        showError('name', 'Name is required.');
                    } else if (value.length < 2) {
                        showError('name', 'Name must be at least 2 characters.');
                    } else if (!validateName(value)) {
                        showError('name', 'Name can only contain letters, spaces, and periods.');
                    }
                    break;
                    
                case 'email':
                    if (!value) {
                        showError('email', 'Email is required.');
                    } else if (!validateEmail(value)) {
                        showError('email', 'Please enter a valid email address.');
                    }
                    break;
                    
                case 'subject':
                    if (!value) {
                        showError('subject', 'Subject is required.');
                    } else if (value.length < 5) {
                        showError('subject', 'Subject must be at least 5 characters.');
                    }
                    break;
                    
                case 'message':
                    if (!value) {
                        showError('message', 'Message is required.');
                    } else if (value.length < 10) {
                        showError('message', 'Message must be at least 10 characters.');
                    }
                    break;
            }
        });

        input.addEventListener('input', function() {
            clearError(fieldId);
        });
    });

    form.addEventListener('submit', function(e) {
        if (!validate()) {
            e.preventDefault();
        }
    });
})();
</script>

<?php require __DIR__ . '/../includes/footer.php'; ?>
