<?php
$pageTitle = $data['title'] ?? 'Login';
?>
<!DOCTYPE html>
<html lang="en">
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
            <h1 class="auth-title">Welcome Back</h1>
            <p class="auth-subtitle">Sign in to continue learning</p>
        </div>

        <?php if (!empty($data['errors']['general'])): ?>
            <div class="auth-alert auth-alert--error">
                <?= htmlspecialchars($data['errors']['general']) ?>
            </div>
        <?php endif; ?>

        <form class="auth-form" id="loginForm" method="POST" action="<?= htmlspecialchars(BASE_URL) ?>/auth/login" novalidate>
            <div class="form-group" id="group-email">
                <label class="form-label" for="email">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-input" 
                    value="<?= htmlspecialchars($data['old']['email'] ?? '') ?>"
                    placeholder="student@edustream.test"
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
                    placeholder="Enter your password"
                    autocomplete="current-password"
                    required
                    minlength="1"
                    maxlength="128"
                >
                <span class="form-error" id="error-password"></span>
            </div>

            <button type="submit" class="auth-btn auth-btn--primary">
                Sign In
            </button>
        </form>

        <div class="auth-footer">
            <p class="auth-footer__text">
                Don't have an account? 
                <a href="<?= htmlspecialchars(BASE_URL) ?>/auth/register" class="auth-link">
                    Create one
                </a>
            </p>
        </div>

        <div class="auth-demo">
            <p class="auth-demo__title">Demo Accounts</p>
            <div class="auth-demo__accounts">
                <div class="auth-demo__account">
                    <strong>Student:</strong> student@edustream.test / Student123!
                </div>
                <div class="auth-demo__account">
                    <strong>Admin:</strong> admin@edustream.test / Admin123!
                </div>
            </div>
        </div>
    </div>
</main>

<script>
(function() {
    'use strict';

    var form = document.getElementById('loginForm');
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
        ['email', 'password'].forEach(function(field) {
            clearError(field);
        });
    }

    function validateEmail(email) {
        var re = /^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/;
        return re.test(email);
    }

    function validate() {
        clearAllErrors();
        var isValid = true;

        var email = document.getElementById('email');
        var password = document.getElementById('password');

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
        }

        return isValid;
    }

    // Real-time validation on blur
    ['email', 'password'].forEach(function(fieldId) {
        var input = document.getElementById(fieldId);
        if (input) {
            input.addEventListener('blur', function() {
                clearError(fieldId);
                
                if (fieldId === 'email') {
                    if (!input.value.trim()) {
                        showError('email', 'Email is required.');
                    } else if (!validateEmail(input.value.trim())) {
                        showError('email', 'Please enter a valid email address.');
                    }
                }
                
                if (fieldId === 'password') {
                    if (!input.value) {
                        showError('password', 'Password is required.');
                    }
                }
            });

            // Clear error on input
            input.addEventListener('input', function() {
                clearError(fieldId);
            });
        }
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
