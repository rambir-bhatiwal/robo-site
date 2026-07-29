/**
 * Frontend JavaScript for Learning Resources
 *
 * @package Robo
 */

jQuery(document).ready(function ($) {
	'use strict';

	// Helper: Toast Notification
	function showToast(message) {
		$('.robo-lr-toast').remove();
		var $toast = $('<div class="robo-lr-toast"><i class="bi bi-check-circle-fill text-success"></i> <span>' + message + '</span></div>');
		$('body').append($toast);
		setTimeout(function () {
			$toast.addClass('show');
		}, 50);
		setTimeout(function () {
			$toast.removeClass('show');
			setTimeout(function () {
				$toast.remove();
			}, 300);
		}, 3000);
	}

	// 1. Copy Link Buttons (GitHub, YouTube, Permalink)
	$(document).on('click', '.copy-link-btn', function (e) {
		e.preventDefault();
		var link = $(this).attr('data-link') || window.location.href;

		if (navigator.clipboard && window.isSecureContext) {
			navigator.clipboard.writeText(link).then(function () {
				showToast(roboLrParams.i18n.copied);
			});
		} else {
			var $temp = $('<input>');
			$('body').append($temp);
			$temp.val(link).select();
			document.execCommand('copy');
			$temp.remove();
			showToast(roboLrParams.i18n.copied);
		}
	});

	// 2. Toggle Like AJAX
	$(document).on('click', '.btn-action-like', function (e) {
		e.preventDefault();
		var $btn = $(this);
		var postId = $btn.attr('data-post-id');
		var $countSpan = $btn.find('.like-count');

		$.ajax({
			url: roboLrParams.ajaxUrl,
			type: 'POST',
			data: {
				action: 'robo_lr_toggle_like',
				nonce: roboLrParams.nonce,
				post_id: postId
			},
			success: function (res) {
				if (res.success) {
					if (res.data.status === 'liked') {
						$btn.addClass('liked');
						showToast('Added to your likes!');
					} else {
						$btn.removeClass('liked');
						showToast('Removed from your likes!');
					}
					if ($countSpan.length) {
						$countSpan.text(res.data.likes);
					}
				}
			}
		});
	});

	// 3. Toggle Bookmark / Favorite AJAX
	$(document).on('click', '.btn-action-fav', function (e) {
		e.preventDefault();
		var $btn = $(this);
		var postId = $btn.attr('data-post-id');

		$.ajax({
			url: roboLrParams.ajaxUrl,
			type: 'POST',
			data: {
				action: 'robo_lr_toggle_favorite',
				nonce: roboLrParams.nonce,
				post_id: postId
			},
			success: function (res) {
				if (res.success) {
					if (res.data.status === 'added') {
						$btn.addClass('bookmarked');
						showToast('Saved to your bookmarks!');
					} else {
						$btn.removeClass('bookmarked');
						showToast('Removed from bookmarks!');
					}
				}
			}
		});
	});

	// 4. Archive AJAX Filtering
	var filterTimer;
	function fetchFilteredResources(page) {
		var category = $('#robo_lr_filter_cat').val() || '';
		var difficulty = $('#robo_lr_filter_difficulty').val() || '';
		var tag = $('#robo_lr_filter_tag').val() || '';
		var search = $('#robo_lr_filter_search').val() || '';
		page = page || 1;

		var $container = $('#robo-lr-archive-grid');
		var $pagination = $('#robo-lr-archive-pagination');
		var $counter = $('#robo-lr-results-count');

		$container.css('opacity', '0.5');

		$.ajax({
			url: roboLrParams.ajaxUrl,
			type: 'POST',
			data: {
				action: 'robo_lr_filter_archive',
				nonce: roboLrParams.nonce,
				category: category,
				difficulty: difficulty,
				tag: tag,
				search: search,
				page: page
			},
			success: function (res) {
				$container.css('opacity', '1');
				if (res.success) {
					$container.html(res.data.html);
					$pagination.html(res.data.pagination);
					if ($counter.length) {
						$counter.text(res.data.count + ' Resources Found');
					}
				}
			},
			error: function () {
				$container.css('opacity', '1');
				showToast(roboLrParams.i18n.error);
			}
		});
	}

	$('#robo_lr_filter_cat, #robo_lr_filter_difficulty, #robo_lr_filter_tag').on('change', function () {
		fetchFilteredResources(1);
	});

	$('#robo_lr_filter_search').on('keyup', function () {
		clearTimeout(filterTimer);
		filterTimer = setTimeout(function () {
			fetchFilteredResources(1);
		}, 400);
	});

	$('#robo_lr_filter_reset').on('click', function (e) {
		e.preventDefault();
		$('#robo_lr_filter_cat').val('');
		$('#robo_lr_filter_difficulty').val('');
		$('#robo_lr_filter_tag').val('');
		$('#robo_lr_filter_search').val('');
		fetchFilteredResources(1);
	});

	$(document).on('click', '.lr-page-btn', function (e) {
		e.preventDefault();
		var page = $(this).attr('data-page');
		fetchFilteredResources(page);
		$('html, body').animate({
			scrollTop: $('#robo-lr-archive-grid').offset().top - 100
		}, 400);
	});
});
