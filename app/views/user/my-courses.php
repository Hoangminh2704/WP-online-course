<?php
$pageTitle = $data['title'] ?? 'My Courses';
$bodyClass = 'site-page my-courses-page';
$navActive = 'courses';
$stylesheets = ['/public/css/home.css', '/public/css/my-courses.css'];
require __DIR__ . '/../includes/header.php';
?>

<main class="mc-main">
    <div class="mc-container">
        <div class="mc-header">
            <div class="mc-header__info">
                <h1 class="mc-title">
                    <span class="material-symbols-outlined" aria-hidden="true">school</span>
                    My Courses
                </h1>
                <p class="mc-subtitle">
                    Hello, <strong><?= htmlspecialchars($data['user_name']) ?></strong>!
                    You own <strong><?= $data['total_courses'] ?></strong> course<?= $data['total_courses'] != 1 ? 's' : '' ?>.
                </p>
            </div>
            <a href="<?= htmlspecialchars(BASE_URL) ?>/courses" class="mc-browse-btn">
                <span class="material-symbols-outlined" aria-hidden="true">add</span>
                Explore More Courses
            </a>
        </div>

        <?php if (empty($data['courses'])): ?>
        <div class="mc-empty">
            <span class="material-symbols-outlined mc-empty__icon" aria-hidden="true">menu_book</span>
            <h2 class="mc-empty__title">No Courses Yet</h2>
            <p class="mc-empty__text">You haven't enrolled in any courses yet. Start exploring and begin learning today!</p>
            <a href="<?= htmlspecialchars(BASE_URL) ?>/courses" class="mc-empty__btn">
                <span class="material-symbols-outlined" aria-hidden="true">explore</span>
                Explore Courses
            </a>
        </div>
        <?php else: ?>
        <div class="mc-grid">
            <?php foreach ($data['courses'] as $course): ?>
            <div class="mc-card">
                <div class="mc-card__image-wrap">
                    <img class="mc-card__image" 
                         src="<?= !empty($course['image_url']) ? htmlspecialchars($course['image_url']) : 'https://via.placeholder.com/400x225?text=No+Image' ?>" 
                         alt="<?= htmlspecialchars($course['title']) ?>">
                    <div class="mc-card__overlay">
                        <a href="<?= htmlspecialchars(BASE_URL) ?>/courses/detail/<?= htmlspecialchars($course['slug']) ?>" class="mc-card__learn-btn">
                            <span class="material-symbols-outlined" aria-hidden="true">play_circle</span>
                            Continue Learning
                        </a>
                    </div>
                </div>
                <div class="mc-card__body">
                    <h3 class="mc-card__title">
                        <a href="<?= htmlspecialchars(BASE_URL) ?>/courses/detail/<?= htmlspecialchars($course['slug']) ?>">
                            <?= htmlspecialchars($course['title']) ?>
                        </a>
                    </h3>
                    <p class="mc-card__instructor">
                        <span class="material-symbols-outlined" aria-hidden="true">person</span>
                        <?= htmlspecialchars($course['instructor'] ?? 'Instructor') ?>
                    </p>
                    <div class="mc-card__meta">
                        <div class="mc-card__rating">
                            <span class="material-symbols-outlined mc-star" aria-hidden="true">star</span>
                            <span><?= number_format($course['rating'] ?? 0, 1) ?></span>
                        </div>
                        <div class="mc-card__enrolled">
                            <span class="material-symbols-outlined" aria-hidden="true">calendar_today</span>
                            <span>Enrolled: <?= date('M d, Y', strtotime($course['enrolled_at'])) ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</main>

<?php require __DIR__ . '/../includes/footer.php'; ?>
