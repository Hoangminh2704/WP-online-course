<?php
$pageTitle = $data['title'] ?? 'Login';
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
            <h1 class="auth-title">Welcome Back</h1>
            <p class="auth-subtitle">Sign in to continue learning</p>
        </div>

        <?php if (!empty($data['errors']['general'])): ?>
            <div class="auth-alert auth-alert--error">
                <?= htmlspecialchars($data['errors']['general']) ?>
            </div>
        <?php endif; ?>

        <form class="auth-form" method="POST" action="<?= htmlspecialchars(BASE_URL) ?>/auth/login" novalidate>
            <div class="form-group <?= isset($data['errors']['email']) ? 'form-group--error' : '' ?>">
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
                    placeholder="Enter your password"
                    autocomplete="current-password"
                    required
                >
                <?php if (!empty($data['errors']['password'])): ?>
                    <span class="form-error"><?= htmlspecialchars($data['errors']['password']) ?></span>
                <?php endif; ?>
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

</body>
</html>
