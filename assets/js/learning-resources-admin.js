/**
 * Admin JavaScript for Learning Resources Meta Box
 */

jQuery(document).ready(function ($) {
	'use strict';

	// 1. Tab Switching
	$('.robo-lr-tabs-nav a').on('click', function (e) {
		e.preventDefault();
		var targetTab = $(this).attr('data-tab');

		$('.robo-lr-tabs-nav li').removeClass('active');
		$(this).parent().addClass('active');

		$('.robo-lr-tab-pane').removeClass('active');
		$('#' + targetTab).addClass('active');
	});

	// Make repeaters & gallery sortable
	function initSortables() {
		if ($.fn.sortable) {
			$('.robo-lr-repeater-list').sortable({
				handle: '.handle',
				placeholder: 'ui-state-highlight',
				forcePlaceholderSize: true
			});

			$('.robo-lr-gallery-preview-grid').sortable({
				placeholder: 'ui-state-highlight',
				update: function () {
					updateGalleryIds($(this));
				}
			});

			$('#robo_lr_wc_selected_list').sortable({
				handle: '.handle'
			});
		}
	}
	initSortables();

	// 2. Single Image Uploaders (Cover, List, OG Image)
	$(document).on('click', '.robo-lr-upload-btn', function (e) {
		e.preventDefault();
		var $picker = $(this).closest('.robo-lr-media-picker');
		var $hiddenInput = $picker.find('.robo-lr-media-id');
		var $preview = $picker.find('.robo-lr-media-preview');
		var $removeBtn = $picker.find('.robo-lr-remove-btn');

		var frame = wp.media({
			title: roboLrAdminParams.i18n.selectImage,
			button: { text: roboLrAdminParams.i18n.useImage },
			multiple: false
		});

		frame.on('select', function () {
			var attachment = frame.state().get('selection').first().toJSON();
			$hiddenInput.val(attachment.id);

			var imgUrl = attachment.sizes && attachment.sizes.medium ? attachment.sizes.medium.url : attachment.url;
			$preview.html('<img src="' + imgUrl + '" />');
			$removeBtn.show();
		});

		frame.open();
	});

	$(document).on('click', '.robo-lr-remove-btn', function (e) {
		e.preventDefault();
		var $picker = $(this).closest('.robo-lr-media-picker');
		$picker.find('.robo-lr-media-id').val('');
		$picker.find('.robo-lr-media-preview').html('<span class="placeholder">No Image Selected</span>');
		$(this).hide();
	});

	// 3. File Uploader for Repeaters (PDFs & Downloads)
	$(document).on('click', '.robo-lr-file-upload-btn', function (e) {
		e.preventDefault();
		var $wrapper = $(this).closest('.robo-lr-file-picker');
		var $idInput = $wrapper.find('.file-id');
		var $urlInput = $wrapper.find('.file-url');

		var frame = wp.media({
			title: roboLrAdminParams.i18n.selectFile,
			button: { text: roboLrAdminParams.i18n.useFile },
			multiple: false
		});

		frame.on('select', function () {
			var attachment = frame.state().get('selection').first().toJSON();
			$idInput.val(attachment.id);
			$urlInput.val(attachment.url);
		});

		frame.open();
	});

	// 4. Gallery & Attachments Multi-Uploader
	function updateGalleryIds($grid) {
		var ids = [];
		$grid.find('.gallery-item').each(function () {
			ids.push($(this).attr('data-id'));
		});
		$grid.closest('.robo-lr-gallery-picker').find('.robo-lr-gallery-ids').val(ids.join(','));
	}

	$(document).on('click', '.robo-lr-add-gallery-btn, .robo-lr-add-attachments-btn', function (e) {
		e.preventDefault();
		var $picker = $(this).closest('.robo-lr-gallery-picker');
		var $grid = $picker.find('.robo-lr-gallery-preview-grid');
		var isAttachments = $picker.attr('data-type') === 'attachments';

		var frame = wp.media({
			title: isAttachments ? 'Select Attachments' : 'Select Gallery Images',
			button: { text: 'Add to Selection' },
			multiple: true
		});

		frame.on('select', function () {
			var selection = frame.state().get('selection');
			selection.each(function (attachment) {
				var att = attachment.toJSON();
				if ($grid.find('.gallery-item[data-id="' + att.id + '"]').length === 0) {
					if (isAttachments) {
						$grid.append(
							'<div class="gallery-item file-item" data-id="' + att.id + '">' +
							'<span class="dashicons dashicons-paperclip"></span>' +
							'<span class="file-name">' + (att.title || att.filename) + '</span>' +
							'<span class="remove-item" title="Remove">&times;</span>' +
							'</div>'
						);
					} else {
						var thumb = att.sizes && att.sizes.thumbnail ? att.sizes.thumbnail.url : att.url;
						$grid.append(
							'<div class="gallery-item" data-id="' + att.id + '">' +
							'<img src="' + thumb + '" />' +
							'<span class="remove-item" title="Remove">&times;</span>' +
							'</div>'
						);
					}
				}
			});
			updateGalleryIds($grid);
		});

		frame.open();
	});

	$(document).on('click', '.robo-lr-gallery-preview-grid .remove-item', function () {
		var $grid = $(this).closest('.robo-lr-gallery-preview-grid');
		$(this).closest('.gallery-item').remove();
		updateGalleryIds($grid);
	});

	// 5. Repeaters Add & Remove Logic
	$(document).on('click', '.robo-lr-add-repeater-item', function (e) {
		e.preventDefault();
		var type = $(this).attr('data-type');
		var $repeater = $(this).closest('.robo-lr-repeater');
		var $list = $repeater.find('.robo-lr-repeater-list');
		var index = $list.children('.robo-lr-repeater-item').length;

		var html = '';

		if (type === 'pdf') {
			html = '<div class="robo-lr-repeater-item">' +
				'<span class="handle dashicons dashicons-move"></span>' +
				'<div class="repeater-content">' +
				'<div class="robo-lr-field-row">' +
				'<div class="robo-lr-field" style="flex:2;"><label>PDF Title</label><input type="text" name="robo_lr_pdf_resources[' + index + '][title]" class="widefat" required></div>' +
				'<div class="robo-lr-field" style="flex:2;"><label>PDF File</label><div class="robo-lr-file-picker"><input type="hidden" name="robo_lr_pdf_resources[' + index + '][file_id]" class="file-id"><input type="text" name="robo_lr_pdf_resources[' + index + '][file_url]" class="file-url widefat" placeholder="File URL"><button type="button" class="button robo-lr-file-upload-btn">Upload PDF</button></div></div>' +
				'</div>' +
				'<div class="robo-lr-field-group"><label>Optional Description</label><input type="text" name="robo_lr_pdf_resources[' + index + '][description]" class="widefat"></div>' +
				'</div>' +
				'<button type="button" class="button robo-lr-remove-repeater-item">&times;</button>' +
				'</div>';
		} else if (type === 'video') {
			html = '<div class="robo-lr-repeater-item">' +
				'<span class="handle dashicons dashicons-move"></span>' +
				'<div class="repeater-content">' +
				'<div class="robo-lr-field-row">' +
				'<div class="robo-lr-field" style="flex:1;"><label>Video Title</label><input type="text" name="robo_lr_video_resources[' + index + '][title]" class="widefat" required></div>' +
				'<div class="robo-lr-field" style="flex:2;"><label>Video URL (YouTube, Vimeo, MP4)</label><input type="url" name="robo_lr_video_resources[' + index + '][url]" class="widefat" placeholder="https://www.youtube.com/watch?v=..." required></div>' +
				'</div>' +
				'</div>' +
				'<button type="button" class="button robo-lr-remove-repeater-item">&times;</button>' +
				'</div>';
		} else if (type === 'github') {
			html = '<div class="robo-lr-repeater-item">' +
				'<span class="handle dashicons dashicons-move"></span>' +
				'<div class="repeater-content">' +
				'<div class="robo-lr-field-row">' +
				'<div class="robo-lr-field" style="flex:1;"><label>Repository Title</label><input type="text" name="robo_lr_github_resources[' + index + '][title]" class="widefat" required></div>' +
				'<div class="robo-lr-field" style="flex:2;"><label>Repository URL</label><input type="url" name="robo_lr_github_resources[' + index + '][url]" class="widefat" placeholder="https://github.com/..." required></div>' +
				'</div>' +
				'<div class="robo-lr-field-group"><label>Short Description</label><input type="text" name="robo_lr_github_resources[' + index + '][description]" class="widefat"></div>' +
				'</div>' +
				'<button type="button" class="button robo-lr-remove-repeater-item">&times;</button>' +
				'</div>';
		} else if (type === 'download') {
			html = '<div class="robo-lr-repeater-item">' +
				'<span class="handle dashicons dashicons-move"></span>' +
				'<div class="repeater-content">' +
				'<div class="robo-lr-field-row">' +
				'<div class="robo-lr-field" style="flex:1;"><label>Title</label><input type="text" name="robo_lr_downloads[' + index + '][title]" class="widefat" required></div>' +
				'<div class="robo-lr-field" style="flex:2;"><label>Upload File</label><div class="robo-lr-file-picker"><input type="hidden" name="robo_lr_downloads[' + index + '][file_id]" class="file-id"><input type="text" name="robo_lr_downloads[' + index + '][file_url]" class="file-url widefat" placeholder="File URL"><button type="button" class="button robo-lr-file-upload-btn">Upload File</button></div></div>' +
				'</div>' +
				'<div class="robo-lr-field-group"><label>Description</label><input type="text" name="robo_lr_downloads[' + index + '][description]" class="widefat"></div>' +
				'</div>' +
				'<button type="button" class="button robo-lr-remove-repeater-item">&times;</button>' +
				'</div>';
		} else if (type === 'external') {
			html = '<div class="robo-lr-repeater-item">' +
				'<span class="handle dashicons dashicons-move"></span>' +
				'<div class="repeater-content">' +
				'<div class="robo-lr-field-row">' +
				'<div class="robo-lr-field" style="flex:2;"><label>Title</label><input type="text" name="robo_lr_external_resources[' + index + '][title]" class="widefat" required></div>' +
				'<div class="robo-lr-field" style="flex:2;"><label>URL</label><input type="url" name="robo_lr_external_resources[' + index + '][url]" class="widefat" required></div>' +
				'<div class="robo-lr-field" style="flex:1;"><label>Icon / Type</label><select name="robo_lr_external_resources[' + index + '][icon]"><option value="book">Documentation</option><option value="journal">Research Paper</option><option value="globe">Website</option><option value="newspaper">Blog</option><option value="bookmark-star">Reference</option></select></div>' +
				'</div>' +
				'<div class="robo-lr-field-group"><label>Optional Description</label><input type="text" name="robo_lr_external_resources[' + index + '][description]" class="widefat"></div>' +
				'</div>' +
				'<button type="button" class="button robo-lr-remove-repeater-item">&times;</button>' +
				'</div>';
		} else if (type === 'outcome') {
			html = '<div class="robo-lr-repeater-item">' +
				'<span class="handle dashicons dashicons-move"></span>' +
				'<div class="repeater-content"><div class="robo-lr-field-group" style="margin:0;"><input type="text" name="robo_lr_outcomes[' + index + '][text]" class="widefat" placeholder="e.g. Learn Arduino Programming" required></div></div>' +
				'<button type="button" class="button robo-lr-remove-repeater-item">&times;</button>' +
				'</div>';
		} else if (type === 'requirement') {
			html = '<div class="robo-lr-repeater-item">' +
				'<span class="handle dashicons dashicons-move"></span>' +
				'<div class="repeater-content"><div class="robo-lr-field-group" style="margin:0;"><input type="text" name="robo_lr_requirements[' + index + '][text]" class="widefat" placeholder="e.g. Arduino UNO Microcontroller" required></div></div>' +
				'<button type="button" class="button robo-lr-remove-repeater-item">&times;</button>' +
				'</div>';
		} else if (type === 'faq') {
			html = '<div class="robo-lr-repeater-item">' +
				'<span class="handle dashicons dashicons-move"></span>' +
				'<div class="repeater-content">' +
				'<div class="robo-lr-field-group"><label>Question</label><input type="text" name="robo_lr_faqs[' + index + '][question]" class="widefat" required></div>' +
				'<div class="robo-lr-field-group"><label>Answer</label><textarea name="robo_lr_faqs[' + index + '][answer]" rows="2" class="widefat" required></textarea></div>' +
				'</div>' +
				'<button type="button" class="button robo-lr-remove-repeater-item">&times;</button>' +
				'</div>';
		}

		if (html) {
			$list.append(html);
			initSortables();
		}
	});

	$(document).on('click', '.robo-lr-remove-repeater-item', function () {
		$(this).closest('.robo-lr-repeater-item').remove();
	});

	// 6. WooCommerce Product AJAX Search
	var wcSearchTimer;
	$('#robo_lr_wc_search_input').on('keyup', function () {
		clearTimeout(wcSearchTimer);
		var term = $(this).val();
		var $results = $('#robo_lr_wc_search_results');

		if (term.length < 2) {
			$results.hide().empty();
			return;
		}

		wcSearchTimer = setTimeout(function () {
			$.ajax({
				url: roboLrAdminParams.ajaxUrl,
				type: 'GET',
				data: {
					action: 'robo_lr_search_wc_products',
					nonce: roboLrAdminParams.nonce,
					term: term
				},
				success: function (res) {
					if (res.success && res.data.length > 0) {
						var html = '';
						$.each(res.data, function (i, item) {
							html += '<li data-id="' + item.id + '" data-title="' + item.title + '" data-price="' + item.price + '"><span>' + item.title + ' (SKU: ' + (item.sku || 'N/A') + ')</span> <strong>' + item.price + '</strong></li>';
						});
						$results.html(html).show();
					} else {
						$results.html('<li style="cursor:default;">No products found</li>').show();
					}
				}
			});
		}, 300);
	});

	$(document).on('click', '#robo_lr_wc_search_results li[data-id]', function () {
		var id = $(this).attr('data-id');
		var title = $(this).attr('data-title');
		var price = $(this).attr('data-price');
		var $list = $('#robo_lr_wc_selected_list');

		if ($list.find('li[data-id="' + id + '"]').length === 0) {
			$list.append(
				'<li data-id="' + id + '">' +
				'<span class="dashicons dashicons-move handle"></span>' +
				'<input type="hidden" name="robo_lr_related_product_ids[]" value="' + id + '">' +
				'<strong>' + title + '</strong> (ID: ' + id + ' | ' + price + ')' +
				'<span class="remove-wc-product" title="Remove">&times;</span>' +
				'</li>'
			);
		}

		$('#robo_lr_wc_search_results').hide().empty();
		$('#robo_lr_wc_search_input').val('');
	});

	$(document).on('click', '.remove-wc-product', function () {
		$(this).closest('li').remove();
	});
});
