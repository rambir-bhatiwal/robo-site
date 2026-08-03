/**
 * Robo Theme - Homepage V2 Interactive Scripts & Animations
 */

(function($) {
	'use strict';

	$(document).ready(function() {
		initScrollAnimations();
		initCounterAnimations();
		initCategoryFilter();
		initFAQAccordion();
	});

	/**
	 * IntersectionObserver Scroll Reveal Animations
	 */
	function initScrollAnimations() {
		const animatedElements = document.querySelectorAll('.fade-in-up, .fade-in-left, .fade-in-right, .scale-in');

		if (!('IntersectionObserver' in window)) {
			// Fallback for older browsers
			animatedElements.forEach(el => el.classList.add('visible'));
			return;
		}

		const observer = new IntersectionObserver((entries, obs) => {
			entries.forEach(entry => {
				if (entry.isIntersecting) {
					entry.target.classList.add('visible');
					obs.unobserve(entry.target);
				}
			});
		}, {
			threshold: 0.15,
			rootMargin: '0px 0px -50px 0px'
		});

		animatedElements.forEach(el => observer.observe(el));
	}

	/**
	 * Animated Number Counters
	 */
	function initCounterAnimations() {
		const counters = document.querySelectorAll('.robo-v2-stat-num');

		if (!counters.length) return;

		const observer = new IntersectionObserver((entries, obs) => {
			entries.forEach(entry => {
				if (entry.isIntersecting) {
					const $el = $(entry.target);
					const targetVal = parseInt($el.data('target'), 10) || 0;
					const prefix = $el.data('prefix') || '';
					const suffix = $el.data('suffix') || '';
					const duration = 2000;
					const steps = 50;
					const stepTime = duration / steps;
					let current = 0;
					const increment = targetVal / steps;

					const timer = setInterval(() => {
						current += increment;
						if (current >= targetVal) {
							current = targetVal;
							clearInterval(timer);
						}
						$el.text(prefix + Math.floor(current).toLocaleString() + suffix);
					}, stepTime);

					obs.unobserve(entry.target);
				}
			});
		}, { threshold: 0.5 });

		counters.forEach(c => observer.observe(c));
	}

	/**
	 * Interactive Category & Bestseller Tabs Filter
	 */
	function initCategoryFilter() {
		$('.robo-v2-tab-btn').on('click', function(e) {
			e.preventDefault();
			const filter = $(this).data('filter');
			
			$('.robo-v2-tab-btn').removeClass('active btn-primary').addClass('btn-secondary');
			$(this).addClass('active btn-primary').removeClass('btn-secondary');

			if (filter === 'all') {
				$('.robo-v2-filter-item').fadeIn(300);
			} else {
				$('.robo-v2-filter-item').hide();
				$('.robo-v2-filter-item[data-category="' + filter + '"]').fadeIn(300);
			}
		});
	}

	/**
	 * Smooth FAQ Accordion Toggle
	 */
	function initFAQAccordion() {
		$('.robo-v2-faq-question').on('click', function() {
			const $item = $(this).closest('.robo-v2-faq-item');
			const $answer = $item.find('.robo-v2-faq-answer');
			const isOpen = $item.hasClass('active');

			// Close other accordion items
			$('.robo-v2-faq-item').removeClass('active').find('.robo-v2-faq-answer').slideUp(250);

			if (!isOpen) {
				$item.addClass('active');
				$answer.slideDown(250);
			}
		});
	}

})(jQuery);
