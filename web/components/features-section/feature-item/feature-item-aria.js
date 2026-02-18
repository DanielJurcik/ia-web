// This script adds aria-expanded to summary elements inside details for accessibility

document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('details.more-info-details').forEach(function (detailsEl) {
    var summary = detailsEl.querySelector('summary');
    if (!summary) return;

    // Set initial state
    summary.setAttribute('aria-expanded', detailsEl.open ? 'true' : 'false');

    // Listen for toggle events
    detailsEl.addEventListener('toggle', function () {
      summary.setAttribute('aria-expanded', detailsEl.open ? 'true' : 'false');
    });
  });
});
