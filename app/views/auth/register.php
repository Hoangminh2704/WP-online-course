<?php
$pageTitle = $data['title'] ?? 'Register';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="<?= htmlspecialchars(BASE_URL) ?>/public/css/auth.css"/>
</head>
<body class="auth-page">

<main class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <a href="<?= htmlspecialchars(BASE_URL) ?>/" class="auth-logo">EduStream</a>
            <h1 class="auth-title">Create Account</h1>
            <p class="auth-subtitle">Start your learning journey today</p>
        </div>

        <form class="auth-form" id="registerForm" method="POST" action="<?= htmlspecialchars(BASE_URL) ?>/auth/register" novalidate>
            <div class="form-group" id="group-full_name">
                <label class="form-label" for="full_name">Full Name</label>
                <input 
                    type="text" 
                    id="full_name" 
                    name="full_name" 
                    class="form-input" 
                    value="<?= htmlspecialchars($data['old']['full_name'] ?? '') ?>"
                    placeholder="Enter your full name"
                    autocomplete="name"
                    required
                    minlength="2"
                    maxlength="100"
                    pattern="[a-zA-ZÀ-ỹ\s]+"
                >
                <span class="form-error" id="error-full_name"></span>
            </div>

            <div class="form-group" id="group-email">
                <label class="form-label" for="email">Email</label>
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
                    pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}"
                >
                <span class="form-error" id="error-email"></span>
            </div>

            <div class="form-group" id="group-password">
                <label class="form-label" for="password">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-input" 
                    placeholder="At least 6 characters"
                    autocomplete="new-password"
                    required
                    minlength="6"
                    maxlength="128"
                >
                <span class="form-error" id="error-password"></span>
                <div class="form-hint" id="password-strength"></div>
            </div>

            <div class="form-group" id="group-password_confirm">
                <label class="form-label" for="password_confirm">Confirm Password</label>
                <input 
                    type="password" 
                    id="password_confirm" 
                    name="password_confirm" 
                    class="form-input" 
                    placeholder="Re-enter your password"
                    autocomplete="new-password"
                    required
                    minlength="6"
                    maxlength="128"
                >
                <span class="form-error" id="error-password_confirm"></span>
            </div>

            <button type="submit" class="auth-btn auth-btn--primary">
                Create Account
            </button>
        </form>

        <div class="auth-footer">
            <p class="auth-footer__text">
                Already have an account? 
                <a href="<?= htmlspecialchars(BASE_URL) ?>/auth/login" class="auth-link">
                    Sign in
                </a>
            </p>
        </div>
    </div>
</main>

<script>
(function() {
    'use strict';

    var form = document.getElementById('registerForm');
    if (!form) return;

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
        ['full_name', 'email', 'password', 'password_confirm'].forEach(function(field) {
            clearError(field);
        });
    }

    function validateEmail(email) {
        var re = /^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/;
        return re.test(email);
    }

    function validateName(name) {
        // Chỉ cho phép chữ cái (có dấu tiếng Việt) và khoảng trắng
        var re = /^[a-zA-ZÀ-ỹ\s]+$/;
        return re.test(name);
    }

    function getPasswordStrength(password) {
        var strength = 0;
        if (password.length >= 6) strength++;
        if (password.length >= 8) strength++;
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
        if (/\d/.test(password)) strength++;
        if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) strength++;
        return strength;
    }

    function showPasswordStrength(password) {
        var strengthDiv = document.getElementById('password-strength');
        if (!strengthDiv) return;
        
        var strength = getPasswordStrength(password);
        var messages = [
            'Very weak',
            'Weak', 
            'Fair',
            'Good',
            'Strong'
        ];
        var colors = ['#dc2626', '#ea580c', '#ca8a04', '#16a34a', '#059669'];
        
        if (password.length === 0) {
            strengthDiv.textContent = '';
            strengthDiv.className = 'form-hint';
            return;
        }
        
        strengthDiv.textContent = 'Strength: ' + (messages[strength] || 'Very weak');
        strengthDiv.style.color = colors[strength] || colors[0];
    }

    function validate() {
        clearAllErrors();
        var isValid = true;

        var fullName = document.getElementById('full_name');
        var email = document.getElementById('email');
        var password = document.getElementById('password');
        var passwordConfirm = document.getElementById('password_confirm');

        // Full Name validation
        if (!fullName.value.trim()) {
            showError('full_name', 'Full name is required.');
            isValid = false;
        } else if (fullName.value.trim().length < 2) {
            showError('full_name', 'Full name must be at least 2 characters.');
            isValid = false;
        } else if (!validateName(fullName.value.trim())) {
            showError('full_name', 'Full name can only contain letters and spaces.');
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

        // Password validation
        if (!password.value) {
            showError('password', 'Password is required.');
            isValid = false;
        } else if (password.value.length < 6) {
            showError('password', 'Password must be at least 6 characters.');
            isValid = false;
        }

        // Password Confirm validation
        if (!passwordConfirm.value) {
            showError('password_confirm', 'Please confirm your password.');
            isValid = false;
        } else if (password.value !== passwordConfirm.value) {
            showError('password_confirm', 'Passwords do not match.');
            isValid = false;
        }

        return isValid;
    }

    // Real-time validation on blur
    var fields = ['full_name', 'email', 'password', 'password_confirm'];
    
    fields.forEach(function(fieldId) {
        var input = document.getElementById(fieldId);
        if (!input) return;

        input.addEventListener('blur', function() {
            clearError(fieldId);
            var value = input.value.trim();

            switch(fieldId) {
                case 'full_name':
                    if (!value) {
                        showError('full_name', 'Full name is required.');
                    } else if (value.length < 2) {
                        showError('full_name', 'Full name must be at least 2 characters.');
                    } else if (!validateName(value)) {
                        showError('full_name', 'Full name can only contain letters and spaces.');
                    }
                    break;
                    
                case 'email':
                    if (!value) {
                        showError('email', 'Email is required.');
                    } else if (!validateEmail(value)) {
                        showError('email', 'Please enter a valid email address.');
                    }
                    break;
                    
                case 'password':
                    if (!input.value) {
                        showError('password', 'Password is required.');
                    } else if (input.value.length < 6) {
                        showError('password', 'Password must be at least 6 characters.');
                    }
                    break;
                    
                case 'password_confirm':
                    var password = document.getElementById('password');
                    if (!input.value) {
                        showError('password_confirm', 'Please confirm your password.');
                    } else if (input.value !== password.value) {
                        showError('password_confirm', 'Passwords do not match.');
                    }
                    break;
            }
        });

        // Clear error on input
        input.addEventListener('input', function() {
            clearError(fieldId);
            
            // Real-time password match check
            if (fieldId === 'password') {
                var passwordConfirm = document.getElementById('password_confirm');
                if (passwordConfirm.value && input.value !== passwordConfirm.value) {
                    showError('password_confirm', 'Passwords do not match.');
                } else {
                    clearError('password_confirm');
                }
                showPasswordStrength(input.value);
            }
        });
    });

    form.addEventListener('submit', function(e) {
        if (!validate()) {
            e.preventDefault();
        }
    });
})();
</script>

</body>
</html>
