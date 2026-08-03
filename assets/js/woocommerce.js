/**
 * Robo Theme - WooCommerce Custom Scripts
 * Manages layout toggles (grid/list), AJAX Quick View, and Wishlist interactions.
 *
 * @package Robo
 */

(function($) {
	'use strict';

	// Defensive fallback for localized PHP parameters
	const params = typeof roboWooParams !== 'undefined' ? roboWooParams : {
		ajaxUrl: '/wp-admin/admin-ajax.php',
		nonce: '',
		cartUrl: '/cart/',
		addedToCartMsg: 'Added to cart!',
		viewCartMsg: 'View Cart'
	};

	$(document).ready(function() {
		initLayoutSwitcher();
		initQuickView();
		initWishlistPlaceholder();
		initCartNotifications();
		initModalDismissFix();
		initCartQuantityMonitor();
		initQuantityButtons();
		initCheckoutCouponBridge();
		initProductLiveSearch();
	});

	// Re-initialize custom quantity buttons after WooCommerce AJAX updates the cart
	$(document.body).on('updated_cart_totals updated_wc_div', function() {
		initQuantityButtons();
	});

	/**
	 * Grid / List View switcher with localStorage state persistence.
	 */
	function initLayoutSwitcher() {
		const $container = $('#robo-products-container');
		const $gridBtn = $('#grid-view-btn');
		const $listBtn = $('#list-view-btn');

		if (!$container.length || !$gridBtn.length || !$listBtn.length) {
			return;
		}

		// Retrieve active state from localStorage
		const savedLayout = localStorage.getItem('robo_shop_layout') || 'grid';

		if (savedLayout === 'list') {
			setListView();
		} else {
			setGridView();
		}

		// Click events
		$gridBtn.on('click', function(e) {
			e.preventDefault();
			setGridView();
		});

		$listBtn.on('click', function(e) {
			e.preventDefault();
			setListView();
		});

		function setGridView() {
			$container.removeClass('list-view');
			$gridBtn.addClass('active text-primary').removeClass('text-muted');
			$listBtn.removeClass('active text-primary').addClass('text-muted');
			localStorage.setItem('robo_shop_layout', 'grid');
		}

		function setListView() {
			$container.addClass('list-view');
			$listBtn.addClass('active text-primary').removeClass('text-muted');
			$gridBtn.removeClass('active text-primary').addClass('text-muted');
			localStorage.setItem('robo_shop_layout', 'list');
		}
	}

	/**
	 * AJAX Quick View Modal Loader.
	 */
	function initQuickView() {
		const $modalBody = $('#robo-quick-view-body');
		
		$(document).on('click', '.quick-view-btn', function(e) {
			e.preventDefault();
			const productId = $(this).data('product-id');
			
			if (!productId) {
				return;
			}

			// Render loading spinner
			$modalBody.html(`
				<div class="text-center py-5">
					<div class="spinner-border text-primary" role="status">
						<span class="visually-hidden">Loading...</span>
					</div>
				</div>
			`);

			// Fetch product content via AJAX
			$.ajax({
				url: params.ajaxUrl,
				type: 'POST',
				data: {
					action: 'robo_woocommerce_quick_view',
					product_id: productId,
					nonce: params.nonce
				},
				success: function(response) {
					if (response.success && response.data.html) {
						$modalBody.html(response.data.html);
						
						// Trigger WooCommerce variation form scripts if present
						const $form = $modalBody.find('form.variations_form');
						if ($form.length && typeof $.fn.wc_variation_form !== 'undefined') {
							$form.wc_variation_form();
						}
					} else {
						$modalBody.html(`
							<div class="alert alert-danger mb-0 text-center">
								<i class="bi bi-exclamation-triangle-fill me-2"></i>
								${response.data.message || 'Could not load product details.'}
							</div>
						`);
					}
				},
				error: function() {
					$modalBody.html(`
						<div class="alert alert-danger mb-0 text-center">
							<i class="bi bi-exclamation-triangle-fill me-2"></i>
							An error occurred. Please try again.
						</div>
					`);
				}
			});
		});
	}

	/**
	 * Wishlist Simulation (Toggle icon & display Toast feedback).
	 */
	function initWishlistPlaceholder() {
		$(document).on('click', '.add-to-wishlist-btn', function(e) {
			e.preventDefault();
			const $btn = $(this);
			const $icon = $btn.find('i');
			const isAdded = $icon.hasClass('bi-heart-fill');

			if (isAdded) {
				// Remove state
				$icon.removeClass('bi-heart-fill text-danger').addClass('bi-heart');
				showToast('Removed from wishlist', 'The product has been removed from your wishlist.');
			} else {
				// Add state
				$icon.removeClass('bi-heart').addClass('bi-heart-fill text-danger');
				showToast('Added to wishlist!', 'The product has been saved to your wishlist.');
			}
		});
	}

	/**
	 * Cart notifications on AJAX Add to Cart.
	 */
	function initCartNotifications() {
		// Listen to WooCommerce native event
		$(document.body).on('added_to_cart', function(event, fragments, cart_hash, $button) {
			if (!$button || !$button.length) {
				return;
			}
			
			const productName = $button.closest('.product-card').find('.product-title').text().trim() || 'Product';
			
			showToast(
				params.addedToCartMsg, 
				`<strong>${productName}</strong> has been successfully added.<br><a href="${params.cartUrl}" class="btn btn-primary btn-sm mt-2 fw-bold">${params.viewCartMsg}</a>`
			);
		});
	}

	/**
	 * Bootstrap 5 Toast helper function.
	 */
	function showToast(title, body) {
		// Ensure container exists
		let $toastContainer = $('#robo-toast-container');
		if (!$toastContainer.length) {
			$('body').append('<div id="robo-toast-container" class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1080;"></div>');
			$toastContainer = $('#robo-toast-container');
		}

		const toastId = 'toast-' + Date.now();
		const toastHTML = `
			<div id="${toastId}" class="toast align-items-center border-0 shadow-lg text-bg-dark" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="4000">
				<div class="toast-header border-bottom border-light border-opacity-10 bg-dark text-white">
					<i class="bi bi-bell-fill text-primary me-2"></i>
					<strong class="me-auto">${title}</strong>
					<small class="text-muted">Just now</small>
					<button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
				</div>
				<div class="toast-body bg-dark text-light">
					${body}
				</div>
			</div>
		`;

		$toastContainer.append(toastHTML);

		const $toastElement = $('#' + toastId);
		
		// Defensive check for global bootstrap object
		if (typeof bootstrap !== 'undefined' && bootstrap.Toast) {
			const toastInstance = new bootstrap.Toast($toastElement[0]);
			toastInstance.show();
		} else {
			// CSS/jQuery fallback if bootstrap JS is not loaded globally
			$toastElement.addClass('show');
			setTimeout(function() {
				$toastElement.removeClass('show');
				setTimeout(function() {
					$toastElement.remove();
				}, 150);
			}, 4000);
		}

		// Cleanup DOM after hidden
		$toastElement.on('hidden.bs.toast', function() {
			$(this).remove();
		});
	}

	/**
	 * Fix for Modal Close Button.
	 */
	function initModalDismissFix() {
		$(document).on('click', '[data-bs-dismiss="modal"]', function(e) {
			e.preventDefault();
			const $modal = $(this).closest('.modal');
			if ($modal.length) {
				const bs = typeof bootstrap !== 'undefined' ? bootstrap : null;
				if (bs && bs.Modal) {
					// Get existing instance or create a new one
					let modalInstance = bs.Modal.getInstance($modal[0]);
					if (!modalInstance) {
						modalInstance = new bs.Modal($modal[0]);
					}
					modalInstance.hide();
				} else {
					// Fallback: manually hide modal and cleanup backdrop
					$modal.removeClass('show');
					$('body').removeClass('modal-open').css('overflow', '');
					$('.modal-backdrop').remove();
					setTimeout(function() {
						$modal.hide();
					}, 150);
				}
			}
		});
	}

	/**
	 * Activate Update Cart button when quantity inputs are adjusted.
	 */
	function initCartQuantityMonitor() {
		$(document).on('change input', '.woocommerce-cart-form .qty', function() {
			const $button = $('button[name="update_cart"]');
			$button.prop('disabled', false).attr('aria-disabled', 'false');
		});
	}

	/**
	 * Render premium plus/minus buttons around WooCommerce quantity inputs.
	 */
	function initQuantityButtons() {
		$('.quantity:not(.buttons-added)').each(function() {
			const $qtyContainer = $(this);
			const $input = $qtyContainer.find('input.qty');
			
			if ($input.length && $input.attr('type') !== 'hidden') {
				$qtyContainer.addClass('buttons-added d-inline-flex align-items-center justify-content-center border rounded bg-light');
				
				// Style the input field
				$input.addClass('text-center border-0 bg-transparent fw-semibold px-1');
				$input.css({
					'width': '38px',
					'height': '36px',
					'font-size': '0.9rem',
					'padding': '0',
					'margin': '0'
				});
				
				// Create minus button
				const $minus = $('<button type="button" class="btn btn-link text-secondary p-0 qty-minus d-flex align-items-center justify-content-center" style="width: 30px; height: 36px; text-decoration: none; font-size: 1.1rem; font-weight: bold; border: 0; outline: none;">−</button>');
				// Create plus button
				const $plus = $('<button type="button" class="btn btn-link text-secondary p-0 qty-plus d-flex align-items-center justify-content-center" style="width: 30px; height: 36px; text-decoration: none; font-size: 1.1rem; font-weight: bold; border: 0; outline: none;">+</button>');
				
				// Insert buttons
				$input.before($minus);
				$input.after($plus);
			}
		});
	}

	// Delegate click events for plus/minus buttons
	$(document).on('click', '.qty-plus, .qty-minus', function(e) {
		e.preventDefault();
		const $button = $(this);
		const $input = $button.siblings('input.qty');
		
		if (!$input.length) return;
		
		let val = parseFloat($input.val()) || 0;
		const step = parseFloat($input.attr('step')) || 1;
		const min = parseFloat($input.attr('min')) || 0;
		const max = parseFloat($input.attr('max')) || Infinity;
		
		if ($button.hasClass('qty-plus')) {
			if (val + step <= max) {
				$input.val(val + step);
			}
		} else {
			if (val - step >= min) {
				$input.val(val - step);
			}
		}
		
		// Trigger change event so WooCommerce knows to enable the "Update Cart" button!
		$input.trigger('change');
	});

	/**
	 * Premium WooCommerce Checkout Custom Coupon handler.
	 */
	function initCheckoutCouponBridge() {
		const $couponCard = $('.robo-checkout-coupon-card');
		if (!$couponCard.length) {
			return;
		}

		const $input = $('#robo_coupon_code');
		const $button = $('#robo_apply_coupon');
		const $msg = $('#robo_coupon_message');

		// Handle keypress Enter on custom coupon input
		$input.on('keypress', function(e) {
			if (e.which === 13) {
				e.preventDefault();
				$button.trigger('click');
			}
		});

		$button.on('click', function(e) {
			e.preventDefault();
			const code = $input.val().trim();
			if (!code) {
				showCouponMessage('Please enter a coupon code.', 'danger');
				return;
			}

			// Clear previous message
			$msg.hide().html('');

			// Find real WooCommerce coupon form
			const $realForm = $('form.checkout_coupon');
			if (!$realForm.length) {
				showCouponMessage('Coupon form not found. Please try again.', 'danger');
				return;
			}

			// Set value in real form and submit
			$realForm.find('input[name="coupon_code"]').val(code);
			
			// Show loading spinner
			$button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Applying...');
			
			$realForm.submit();
		});

		// Listen for checkout update event
		$(document.body).on('updated_checkout', function() {
			// Restore button state
			$button.prop('disabled', false).html('Apply');
			$input.val('');

			// Extract notices if any relate to coupons
			const $notices = $('.woocommerce-error, .woocommerce-message, .woocommerce-info');
			let foundCouponNotice = false;

			$notices.each(function() {
				const text = $(this).text().toLowerCase();
				// If notice contains coupon keywords, display it inside our card
				if (text.includes('coupon') || text.includes('code')) {
					const noticeHTML = $(this).html();
					const isError = $(this).hasClass('woocommerce-error');
					showCouponMessage(noticeHTML, isError ? 'danger' : 'success');
					foundCouponNotice = true;
				}
			});

			if (!foundCouponNotice) {
				$msg.hide().html('');
			}
		});

		function showCouponMessage(content, type) {
			// Clean up output if WooCommerce adds raw buttons
			let cleanedContent = content;
			if (cleanedContent.includes('<a') && cleanedContent.includes('button')) {
				// Strip any actions like "Show Coupon" or "Login" links that woo notices might include
				cleanedContent = cleanedContent.replace(/<a\b[^>]*>(.*?)<\/a>/gi, '');
			}
			$msg.removeClass('text-danger text-success')
				.addClass(type === 'danger' ? 'text-danger' : 'text-success')
				.html(cleanedContent)
				.fadeIn(200);
		}
	}

	/**
	 * AJAX Live Product Search with Expandable Desktop Input & Accessibility.
	 */
	function initProductLiveSearch() {
		// Desktop Search Toggle Interaction
		$(document).on('click', '.robo-search-toggle-btn', function(e) {
			e.preventDefault();
			e.stopPropagation();

			var $toggleBtn = $(this);
			var $navItem = $toggleBtn.closest('.robo-search-nav-item');
			var $desktopInput = $navItem.find('.robo-search-input');

			if ($navItem.hasClass('is-expanded')) {
				$navItem.removeClass('is-expanded');
				$toggleBtn.attr('aria-expanded', 'false');
				$navItem.find('.robo-search-dropdown').removeClass('show').empty();
			} else {
				$navItem.addClass('is-expanded');
				$toggleBtn.attr('aria-expanded', 'true');
				setTimeout(function() {
					$desktopInput.focus();
				}, 150);
			}
		});

		// Prevent clicks inside the expandable search container from closing it
		$(document).on('click', '.robo-desktop-expandable-search', function(e) {
			e.stopPropagation();
		});

		// Auto collapse if empty input loses focus
		$(document).on('blur', '.robo-search-nav-item .robo-search-input', function() {
			var $input = $(this);
			var $navItem = $input.closest('.robo-search-nav-item');
			setTimeout(function() {
				if ($input.val().trim() === '' && !$navItem.find(':focus').length) {
					$navItem.removeClass('is-expanded');
					$navItem.find('.robo-search-toggle-btn').attr('aria-expanded', 'false');
					$navItem.find('.robo-search-dropdown').removeClass('show').empty();
				}
			}, 200);
		});

		// ESC key listener to collapse
		$(document).on('keydown', function(e) {
			if (e.key === 'Escape') {
				$('.robo-search-nav-item.is-expanded').each(function() {
					var $navItem = $(this);
					$navItem.removeClass('is-expanded');
					$navItem.find('.robo-search-toggle-btn').attr('aria-expanded', 'false');
					$navItem.find('.robo-search-dropdown').removeClass('show').empty();
				});
			}
		});

		// Click outside to collapse
		$(document).on('click', function(e) {
			if (!$(e.target).closest('.robo-search-nav-item').length) {
				$('.robo-search-nav-item.is-expanded').each(function() {
					var $navItem = $(this);
					$navItem.removeClass('is-expanded');
					$navItem.find('.robo-search-toggle-btn').attr('aria-expanded', 'false');
					$navItem.find('.robo-search-dropdown').removeClass('show').empty();
				});
			}
		});


		// Live Search AJAX & Keyboard logic for all search wrappers
		$('.robo-search-wrapper').each(function() {
			var $wrapper = $(this);
			var $input = $wrapper.find('.robo-search-input');
			var $dropdown = $wrapper.find('.robo-search-dropdown');
			var $clearBtn = $wrapper.find('.robo-search-clear-btn');

			var searchTimeout = null;
			var activeIndex = -1;

			if (!$input.length || !$dropdown.length) return;

			function toggleClearBtn() {
				if ($input.val().length > 0) {
					$clearBtn.removeClass('d-none');
				} else {
					$clearBtn.addClass('d-none');
				}
			}

			toggleClearBtn();

			$clearBtn.on('click', function(e) {
				e.preventDefault();
				e.stopPropagation();
				$input.val('').focus();
				$clearBtn.addClass('d-none');
				hideSpinner();
				hideDropdown();
			});

			function showSpinner() {
				$spinner.removeClass('d-none');
			}

			function hideSpinner() {
				$spinner.addClass('d-none');
			}

			function showDropdown() {
				$dropdown.addClass('show');
				$input.attr('aria-expanded', 'true');
			}

			function hideDropdown() {
				$dropdown.removeClass('show').empty();
				$input.attr('aria-expanded', 'false');
				$input.removeAttr('aria-activedescendant');
				activeIndex = -1;
			}

			function updateActiveItem($items) {
				$items.removeClass('active').attr('aria-selected', 'false');
				if (activeIndex >= 0 && activeIndex < $items.length) {
					var $activeItem = $items.eq(activeIndex);
					$activeItem.addClass('active').attr('aria-selected', 'true');
					$input.attr('aria-activedescendant', $activeItem.attr('id'));

					var dropdownEl = $dropdown[0];
					var itemEl = $activeItem[0];
					if (itemEl && dropdownEl) {
						var itemTop = itemEl.offsetTop;
						var itemBottom = itemTop + itemEl.offsetHeight;
						var dropdownTop = dropdownEl.scrollTop;
						var dropdownBottom = dropdownTop + dropdownEl.clientHeight;

						if (itemTop < dropdownTop) {
							dropdownEl.scrollTop = itemTop;
						} else if (itemBottom > dropdownBottom) {
							dropdownEl.scrollTop = itemBottom - dropdownEl.clientHeight;
						}
					}
				} else {
					$input.removeAttr('aria-activedescendant');
				}
			}

			function performSearch(query) {
				if (query.length < 2) {
					hideSpinner();
					hideDropdown();
					return;
				}

				showSpinner();

				var ajaxUrl = (window.roboWooParams && window.roboWooParams.ajaxUrl) || (window.roboParams && window.roboParams.ajaxUrl) || params.ajaxUrl || '/wp-admin/admin-ajax.php';
				var nonce = (window.roboWooParams && window.roboWooParams.nonce) || (window.roboParams && window.roboParams.nonce) || params.nonce || '';

				$.ajax({
					url: ajaxUrl,
					type: 'GET',
					dataType: 'json',
					data: {
						action: 'robo_product_live_search',
						nonce: nonce,
						query: query
					},
					success: function(response) {
						hideSpinner();

						if (query !== $input.val().trim()) {
							return;
						}

						if (response.success && response.data && response.data.products && response.data.products.length > 0) {
							renderResults(response.data);
						} else {
							renderNoResults();
						}
					},
					error: function() {
						hideSpinner();
						renderNoResults();
					}
				});
			}

			function renderResults(data) {
				var products = data.products || [];
				var viewAllUrl = data.view_all_url || '#';
				var html = '';

				products.forEach(function(item, index) {
					var itemId = 'robo-search-item-' + index;
					html += '<a href="' + item.url + '" class="dropdown-item d-flex align-items-center gap-3 py-2 px-3 border-bottom border-light-subtle robo-search-item" id="' + itemId + '" role="option" aria-selected="false">';
					
					html += '<div class="flex-shrink-0 position-relative rounded overflow-hidden bg-light" style="width: 44px; height: 44px;">';
					html += '<img src="' + item.image + '" alt="' + item.title + '" class="img-fluid w-100 h-100 object-fit-cover">';
					html += '</div>';

					html += '<div class="flex-grow-1 min-w-0 me-2">';
					html += '<div class="fw-semibold text-dark text-truncate small mb-1" title="' + item.title + '">' + item.title + '</div>';
					
					html += '<div class="d-flex align-items-center gap-2 flex-wrap text-muted small" style="font-size: 0.78rem;">';
					if (item.category) {
						html += '<span class="badge bg-secondary-subtle text-secondary fw-normal px-2 py-1">' + item.category + '</span>';
					}
					if (item.stock_label) {
						html += '<span class="badge ' + item.stock_class + ' px-2 py-1">' + item.stock_label + '</span>';
					}
					html += '</div>';
					html += '</div>';

					html += '<div class="flex-shrink-0 text-end">';
					html += '<div class="fw-bold text-primary small">' + item.price + '</div>';
					html += '</div>';

					html += '</a>';
				});

				html += '<a href="' + viewAllUrl + '" class="dropdown-item text-center py-2 px-3 bg-light text-primary fw-semibold small border-top d-flex align-items-center justify-content-center gap-1 robo-search-view-all">';
				html += '<span>View all results</span> <i class="bi bi-arrow-right"></i>';
				html += '</a>';

				$dropdown.html(html);
				showDropdown();
				activeIndex = -1;
			}

			function renderNoResults() {
				var html = '<div class="p-3 text-center text-muted small d-flex flex-column align-items-center gap-2">';
				html += '<i class="bi bi-search text-secondary fs-4"></i>';
				html += '<span>No products found matching your search.</span>';
				html += '</div>';

				$dropdown.html(html);
				showDropdown();
				activeIndex = -1;
			}

			$input.on('input keyup', function() {
				toggleClearBtn();
				var query = $(this).val().trim();

				clearTimeout(searchTimeout);
				if (query.length >= 2) {
					showSpinner();
					searchTimeout = setTimeout(function() {
						performSearch(query);
					}, 250);
				} else {
					hideSpinner();
					hideDropdown();
				}
			});

			$input.on('focus', function() {
				var query = $(this).val().trim();
				if (query.length >= 2 && $dropdown.children().length > 0) {
					showDropdown();
				}
			});

			$input.on('keydown', function(e) {
				var $items = $dropdown.find('.robo-search-item, .robo-search-view-all');

				if (!$dropdown.hasClass('show') || !$items.length) {
					if (e.key === 'Enter' && $input.val().trim().length > 0) {
						$form.submit();
					}
					return;
				}

				if (e.key === 'ArrowDown') {
					e.preventDefault();
					activeIndex++;
					if (activeIndex >= $items.length) {
						activeIndex = 0;
					}
					updateActiveItem($items);
				} else if (e.key === 'ArrowUp') {
					e.preventDefault();
					activeIndex--;
					if (activeIndex < 0) {
						activeIndex = $items.length - 1;
					}
					updateActiveItem($items);
				} else if (e.key === 'Enter') {
					if (activeIndex >= 0 && activeIndex < $items.length) {
						e.preventDefault();
						var targetUrl = $items.eq(activeIndex).attr('href');
						if (targetUrl) {
							window.location.href = targetUrl;
						}
					} else {
						$form.submit();
					}
				} else if (e.key === 'Escape') {
					e.preventDefault();
					hideDropdown();
				}
			});

			$(document).on('click.roboSearch', function(e) {
				if (!$(e.target).closest($wrapper).length) {
					hideDropdown();
				}
			});
		});
	}

})(jQuery);

