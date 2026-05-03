(function () {
  var base = typeof window.__BASE_URL__ === "string" ? window.__BASE_URL__ : "";
  var input = document.getElementById("nav-search-q");
  var panel = document.getElementById("nav-search-results");
  if (!input || !panel) return;

  var debounceTimer = null;

  function escapeHtml(s) {
    var d = document.createElement("div");
    d.textContent = s;
    return d.innerHTML;
  }

  function hidePanel() {
    panel.hidden = true;
    panel.innerHTML = "";
  }

  function buildUrl(q) {
    var root = base.replace(/\/?$/, "");
    return root + "/search/suggest?q=" + encodeURIComponent(q);
  }

  function renderResults(items) {
    if (items.length === 0) {
      panel.innerHTML =
        '<div class="home-nav__search-empty" role="status">No courses found.</div>';
      panel.hidden = false;
      return;
    }
    var html = items
      .map(function (r) {
        var meta =
          escapeHtml(r.instructor || "") +
          (r.price ? " · $" + escapeHtml(String(r.price)) : "");
        return (
          '<a role="option" class="home-nav__search-item" href="' +
          escapeHtml(r.url) +
          '">' +
          '<span class="home-nav__search-item-title">' +
          escapeHtml(r.title) +
          "</span>" +
          '<span class="home-nav__search-item-meta">' +
          meta +
          "</span></a>"
        );
      })
      .join("");
    panel.innerHTML = html;
    panel.hidden = false;
  }

  function fetchSuggest(q) {
    if (!q.trim()) {
      hidePanel();
      return;
    }
    fetch(buildUrl(q), { headers: { Accept: "application/json" } })
      .then(function (res) {
        if (!res.ok) throw new Error("bad status");
        return res.json();
      })
      .then(function (data) {
        renderResults(data.results || []);
      })
      .catch(function () {
        panel.innerHTML =
          '<div class="home-nav__search-empty" role="alert">Search unavailable.</div>';
        panel.hidden = false;
      });
  }

  input.addEventListener("input", function () {
    clearTimeout(debounceTimer);
    var v = input.value;
    debounceTimer = setTimeout(function () {
      fetchSuggest(v);
    }, 280);
  });

  input.addEventListener("keydown", function (e) {
    if (e.key === "Escape") hidePanel();
  });

  document.addEventListener("click", function (e) {
    if (e.target.closest(".home-nav__search")) return;
    hidePanel();
  });
})();
