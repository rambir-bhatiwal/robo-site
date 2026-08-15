/* ==========================================================
 * Product Categories Slider Configuration
 * ========================================================== */

const CATEGORY_SLIDER_CONFIG = {

    /* --------------------------------------------------
     | Slider Type
     |---------------------------------------------------
     | continuous = True marquee conveyor-belt scrolling
     | step       = One slide at a time (Carousel mode)
     -------------------------------------------------- */
    slideType: 'continuous',

    /* --------------------------------------------------
     | Continuous Marquee Speed (Pixels Per Second)
     |
     | Used ONLY in 'continuous' mode.
     |
     | Examples:
     | 10  = Very Slow
     | 20  = Slow (Default)
     | 30  = Normal
     | 50  = Fast
     | 100 = Very Fast
     -------------------------------------------------- */
    continuousSpeed: 40,

    /* --------------------------------------------------
     | Delay before next slide starts (Step Mode)
     | (In Seconds)
     -------------------------------------------------- */
    slideDelay: 2,

    /* --------------------------------------------------
     | Time taken to move ONE slide (Step Mode)
     | (In Seconds)
     -------------------------------------------------- */
    slideTransitionDuration: 1,

    /* --------------------------------------------------
     | Autoplay
     -------------------------------------------------- */
    autoplay: true,

    /* --------------------------------------------------
     | Pause slider ONLY while hovering a category card
     -------------------------------------------------- */
    pauseOnCardHover: true,

    /* --------------------------------------------------
     | Pause slider ONLY while hovering navigation arrows
     -------------------------------------------------- */
    pauseOnArrowHover: true,

    /* --------------------------------------------------
     | Responsive Slides Per View
     |
     | Number of category cards visible on each device.
     -------------------------------------------------- */
    slidesPerView: {
        mobile: 2,
        tablet: 3,
        desktop: 4
    },

    /* --------------------------------------------------
     | Space Between Slides (px)
     |
     | Controls the gap between category cards.
     | Simply change these values for each device.
     -------------------------------------------------- */
    spaceBetween: {
        mobile: 12,
        tablet: 20,
        desktop: 24
    },

    /* --------------------------------------------------
     | Loop
     -------------------------------------------------- */
    loop: true,

    /* --------------------------------------------------
     | Show Navigation Arrows
     -------------------------------------------------- */
    navigation: true,

    /* --------------------------------------------------
     | Show Pagination Dots
     -------------------------------------------------- */
    pagination: true,

    /* --------------------------------------------------
     | Touch / Swipe on Mobile & Tablet
     -------------------------------------------------- */
    touchSwipe: true,
    swipeThreshold: 40

};

