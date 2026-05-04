<?php
$pageTitle = isset($course['title']) ? htmlspecialchars($course['title']) . ' | EduStream' : 'Course Detail - EduStream';
$bodyClass = 'site-page course-detail-page';
$navActive = 'courses';
$stylesheets = ['/public/css/home.css', '/public/css/course_detail.css'];
require __DIR__ . '/../includes/header.php';

// Display flash notifications
$success = $_SESSION['success'] ?? null;
$error = $_SESSION['error'] ?? null;
$warning = $_SESSION['warning'] ?? null;
unset($_SESSION['success'], $_SESSION['error'], $_SESSION['warning']);
?>

<main class="cd-main">
    <?php if ($success): ?>
    <div class="cd-notification cd-notification--success">
        <span class="material-symbols-outlined" aria-hidden="true">check_circle</span>
        <?= htmlspecialchars($success) ?>
    </div>
    <?php endif; ?>

    <?php if ($error): ?>
    <div class="cd-notification cd-notification--error">
        <span class="material-symbols-outlined" aria-hidden="true">error</span>
        <?= htmlspecialchars($error) ?>
    </div>
    <?php endif; ?>

    <?php if ($warning): ?>
    <div class="cd-notification cd-notification--warning">
        <span class="material-symbols-outlined" aria-hidden="true">warning</span>
        <?= htmlspecialchars($warning) ?>
    </div>
    <?php endif; ?>

    <nav class="cd-breadcrumb" aria-label="Breadcrumb">
        <a href="<?= htmlspecialchars(BASE_URL) ?>/">Home</a>
        <span class="material-symbols-outlined cd-breadcrumb__sep" aria-hidden="true">chevron_right</span>
        <a href="<?= htmlspecialchars(BASE_URL) ?>/courses">Courses</a>
        <span class="material-symbols-outlined cd-breadcrumb__sep" aria-hidden="true">chevron_right</span>
        <a href="<?= htmlspecialchars(BASE_URL) ?>/courses"><?= htmlspecialchars($course['category_name'] ?? 'Category') ?></a>
        <span class="material-symbols-outlined cd-breadcrumb__sep" aria-hidden="true">chevron_right</span>
        <span class="cd-breadcrumb__current"><?= htmlspecialchars($course['title'] ?? '') ?></span>
    </nav>

    <div class="cd-layout">
        <div class="cd-primary">
            <div class="cd-video ambient-shadow">
                <img class="cd-video__thumb" alt="<?= htmlspecialchars($course['title'] ?? '') ?>"
                     src="<?= !empty($course['image_url']) ? htmlspecialchars($course['image_url']) : 'https://via.placeholder.com/1280x720?text=No+Image' ?>">
                <div class="cd-video__play-wrap">
                    <button type="button" class="cd-video__play" aria-label="Play course preview">
                        <span class="material-symbols-outlined cd-play-icon" aria-hidden="true">play_arrow</span>
                    </button>
                </div>
                <div class="cd-video__caption">
                    <p><?= htmlspecialchars($course['title'] ?? 'Course Preview') ?></p>
                </div>
            </div>
            <div class="cd-meta-row">
                <div class="cd-meta-chip">
                    <span class="material-symbols-outlined" aria-hidden="true">person</span>
                    <span><?= htmlspecialchars($course['instructor'] ?? 'Instructor') ?></span>
                </div>
                <div class="cd-meta-chip">
                    <span class="material-symbols-outlined" aria-hidden="true">category</span>
                    <span><?= htmlspecialchars($course['category_name'] ?? 'General') ?></span>
                </div>
            </div>
        </div>

        <aside class="cd-sidebar">
            <div class="cd-purchase ambient-shadow">
                <div>
                    <h1 class="cd-purchase__title"><?= htmlspecialchars($course['title'] ?? '') ?></h1>
                    <div class="cd-purchase__rating-row">
                        <span class="cd-purchase__score"><?= number_format($course['rating'] ?? 0, 1) ?></span>
                        <div class="cd-purchase__stars" aria-hidden="true">
                            <?php
                            $rating = floatval($course['rating'] ?? 0);
                            $fullStars = floor($rating);
                            $hasHalf = ($rating - $fullStars) >= 0.5;
                            for ($i = 0; $i < 5; $i++):
                                if ($i < $fullStars):
                            ?>
                                <span class="material-symbols-outlined cd-star--fill">star</span>
                            <?php elseif ($i === $fullStars && $hasHalf): ?>
                                <span class="material-symbols-outlined cd-star--fill">star_half</span>
                            <?php else: ?>
                                <span class="material-symbols-outlined">star</span>
                            <?php endif; endfor; ?>
                        </div>
                        <span class="cd-purchase__reviews">(<?= number_format($rating, 1) ?> rating)</span>
                    </div>
                </div>
                <div class="cd-purchase__price-row">
                    <span class="cd-purchase__price">$<?= number_format($course['price'] ?? 0, 2) ?></span>
                </div>

                <?php if ($is_enrolled): ?>
                <div class="cd-enrolled-badge">
                    <span class="material-symbols-outlined" aria-hidden="true">verified</span>
                    You own this course
                </div>
                <a href="<?= htmlspecialchars(BASE_URL) ?>/user/my-courses" class="cd-btn cd-btn--primary cd-btn--full">
                    <span class="material-symbols-outlined" aria-hidden="true">play_circle</span>
                    Start Learning
                </a>
                <?php elseif ($is_logged_in): ?>
                <div class="cd-purchase__actions">
                    <form method="POST" action="<?= htmlspecialchars(BASE_URL) ?>/courses/enroll">
                        <input type="hidden" name="course_id" value="<?= (int) $course['course_id'] ?>">
                        <button type="submit" class="cd-btn cd-btn--primary cd-btn--full">
                            <span class="material-symbols-outlined" aria-hidden="true">school</span>
                            Enroll Now
                        </button>
                    </form>

                    <?php if ($is_in_cart): ?>
                    <a href="<?= htmlspecialchars(BASE_URL) ?>/courses/cart" class="cd-btn cd-btn--outline cd-btn--full">
                        <span class="material-symbols-outlined" aria-hidden="true">shopping_cart</span>
                        View Cart
                    </a>
                    <?php else: ?>
                    <form method="POST" action="<?= htmlspecialchars(BASE_URL) ?>/courses/addToCart">
                        <input type="hidden" name="course_id" value="<?= (int) $course['course_id'] ?>">
                        <button type="submit" class="cd-btn cd-btn--outline cd-btn--full">
                            <span class="material-symbols-outlined" aria-hidden="true">add_shopping_cart</span>
                            Add to Cart
                        </button>
                    </form>
                    <?php endif; ?>
                </div>
                <?php else: ?>
                <div class="cd-purchase__actions">
                    <a href="<?= htmlspecialchars(BASE_URL) ?>/auth/login" class="cd-btn cd-btn--primary cd-btn--full">
                        <span class="material-symbols-outlined" aria-hidden="true">login</span>
                        Login to Enroll
                    </a>
                    <?php if (!$is_in_cart): ?>
                    <form method="POST" action="<?= htmlspecialchars(BASE_URL) ?>/courses/addToCart">
                        <input type="hidden" name="course_id" value="<?= (int) $course['course_id'] ?>">
                        <button type="submit" class="cd-btn cd-btn--outline cd-btn--full">
                            <span class="material-symbols-outlined" aria-hidden="true">add_shopping_cart</span>
                            Add to Cart
                        </button>
                    </form>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <div class="cd-purchase__highlights">
                    <p class="cd-purchase__highlights-title">Course Highlights:</p>
                    <ul class="cd-purchase__list">
                        <li>
                            <span class="material-symbols-outlined" aria-hidden="true">all_inclusive</span>
                            Lifetime Access to all materials
                        </li>
                        <li>
                            <span class="material-symbols-outlined" aria-hidden="true">workspace_premium</span>
                            Professional Certificate of Completion
                        </li>
                        <li>
                            <span class="material-symbols-outlined" aria-hidden="true">devices</span>
                            Access on mobile, tablet, and desktop
                        </li>
                        <li>
                            <span class="material-symbols-outlined" aria-hidden="true">quiz</span>
                            Interactive coding challenges
                        </li>
                        <li>
                            <span class="material-symbols-outlined" aria-hidden="true">download</span>
                            Downloadable resources
                        </li>
                    </ul>
                </div>
            </div>
        </aside>
    </div>

    <section class="cd-body" aria-labelledby="cd-desc-heading">
        <div class="cd-prose-block">
            <h2 id="cd-desc-heading" class="cd-section-title">Detailed Course Description</h2>
            <div class="cd-prose">
                <p><?= nl2br(htmlspecialchars($course['description'] ?? 'No description available.')) ?></p>
            </div>
        </div>

        <?php if (!empty($course['location_name'])): ?>
        <div class="cd-centers">
            <h2 class="cd-section-title">Course Location &amp; Support Center</h2>
            <div class="cd-centers__grid">
                <div>
                    <p class="cd-centers__intro">Visit our support center for in-person assistance or certification exam. Click the link below to view the location on Google Maps.</p>
                    <div class="cd-location-list">
                        <div class="cd-location-card">
                            <span class="material-symbols-outlined" aria-hidden="true">location_on</span>
                            <div>
                                <h4><?= htmlspecialchars($course['location_name']) ?></h4>
                                <p><?= htmlspecialchars($course['address']) ?></p>
                                <div class="cd-location-card__meta">
                                    <a href="<?= htmlspecialchars($course['map_link']) ?>"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       class="cd-location-card__map-link">
                                        <span class="material-symbols-outlined" aria-hidden="true">map</span>
                                        View on Google Maps
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cd-map ambient-shadow">
                    <div class="cd-map__card">
                        <h3><?= htmlspecialchars($course['location_name']) ?></h3>
                        <p><?= htmlspecialchars($course['address']) ?></p>
                    </div>
                    <div class="cd-map__center-icon">
                        <span class="cd-map__pulse">
                            <span class="material-symbols-outlined cd-star--fill" aria-hidden="true">my_location</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </section>
</main>

<?php require __DIR__ . '/../includes/footer.php'; ?>
