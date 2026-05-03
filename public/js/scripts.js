/**
 * EduStream Catalog Pagination
 * - Show max 9 courses per page
 * - Dynamic pagination based on total courses
 */
(function () {
  var ITEMS_PER_PAGE = 9;
  var currentPage = 1;
  var allCourses = [];
  var totalPages = 0;

  var grid, pagination, metaText;

  function init() {
    grid = document.querySelector('.catalog-grid');
    pagination = document.querySelector('.catalog-pagination');
    metaText = document.querySelector('.catalog-toolbar__meta');

    if (!grid || !pagination) return;

    // Clone course articles for client-side pagination
    var articles = Array.from(grid.querySelectorAll('.catalog-card'));
    if (articles.length === 0) return;

    allCourses = articles;
    totalPages = Math.ceil(allCourses.length / ITEMS_PER_PAGE);

    renderPage(currentPage);
    renderPagination();
    updateMeta();
  }

  function renderPage(page) {
    currentPage = page;
    var start = (page - 1) * ITEMS_PER_PAGE;
    var end = start + ITEMS_PER_PAGE;

    allCourses.forEach(function (article, index) {
      article.style.display = (index >= start && index < end) ? '' : 'none';
    });

    renderPagination();
    updateMeta();
  }

  function renderPagination() {
    if (totalPages <= 1) {
      pagination.innerHTML = '';
      return;
    }

    var html = '';

    // Previous button
    html += '<button type="button" class="catalog-pagination__btn" ' +
            'aria-label="Previous page" ' +
            (currentPage === 1 ? 'disabled style="opacity:0.5;cursor:not-allowed;"' : '') + '>' +
            '<span class="material-symbols-outlined">chevron_left</span></button>';

    // Page numbers
    var pages = getPageNumbers();

    pages.forEach(function (p) {
      if (p === '...') {
        html += '<span class="catalog-pagination__ellipsis">…</span>';
      } else {
        var isCurrent = (p === currentPage);
        html += '<button type="button" class="catalog-pagination__btn' +
                (isCurrent ? ' catalog-pagination__btn--current' : '') + '"' +
                (isCurrent ? ' aria-current="page"' : '') + '>' + p + '</button>';
      }
    });

    // Next button
    html += '<button type="button" class="catalog-pagination__btn catalog-pagination__next"' +
            ' aria-label="Next page"' +
            (currentPage === totalPages ? ' disabled style="opacity:0.5;cursor:not-allowed;"' : '') + '>' +
            'Next <span class="material-symbols-outlined">chevron_right</span></button>';

    pagination.innerHTML = html;

    // Attach event listeners
    pagination.querySelectorAll('.catalog-pagination__btn:not(.catalog-pagination__btn--current)').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var label = btn.getAttribute('aria-label');
        if (label === 'Previous page' && currentPage > 1) {
          renderPage(currentPage - 1);
        } else if (label === 'Next page' && currentPage < totalPages) {
          renderPage(currentPage + 1);
        } else if (!label) {
          var pageNum = parseInt(btn.textContent.trim(), 10);
          if (!isNaN(pageNum)) {
            renderPage(pageNum);
          }
        }
      });
    });
  }

  function getPageNumbers() {
    var pages = [];
    var delta = 1;

    if (totalPages <= 7) {
      for (var i = 1; i <= totalPages; i++) pages.push(i);
    } else {
      pages.push(1);

      if (currentPage > 3) pages.push('...');

      var start = Math.max(2, currentPage - delta);
      var end = Math.min(totalPages - 1, currentPage + delta);

      for (var i = start; i <= end; i++) pages.push(i);

      if (currentPage < totalPages - 2) pages.push('...');

      pages.push(totalPages);
    }

    return pages;
  }

  function updateMeta() {
    if (!metaText) return;
    var start = (currentPage - 1) * ITEMS_PER_PAGE + 1;
    var end = Math.min(currentPage * ITEMS_PER_PAGE, allCourses.length);
    var total = allCourses.length;

    if (total <= ITEMS_PER_PAGE) {
      metaText.textContent = 'Showing ' + total + ' courses';
    } else {
      metaText.textContent = 'Showing ' + start + '-' + end + ' of ' + total + ' courses';
    }
  }

  // Init when DOM ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
