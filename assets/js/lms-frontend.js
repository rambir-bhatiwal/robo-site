/**
 * Robo LMS Frontend JavaScript
 */
(function($) {
	'use strict';

	$(document).ready(function() {

		var $filterForm = $('#robo-lms-filter-form');
		var $gridContainer = $('#robo-lms-archive-grid');
		var $paginationContainer = $('#robo-lms-archive-pagination');

		if ($filterForm.length && $gridContainer.length) {
			var currentCPT = $('.robo-lms-filter-bar').data('cpt') || 'learning-pdf';

			// AJAX Filter Submission
			function fetchFilteredPosts(paged) {
				paged = paged || 1;

				var formData = {
					action: 'robo_lms_filter_archive',
					nonce: roboLMSParams.nonce,
					cpt: currentCPT,
					search: $filterForm.find('input[name="lms_search"]').val(),
					category: $filterForm.find('select[name="lms_cat"]').val(),
					tag: $filterForm.find('select[name="lms_tag"]').val(),
					difficulty: $filterForm.find('select[name="lms_difficulty"]').val(),
					sort: $filterForm.find('select[name="lms_sort"]').val(),
					paged: paged
				};

				$gridContainer.css('opacity', '0.5');

				$.ajax({
					url: roboLMSParams.ajaxUrl,
					type: 'POST',
					data: formData,
					success: function(response) {
						$gridContainer.css('opacity', '1');
						if (response.success) {
							$gridContainer.html(response.data.html);
							if ($paginationContainer.length) {
								$paginationContainer.html(response.data.pagination);
							}
						}
					},
					error: function() {
						$gridContainer.css('opacity', '1');
					}
				});
			}

			// Form submit event
			$filterForm.on('submit', function(e) {
				e.preventDefault();
				fetchFilteredPosts(1);
			});

			// Instant filter on select change
			$filterForm.find('select').on('change', function() {
				fetchFilteredPosts(1);
			});

			// AJAX Pagination links click
			$(document).on('click', '#robo-lms-archive-pagination a.page-link', function(e) {
				e.preventDefault();
				var href = $(this).attr('href');
				var pageMatch = href.match(/paged=(\d+)/) || href.match(/page\/(\d+)/);
				var paged = pageMatch ? pageMatch[1] : 1;

				fetchFilteredPosts(paged);

				$('html, body').animate({
					scrollTop: $gridContainer.offset().top - 100
				}, 400);
			});
		}

	});

})(jQuery);
