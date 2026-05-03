<?php
$pageTitle = 'EduStream - Empowering Professional Growth';
$bodyClass = 'home-page';
$navActive = 'home';
require __DIR__ . '/../includes/header.php';
?>

    <main class="home-main">
        <section class="home-hero">
            <div class="home-hero__content">
                <div class="home-hero__badge">
                    <span class="material-symbols-outlined" aria-hidden="true">school</span>
                    New Semester 2026 is Open
                </div>
                <h1 class="home-hero__title">Master New Skills with Academic Rigor</h1>
                <p class="home-hero__lead">EduStream provides high-end educational content designed for professional growth. Experience a focused learning environment built on intellectual excellence.</p>
                <div class="home-hero__actions">
                    <button type="button" class="home-hero__btn home-hero__btn--primary">Get Started</button>
                    <button type="button" class="home-hero__btn home-hero__btn--secondary">Browse Catalog</button>
                </div>
            </div>
            <div class="home-hero__media">
                <div class="home-hero__figure">
                    <img alt="Student learning" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAy5RwJvtH_ZGah185KNIzBRbjn0J6CMt-5bLpN1dDv8Qf-HjeafMcU4jozHgSOPyCdLkirezwIKSoNiBHqZymvLPJSfg_AHIUxod-vDFmD6hyESqdi7qhvg9Pd4ogj1YlgjA3lBd16yndo7AJ9IZ9Oa0Y2tKeTPw67epyRhPEib-mKn8GtjaLlbQ8HPTYy3Q1FFkGqpaJgWbu7Z8secLIRXZjb0dxPHR8_PuRxflbccqt9eUET4j1J2gQ-pxdjEE64QXyarIlvU3L8"/>
                </div>
            </div>
        </section>

        <section class="home-categories" aria-labelledby="categories-heading">
            <div class="home-categories__head">
                <div class="home-categories__intro">
                    <h2 id="categories-heading" class="home-categories__title">Explore Categories</h2>
                    <p class="home-categories__subtitle">Specialized paths for professional advancement.</p>
                </div>
            </div>
            <div class="home-categories__grid">
                <div class="home-cat-card">
                    <div class="home-cat-card__icon-wrap">
                        <span class="material-symbols-outlined" aria-hidden="true">code</span>
                    </div>
                    <h3 class="home-cat-card__name">Programming</h3>
                </div>
                <div class="home-cat-card">
                    <div class="home-cat-card__icon-wrap">
                        <span class="material-symbols-outlined" aria-hidden="true">palette</span>
                    </div>
                    <h3 class="home-cat-card__name">Design</h3>
                </div>
                <div class="home-cat-card">
                    <div class="home-cat-card__icon-wrap">
                        <span class="material-symbols-outlined" aria-hidden="true">leaderboard</span>
                    </div>
                    <h3 class="home-cat-card__name">Business</h3>
                </div>
                <div class="home-cat-card">
                    <div class="home-cat-card__icon-wrap">
                        <span class="material-symbols-outlined" aria-hidden="true">campaign</span>
                    </div>
                    <h3 class="home-cat-card__name">Marketing</h3>
                </div>
            </div>
        </section>
    </main>

<?php require __DIR__ . '/../includes/footer.php'; ?>
