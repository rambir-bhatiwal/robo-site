/**
 * Robo Theme - Single Product Page Interactive Scripts
 * Handles hover zooms, gallery synchronization, zip checks, FBT bulk cart additions, and lightbox modals.
 *
 * @package Robo
 */

(function($) {
	'use strict';

	// Safe parameters fallback
	const params = typeof roboSingleProductParams !== 'undefined' ? roboSingleProductParams : {
		productId: 0,
		ajaxUrl: '/wp-admin/admin-ajax.php',
		nonce: '',
		cartUrl: '/cart/',
		checkoutUrl: '/checkout/',
		addingBundleMsg: 'Adding bundle to cart...',
		addedBundleMsg: 'Bundle added to cart!',
		checkZipPromptMsg: 'Checking availability...',
		zipAvailableMsg: 'Delivery available! Estimated delivery in 2-4 days.',
		zipUnavailableMsg: 'We cannot ship to this zip code. Please try another.',
		zipEnterValidMsg: 'Please enter a valid zip code.'
	};

	$(document).ready(function() {
		initHoverZoom();
		initGallerySync();
		initScrollToReviews();
		initZipChecker();
		initWishlistCompareToggle();
		initFbtBundleCalculator();
		initLightboxSync();
	});

	/**
	 * 1. Interactive Hover Zoom on Gallery Image (Amazon style)
	 */
	function initHoverZoom() {
		// Only run zoom on desktop viewports
		if (window.innerWidth < 992) {
			return;
		}

		$(document).on('mouseenter', '.gallery-image-zoom-wrapper', function() {
			$(this).addClass('zoomed');
		}).on('mouseleave', '.gallery-image-zoom-wrapper', function() {
			$(this).removeClass('zoomed').find('img').css('transform-origin', 'center center');
		}).on('mousemove', '.gallery-image-zoom-wrapper', function(e) {
			const $wrapper = $(this);
			const $img = $wrapper.find('img');
			const rect = this.getBoundingClientRect();
			
			// Calculate mouse coordinates relative to the image container (in percentage)
			const x = ((e.clientX - rect.left) / rect.width) * 100;
			const y = ((e.clientY - rect.top) / rect.height) * 100;
			
			$img.css('transform-origin', `${x}% ${y}%`);
		});
	}

	/**
	 * 2. Synchronize main gallery Carousel with thumbnail list
	 */
	function initGallerySync() {
		const $carousel = $('#roboProductGalleryCarousel');
		const $thumbs = $('.robo-gallery-thumbnails');

		if (!$carousel.length || !$thumbs.length) {
			return;
		}

		// When carousel slides, update active thumbnail state
		$carousel.on('slide.bs.carousel', function(e) {
			const targetIndex = e.to;
			const $activeThumb = $thumbs.find(`[data-bs-slide-to="${targetIndex}"]`);
			
			$thumbs.find('.thumb-btn').removeClass('active border-primary shadow-sm').addClass('border-light-subtle');
			$activeThumb.addClass('active border-primary shadow-sm').removeClass('border-light-subtle');

			// Smooth scroll the active thumbnail into view if list is horizontally overflowing
			const container = $thumbs[0];
			const thumbElement = $activeThumb.closest('.col-auto')[0];
			if (container && thumbElement) {
				const containerScrollLeft = container.scrollLeft;
				const containerWidth = container.clientWidth;
				const thumbLeft = thumbElement.offsetLeft;
				const thumbWidth = thumbElement.clientWidth;

				if (thumbLeft < containerScrollLeft) {
					container.scrollTo({ left: thumbLeft - 10, behavior: 'smooth' });
				} else if (thumbLeft + thumbWidth > containerScrollLeft + containerWidth) {
					container.scrollTo({ left: thumbLeft - containerWidth + thumbWidth + 10, behavior: 'smooth' });
				}
			}
		});
	}

	/**
	 * 3. Smooth scroll to reviews tab and activate it
	 */
	function initScrollToReviews() {
		$('.scroll-to-reviews-tab').on('click', function(e) {
			e.preventDefault();
			
			// Find review tab anchor button
			const $reviewTabBtn = $('#tab-title-reviews a');
			if ($reviewTabBtn.length) {
				// Trigger click to active the review tab panel
				$reviewTabBtn.trigger('click');
				
				// Smooth scroll to the tab container
				$('html, body').animate({
					scrollTop: $('.woocommerce-tabs-card').offset().top - 80
				}, 600);
			}
		});
	}

	/**
	 * 4. Delivery Zipcode Checker Simulator
	 */
	function initZipChecker() {
		const $input = $('#deliveryZipInput');
		const $btn = $('#deliveryZipCheckBtn');
		const $feedback = $('#deliveryZipFeedback');

		if (!$input.length || !$btn.length || !$feedback.length) {
			return;
		}

		$btn.on('click', function(e) {
			e.preventDefault();
			const zip = $input.val().trim();
			
			// Simple validation
			if (!zip || isNaN(zip) || zip.length < 5) {
				$feedback.removeClass('d-none text-success text-info').addClass('text-danger').text(params.zipEnterValidMsg);
				return;
			}

			// Show checking feedback
			$feedback.removeClass('d-none text-success text-danger').addClass('text-info').html(`<div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div>${params.checkZipPromptMsg}`);
			$btn.prop('disabled', true);

			// Simulate network latency (800ms)
			setTimeout(function() {
				$btn.prop('disabled', false);
				
				// Simulating simple rule: even zipcodes are available, odd are unavailable
				const lastDigit = parseInt(zip.charAt(zip.length - 1));
				if (lastDigit % 2 === 0) {
					$feedback.removeClass('text-info text-danger').addClass('text-success').html(`<i class="bi bi-check-circle-fill me-1"></i> ${params.zipAvailableMsg}`);
				} else {
					$feedback.removeClass('text-info text-success').addClass('text-danger').html(`<i class="bi bi-x-circle-fill me-1"></i> ${params.zipUnavailableMsg}`);
				}
			}, 800);
		});

		// Trigger check on Enter press
		$input.on('keypress', function(e) {
			if (e.which === 13) {
				$btn.trigger('click');
			}
		});
	}

	/**
	 * 5. Single Product Wishlist & Compare click animation toggles with Toast alert feedback
	 */
	function initWishlistCompareToggle() {
		// Single Wishlist Button Toggle
		$(document).on('click', '.single-add-to-wishlist-btn', function(e) {
			e.preventDefault();
			const $btn = $(this);
			const $icon = $btn.find('i');
			const isAdded = $icon.hasClass('bi-heart-fill');

			if (isAdded) {
				$icon.removeClass('bi-heart-fill text-danger').addClass('bi-heart');
				showSingleProductToast('Wishlist Updated', 'Product removed from your wishlist.');
			} else {
				$icon.removeClass('bi-heart').addClass('bi-heart-fill text-danger');
				showSingleProductToast('Wishlist Updated', 'Product added to your wishlist successfully!');
			}
		});

		// Single Compare Button Toggle
		$(document).on('click', '.single-add-to-compare-btn', function(e) {
			e.preventDefault();
			const $btn = $(this);
			const $icon = $btn.find('i');
			const isAdded = $icon.hasClass('bi-shuffle-fill');

			if (isAdded) {
				$icon.removeClass('bi-shuffle-fill text-primary').addClass('bi-shuffle');
				showSingleProductToast('Compare List Updated', 'Product removed from compare list.');
			} else {
				$icon.removeClass('bi-shuffle').addClass('bi-shuffle-fill text-primary');
				showSingleProductToast('Compare List Updated', 'Product added to compare list! You can compare products on the compare page.');
			}
		});
	}

	/**
	 * 6. Frequently Bought Together (FBT) Bundle Price Calculator & AJAX cart submission
	 */
	function initFbtBundleCalculator() {
		const $container = $('.frequently-bought-together');
		if (!$container.length) {
			return;
		}

		const $checkboxes = $container.find('.fbt-checkbox');
		const $priceDisplay = $container.find('.fbt-total-price-display');
		const $addBtn = $container.find('.fbt-add-to-cart-btn');

		if (!$checkboxes.length || !$priceDisplay.length || !$addBtn.length) {
			return;
		}

		// Calculate total price based on selected checkboxes
		function updateFbtTotal() {
			let total = 0;
			$checkboxes.each(function() {
				if ($(this).is(':checked')) {
					total += parseFloat($(this).data('price')) || 0;
				}
			});

			// AJAX format price output (or quick js currency format approximation)
			// Since WooCommerce formats currency nicely, we can do a simple replacement of numbers in the string
			// keeping the currency symbols intact!
			const currentFormatted = $priceDisplay.text();
			const symbol = currentFormatted.replace(/[0-9.,]/g, '').trim();
			
			// Simple fallback check for symbol placement
			const isSymbolPrefix = currentFormatted.trim().indexOf(symbol) === 0;
			const formattedTotal = total.toFixed(2);
			
			if (isSymbolPrefix) {
				$priceDisplay.text(symbol + formattedTotal);
			} else {
				$priceDisplay.text(formattedTotal + ' ' + symbol);
			}
		}

		// Listen to checkbox changes
		$checkboxes.on('change', function() {
			updateFbtTotal();
		});

		// Add bundle to cart via AJAX
		$addBtn.on('click', function(e) {
			e.preventDefault();
			const selectedIds = [];
			
			$checkboxes.each(function() {
				if ($(this).is(':checked')) {
					selectedIds.push($(this).val());
				}
			});

			if (selectedIds.length === 0) {
				return;
			}

			$addBtn.prop('disabled', true).html(`<div class="spinner-border spinner-border-sm text-dark me-2" role="status"></div>${params.addingBundleMsg}`);

			$.ajax({
				url: params.ajaxUrl,
				type: 'POST',
				data: {
					action: 'robo_add_bundle_to_cart',
					product_ids: selectedIds,
					nonce: params.nonce
				},
				success: function(response) {
					$addBtn.prop('disabled', false).html(`<i class="bi bi-check-circle-fill me-2"></i>${params.addedBundleMsg}`);
					
					if (response.success) {
						showSingleProductToast(
							'Bundle Added!',
							`${response.data.message}<br><a href="${params.cartUrl}" class="btn btn-primary btn-sm mt-2 fw-bold text-white">View Cart</a>`
						);
						// Refresh WooCommerce mini-cart fragments
						$(document.body).trigger('wc_fragment_refresh');
					} else {
						showSingleProductToast('Error', response.data.message || 'Failed to add bundle to cart.', true);
					}
					
					// Reset button state after 3s
					setTimeout(function() {
						$addBtn.html(`<i class="bi bi-cart-plus-fill me-2"></i>Add Bundle to Cart`);
					}, 3000);
				},
				error: function() {
					$addBtn.prop('disabled', false).html(`<i class="bi bi-exclamation-triangle-fill me-2"></i>Error`);
					showSingleProductToast('Error', 'An error occurred. Please try again.', true);
					
					setTimeout(function() {
						$addBtn.html(`<i class="bi bi-cart-plus-fill me-2"></i>Add Bundle to Cart`);
					}, 3000);
				}
			});
		});
	}

	/**
	 * 7. Fullscreen Lightbox Synchronization
	 */
	function initLightboxSync() {
		const $lightboxModal = $('#roboGalleryLightboxModal');
		const $lightboxCarousel = $('#roboLightboxCarousel');
		const $mainCarousel = $('#roboProductGalleryCarousel');

		if (!$lightboxModal.length || !$lightboxCarousel.length || !$mainCarousel.length) {
			return;
		}

		const bs = typeof bootstrap !== 'undefined' ? bootstrap : null;

		// When clicking a main gallery link, open modal and go to that index
		$(document).on('click', '.gallery-lightbox-trigger', function(e) {
			e.preventDefault();
			const clickedIndex = parseInt($(this).data('gallery-index')) || 0;

			// Open modal using BS or manual CSS fallback
			if (bs && bs.Modal) {
				const modalInstance = new bs.Modal($lightboxModal[0]);
				modalInstance.show();
			} else {
				$lightboxModal.addClass('show').show().css('background', 'rgba(0,0,0,0.9)');
			}

			// Slide lightbox carousel to clicked slide index immediately
			setTimeout(function() {
				if (bs && bs.Carousel) {
					let carouselInstance = bs.Carousel.getInstance($lightboxCarousel[0]);
					if (!carouselInstance) {
						carouselInstance = new bs.Carousel($lightboxCarousel[0], { ride: false });
					}
					carouselInstance.to(clickedIndex);
				} else {
					// Fallback carousel shift
					$lightboxCarousel.find('.carousel-item').removeClass('active');
					$lightboxCarousel.find(`[data-lightbox-index="${clickedIndex}"]`).addClass('active');
					$lightboxCarousel.find('.lightbox-thumb-btn').removeClass('active border-primary').addClass('border-secondary');
					$lightboxCarousel.find(`[data-bs-slide-to="${clickedIndex}"]`).addClass('active border-primary').removeClass('border-secondary');
				}
			}, 250);
		});

		// Sync lightbox thumbnails clicks
		$(document).on('click', '.lightbox-thumb-btn', function(e) {
			e.preventDefault();
			const targetIndex = parseInt($(this).data('bs-slide-to')) || 0;
			
			if (bs && bs.Carousel) {
				const carouselInstance = bs.Carousel.getInstance($lightboxCarousel[0]) || new bs.Carousel($lightboxCarousel[0]);
				carouselInstance.to(targetIndex);
			}
		});

		// Sync lightbox thumbnail active states on sliding
		$lightboxCarousel.on('slide.bs.carousel', function(e) {
			const targetIndex = e.to;
			const $thumbs = $lightboxCarousel.find('.lightbox-thumbs-container');
			
			$thumbs.find('.lightbox-thumb-btn').removeClass('active border-primary').addClass('border-secondary');
			$thumbs.find(`[data-bs-slide-to="${targetIndex}"]`).addClass('active border-primary').removeClass('border-secondary');
		});

		// Fix manual modal closing fallback
		$lightboxModal.on('click', '[data-bs-dismiss="modal"]', function(e) {
			e.preventDefault();
			if (!bs || !bs.Modal) {
				$lightboxModal.removeClass('show').hide();
				$('body').removeClass('modal-open').css('overflow', '');
				$('.modal-backdrop').remove();
			}
		});
	}

	/**
	 * Simple Single Product Toast Notification helper (Bootstrap 5 styles)
	 */
	function showSingleProductToast(title, body, isError = false) {
		let $toastContainer = $('#robo-toast-container');
		if (!$toastContainer.length) {
			$('body').append('<div id="robo-toast-container" class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1080;"></div>');
			$toastContainer = $('#robo-toast-container');
		}

		const toastId = 'toast-' + Date.now();
		const headerBg = isError ? 'bg-danger text-white' : 'bg-dark text-white';
		const iconClass = isError ? 'bi-exclamation-triangle-fill text-white' : 'bi-bell-fill text-primary';
		
		const toastHTML = `
			<div id="${toastId}" class="toast align-items-center border-0 shadow-lg text-bg-dark" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="4000">
				<div class="toast-header border-bottom border-light border-opacity-10 ${headerBg}">
					<i class="bi ${iconClass} me-2"></i>
					<strong class="me-auto">${title}</strong>
					<small class="text-white-50">Just now</small>
					<button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
				</div>
				<div class="toast-body bg-dark text-light">
					${body}
				</div>
			</div>
		`;

		$toastContainer.append(toastHTML);
		const $toastElement = $('#' + toastId);
		
		const bs = typeof bootstrap !== 'undefined' ? bootstrap : null;
		if (bs && bs.Toast) {
			const toastInstance = new bs.Toast($toastElement[0]);
			toastInstance.show();
		} else {
			$toastElement.addClass('show');
			setTimeout(function() {
				$toastElement.removeClass('show');
				setTimeout(function() {
					$toastElement.remove();
				}, 150);
			}, 4000);
		}

		$toastElement.on('hidden.bs.toast', function() {
			$(this).remove();
		});
	}

})(jQuery);
