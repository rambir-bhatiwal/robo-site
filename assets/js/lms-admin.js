/**
 * Robo LMS Admin JavaScript
 */
(function($) {
	'use strict';

	$(document).ready(function() {

		// 1. TABS SWITCHING
		$(document).on('click', '.robo-lms-tab-item', function() {
			var tabId = $(this).data('tab');
			$('.robo-lms-tab-item').removeClass('active');
			$('.robo-lms-tab-content').removeClass('active');

			$(this).addClass('active');
			$('#' + tabId).addClass('active');
		});

		// 2. REALTIME TITLE SYNC IN REPEATER HEADERS
		$(document).on('input', '.robo-lms-title-input', function() {
			var val = $(this).val();
			var $header = $(this).closest('.robo-lms-repeater-row').find('.robo-lms-row-title');
			if (val.trim() !== '') {
				$header.text(val);
			} else {
				$header.text('Resource Item');
			}
		});

		// 3. SORTABLE REPEATERS
		function initSortable() {
			$('.robo-lms-repeater-rows').sortable({
				handle: '.robo-lms-drag-handle',
				placeholder: 'robo-lms-sortable-placeholder',
				update: function(event, ui) {
					updateOrderIndexes($(this));
				}
			});
		}
		initSortable();

		function updateOrderIndexes($rowsContainer) {
			$rowsContainer.children('.robo-lms-repeater-row').each(function(index) {
				$(this).find('.robo-lms-order-input').val(index);
			});
		}

		// 4. ADD REPEATER ROW
		$(document).on('click', '.robo-lms-add-row-btn', function(e) {
			e.preventDefault();
			var $repeater = $(this).closest('.robo-lms-repeater');
			var $rows = $repeater.find('.robo-lms-repeater-rows');
			var templateHtml = $repeater.find('.robo-lms-row-template').html();

			var newIndex = new Date().getTime();
			var newRowHtml = templateHtml.replace(/\{\{INDEX\}\}/g, newIndex);

			var $newRow = $(newRowHtml);
			$rows.append($newRow);
			updateOrderIndexes($rows);
			$newRow.find('.robo-lms-title-input').focus();
		});

		// 5. DUPLICATE REPEATER ROW
		$(document).on('click', '.robo-lms-duplicate-row', function(e) {
			e.preventDefault();
			var $row = $(this).closest('.robo-lms-repeater-row');
			var $rows = $row.closest('.robo-lms-repeater-rows');
			var newIndex = new Date().getTime();

			var $clone = $row.clone();

			// Update input names and IDs with newIndex
			$clone.attr('data-index', newIndex);
			$clone.find('input, select, textarea').each(function() {
				var name = $(this).attr('name');
				if (name) {
					var updatedName = name.replace(/\[\d+\]|\[\{\{INDEX\}\}\]/g, '[' + newIndex + ']');
					$(this).attr('name', updatedName);
				}
			});

			// Restore select values from original row
			$row.find('select').each(function(i) {
				$clone.find('select').eq(i).val($(this).val());
			});

			$clone.insertAfter($row);
			updateOrderIndexes($rows);
		});

		// 6. REMOVE REPEATER ROW
		$(document).on('click', '.robo-lms-remove-row', function(e) {
			e.preventDefault();
			var confirmMsg = roboLMSAdmin.i18n.confirmDelete || 'Are you sure you want to remove this item?';
			if (confirm(confirmMsg)) {
				var $row = $(this).closest('.robo-lms-repeater-row');
				var $rows = $row.closest('.robo-lms-repeater-rows');
				$row.fadeOut(200, function() {
					$(this).remove();
					updateOrderIndexes($rows);
				});
			}
		});

		// 7. MEDIA UPLOADER (IMAGE / PDF / ZIP)
		$(document).on('click', '.robo-lms-upload-btn', function(e) {
			e.preventDefault();
			var $uploader = $(this).closest('.robo-lms-media-uploader');
			var mediaType = $uploader.data('type') || 'image';

			var frameTitle = roboLMSAdmin.i18n.selectImage;
			var libraryType = 'image';

			if (mediaType === 'pdf') {
				frameTitle = roboLMSAdmin.i18n.selectFile;
				libraryType = 'application/pdf';
			} else if (mediaType === 'archive') {
				frameTitle = roboLMSAdmin.i18n.selectFile;
				libraryType = ''; // Allow any document/archive
			}

			var mediaFrame = wp.media({
				title: frameTitle,
				button: { text: roboLMSAdmin.i18n.useFile },
				multiple: false,
				library: libraryType ? { type: libraryType } : {}
			});

			mediaFrame.on('select', function() {
				var attachment = mediaFrame.state().get('selection').first().toJSON();

				$uploader.find('.robo-lms-media-id').val(attachment.id);
				$uploader.find('.robo-lms-media-url').val(attachment.url);

				if (mediaType === 'image') {
					var thumbUrl = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
					$uploader.find('.robo-lms-media-preview').html('<img src="' + thumbUrl + '" alt="Preview" />');
					$uploader.find('.robo-lms-remove-media-btn').show();
				}
			});

			mediaFrame.open();
		});

		// 8. REMOVE MEDIA
		$(document).on('click', '.robo-lms-remove-media-btn', function(e) {
			e.preventDefault();
			var $uploader = $(this).closest('.robo-lms-media-uploader');
			$uploader.find('.robo-lms-media-id').val('');
			$uploader.find('.robo-lms-media-url').val('');
			$uploader.find('.robo-lms-media-preview').empty();
			$(this).hide();
		});

	});

})(jQuery);
