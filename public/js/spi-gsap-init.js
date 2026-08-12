/**
 * SPI POLINEMA — GSAP Micro-Interaction Animations
 * spi-gsap-init.js
 * Loaded globally from layout/app.blade.php
 * Requires GSAP 3.12+ CDN
 */

(function () {
  'use strict';

  // Guard: exit if GSAP not loaded
  if (typeof gsap === 'undefined') return;

  // ─── 1. Register ScrollTrigger (if available)
  if (typeof ScrollTrigger !== 'undefined') {
    gsap.registerPlugin(ScrollTrigger);
  }

  // ─── 2. Default ease config
  const easeSmooth = 'power2.out';
  const easeBounce = 'back.out(1.2)';

  // ─── 3. Page Entrance Animation
  function runPageEntrance() {
    // Animate the main content wrapper
    var content = document.querySelector('.main-content, .spi-content, [class*="main-content"]');
    if (content) {
      gsap.fromTo(content,
        { opacity: 0, y: 16 },
        { opacity: 1, y: 0, duration: 0.45, ease: easeSmooth, delay: 0.05 }
      );
    }

    // Page header animation
    var pageHeader = document.querySelector('.spi-page-header, .section-header');
    if (pageHeader) {
      gsap.fromTo(pageHeader,
        { opacity: 0, y: -10 },
        { opacity: 1, y: 0, duration: 0.35, ease: easeSmooth, delay: 0.1 }
      );
    }
  }

  // ─── 4. Stat Cards Stagger
  function animateStatCards() {
    var cards = document.querySelectorAll('.spi-stat-card, .spi-stagger-item');
    if (cards.length > 0) {
      gsap.fromTo(cards,
        { opacity: 0, y: 20, scale: 0.97 },
        {
          opacity: 1,
          y: 0,
          scale: 1,
          duration: 0.4,
          ease: easeSmooth,
          stagger: 0.06,
          delay: 0.2
        }
      );
    }
  }

  // ─── 5. Card Entrance
  function animateCards() {
    var cards = document.querySelectorAll('.spi-card, .card');
    if (cards.length > 0) {
      gsap.fromTo(cards,
        { opacity: 0, y: 18 },
        {
          opacity: 1,
          y: 0,
          duration: 0.4,
          ease: easeSmooth,
          stagger: 0.05,
          delay: 0.25
        }
      );
    }
  }

  // ─── 6. Table Row Stagger
  function animateTableRows() {
    var rows = document.querySelectorAll('.spi-table tbody tr, .table tbody tr');
    if (rows.length > 0) {
      gsap.fromTo(rows,
        { opacity: 0, x: -8 },
        {
          opacity: 1,
          x: 0,
          duration: 0.28,
          ease: easeSmooth,
          stagger: 0.025,
          delay: 0.35
        }
      );
    }
  }

  // ─── 7. Sidebar Nav Items
  function animateSidebarItems() {
    var items = document.querySelectorAll('.spi-nav-item, .sidebar-menu li');
    if (items.length > 0) {
      gsap.fromTo(items,
        { opacity: 0, x: -12 },
        {
          opacity: 1,
          x: 0,
          duration: 0.25,
          ease: easeSmooth,
          stagger: 0.025,
          delay: 0.1
        }
      );
    }
  }

  // ─── 8. Progress Bar Animation
  function animateProgressBars() {
    var bars = document.querySelectorAll('.spi-progress-bar, .progress-bar');
    bars.forEach(function (bar) {
      var targetWidth = bar.style.width || bar.getAttribute('aria-valuenow') + '%';
      var numericValue = parseFloat(targetWidth);
      if (!isNaN(numericValue)) {
        bar.style.width = '0%';
        gsap.to(bar, {
          width: numericValue + '%',
          duration: 1.2,
          ease: 'power2.inOut',
          delay: 0.5
        });
      }
    });
  }

  // ─── 9. Hover Effect Helpers
  function attachHoverEffects() {
    // Stat cards — subtle glow on hover
    document.querySelectorAll('.spi-stat-card').forEach(function (card) {
      card.addEventListener('mouseenter', function () {
        gsap.to(card, { y: -3, duration: 0.18, ease: easeSmooth });
      });
      card.addEventListener('mouseleave', function () {
        gsap.to(card, { y: 0, duration: 0.18, ease: easeSmooth });
      });
    });

    // Buttons — press effect
    document.querySelectorAll('.spi-btn').forEach(function (btn) {
      btn.addEventListener('mousedown', function () {
        gsap.to(btn, { scale: 0.96, duration: 0.1, ease: easeSmooth });
      });
      btn.addEventListener('mouseup', function () {
        gsap.to(btn, { scale: 1.02, duration: 0.1, ease: easeBounce });
        setTimeout(function () {
          gsap.to(btn, { scale: 1, duration: 0.15, ease: easeSmooth });
        }, 100);
      });
    });
  }

  // ─── 10. Alert Auto-dismiss animation
  function attachAlertDismiss() {
    document.querySelectorAll('.spi-alert-close, [data-dismiss="alert"]').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var alert = btn.closest('.spi-alert, .alert');
        if (alert) {
          gsap.to(alert, {
            opacity: 0,
            height: 0,
            marginBottom: 0,
            paddingTop: 0,
            paddingBottom: 0,
            duration: 0.3,
            ease: easeSmooth,
            onComplete: function () { alert.remove(); }
          });
        }
      });
    });
  }

  // ─── 11. Dropdown Animation
  function attachDropdownAnimations() {
    // Topbar dropdowns
    document.querySelectorAll('[data-spi-dropdown-toggle]').forEach(function (trigger) {
      var targetId = trigger.getAttribute('data-spi-dropdown-toggle');
      var dropdown = document.getElementById(targetId);
      if (!dropdown) return;

      trigger.addEventListener('click', function (e) {
        e.stopPropagation();
        if (dropdown.classList.contains('show')) {
          gsap.to(dropdown, {
            opacity: 0,
            y: -6,
            duration: 0.15,
            ease: easeSmooth,
            onComplete: function () { dropdown.classList.remove('show'); }
          });
        } else {
          dropdown.classList.add('show');
          gsap.fromTo(dropdown,
            { opacity: 0, y: -8 },
            { opacity: 1, y: 0, duration: 0.18, ease: easeSmooth }
          );
        }
      });
    });

    // Close on outside click
    document.addEventListener('click', function () {
      document.querySelectorAll('.spi-dropdown-topbar.show').forEach(function (d) {
        gsap.to(d, {
          opacity: 0, y: -6, duration: 0.15, ease: easeSmooth,
          onComplete: function () { d.classList.remove('show'); }
        });
      });
    });
  }

  // ─── 12. Sidebar Mobile Toggle
  function attachSidebarToggle() {
    var toggleBtn = document.getElementById('spi-sidebar-toggle');
    var sidebar = document.querySelector('.spi-sidebar, .main-sidebar');
    var overlay = document.getElementById('spi-sidebar-overlay');

    if (!toggleBtn || !sidebar) return;

    toggleBtn.addEventListener('click', function () {
      sidebar.classList.toggle('show');
      if (overlay) overlay.classList.toggle('show');
    });

    if (overlay) {
      overlay.addEventListener('click', function () {
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
      });
    }
  }

  // ─── 13. Sidebar Dropdown Sub-menus
  function attachSidebarDropdowns() {
    document.querySelectorAll('.spi-nav-link[data-spi-sub]').forEach(function (link) {
      link.addEventListener('click', function (e) {
        e.preventDefault();
        var parentItem = link.closest('.spi-nav-item');
        if (!parentItem) return;

        var subMenu = parentItem.querySelector('.spi-dropdown-menu');
        if (!subMenu) return;

        var isOpen = parentItem.classList.contains('open');

        // Close all siblings
        var siblings = parentItem.parentElement.querySelectorAll('.spi-nav-item.open');
        siblings.forEach(function (sib) {
          if (sib !== parentItem) {
            var sibMenu = sib.querySelector('.spi-dropdown-menu');
            if (sibMenu) {
              gsap.to(sibMenu, {
                height: 0, opacity: 0, duration: 0.2, ease: easeSmooth,
                onComplete: function () {
                  sibMenu.style.display = 'none';
                  sib.classList.remove('open');
                }
              });
            }
          }
        });

        if (isOpen) {
          gsap.to(subMenu, {
            height: 0, opacity: 0, duration: 0.22, ease: easeSmooth,
            onComplete: function () {
              subMenu.style.display = 'none';
              parentItem.classList.remove('open');
            }
          });
        } else {
          subMenu.style.display = 'block';
          var naturalHeight = subMenu.scrollHeight;
          gsap.fromTo(subMenu,
            { height: 0, opacity: 0 },
            { height: naturalHeight, opacity: 1, duration: 0.25, ease: easeSmooth,
              onComplete: function () { subMenu.style.height = 'auto'; }
            }
          );
          parentItem.classList.add('open');
        }
      });
    });
  }

  // ─── INIT on DOM Ready
  document.addEventListener('DOMContentLoaded', function () {
    runPageEntrance();
    animateStatCards();
    animateCards();
    animateTableRows();
    animateSidebarItems();
    animateProgressBars();
    attachHoverEffects();
    attachAlertDismiss();
    attachDropdownAnimations();
    attachSidebarToggle();
    attachSidebarDropdowns();
  });

})();
