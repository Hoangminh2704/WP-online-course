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

        <form class="auth-form" method="POST" action="<?= htmlspecialchars(BASE_URL) ?>/auth/register" novalidate>
            <div class="form-group <?= isset($data['errors']['full_name']) ? 'form-group--error' : '' ?>">
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
                >
                <?php if (!empty($data['errors']['full_name'])): ?>
                    <span class="form-error"><?= htmlspecialchars($data['errors']['full_name']) ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group <?= isset($data['errors']['email']) ? 'form-group--error' : '' ?>">
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
                >
                <?php if (!empty($data['errors']['email'])): ?>
                    <span class="form-error"><?= htmlspecialchars($data['errors']['email']) ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group <?= isset($data['errors']['password']) ? 'form-group--error' : '' ?>">
                <label class="form-label" for="password">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-input" 
                    placeholder="At least 6 characters"
                    autocomplete="new-password"
                    required
                >
                <?php if (!empty($data['errors']['password'])): ?>
                    <span class="form-error"><?= htmlspecialchars($data['errors']['password']) ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group <?= isset($data['errors']['password_confirm']) ? 'form-group--error' : '' ?>">
                <label class="form-label" for="password_confirm">Confirm Password</label>
                <input 
                    type="password" 
                    id="password_confirm" 
                    name="password_confirm" 
                    class="form-input" 
                    placeholder="Re-enter your password"
                    autocomplete="new-password"
                    required
                >
                <?php if (!empty($data['errors']['password_confirm'])): ?>
                    <span class="form-error"><?= htmlspecialchars($data['errors']['password_confirm']) ?></span>
                <?php endif; ?>
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

</body>
</html>
