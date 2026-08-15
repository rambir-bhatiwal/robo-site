/**
 * Theme Main JavaScript.
 *
 * @package Robo
 */

document.addEventListener('DOMContentLoaded', () => {
    'use strict';

    // Initialize core elements.
    const header = document.getElementById('masthead');
    const backToTopBtn = document.getElementById('back-to-top');

    /**
     * Topbar & Fixed Header Scroll Configuration
     */
    const topbarScrollConfig = {
        // Master switch for customized scroll behavior (true = asymmetric sensitivity & configurable duration, false = original default)
        enabled: true,

        // Downward scroll distance (px) required to hide the topbar (quick / responsive)
        hideThreshold: 6,

        // Upward accumulated scroll distance (px) required to show the topbar (prevents accidental reveal / flickering)
        showThreshold: 35,

        // Transition duration when hiding the topbar on downward scroll
        hideDuration: '0.45s',

        // Transition duration when showing the topbar on upward scroll
        showDuration: '0.35s'
    };

    /**
     * 1. Fixed Header scroll behavior (GPU-accelerated slide up/down without layout shift or vibration).
     */
    const handleHeaderScroll = () => {
        const topbar = document.querySelector('.topbar');
        if (!header || !topbar) return;

        // Helper to format transition duration string
        const formatDuration = (val) => (typeof val === 'number' ? `${val}ms` : val);
        const setHeaderTransition = (duration) => {
            if (duration) {
                header.style.transition = `transform ${formatDuration(duration)} cubic-bezier(0.4, 0, 0.2, 1), background-color 0.3s ease, box-shadow 0.3s ease`;
            }
        };

        // Keep body padding-top matched to full header height so content never jumps
        const updateHeaderPadding = () => {
            const headerHeight = header.offsetHeight;
            document.body.style.paddingTop = headerHeight + 'px';
        };

        updateHeaderPadding();
        window.addEventListener('resize', updateHeaderPadding);

        let lastScrollY = Math.max(0, window.scrollY);
        let isHidden = false;
        let ticking = false;
        let accumulatedUp = 0;
        let accumulatedDown = 0;

        const updateHeader = () => {
            const currentScrollY = Math.max(0, window.scrollY);
            const scrollDelta = currentScrollY - lastScrollY;

            // Check if mobile menu is currently expanded
            const navbarCollapse = document.getElementById('primaryNavbar');
            const isMobileMenuOpen = navbarCollapse && navbarCollapse.classList.contains('show');
            const topbarHeight = topbar.offsetHeight || 40;

            if (currentScrollY <= 0 || isMobileMenuOpen) {
                // At top of page or mobile menu open -> slide header to 0
                if (isHidden) {
                    if (topbarScrollConfig.enabled && topbarScrollConfig.showDuration) {
                        setHeaderTransition(topbarScrollConfig.showDuration);
                    }
                    header.style.transform = 'translateY(0)';
                    isHidden = false;
                }
                accumulatedUp = 0;
                accumulatedDown = 0;
            } else if (!topbarScrollConfig.enabled) {
                // Fallback to original scroll behavior when custom config is disabled
                header.style.transition = '';
                if (scrollDelta > 0) {
                    if (!isHidden) {
                        header.style.transform = `translateY(-${topbarHeight}px)`;
                        isHidden = true;
                    }
                } else if (scrollDelta < 0) {
                    if (isHidden) {
                        header.style.transform = 'translateY(0)';
                        isHidden = false;
                    }
                }
            } else if (scrollDelta > 0) {
                // Scrolling DOWN -> accumulate down movement and hide topbar
                accumulatedDown += scrollDelta;
                accumulatedUp = 0;

                if (!isHidden && accumulatedDown >= topbarScrollConfig.hideThreshold) {
                    if (topbarScrollConfig.hideDuration) {
                        setHeaderTransition(topbarScrollConfig.hideDuration);
                    }
                    header.style.transform = `translateY(-${topbarHeight}px)`;
                    isHidden = true;
                    accumulatedDown = 0;
                }
            } else if (scrollDelta < 0) {
                // Scrolling UP -> accumulate up movement; show topbar only after exceeding showThreshold
                accumulatedUp += Math.abs(scrollDelta);
                accumulatedDown = 0;

                if (isHidden && accumulatedUp >= topbarScrollConfig.showThreshold) {
                    if (topbarScrollConfig.showDuration) {
                        setHeaderTransition(topbarScrollConfig.showDuration);
                    }
                    header.style.transform = 'translateY(0)';
                    isHidden = false;
                    accumulatedUp = 0;
                }
            }

            // Update header shadow state
            if (currentScrollY > 50) {
                header.classList.add('shadow');
                header.classList.remove('shadow-sm');
            } else {
                header.classList.add('shadow-sm');
                header.classList.remove('shadow');
            }

            lastScrollY = currentScrollY;
            ticking = false;
        };

        window.addEventListener('scroll', () => {
            if (!ticking) {
                window.requestAnimationFrame(updateHeader);
                ticking = true;
            }
        }, { passive: true });

        updateHeader();
    };

    handleHeaderScroll();

    /**
     * 2. Back To Top button visibility and action.
     */
    if (backToTopBtn) {
        const toggleBackToTopBtn = () => {
            if (window.scrollY > 300) {
                backToTopBtn.style.setProperty('display', 'flex', 'important');
                setTimeout(() => {
                    backToTopBtn.style.opacity = '1';
                    backToTopBtn.style.transform = 'scale(1)';
                }, 10);
            } else {
                backToTopBtn.style.opacity = '0';
                backToTopBtn.style.transform = 'scale(0.8)';
                setTimeout(() => {
                    if (window.scrollY <= 300) {
                        backToTopBtn.style.setProperty('display', 'none', 'important');
                    }
                }, 300);
            }
        };

        window.addEventListener('scroll', toggleBackToTopBtn);
        toggleBackToTopBtn();

        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // /**
    //  * 3. Fix dropdown interaction on desktop and mobile devices (prevent page navigation/reload).
    //  */
    // const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    
    // // Helper function to close all open dropdowns
    // const closeAllDropdowns = (exceptToggle = null) => {
    //     document.querySelectorAll('.dropdown-menu.show').forEach((menu) => {
    //         const parentLi = menu.closest('.dropdown, .dropdown-submenu');
    //         if (exceptToggle) {
    //             const exceptParent = exceptToggle.closest('.dropdown, .dropdown-submenu');
    //             const exceptMenu = exceptParent ? exceptParent.querySelector('.dropdown-menu') : null;
    //             if (menu === exceptMenu || (exceptParent && exceptParent.contains(menu))) {
    //                 return;
    //             }
    //         }
    //         menu.classList.remove('show');
    //         if (parentLi) {
    //             parentLi.classList.remove('show');
    //         }
    //     });
    //     document.querySelectorAll('.dropdown-toggle.show').forEach((tgl) => {
    //         if (exceptToggle && tgl === exceptToggle) {
    //             return;
    //         }
    //         tgl.classList.remove('show');
    //         tgl.setAttribute('aria-expanded', 'false');
    //     });
    // };

    // dropdownToggles.forEach((toggle) => {
    //     toggle.addEventListener('click', (e) => {
    //         const href = toggle.getAttribute('href');
    //         const hasValidUrl = href && href !== '#' && href !== 'javascript:void(0)';
            
    //         const parentLi = toggle.closest('.dropdown, .dropdown-submenu');
    //         const nextMenu = parentLi ? parentLi.querySelector('.dropdown-menu') : null;

    //         if (!nextMenu) {
    //             return;
    //         }

    //         const isNested = toggle.closest('.dropdown-menu') !== null;

    //         // Desktop logic
    //         if (window.innerWidth >= 992) {
    //             if (hasValidUrl) {
    //                 const isOpen = nextMenu.classList.contains('show');
                    
    //                 if (!isOpen) {
    //                     // First click: dropdown is closed. Open it and prevent navigation.
    //                     e.preventDefault();
    //                     e.stopPropagation();
                        
    //                     if (!isNested) {
    //                         closeAllDropdowns(toggle);
    //                     }
                        
    //                     nextMenu.classList.add('show');
    //                     toggle.classList.add('show');
    //                     if (parentLi) {
    //                         parentLi.classList.add('show');
    //                     }
    //                     toggle.setAttribute('aria-expanded', 'true');
    //                 } else {
    //                     // Second click: dropdown is open. Navigate to the link.
    //                     window.location.href = href;
    //                 }
    //             } else {
    //                 // No valid URL: toggle dropdown
    //                 e.preventDefault();
    //                 e.stopPropagation();
                    
    //                 const isOpen = nextMenu.classList.contains('show');
    //                 if (!isNested && !isOpen) {
    //                     closeAllDropdowns(toggle);
    //                 }
                    
    //                 nextMenu.classList.toggle('show');
    //                 toggle.classList.toggle('show');
    //                 if (parentLi) {
    //                     parentLi.classList.toggle('show');
    //                 }
    //                 toggle.setAttribute('aria-expanded', isOpen ? 'false' : 'true');
    //             }
    //         } else {
    //             // Mobile logic: always toggle, prevent navigation
    //             e.preventDefault();
    //             e.stopPropagation();
                
    //             const isOpen = nextMenu.classList.contains('show');
    //             if (!isNested && !isOpen) {
    //                 closeAllDropdowns(toggle);
    //             }
                
    //             nextMenu.classList.toggle('show');
    //             toggle.classList.toggle('show');
    //             if (parentLi) {
    //                 parentLi.classList.toggle('show');
    //             }
    //             toggle.setAttribute('aria-expanded', isOpen ? 'false' : 'true');
    //         }
    //     });
    // });

    // Close dropdowns when clicking outside (commented out as custom dropdown JS is disabled)
    // document.addEventListener('click', (e) => {
    //     if (!e.target.closest('.dropdown') && !e.target.closest('.dropdown-submenu')) {
    //         closeAllDropdowns();
    //     }
    // });

    /**
     * 4. Bootstrap form validations helper.
     */
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach((form) => {
        form.addEventListener('submit', (event) => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });

    // Close mobile menu when hash links are clicked (useful for landing pages).
    const navLinks = document.querySelectorAll('#primaryNavbar .nav-link');
    const navbarCollapse = document.getElementById('primaryNavbar');
    if (navbarCollapse) {
        // Retrieve Bootstrap Collapse instance if it exists.
        navLinks.forEach((link) => {
            link.addEventListener('click', () => {
                const href = link.getAttribute('href');
                if (href && href.startsWith('#')) {
                    if (typeof bootstrap !== 'undefined' && bootstrap.Collapse) {
                        const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
                        if (bsCollapse) {
                            bsCollapse.hide();
                        }
                    }
                }
            });
        });
    }
});



document.addEventListener("DOMContentLoaded",function(){

const cards=document.querySelectorAll(".service-card");

const observer=new IntersectionObserver(entries=>{

entries.forEach(entry=>{

if(entry.isIntersecting){

entry.target.classList.add("show");

}

});

},{threshold:.2});

cards.forEach(card=>observer.observe(card));

});