document.addEventListener('DOMContentLoaded', function () {
    const sliderContainer = document.querySelector('.robo-category-slider');
    if (!sliderContainer) return;

    const track = sliderContainer.querySelector('.robo-category-slider__track');
    const prevBtn = sliderContainer.querySelector('.robo-category-slider__nav--prev');
    const nextBtn = sliderContainer.querySelector('.robo-category-slider__nav--next');
    const dotsContainer = sliderContainer.querySelector('.robo-category-slider__dots');

    if (!track) return;

    let originalSlides = Array.from(track.children);
    if (originalSlides.length === 0) return;

    const originalCount = originalSlides.length;

    // Helper: get space between for current device
    function getSpaceBetween() {
        const width = window.innerWidth;
        if (typeof CATEGORY_SLIDER_CONFIG.spaceBetween === 'object') {
            if (width <= 767.98) return CATEGORY_SLIDER_CONFIG.spaceBetween.mobile;
            if (width <= 1024) return CATEGORY_SLIDER_CONFIG.spaceBetween.tablet;
            return CATEGORY_SLIDER_CONFIG.spaceBetween.desktop;
        }
        return CATEGORY_SLIDER_CONFIG.spaceBetween;
    }

    // Helper: get slides per view for current device
    function getSlidesPerView() {
        const width = window.innerWidth;
        if (width <= 767.98) return CATEGORY_SLIDER_CONFIG.slidesPerView.mobile;
        if (width <= 1024) return CATEGORY_SLIDER_CONFIG.slidesPerView.tablet;
        return CATEGORY_SLIDER_CONFIG.slidesPerView.desktop;
    }

    // Helper: Bind hover pause events for cards and arrows
    function bindPauseEvents(onPause, onResume) {
        if (CATEGORY_SLIDER_CONFIG.pauseOnCardHover) {
            track.querySelectorAll('.robo-category-card').forEach(card => {
                card.addEventListener('mouseenter', onPause);
                card.addEventListener('mouseleave', onResume);
            });
        }

        if (CATEGORY_SLIDER_CONFIG.pauseOnArrowHover) {
            if (prevBtn) {
                prevBtn.addEventListener('mouseenter', onPause);
                prevBtn.addEventListener('mouseleave', onResume);
            }
            if (nextBtn) {
                nextBtn.addEventListener('mouseenter', onPause);
                nextBtn.addEventListener('mouseleave', onResume);
            }
        }
    }

    /* ==========================================================
     | 1) PURE HARDWARE MARQUEE ENGINE (CONTINUOUS MODE)
     |=========================================================== */
    function initContinuousMarqueeEngine() {
        track.style.transition = 'none';
        track.style.willChange = 'transform';
        track.style.transformStyle = 'preserve-3d';

        // Duplicate original slides once: [Original Set][Duplicated Set]
        if (CATEGORY_SLIDER_CONFIG.loop) {
            for (let i = 0; i < originalCount; i++) {
                const clone = originalSlides[i].cloneNode(true);
                clone.classList.add('robo-category-slider__slide--clone');
                track.appendChild(clone);
            }
        }

        let allSlides = Array.from(track.children);
        let keyframeStyleElement = null;
        let setWidth = 0;
        let stepWidth = 0;
        let dotButtons = [];
        let activeDotIdx = 0;
        let isNavigating = false;

        function updateLayoutAndSpeed(startX = 0) {
            const gap = getSpaceBetween();
            track.style.gap = `${gap}px`;

            const spv = Math.max(1, getSlidesPerView());
            const flexBasis = `calc((100% - ${(spv - 1) * gap}px) / ${spv})`;

            allSlides.forEach(s => {
                s.style.flex = `0 0 ${flexBasis}`;
                s.style.maxWidth = flexBasis;
            });

            if (allSlides[0]) {
                stepWidth = allSlides[0].getBoundingClientRect().width + gap;
            }

            setWidth = 0;
            for (let i = 0; i < originalCount; i++) {
                if (allSlides[i]) {
                    setWidth += allSlides[i].getBoundingClientRect().width + gap;
                }
            }

            if (setWidth <= 0) return;

            startMarqueeAnimation(startX);
        }

        function startMarqueeAnimation(startX = 0) {
            if (setWidth <= 0) return;

            const speed = Math.max(1, CATEGORY_SLIDER_CONFIG.continuousSpeed);
            const duration = setWidth / speed;

            if (!keyframeStyleElement) {
                keyframeStyleElement = document.createElement('style');
                keyframeStyleElement.id = 'robo-category-marquee-style';
                document.head.appendChild(keyframeStyleElement);
            }

            const normX = Math.abs(startX) % setWidth;

            keyframeStyleElement.textContent = `
                @keyframes roboMarqueeConveyor {
                    0% {
                        transform: translate3d(-${normX.toFixed(3)}px, 0, 0);
                    }
                    100% {
                        transform: translate3d(-${(normX + setWidth).toFixed(3)}px, 0, 0);
                    }
                }
            `;

            if (CATEGORY_SLIDER_CONFIG.autoplay && !isNavigating) {
                track.style.transition = 'none';
                track.style.animation = `roboMarqueeConveyor ${duration.toFixed(4)}s linear infinite`;
            }
        }

        // Pagination Dots
        function createDots() {
            if (!dotsContainer || !CATEGORY_SLIDER_CONFIG.pagination) return;
            dotsContainer.innerHTML = '';
            dotButtons = [];

            for (let i = 0; i < originalCount; i++) {
                const dot = document.createElement('button');
                dot.className = `robo-category-dot${i === 0 ? ' active' : ''}`;
                dot.setAttribute('type', 'button');
                dot.setAttribute('aria-label', `Go to category slide ${i + 1}`);
                dot.addEventListener('click', () => {
                    navigateToIndex(i);
                });
                dotsContainer.appendChild(dot);
                dotButtons.push(dot);
            }
            activeDotIdx = 0;
        }

        function updateDotHighlight(newIdx) {
            if (newIdx !== activeDotIdx && dotButtons[newIdx]) {
                if (dotButtons[activeDotIdx]) dotButtons[activeDotIdx].classList.remove('active');
                dotButtons[newIdx].classList.add('active');
                activeDotIdx = newIdx;
            }
        }

        // Continuous Dot Active Tracking loop
        function trackDotsLoop() {
            if (CATEGORY_SLIDER_CONFIG.pagination && setWidth > 0 && stepWidth > 0 && !isNavigating) {
                try {
                    const style = window.getComputedStyle(track);
                    const matrixStr = style.transform || style.webkitTransform;
                    if (matrixStr && matrixStr !== 'none') {
                        const matrix = new DOMMatrix(matrixStr);
                        const currentX = Math.abs(matrix.m41);
                        const norm = currentX % setWidth;
                        const idx = Math.floor(norm / stepWidth) % originalCount;
                        updateDotHighlight(idx);
                    }
                } catch (e) {}
            }
            requestAnimationFrame(trackDotsLoop);
        }

        function navigateToIndex(targetIdx) {
            if (setWidth <= 0 || stepWidth <= 0) return;
            isNavigating = true;
            track.style.animation = 'none';

            const targetX = targetIdx * stepWidth;
            track.style.transition = 'transform 0.4s cubic-bezier(0.25, 1, 0.5, 1)';
            track.style.transform = `translate3d(-${targetX}px, 0, 0)`;
            updateDotHighlight(targetIdx);

            setTimeout(() => {
                isNavigating = false;
                track.style.transition = 'none';
                startMarqueeAnimation(targetX);
            }, 400);
        }

        // Navigation Arrows in Continuous Mode
        if (nextBtn) {
            nextBtn.style.display = CATEGORY_SLIDER_CONFIG.navigation ? '' : 'none';
            nextBtn.addEventListener('click', () => {
                const nextIdx = (activeDotIdx + 1) % originalCount;
                navigateToIndex(nextIdx);
            });
        }

        if (prevBtn) {
            prevBtn.style.display = CATEGORY_SLIDER_CONFIG.navigation ? '' : 'none';
            prevBtn.addEventListener('click', () => {
                const prevIdx = (activeDotIdx - 1 + originalCount) % originalCount;
                navigateToIndex(prevIdx);
            });
        }

        if (dotsContainer) {
            dotsContainer.style.display = CATEGORY_SLIDER_CONFIG.pagination ? '' : 'none';
        }

        createDots();
        updateLayoutAndSpeed(0);

        // Bind Pause / Resume
        bindPauseEvents(
            () => { track.style.animationPlayState = 'paused'; },
            () => { track.style.animationPlayState = 'running'; }
        );

        // Re-calculate when images finish loading or window resizes
        track.querySelectorAll('img').forEach(img => {
            if (!img.complete) {
                img.addEventListener('load', () => updateLayoutAndSpeed(0));
            }
        });
        // Enable touch/swipe interaction for mobile and tablet touch devices.
        // Arrow navigation remains unchanged.
        // Horizontal gestures move slides while vertical gestures remain available for normal page scrolling.
        function initTouchSwipe() {
            if (!CATEGORY_SLIDER_CONFIG.touchSwipe) return;

            let touchStartX = 0;
            let touchStartY = 0;
            let touchDiffX = 0;
            let isSwiping = false;
            let isScrolling = undefined;
            let wasPausedByTouch = false;

            const onTouchStart = (e) => {
                if (window.innerWidth > 1024 && !('ontouchstart' in window)) return;
                const touch = e.touches[0];
                touchStartX = touch.clientX;
                touchStartY = touch.clientY;
                touchDiffX = 0;
                isSwiping = false;
                isScrolling = undefined;

                wasPausedByTouch = true;
                track.style.animationPlayState = 'paused';
            };

            const onTouchMove = (e) => {
                if (!wasPausedByTouch) return;
                const touch = e.touches[0];
                const diffX = touch.clientX - touchStartX;
                const diffY = touch.clientY - touchStartY;

                if (isScrolling === undefined) {
                    if (Math.abs(diffY) > Math.abs(diffX)) {
                        isScrolling = true; // Vertical page scroll
                    } else if (Math.abs(diffX) > 8) {
                        isScrolling = false; // Horizontal gesture
                    }
                }

                if (isScrolling === false) {
                    if (e.cancelable) e.preventDefault();
                    isSwiping = true;
                    touchDiffX = diffX;
                }
            };

            const onTouchEnd = () => {
                if (wasPausedByTouch) {
                    wasPausedByTouch = false;
                    track.style.animationPlayState = 'running';
                }

                if (isSwiping && isScrolling === false) {
                    const threshold = CATEGORY_SLIDER_CONFIG.swipeThreshold || 40;
                    if (touchDiffX <= -threshold) {
                        // Swiped Left -> Move to Next Slide
                        const nextIdx = (activeDotIdx + 1) % originalCount;
                        navigateToIndex(nextIdx);
                    } else if (touchDiffX >= threshold) {
                        // Swiped Right -> Move to Previous Slide
                        const prevIdx = (activeDotIdx - 1 + originalCount) % originalCount;
                        navigateToIndex(prevIdx);
                    }

                    // Prevent triggering link click on card during swipe
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

        requestAnimationFrame(trackDotsLoop);
    }

    /* ==========================================================
     | 2) STEP CAROUSEL ENGINE (STEP MODE - UNTOUCHED)
     |=========================================================== */
    function initStepCarouselEngine() {
        if (CATEGORY_SLIDER_CONFIG.loop) {
            for (let i = 0; i < originalCount; i++) {
                const clone = originalSlides[i].cloneNode(true);
                clone.classList.add('robo-category-slider__slide--clone');
                track.appendChild(clone);
            }
        }

        let allSlides = Array.from(track.children);
        let dotButtons = [];
        let currentTranslate = 0;
        let isPaused = false;
        let isDragging = false;
        let startX = 0;
        let dragStartTranslate = 0;
        let stepInterval = null;
        let activeDotIdx = 0;
        let cachedStepWidth = 0;
        let cachedSetWidth = 0;

        function updateMetrics() {
            if (allSlides.length === 0) return;
            const firstSlide = allSlides[0];
            const secondSlide = allSlides[1];
            
            if (secondSlide) {
                cachedStepWidth = secondSlide.offsetLeft - firstSlide.offsetLeft;
            } else {
                cachedStepWidth = firstSlide.getBoundingClientRect().width + getSpaceBetween();
            }

            if (CATEGORY_SLIDER_CONFIG.loop && allSlides[originalCount]) {
                cachedSetWidth = allSlides[originalCount].offsetLeft - firstSlide.offsetLeft;
            } else {
                cachedSetWidth = cachedStepWidth * originalCount;
            }
        }

        function applyDynamicStyles() {
            const gap = getSpaceBetween();
            track.style.gap = `${gap}px`;

            const spv = Math.max(1, getSlidesPerView());
            const flexBasis = `calc((100% - ${(spv - 1) * gap}px) / ${spv})`;

            allSlides.forEach(slide => {
                slide.style.flex = `0 0 ${flexBasis}`;
                slide.style.maxWidth = flexBasis;
            });

            if (prevBtn) prevBtn.style.display = CATEGORY_SLIDER_CONFIG.navigation ? '' : 'none';
            if (nextBtn) nextBtn.style.display = CATEGORY_SLIDER_CONFIG.navigation ? '' : 'none';
            if (dotsContainer) dotsContainer.style.display = CATEGORY_SLIDER_CONFIG.pagination ? '' : 'none';

            updateMetrics();
        }

        function stepToNext() {
            if (!CATEGORY_SLIDER_CONFIG.autoplay || isPaused || isDragging) return;

            const animMs = Math.max(100, CATEGORY_SLIDER_CONFIG.slideTransitionDuration * 1000);
            track.style.transition = `transform ${CATEGORY_SLIDER_CONFIG.slideTransitionDuration}s cubic-bezier(0.25, 1, 0.5, 1)`;
            currentTranslate -= cachedStepWidth;

            if (CATEGORY_SLIDER_CONFIG.loop && Math.abs(currentTranslate) >= cachedSetWidth) {
                setTimeout(() => {
                    track.style.transition = 'none';
                    currentTranslate += cachedSetWidth;
                    track.style.transform = `translate3d(${currentTranslate}px, 0, 0)`;
                }, animMs);
            }

            track.style.transform = `translate3d(${currentTranslate}px, 0, 0)`;
            updateActiveDot();
        }

        function startStepAutoplay() {
            stopStepAutoplay();
            if (!CATEGORY_SLIDER_CONFIG.autoplay) return;

            const delayMs = Math.max(100, CATEGORY_SLIDER_CONFIG.slideDelay * 1000);
            const animMs = Math.max(100, CATEGORY_SLIDER_CONFIG.slideTransitionDuration * 1000);
            stepInterval = setInterval(stepToNext, delayMs + animMs);
        }

        function stopStepAutoplay() {
            if (stepInterval) {
                clearInterval(stepInterval);
                stepInterval = null;
            }
        }

        function createDots() {
            if (!dotsContainer || !CATEGORY_SLIDER_CONFIG.pagination) return;
            dotsContainer.innerHTML = '';
            dotButtons = [];

            for (let i = 0; i < originalCount; i++) {
                const dot = document.createElement('button');
                dot.className = `robo-category-dot${i === 0 ? ' active' : ''}`;
                dot.setAttribute('type', 'button');
                dot.setAttribute('aria-label', `Go to category slide ${i + 1}`);
                dot.addEventListener('click', () => {
                    track.style.transition = `transform ${CATEGORY_SLIDER_CONFIG.slideTransitionDuration}s cubic-bezier(0.25, 1, 0.5, 1)`;
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
            if (!dotsContainer || !CATEGORY_SLIDER_CONFIG.pagination || originalCount === 0 || cachedStepWidth <= 0) return;

            let normalizedPos = Math.abs(currentTranslate) % cachedSetWidth;
            let newActiveIdx = Math.round(normalizedPos / cachedStepWidth) % originalCount;

            if (newActiveIdx !== activeDotIdx) {
                if (dotButtons[activeDotIdx]) dotButtons[activeDotIdx].classList.remove('active');
                if (dotButtons[newActiveIdx]) dotButtons[newActiveIdx].classList.add('active');
                activeDotIdx = newActiveIdx;
            }
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                track.style.transition = `transform ${CATEGORY_SLIDER_CONFIG.slideTransitionDuration}s cubic-bezier(0.25, 1, 0.5, 1)`;
                currentTranslate -= cachedStepWidth;
                if (CATEGORY_SLIDER_CONFIG.loop && Math.abs(currentTranslate) >= cachedSetWidth) {
                    currentTranslate += cachedSetWidth;
                }
                track.style.transform = `translate3d(${currentTranslate}px, 0, 0)`;
                updateActiveDot();
            });
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                track.style.transition = `transform ${CATEGORY_SLIDER_CONFIG.slideTransitionDuration}s cubic-bezier(0.25, 1, 0.5, 1)`;
                currentTranslate += cachedStepWidth;
                if (CATEGORY_SLIDER_CONFIG.loop && currentTranslate > 0) {
                    currentTranslate -= cachedSetWidth;
                }
                track.style.transform = `translate3d(${currentTranslate}px, 0, 0)`;
                updateActiveDot();
            });
        }

        bindPauseEvents(
            () => { isPaused = true; stopStepAutoplay(); },
            () => { isPaused = false; startStepAutoplay(); }
        );

        // Enable touch/swipe interaction for mobile and tablet touch devices in Step mode.
        function initStepTouchSwipe() {
            if (!CATEGORY_SLIDER_CONFIG.touchSwipe) return;

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
                stopStepAutoplay();
            };

            const onTouchMove = (e) => {
                const touch = e.touches[0];
                const diffX = touch.clientX - touchStartX;
                const diffY = touch.clientY - touchStartY;

                if (isScrolling === undefined) {
                    if (Math.abs(diffY) > Math.abs(diffX)) {
                        isScrolling = true; // Vertical page scroll
                    } else if (Math.abs(diffX) > 8) {
                        isScrolling = false; // Horizontal gesture
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
                startStepAutoplay();

                if (isSwiping && isScrolling === false) {
                    const threshold = CATEGORY_SLIDER_CONFIG.swipeThreshold || 40;
                    if (touchDiffX <= -threshold) {
                        // Swiped Left -> Next Slide
                        if (nextBtn) {
                            nextBtn.click();
                        } else {
                            track.style.transition = `transform ${CATEGORY_SLIDER_CONFIG.slideTransitionDuration}s cubic-bezier(0.25, 1, 0.5, 1)`;
                            currentTranslate -= cachedStepWidth;
                            if (CATEGORY_SLIDER_CONFIG.loop && Math.abs(currentTranslate) >= cachedSetWidth) {
                                currentTranslate += cachedSetWidth;
                            }
                            track.style.transform = `translate3d(${currentTranslate}px, 0, 0)`;
                            updateActiveDot();
                        }
                    } else if (touchDiffX >= threshold) {
                        // Swiped Right -> Previous Slide
                        if (prevBtn) {
                            prevBtn.click();
                        } else {
                            track.style.transition = `transform ${CATEGORY_SLIDER_CONFIG.slideTransitionDuration}s cubic-bezier(0.25, 1, 0.5, 1)`;
                            currentTranslate += cachedStepWidth;
                            if (CATEGORY_SLIDER_CONFIG.loop && currentTranslate > 0) {
                                currentTranslate -= cachedSetWidth;
                            }
                            track.style.transform = `translate3d(${currentTranslate}px, 0, 0)`;
                            updateActiveDot();
                        }
                    }

                    // Prevent triggering link click on card during swipe
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

        initStepTouchSwipe();

        applyDynamicStyles();
        createDots();
        startStepAutoplay();
    }

    // INITIALIZATION ROUTER
    if (CATEGORY_SLIDER_CONFIG.slideType === 'continuous') {
        initContinuousMarqueeEngine();
    } else {
        initStepCarouselEngine();
    }
});
