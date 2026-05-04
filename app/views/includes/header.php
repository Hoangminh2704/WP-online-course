<?php
$pageTitle = $pageTitle ?? (isset($data['title']) ? (string) $data['title'] : 'EduStream');
$bodyClass = $bodyClass ?? 'site-page';
$navActive = $navActive ?? '';
$stylesheets = $stylesheets ?? ['/public/css/home.css'];

$isLoggedIn = isset($_SESSION['user_id']);
$userName = $_SESSION['user_name'] ?? '';
$userRole = $_SESSION['user_role'] ?? '';

$cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= htmlspecialchars($pageTitle) ?></title>

    <link
        href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />

    <?php foreach ($stylesheets as $css):
        $href = (strpos($css, 'http') === 0) ? $css : BASE_URL . $css;
    ?>
    <link rel="stylesheet" href="<?= htmlspecialchars($href) ?>" />
    <?php endforeach; ?>
</head>

<body class="<?= htmlspecialchars($bodyClass) ?>">

    <nav class="home-nav" aria-label="Main Navigation">
        <div class="home-nav__inner">
            <a class="home-nav__brand" href="<?= htmlspecialchars(BASE_URL) ?>/">EduStream</a>
            <div class="home-nav__menu">
                <a class="home-nav__link<?= $navActive === 'home' ? ' home-nav__link--active' : '' ?>"
                    href="<?= htmlspecialchars(BASE_URL) ?>/">Home</a>
                <a class="home-nav__link<?= $navActive === 'courses' ? ' home-nav__link--active' : '' ?>"
                    href="<?= htmlspecialchars(BASE_URL) ?>/courses">Courses</a>
                <a class="home-nav__link<?= $navActive === 'contact' ? ' home-nav__link--active' : '' ?>"
                    href="<?= htmlspecialchars(BASE_URL) ?>/contact">Contact</a>
            </div>
            <div class="home-nav__search-wrap">
                <div class="home-nav__search">
                    <label class="visually-hidden" for="nav-search-q">Search courses</label>
                    <span class="material-symbols-outlined home-nav__search-icon" aria-hidden="true">search</span>
                    <input id="nav-search-q" class="home-nav__search-input" type="search" name="q" autocomplete="off"
                        placeholder="Search courses…" maxlength="120" />
                    <div id="nav-search-results" class="home-nav__search-results" hidden role="listbox"
                        aria-label="Search suggestions"></div>
                </div>
            </div>
            <div class="home-nav__actions">
                <?php if ($isLoggedIn): ?>
                <div class="home-nav__user">
                    <div class="home-nav__user-left">
                        <button class="home-nav__user-btn" id="user-menu-btn" aria-expanded="false"
                            aria-haspopup="true">
                            <span class="material-symbols-outlined home-nav__user-icon"
                                aria-hidden="true">account_circle</span>
                            <span class="home-nav__user-name"><?= htmlspecialchars($userName) ?></span>
                            <span class="material-symbols-outlined home-nav__user-arrow"
                                aria-hidden="true">expand_more</span>
                        </button>
                        <div class="home-nav__user-dropdown" id="user-dropdown" hidden>
                            <?php if ($userRole === 'admin'): ?>
                            <a href="<?= htmlspecialchars(BASE_URL) ?>/admin" class="home-nav__dropdown-item">
                                <span class="material-symbols-outlined" aria-hidden="true">admin_panel_settings</span>
                                Admin Dashboard
                            </a>
                            <?php endif; ?>
                            <a href="<?= htmlspecialchars(BASE_URL) ?>/user/profile" class="home-nav__dropdown-item">
                                <span class="material-symbols-outlined" aria-hidden="true">person</span>
                                My Profile
                            </a>
                            <a href="<?= htmlspecialchars(BASE_URL) ?>/user/my-courses" class="home-nav__dropdown-item">
                                <span class="material-symbols-outlined" aria-hidden="true">school</span>
                                My Courses
                            </a>
                            <div class="home-nav__dropdown-divider"></div>
                            <a href="<?= htmlspecialchars(BASE_URL) ?>/auth/logout"
                                class="home-nav__dropdown-item home-nav__dropdown-item--danger">
                                <span class="material-symbols-outlined" aria-hidden="true">logout</span>
                                Sign Out
                            </a>
                        </div>
                    </div>
                    <a href="<?= htmlspecialchars(BASE_URL) ?>/courses/cart" class="home-nav__cart-btn"
                        aria-label="Shopping Cart">
                        <span class="material-symbols-outlined" aria-hidden="true">shopping_cart</span>
                        <?php if ($cartCount > 0): ?>
                        <span class="home-nav__cart-badge"><?= $cartCount ?></span>
                        <?php endif; ?>
                    </a>
                </div>
                <?php else: ?>
                <a href="<?= htmlspecialchars(BASE_URL) ?>/courses/cart" class="home-nav__cart-btn"
                    aria-label="Shopping Cart">
                    <span class="material-symbols-outlined" aria-hidden="true">shopping_cart</span>
                    <?php if ($cartCount > 0): ?>
                    <span class="home-nav__cart-badge"><?= $cartCount ?></span>
                    <?php endif; ?>
                </a>
                <a href="<?= htmlspecialchars(BASE_URL) ?>/auth/login"
                    class="home-nav__btn home-nav__btn--ghost">Login</a>
                <a href="<?= htmlspecialchars(BASE_URL) ?>/auth/register"
                    class="home-nav__btn home-nav__btn--primary">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <script>
    window.__BASE_URL__ = <?= json_encode(BASE_URL, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
    </script>
    <script src="<?= htmlspecialchars(BASE_URL) ?>/public/js/search-suggest.js" defer></script>
    <?php if ($isLoggedIn): ?>
    <script>
    (function() {
        var btn = document.getElementById('user-menu-btn');
        var dropdown = document.getElementById('user-dropdown');
        if (!btn || !dropdown) return;

        btn.addEventListener('click', function() {
            var isHidden = dropdown.hidden;
            dropdown.hidden = !isHidden;
            btn.setAttribute('aria-expanded', String(isHidden));
        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.home-nav__user')) {
                dropdown.hidden = true;
                btn.setAttribute('aria-expanded', 'false');
            }
        });
    })();
    </script>
    <?php endif; ?>

</body>

</html>