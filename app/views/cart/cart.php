<?php
$pageTitle = 'Giỏ hàng - EduStream';
$bodyClass = 'site-page cart-page';
$navActive = 'courses';
$stylesheets = ['/public/css/home.css', '/public/css/cart.css'];
require __DIR__ . '/../includes/header.php';

// Hiển thị thông báo
$success = $_SESSION['success'] ?? null;
$error = $_SESSION['error'] ?? null;
unset($_SESSION['success'], $_SESSION['error']);
?>

<main class="cart-main">
    <div class="cart-container">
        <h1 class="cart-title">
            <span class="material-symbols-outlined" aria-hidden="true">shopping_cart</span>
            Giỏ hàng của bạn
        </h1>

        <?php if ($success): ?>
        <div class="cart-notification cart-notification--success">
            <span class="material-symbols-outlined" aria-hidden="true">check_circle</span>
            <?= htmlspecialchars($success) ?>
        </div>
        <?php endif; ?>

        <?php if ($error): ?>
        <div class="cart-notification cart-notification--error">
            <span class="material-symbols-outlined" aria-hidden="true">error</span>
            <?= htmlspecialchars($error) ?>
        </div>
        <?php endif; ?>

        <?php if (empty($courses)): ?>
        <div class="cart-empty">
            <span class="material-symbols-outlined cart-empty__icon" aria-hidden="true">shopping_cart</span>
            <h2 class="cart-empty__title">Giỏ hàng trống</h2>
            <p class="cart-empty__text">Bạn chưa thêm khóa học nào vào giỏ hàng.</p>
            <a href="<?= htmlspecialchars(BASE_URL) ?>/courses" class="cart-empty__btn">
                <span class="material-symbols-outlined" aria-hidden="true">school</span>
                Khám phá khóa học
            </a>
        </div>
        <?php else: ?>
        <div class="cart-layout">
            <div class="cart-items">
                <?php foreach ($courses as $course): ?>
                <div class="cart-item">
                    <img class="cart-item__img" 
                         src="<?= !empty($course['image_url']) ? htmlspecialchars($course['image_url']) : 'https://via.placeholder.com/120x80?text=No+Image' ?>" 
                         alt="<?= htmlspecialchars($course['title']) ?>">
                    <div class="cart-item__info">
                        <h3 class="cart-item__title">
                            <a href="<?= htmlspecialchars(BASE_URL) ?>/courses/detail/<?= htmlspecialchars($course['slug']) ?>">
                                <?= htmlspecialchars($course['title']) ?>
                            </a>
                        </h3>
                        <p class="cart-item__meta">
                            <span class="material-symbols-outlined" aria-hidden="true">person</span>
                            <?= htmlspecialchars($course['instructor'] ?? 'Instructor') ?>
                        </p>
                    </div>
                    <div class="cart-item__price">
                        $<?= number_format($course['price'], 2) ?>
                    </div>
                    <form method="POST" action="<?= htmlspecialchars(BASE_URL) ?>/courses/removeFromCart" class="cart-item__remove">
                        <input type="hidden" name="course_id" value="<?= (int) $course['course_id'] ?>">
                        <button type="submit" class="cart-item__remove-btn" title="Xóa khỏi giỏ hàng">
                            <span class="material-symbols-outlined" aria-hidden="true">delete</span>
                        </button>
                    </form>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="cart-summary">
                <div class="cart-summary__card">
                    <h2 class="cart-summary__title">Tóm tắt đơn hàng</h2>
                    <div class="cart-summary__row">
                        <span>Số khóa học:</span>
                        <span><?= $count ?> khóa</span>
                    </div>
                    <div class="cart-summary__row cart-summary__row--total">
                        <span>Tổng cộng:</span>
                        <span>$<?= number_format($total, 2) ?></span>
                    </div>
                    <form method="POST" action="<?= htmlspecialchars(BASE_URL) ?>/courses/checkout">
                        <button type="submit" class="cart-summary__checkout-btn">
                            <span class="material-symbols-outlined" aria-hidden="true">credit_card</span>
                            Thanh toán & Đăng ký
                        </button>
                    </form>
                    <p class="cart-summary__note">
                        <span class="material-symbols-outlined" aria-hidden="true">info</span>
                        Sau khi thanh toán, bạn sẽ được ghi danh vào tất cả khóa học trong giỏ.
                    </p>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</main>

<?php require __DIR__ . '/../includes/footer.php'; ?>
