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
        let isNavigating = false;
        let snapTimeout = null;

        // =========================================================
        // SINGLE SOURCE OF TRUTH FOR CURRENT SLIDE INDEX
        // =========================================================
        // Stores the canonical active slide index [0, originalCount - 1].
        // Updated synchronously by drag completion, arrow clicks, dot clicks,
        // and desktop marquee tracking.
        // =========================================================
        let currentContinueSlideIndex = 0;

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

        // =========================================================
        // CENTRALIZED DOT SYNCHRONIZATION FUNCTION
        // =========================================================
        // Responsible for updating the visual state of all pagination dots.
        // Strips .active from all inactive dots and applies .active only
        // to the dot matching targetIndex.
        // =========================================================
        function updateContinueSliderDots(targetIndex) {
            if (!dotsContainer || dotButtons.length === 0 || originalCount === 0) return;

            // Normalize and clamp target index to valid slide boundary [0, originalCount - 1]
            const safeIndex = ((targetIndex % originalCount) + originalCount) % originalCount;
            currentContinueSlideIndex = safeIndex;

            // Synchronize active classes across all pagination dots
            dotButtons.forEach((dot, idx) => {
                if (idx === safeIndex) {
                    dot.classList.add('active');
                    dot.setAttribute('aria-current', 'true');
                } else {
                    dot.classList.remove('active');
                    dot.removeAttribute('aria-current');
                }
            });
        }

        // =========================================================
        // CREATE PAGINATION DOTS
        // =========================================================
        // Creates DOM buttons for each slide and registers click handlers.
        // =========================================================
        function createDots() {
            if (!dotsContainer || !CATEGORY_SLIDER_CONFIG.pagination) return;
            dotsContainer.innerHTML = '';
            dotButtons = [];

            for (let i = 0; i < originalCount; i++) {
                const dot = document.createElement('button');
                dot.className = `robo-category-dot${i === 0 ? ' active' : ''}`;
                dot.setAttribute('type', 'button');
                dot.setAttribute('aria-label', `Go to category slide ${i + 1}`);
                if (i === 0) dot.setAttribute('aria-current', 'true');

                // DOT-CLICK NAVIGATION: Triggers slide movement and dot update
                dot.addEventListener('click', () => {
                    navigateToIndex(i);
                });

                dotsContainer.appendChild(dot);
                dotButtons.push(dot);
            }

            updateContinueSliderDots(currentContinueSlideIndex);
        }

        // Continuous Dot Active Tracking loop (Desktop continuous marquee autoplay only)
        function trackDotsLoop() {
            if (CATEGORY_SLIDER_CONFIG.pagination && setWidth > 0 && stepWidth > 0 && !isNavigating && window.innerWidth > 1024) {
                try {
                    const style = window.getComputedStyle(track);
                    const matrixStr = style.transform || style.webkitTransform;
                    if (matrixStr && matrixStr !== 'none') {
                        const matrix = new DOMMatrix(matrixStr);
                        const currentX = Math.abs(matrix.m41);
                        const norm = currentX % setWidth;
                        const idx = Math.floor(norm / stepWidth) % originalCount;
                        if (idx !== currentContinueSlideIndex) {
                            updateContinueSliderDots(idx);
                        }
                    }
                } catch (e) {}
            }
            requestAnimationFrame(trackDotsLoop);
        }

        // =========================================================
        // DRAG / SWIPE COMPLETION SNAP HANDLER
        // =========================================================
        // Called when a touch/drag gesture ends. Calculates the shortest
        // distance snap, updates pagination dots immediately, and eases track.
        // =========================================================
        function snapToSlideIndex(targetIdx, currentX) {
            if (setWidth <= 0 || stepWidth <= 0) return;
            if (snapTimeout) {
                clearTimeout(snapTimeout);
                snapTimeout = null;
            }
            isNavigating = true;
            track.style.animation = 'none';

            // Normalize target index
            const safeIdx = ((targetIdx % originalCount) + originalCount) % originalCount;

            // DRAG COMPLETION DOT SYNC: Update single source of truth & active dot immediately
            updateContinueSliderDots(safeIdx);

            const targetX = safeIdx * stepWidth;
            let desiredTranslate = -targetX;

            // Calculate shortest visual distance between currentX and desiredTranslate
            const delta = desiredTranslate - currentX;
            if (delta > setWidth / 2) {
                desiredTranslate -= setWidth;
            } else if (delta < -setWidth / 2) {
                desiredTranslate += setWidth;
            }

            track.style.transition = 'transform 0.35s cubic-bezier(0.25, 1, 0.5, 1)';
            track.style.transform = `translate3d(${desiredTranslate}px, 0, 0)`;

            snapTimeout = setTimeout(() => {
                isNavigating = false;
                track.style.transition = 'none';
                track.style.transform = `translate3d(-${targetX}px, 0, 0)`;
                if (CATEGORY_SLIDER_CONFIG.autoplay && window.innerWidth > 1024) {
                    startMarqueeAnimation(targetX);
                }
                snapTimeout = null;
            }, 350);
        }

        // =========================================================
        // DISCRETE SLIDE NAVIGATION HANDLER (ARROWS & DOT CLICKS)
        // =========================================================
        // Moves the slider to a specific slide index and updates dots.
        // =========================================================
        function navigateToIndex(targetIdx) {
            if (setWidth <= 0 || stepWidth <= 0) return;
            if (snapTimeout) {
                clearTimeout(snapTimeout);
                snapTimeout = null;
            }
            isNavigating = true;
            track.style.animation = 'none';

            // Normalize target index
            const safeIdx = ((targetIdx % originalCount) + originalCount) % originalCount;

            // ARROW / DOT CLICK DOT SYNC: Update single source of truth & active dot immediately
            updateContinueSliderDots(safeIdx);

            const targetX = safeIdx * stepWidth;
            track.style.transition = 'transform 0.35s cubic-bezier(0.25, 1, 0.5, 1)';
            track.style.transform = `translate3d(-${targetX}px, 0, 0)`;

            snapTimeout = setTimeout(() => {
                isNavigating = false;
                track.style.transition = 'none';
                if (CATEGORY_SLIDER_CONFIG.autoplay && window.innerWidth > 1024) {
                    startMarqueeAnimation(targetX);
                }
                snapTimeout = null;
            }, 350);
        }

        // =========================================================
        // ARROW NAVIGATION EVENT LISTENERS
        // =========================================================
        if (nextBtn) {
            nextBtn.style.display = CATEGORY_SLIDER_CONFIG.navigation ? '' : 'none';
            // NEXT ARROW: Advances from currentContinueSlideIndex to next slide
            nextBtn.addEventListener('click', () => {
                const nextIdx = (currentContinueSlideIndex + 1) % originalCount;
                navigateToIndex(nextIdx);
            });
        }

        if (prevBtn) {
            prevBtn.style.display = CATEGORY_SLIDER_CONFIG.navigation ? '' : 'none';
            // PREVIOUS ARROW: Reverses from currentContinueSlideIndex to previous slide
            prevBtn.addEventListener('click', () => {
                const prevIdx = (currentContinueSlideIndex - 1 + originalCount) % originalCount;
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

        // =========================================================
        // CONTROLLED MOBILE LIVE DRAGGING (NO MOMENTUM / NO SKIPPING)
        // =========================================================
        // Provides exact 1:1 real-time finger tracking without multi-slide
        // throwing or runaway acceleration on repeated direction changes.
        // =========================================================
        function initTouchSwipe() {
            if (!CATEGORY_SLIDER_CONFIG.touchSwipe) return;

            // 1. DRAG STATE VARIABLES
            let dragStartX = 0;             // Touch start clientX
            let dragStartY = 0;             // Touch start clientY
            let dragStartTranslate = 0;     // Stable normalized track translate at drag start
            let startSlideIndex = 0;        // Slide index when drag started
            let touchDeltaX = 0;            // Net displacement (currentX - startX)
            let isDragging = false;         // True once horizontal movement is confirmed
            let isScrolling = undefined;    // True if gesture is vertical page scroll
            let wasPausedByTouch = false;   // Flags that background motion was paused
            let rafId = null;               // requestAnimationFrame handle for 60fps throttling
            let pendingTranslate = 0;       // Buffered translate value for rAF render

            // 2. DRAG START HANDLER
            const onTouchStart = (e) => {
                if (window.innerWidth > 1024 && !('ontouchstart' in window)) return;

                // Clear any pending snap timers from previous gestures
                if (snapTimeout) {
                    clearTimeout(snapTimeout);
                    snapTimeout = null;
                }
                if (rafId) {
                    cancelAnimationFrame(rafId);
                    rafId = null;
                }

                const touch = e.touches[0];
                dragStartX = touch.clientX;
                dragStartY = touch.clientY;
                touchDeltaX = 0;
                isDragging = false;
                isScrolling = undefined;
                wasPausedByTouch = true;
                isNavigating = true; // Lock background loops during active gesture

                // 3. CAPTURE CURRENT TRANSLATE POSITION
                let currentMatrixX = 0;
                try {
                    const style = window.getComputedStyle(track);
                    const matrixStr = style.transform || style.webkitTransform;
                    if (matrixStr && matrixStr !== 'none') {
                        const matrix = new DOMMatrix(matrixStr);
                        currentMatrixX = matrix.m41;
                    }
                } catch (err) {}

                // Normalize starting translate within (-setWidth, 0]
                if (setWidth > 0) {
                    currentMatrixX = currentMatrixX % setWidth;
                    if (currentMatrixX > 0) currentMatrixX -= setWidth;
                }

                dragStartTranslate = currentMatrixX;
                // DRAG START INDEX: Stored from single source of truth or computed matrix
                startSlideIndex = currentContinueSlideIndex;

                // Freeze animations immediately so the track is directly connected to the touch
                track.style.animation = 'none';
                track.style.transition = 'none';
                track.style.transform = `translate3d(${dragStartTranslate}px, 0, 0)`;
            };

            // 4. LIVE DRAG MOVE HANDLER
            const onTouchMove = (e) => {
                if (!wasPausedByTouch) return;

                const touch = e.touches[0];
                const deltaX = touch.clientX - dragStartX;
                const deltaY = touch.clientY - dragStartY;
                const absX = Math.abs(deltaX);
                const absY = Math.abs(deltaY);

                // 5. GESTURE DISCRIMINATION (6px Deadband)
                if (isScrolling === undefined) {
                    if (absX >= 6 || absY >= 6) {
                        if (absX >= absY) {
                            isScrolling = false; // Horizontal slider drag
                            isDragging = true;
                        } else {
                            isScrolling = true;  // Vertical page scroll
                            isNavigating = false;
                            if (CATEGORY_SLIDER_CONFIG.autoplay && window.innerWidth > 1024) {
                                startMarqueeAnimation(Math.abs(dragStartTranslate));
                            }
                            return;
                        }
                    }
                }

                // 6. LIVE TRANSFORM UPDATE (SYNCHRONIZED WITH RAF)
                if (isScrolling === false && isDragging) {
                    if (e.cancelable) e.preventDefault();
                    touchDeltaX = deltaX;

                    // Calculate live position from immutable starting anchor
                    const rawTranslate = dragStartTranslate + deltaX;

                    // Wrap within canonical range (-setWidth, 0] for continuous slide coverage
                    let liveTranslate = rawTranslate;
                    if (setWidth > 0) {
                        liveTranslate = rawTranslate % setWidth;
                        if (liveTranslate > 0) liveTranslate -= setWidth;
                    }

                    pendingTranslate = liveTranslate;
                    if (!rafId) {
                        rafId = requestAnimationFrame(() => {
                            track.style.transition = 'none';
                            track.style.transform = `translate3d(${pendingTranslate}px, 0, 0)`;
                            rafId = null;
                        });
                    }
                }
            };

            // 7. DRAG RELEASE & CONTROLLED SNAP (NO MOMENTUM / NO MULTI-SLIDE SKIPPING)
            const onTouchEnd = () => {
                if (rafId) {
                    cancelAnimationFrame(rafId);
                    rafId = null;
                }

                if (isDragging && isScrolling === false) {
                    const threshold = CATEGORY_SLIDER_CONFIG.swipeThreshold || 40;
                    const deltaX = touchDeltaX;

                    if (setWidth > 0 && stepWidth > 0) {
                        const rawTranslate = dragStartTranslate + deltaX;
                        let liveTranslate = rawTranslate % setWidth;
                        if (liveTranslate > 0) liveTranslate -= setWidth;

                        // Controlled single-slide step decision:
                        // Move at most 1 adjacent slide or return to starting slide
                        let targetIdx;
                        if (deltaX <= -threshold) {
                            // Forward Drag (Left): advance to next adjacent slide
                            targetIdx = (startSlideIndex + 1) % originalCount;
                        } else if (deltaX >= threshold) {
                            // Backward Drag (Right): return to previous adjacent slide
                            targetIdx = (startSlideIndex - 1 + originalCount) % originalCount;
                        } else {
                            // Drag distance below threshold: return to start slide
                            targetIdx = startSlideIndex;
                        }

                        // Smooth shortest-path snap transition & dot update
                        snapToSlideIndex(targetIdx, liveTranslate);
                    } else {
                        isNavigating = false;
                        if (CATEGORY_SLIDER_CONFIG.autoplay && window.innerWidth > 1024) {
                            startMarqueeAnimation(Math.abs(dragStartTranslate));
                        }
                    }

                    // Prevent accidental card link opening on drag release
                    if (Math.abs(deltaX) > 5) {
                        const preventClick = (ev) => {
                            ev.preventDefault();
                            ev.stopPropagation();
                        };
                        track.addEventListener('click', preventClick, { capture: true, once: true });
                        setTimeout(() => {
                            track.removeEventListener('click', preventClick, { capture: true });
                        }, 100);
                    }
                } else if (wasPausedByTouch && isScrolling !== true) {
                    isNavigating = false;
                    if (CATEGORY_SLIDER_CONFIG.autoplay && window.innerWidth > 1024) {
                        startMarqueeAnimation(Math.abs(dragStartTranslate));
                    }
                }

                // 8. RESET DRAG STATE
                wasPausedByTouch = false;
                isDragging = false;
                isScrolling = undefined;
            };

            // Register touch event listeners
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

        // Real-time live touch dragging in Step mode for mobile & tablet.
        function initStepTouchSwipe() {
            if (!CATEGORY_SLIDER_CONFIG.touchSwipe) return;

            let touchStartX = 0;
            let touchStartY = 0;
            let touchDiffX = 0;
            let dragStartTranslate = 0;
            let isDragging = false;
            let isScrolling = undefined;

            const onTouchStart = (e) => {
                if (window.innerWidth > 1024 && !('ontouchstart' in window)) return;
                const touch = e.touches[0];
                touchStartX = touch.clientX;
                touchStartY = touch.clientY;
                touchDiffX = 0;
                dragStartTranslate = currentTranslate;
                isDragging = false;
                isScrolling = undefined;
                isPaused = true;
                stopStepAutoplay();

                track.style.transition = 'none';
            };

            const onTouchMove = (e) => {
                const touch = e.touches[0];
                const diffX = touch.clientX - touchStartX;
                const diffY = touch.clientY - touchStartY;

                if (isScrolling === undefined) {
                    if (Math.abs(diffY) > Math.abs(diffX)) {
                        isScrolling = true; // Vertical page scroll
                    } else if (Math.abs(diffX) > 6) {
                        isScrolling = false; // Horizontal gesture established
                        isDragging = true;
                    }
                }

                if (isScrolling === false && isDragging) {
                    if (e.cancelable) e.preventDefault();
                    touchDiffX = diffX;

                    // Real-time live dragging: move track directly with finger
                    let liveTranslate = dragStartTranslate + diffX;
                    if (CATEGORY_SLIDER_CONFIG.loop && cachedSetWidth > 0) {
                        if (liveTranslate > 0) {
                            liveTranslate -= cachedSetWidth;
                            dragStartTranslate -= cachedSetWidth;
                        } else if (Math.abs(liveTranslate) >= cachedSetWidth * 2) {
                            liveTranslate += cachedSetWidth;
                            dragStartTranslate += cachedSetWidth;
                        }
                    }

                    track.style.transition = 'none';
                    track.style.transform = `translate3d(${liveTranslate}px, 0, 0)`;
                }
            };

            const onTouchEnd = () => {
                isPaused = false;
                startStepAutoplay();

                if (isDragging && isScrolling === false) {
                    const threshold = CATEGORY_SLIDER_CONFIG.swipeThreshold || 40;
                    const diffX = touchDiffX;
                    const animMs = Math.max(100, CATEGORY_SLIDER_CONFIG.slideTransitionDuration * 1000);

                    track.style.transition = `transform ${CATEGORY_SLIDER_CONFIG.slideTransitionDuration}s cubic-bezier(0.25, 1, 0.5, 1)`;

                    if (diffX <= -threshold) {
                        // Dragged left -> Snap to Next slide
                        currentTranslate = dragStartTranslate - cachedStepWidth;
                    } else if (diffX >= threshold) {
                        // Dragged right -> Snap to Previous slide
                        currentTranslate = dragStartTranslate + cachedStepWidth;
                    } else {
                        // Small drag -> Settle smoothly back to original position
                        currentTranslate = dragStartTranslate;
                    }

                    if (CATEGORY_SLIDER_CONFIG.loop && Math.abs(currentTranslate) >= cachedSetWidth) {
                        setTimeout(() => {
                            track.style.transition = 'none';
                            currentTranslate += cachedSetWidth;
                            track.style.transform = `translate3d(${currentTranslate}px, 0, 0)`;
                        }, animMs);
                    } else if (CATEGORY_SLIDER_CONFIG.loop && currentTranslate > 0) {
                        setTimeout(() => {
                            track.style.transition = 'none';
                            currentTranslate -= cachedSetWidth;
                            track.style.transform = `translate3d(${currentTranslate}px, 0, 0)`;
                        }, animMs);
                    }

                    track.style.transform = `translate3d(${currentTranslate}px, 0, 0)`;
                    updateActiveDot();

                    // Prevent accidental link tap on card
                    if (Math.abs(diffX) > 5) {
                        const preventClick = (ev) => {
                            ev.preventDefault();
                            ev.stopPropagation();
                        };
                        track.addEventListener('click', preventClick, { capture: true, once: true });
                        setTimeout(() => {
                            track.removeEventListener('click', preventClick, { capture: true });
                        }, 100);
                    }
                }

                isDragging = false;
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
