/* ==========================================================
 * Robo Theme - Customer Reviews Slider JS
 * ========================================================== */

document.addEventListener('DOMContentLoaded', function () {
    const section = document.querySelector('.robo-reviews-section');
    if (!section) return;

    const track = section.querySelector('.robo-reviews-track');
    if (!track) return; // In grid mode, track won't exist

    const prevBtn = section.querySelector('.robo-reviews-nav--prev');
    const nextBtn = section.querySelector('.robo-reviews-nav--next');
    const dotsContainer = section.querySelector('.robo-reviews-dots');

    const configAttr = section.getAttribute('data-reviews-config');
    let config = {
        autoplay: true,
        autoplaySpeed: 4,
        desktopColumns: 3,
        tabletColumns: 2,
        mobileColumns: 1,
        touchSwipe: true,
        swipeThreshold: 40
    };

    if (configAttr) {
        try {
            config = Object.assign(config, JSON.parse(configAttr));
        } catch (e) {}
    }

    let originalSlides = Array.from(track.children);
    if (originalSlides.length === 0) return;
    const originalCount = originalSlides.length;

    // Clone slides for infinite smooth loop
    for (let i = 0; i < originalCount; i++) {
        const clone = originalSlides[i].cloneNode(true);
        clone.classList.add('robo-reviews-slide--clone');
        track.appendChild(clone);
    }

    let allSlides = Array.from(track.children);
    let currentTranslate = 0;
    let isPaused = false;
    let autoplayTimer = null;
    let activeDotIdx = 0;
    let dotButtons = [];
    let cachedStepWidth = 0;
    let cachedSetWidth = 0;

    function getDeviceColumns() {
        const width = window.innerWidth;
        if (width <= 767.98) return config.mobileColumns || 1;
        if (width <= 1024) return config.tabletColumns || 2;
        return config.desktopColumns || 3;
    }

    function updateMetrics() {
        if (allSlides.length === 0) return;
        const gap = window.innerWidth <= 767.98 ? 16 : 24;
        const cols = Math.max(1, getDeviceColumns());
        const flexBasis = `calc((100% - ${(cols - 1) * gap}px) / ${cols})`;

        allSlides.forEach(slide => {
            slide.style.flex = `0 0 ${flexBasis}`;
            slide.style.maxWidth = flexBasis;
        });

        const first = allSlides[0];
        const second = allSlides[1];
        if (second) {
            cachedStepWidth = second.offsetLeft - first.offsetLeft;
        } else {
            cachedStepWidth = first.getBoundingClientRect().width + gap;
        }

        if (allSlides[originalCount]) {
            cachedSetWidth = allSlides[originalCount].offsetLeft - first.offsetLeft;
        } else {
            cachedSetWidth = cachedStepWidth * originalCount;
        }
    }

    function stepNext() {
        if (!config.autoplay || isPaused) return;

        track.style.transition = 'transform 0.5s cubic-bezier(0.25, 1, 0.5, 1)';
        currentTranslate -= cachedStepWidth;

        if (Math.abs(currentTranslate) >= cachedSetWidth) {
            setTimeout(() => {
                track.style.transition = 'none';
                currentTranslate += cachedSetWidth;
                track.style.transform = `translate3d(${currentTranslate}px, 0, 0)`;
            }, 500);
        }

        track.style.transform = `translate3d(${currentTranslate}px, 0, 0)`;
        updateActiveDot();
    }

    function startAutoplay() {
        stopAutoplay();
        if (config.autoplay) {
            const intervalMs = Math.max(1000, (config.autoplaySpeed || 4) * 1000);
            autoplayTimer = setInterval(stepNext, intervalMs);
        }
    }

    function stopAutoplay() {
        if (autoplayTimer) {
            clearInterval(autoplayTimer);
            autoplayTimer = null;
        }
    }

    function createDots() {
        if (!dotsContainer) return;
        dotsContainer.innerHTML = '';
        dotButtons = [];

        for (let i = 0; i < originalCount; i++) {
            const dot = document.createElement('button');
            dot.className = `robo-reviews-dot${i === 0 ? ' active' : ''}`;
            dot.setAttribute('type', 'button');
            dot.setAttribute('aria-label', `Go to review slide ${i + 1}`);
            dot.addEventListener('click', () => {
                track.style.transition = 'transform 0.5s cubic-bezier(0.25, 1, 0.5, 1)';
                currentTranslate = -(i * cachedStepWidth);
                track.style.transform = `translate3d(${currentTranslate}px, 0, 0)`;
                updateActiveDot();
            });
            dotsContainer.appendChild(dot);
            dotButtons.push(dot);
        }
        activeDotIdx = 0;
    }

    function updateActiveDot() {
        if (!dotsContainer || originalCount === 0 || cachedStepWidth <= 0) return;
        let norm = Math.abs(currentTranslate) % cachedSetWidth;
        let newIdx = Math.round(norm / cachedStepWidth) % originalCount;

        if (newIdx !== activeDotIdx && dotButtons[newIdx]) {
            if (dotButtons[activeDotIdx]) dotButtons[activeDotIdx].classList.remove('active');
            dotButtons[newIdx].classList.add('active');
            activeDotIdx = newIdx;
        }
    }

    function goToNext() {
        track.style.transition = 'transform 0.5s cubic-bezier(0.25, 1, 0.5, 1)';
        currentTranslate -= cachedStepWidth;
        if (Math.abs(currentTranslate) >= cachedSetWidth) {
            currentTranslate += cachedSetWidth;
        }
        track.style.transform = `translate3d(${currentTranslate}px, 0, 0)`;
        updateActiveDot();
    }

    function goToPrev() {
        track.style.transition = 'transform 0.5s cubic-bezier(0.25, 1, 0.5, 1)';
        currentTranslate += cachedStepWidth;
        if (currentTranslate > 0) {
            currentTranslate -= cachedSetWidth;
        }
        track.style.transform = `translate3d(${currentTranslate}px, 0, 0)`;
        updateActiveDot();
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', goToNext);
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', goToPrev);
    }

    // Enable touch/swipe interaction for mobile and tablet touch devices.
    // Arrow navigation remains unchanged.
    // Horizontal gestures move slides while vertical gestures remain available for normal page scrolling.
    function initTouchSwipe() {
        if (!config.touchSwipe) return;

        let touchStartX = 0;
        let touchStartY = 0;
        let touchDiffX = 0;
        let isSwiping = false;
        let isScrolling = undefined;

        const onTouchStart = (e) => {
            if (window.innerWidth > 1024 && !('ontouchstart' in window)) return;
            const touch = e.touches[0];
            touchStartX = touch.clientX;
            touchStartY = touch.clientY;
            touchDiffX = 0;
            isSwiping = false;
            isScrolling = undefined;
            isPaused = true;
            stopAutoplay();
        };

        const onTouchMove = (e) => {
            const touch = e.touches[0];
            const diffX = touch.clientX - touchStartX;
            const diffY = touch.clientY - touchStartY;

            if (isScrolling === undefined) {
                if (Math.abs(diffY) > Math.abs(diffX)) {
                    isScrolling = true; // User is scrolling vertically
                } else if (Math.abs(diffX) > 8) {
                    isScrolling = false; // User is swiping horizontally
                }
            }

            if (isScrolling === false) {
                if (e.cancelable) e.preventDefault();
                isSwiping = true;
                touchDiffX = diffX;
            }
        };

        const onTouchEnd = () => {
            isPaused = false;
            startAutoplay();

            if (isSwiping && isScrolling === false) {
                const threshold = config.swipeThreshold || 40;
                if (touchDiffX <= -threshold) {
                    // Swiped Left -> Next Slide
                    goToNext();
                } else if (touchDiffX >= threshold) {
                    // Swiped Right -> Previous Slide
                    goToPrev();
                }

                // Prevent accidental click inside card during drag
                const preventClick = (ev) => {
                    ev.preventDefault();
                    ev.stopPropagation();
                };
                track.addEventListener('click', preventClick, { capture: true, once: true });
                setTimeout(() => {
                    track.removeEventListener('click', preventClick, { capture: true });
                }, 100);
            }

            isSwiping = false;
            isScrolling = undefined;
        };

        track.addEventListener('touchstart', onTouchStart, { passive: true });
        track.addEventListener('touchmove', onTouchMove, { passive: false });
        track.addEventListener('touchend', onTouchEnd, { passive: true });
        track.addEventListener('touchcancel', onTouchEnd, { passive: true });
    }

    initTouchSwipe();

    // Pause Autoplay ONLY on Card Hover
    track.querySelectorAll('.robo-reviews-card').forEach(card => {
        card.addEventListener('mouseenter', () => {
            isPaused = true;
            stopAutoplay();
        });

        card.addEventListener('mouseleave', () => {
            isPaused = false;
            startAutoplay();
        });
    });

    window.addEventListener('resize', () => {
        updateMetrics();
    });

    updateMetrics();
    createDots();
    startAutoplay();
});
