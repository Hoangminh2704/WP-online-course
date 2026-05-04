<?php
$pageTitle = $data['title'] ?? 'Course Catalog — EduStream';
$bodyClass = 'site-page catalog-page';
$navActive = 'courses';
$stylesheets = ['/public/css/home.css', '/public/css/catalog.css'];
$categories = $data['categories'] ?? [];
$activeCategoryId = $data['active_category_id'] ?? 0;
$activeCategoryName = $data['active_category_name'] ?? 'All Courses';
$courses = $data['courses'] ?? [];
require __DIR__ . '/../includes/header.php';
?>

<main class="catalog-main">
    <nav class="catalog-breadcrumb" aria-label="Breadcrumb">
        <a href="<?= htmlspecialchars(BASE_URL) ?>/">Home</a>
        <span class="material-symbols-outlined catalog-breadcrumb__sep" aria-hidden="true">chevron_right</span>
        <a href="<?= htmlspecialchars(BASE_URL) ?>/courses">Courses</a>
        <span class="material-symbols-outlined catalog-breadcrumb__sep" aria-hidden="true">chevron_right</span>
        <span class="catalog-breadcrumb__current"><?= htmlspecialchars($activeCategoryName) ?></span>
    </nav>

    <div class="catalog-layout">
        <aside class="catalog-sidebar" aria-label="Course categories">
            <div class="catalog-sidebar__head">
                <h2 class="catalog-sidebar__title">Categories</h2>
                <p class="catalog-sidebar__sub">Explore by topic</p>
            </div>
            <nav class="catalog-sidebar__nav">
                <a class="catalog-sidebar__link<?= $activeCategoryId === 0 ? ' catalog-sidebar__link--active' : '' ?>" href="<?= htmlspecialchars(BASE_URL) ?>/courses">
                    <span class="material-symbols-outlined" aria-hidden="true">code</span>
                    <span>All Courses</span>
                </a>
                <?php foreach ($categories as $category): ?>
                    <?php
                        $isActive = (int) $category['category_id'] === (int) $activeCategoryId;
                        $categorySlug = $category['slug'] ?? '';
                        $categoryHref = $categorySlug
                            ? (BASE_URL . '/courses/category/' . rawurlencode($categorySlug))
                            : (BASE_URL . '/courses?category=' . urlencode((string) $category['category_id']));
                    ?>
                    <a class="catalog-sidebar__link<?= $isActive ? ' catalog-sidebar__link--active' : '' ?>"
                        href="<?= htmlspecialchars($categoryHref) ?>">
                        <span class="material-symbols-outlined" aria-hidden="true">category</span>
                        <span><?= htmlspecialchars($category['category_name']) ?></span>
                    </a>
                <?php endforeach; ?>
            </nav>
            <div class="catalog-sidebar__cta">
                <button type="button" class="catalog-sidebar__cta-btn">Request Subject</button>
            </div>
            <div class="catalog-sidebar__footer">
                <a href="<?= htmlspecialchars(BASE_URL) ?>/help"><span class="material-symbols-outlined">help</span> Help Center</a>
                <a href="#"><span class="material-symbols-outlined">settings</span> Settings</a>
            </div>
        </aside>

        <div class="catalog-content">
            <div class="catalog-toolbar">
                <div class="catalog-toolbar__titles">
                    <h1><?= htmlspecialchars($activeCategoryName) ?></h1>
                    <p class="catalog-toolbar__meta">Showing <?= count($courses ?? []) ?> courses</p>
                </div>
                <div class="catalog-toolbar__sort">
                    <span class="catalog-toolbar__sort-label">Sort by:</span>
                    <label class="visually-hidden" for="catalog-sort">Sort courses</label>
                    <select id="catalog-sort" class="catalog-toolbar__select">
                        <option>Price</option>
                        <option selected>Rating</option>
                        <option>Newest</option>
                        <option>Popularity</option>
                    </select>
                </div>
            </div>

            <div class="catalog-grid">
                <?php if (!empty($courses)): ?>
                    <?php foreach($courses as $course): ?>
                    <article class="catalog-card">
                        <div class="catalog-card__media">
                            <img class="catalog-card__img" alt="<?= htmlspecialchars($course['title']) ?>"
                                 src="<?= !empty($course['image_url']) ? htmlspecialchars($course['image_url']) : BASE_URL . '/public/images/default-course.jpg' ?>">
                        </div>
                        <div class="catalog-card__body">
                            <h3 class="catalog-card__title">
                                <a href="<?= htmlspecialchars(BASE_URL) ?>/courses/detail/<?= htmlspecialchars($course['slug']) ?>">
                                    <?= htmlspecialchars($course['title']) ?>
                                </a>
                            </h3>
                            <p class="catalog-card__author"><?= htmlspecialchars($course['instructor'] ?? '') ?></p>
                            <div class="catalog-card__rating">
                                <div class="catalog-card__stars" aria-hidden="true">
                                    <?php
                                    $rating = floatval($course['rating'] ?? 0);
                                    $fullStars = floor($rating);
                                    $hasHalf = ($rating - $fullStars) >= 0.5;
                                    for ($i = 0; $i < 5; $i++):
                                        if ($i < $fullStars):
                                    ?>
                                        <span class="material-symbols-outlined catalog-star--fill">star</span>
                                    <?php elseif ($i === $fullStars && $hasHalf): ?>
                                        <span class="material-symbols-outlined catalog-star--fill">star_half</span>
                                    <?php else: ?>
                                        <span class="material-symbols-outlined">star</span>
                                    <?php endif; endfor; ?>
                                </div>
                                <span class="catalog-card__score"><?= number_format($rating, 1) ?></span>
                            </div>
                            <div class="catalog-card__footer">
                                <div class="catalog-card__price">$<?= number_format($course['price'] ?? 0, 2) ?></div>
                                <button type="button" class="catalog-card__bookmark" aria-label="Save course">
                                    <span class="material-symbols-outlined">bookmark</span>
                                </button>
                            </div>
                        </div>
                    </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="catalog-empty">No courses found.</p>
                <?php endif; ?>
            </div>

            <nav class="catalog-pagination" aria-label="Pagination">
                <button type="button" class="catalog-pagination__btn" aria-label="Previous page"><span class="material-symbols-outlined">chevron_left</span></button>
                <button type="button" class="catalog-pagination__btn catalog-pagination__btn--current" aria-current="page">1</button>
                <a class="catalog-pagination__btn" href="#">2</a>
                <a class="catalog-pagination__btn" href="#">3</a>
                <span class="catalog-pagination__ellipsis">…</span>
                <a class="catalog-pagination__btn catalog-pagination__next" href="#">Next <span class="material-symbols-outlined">chevron_right</span></a>
            </nav>
        </div>
    </div>
</main>

<?php require __DIR__ . '/../includes/footer.php'; ?>
<script src="<?= htmlspecialchars(BASE_URL) ?>/public/js/scripts.js" defer></script>
