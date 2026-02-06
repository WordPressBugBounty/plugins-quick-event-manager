/*
 * @copyright (c) 2020.
 * @author            Alan Fuller (support@fullworks)
 * @licence           GPL V3 https://www.gnu.org/licenses/gpl-3.0.en.html
 * @link                  https://fullworks.net
 *
 * This file is part of  a Fullworks plugin.
 *
 *   This plugin is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 *
 *     This plugin is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 *
 *     You should have received a copy of the GNU General Public License
 *     along with  this plugin.  https://www.gnu.org/licenses/gpl-3.0.en.html
 */


/* <fs_premium_only> */
document.addEventListener('DOMContentLoaded', function() {
	// Original elements from your code
	let dropArea = document.getElementById('qem-drop-area');
	let fileInput = document.getElementById('qem-fileElem');
	let fileNameDisplay = document.getElementById('qem-file-name');
	let fileSelection = document.getElementById('qem-file-selection');
	let fileClear = document.getElementById('qem-file-clear');

	// Get max file size from localized data or use default
	const MAX_FILE_SIZE = window.qem_data && window.qem_data.guest_max_file_size ?
		parseInt(window.qem_data.guest_max_file_size) : 100 * 1024; // 100KB default

	// Create image preview element if it doesn't exist
	let imagePreview = document.getElementById('qem-image-preview');
	if (!imagePreview) {
		imagePreview = document.createElement('div');
		imagePreview.id = 'qem-image-preview';
		imagePreview.className = 'qem-tw-mt-2 qem-tw-hidden';
		imagePreview.innerHTML = `
            <div class="qem-tw-border qem-tw-border-gray-300 qem-tw-rounded-md qem-tw-overflow-hidden qem-tw-w-full qem-tw-max-h-48 qem-tw-flex qem-tw-justify-center qem-tw-bg-gray-50">
                <img id="qem-preview-img" class="qem-tw-max-h-48 qem-tw-object-contain" src="" alt="Preview">
            </div>
            <div class="qem-tw-mt-1 qem-tw-flex qem-tw-justify-between qem-tw-items-center">
                <span id="qem-image-size" class="qem-tw-text-xs qem-tw-text-gray-500"></span>
                <span id="qem-image-dimensions" class="qem-tw-text-xs qem-tw-text-gray-500"></span>
            </div>
        `;
		// Insert preview after the drop area
		if (dropArea && dropArea.parentNode) {
			dropArea.parentNode.insertBefore(imagePreview, dropArea.nextSibling);
		}
	}

	// If we can't find the necessary elements, just exit
	if (!dropArea || !fileInput) {
		return;
	}

	const previewImg = document.getElementById('qem-preview-img');
	const imageSizeDisplay = document.getElementById('qem-image-size');
	const imageDimensionsDisplay = document.getElementById('qem-image-dimensions');

	// Add resize modal elements if they don't exist
	let resizeModal = document.getElementById('qem-resize-modal');
	if (!resizeModal) {
		const modal = document.createElement('div');
		modal.id = 'qem-resize-modal';
		modal.className = 'qem-tw-fixed qem-tw-inset-0 qem-tw-bg-gray-600 qem-tw-bg-opacity-50 qem-tw-hidden qem-tw-flex qem-tw-items-center qem-tw-justify-center qem-tw-z-50';
		modal.innerHTML = `
    <div class="qem-tw-bg-white qem-tw-p-6 qem-tw-rounded-lg qem-tw-shadow-xl qem-tw-max-w-md qem-tw-w-full">
        <h3 class="qem-tw-text-lg qem-tw-font-medium qem-tw-mb-4">${window.qem_data.guest_max_file_size_message || 'Image Size Exceeded'}</h3>
        <p class="qem-tw-mb-4">${window.qem_data.guest_max_file_size_message_text || `The selected image exceeds the maximum allowed size (${(MAX_FILE_SIZE/1024/1024).toFixed(1)}MB). Would you like to resize it?`}</p>
        <div class="qem-tw-flex qem-tw-justify-end qem-tw-space-x-3">
            <button id="qem-resize-cancel" class="qem-tw-px-4 qem-tw-py-2 qem-tw-border qem-tw-rounded qem-tw-text-gray-600">${window.qem_data.guest_max_file_size_message_cancel || 'Cancel'}</button>
            <button id="qem-resize-confirm" class="qem-tw-px-4 qem-tw-py-2 qem-tw-bg-blue-500 qem-tw-text-white qem-tw-rounded">${window.qem_data.guest_max_file_size_message_confirm || 'Resize Image'}</button>
        </div>
    </div>
`;
		document.body.appendChild(modal);
		resizeModal = modal;
	}

	// Get modal buttons
	const resizeConfirmBtn = document.getElementById('qem-resize-confirm');
	const resizeCancelBtn = document.getElementById('qem-resize-cancel');

	// Store original file temporarily
	let originalFile = null;

	// Prevent default drag behaviors (from your original code)
	['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
		dropArea.addEventListener(eventName, preventDefaults, false);
	});

	// Highlight drop area when item is dragged over it (from your original code)
	['dragenter', 'dragover'].forEach(eventName => {
		dropArea.addEventListener(eventName, highlight, false);
	});

	['dragleave', 'drop'].forEach(eventName => {
		dropArea.addEventListener(eventName, unhighlight, false);
	});

	// Handle dropped files (modified to check file size)
	dropArea.addEventListener('drop', handleDrop, false);

	// Handle file input change (modified to check file size)
	fileInput.addEventListener('change', function() {
		if (this.files && this.files.length > 0) {
			checkFileSize(this.files);
		}
	});

	// Handle file clear button (from your original code)
	if (fileClear) {
		fileClear.addEventListener('click', function() {
			clearFile();
		});
	}

	// Modal buttons event listeners
	if (resizeConfirmBtn) {
		resizeConfirmBtn.addEventListener('click', function() {
			if (originalFile) {
				resizeImage(originalFile);
				resizeModal.classList.add('qem-tw-hidden');
			}
		});
	}

	if (resizeCancelBtn) {
		resizeCancelBtn.addEventListener('click', function() {
			originalFile = null;
			clearFile();
			resizeModal.classList.add('qem-tw-hidden');
		});
	}

	function preventDefaults(e) {
		e.preventDefault();
		e.stopPropagation();
	}

	function highlight() {
		dropArea.classList.add('qem-tw-border-gray-500');
		dropArea.classList.add('qem-tw-bg-gray-50');
	}

	function unhighlight() {
		dropArea.classList.remove('qem-tw-border-gray-500');
		dropArea.classList.remove('qem-tw-bg-gray-50');
	}

	function handleDrop(e) {
		let dt = e.dataTransfer;
		let files = dt.files;

		checkFileSize(files);
	}

	function formatFileSize(bytes) {
		if (bytes < 1024) {
			return bytes + ' bytes';
		} else if (bytes < 1024 * 1024) {
			return (bytes / 1024).toFixed(1) + ' KB';
		} else {
			return (bytes / (1024 * 1024)).toFixed(2) + ' MB';
		}
	}

	function checkFileSize(files) {
		if (files && files.length > 0) {
			const file = files[0];
			// Check if file is an image
			if (!file.type.match('image.*')) {
				handleFiles(files); // Process normally if not an image
				return;
			}

			// Always create preview first
			createImagePreview(file);

			// Check file size
			if (file.size > MAX_FILE_SIZE) {
				// Store original file for potential resizing
				originalFile = file;
				// Show resize modal
				if (resizeModal) {
					resizeModal.classList.remove('qem-tw-hidden');
				}

				// Important: Also show the original file name in the UI
				updateFileDisplay(file);
			} else {
				// Process file normally if size is acceptable
				handleFiles(files);
			}
		}
	}

	function handleFiles(files) {
		fileInput.files = files;
		if (files && files.length > 0) {
			updateFileDisplay(files[0]);
		}
	}

	function updateFileDisplay(file) {
		// Update file name display
		if (fileNameDisplay) {
			fileNameDisplay.innerText = file.name;
		}

		// Show the file selection element
		if (fileSelection) {
			fileSelection.classList.remove('qem-tw-hidden');
		}
	}

	function createImagePreview(file) {
		if (!previewImg || !imagePreview) return;

		const reader = new FileReader();

		reader.onload = function(e) {
			// Set preview image source
			previewImg.src = e.target.result;

			// Update file size display
			if (imageSizeDisplay) {
				imageSizeDisplay.textContent = formatFileSize(file.size);
			}

			// Load image to get dimensions
			const img = new Image();
			img.onload = function() {
				if (imageDimensionsDisplay) {
					imageDimensionsDisplay.textContent = `${img.width} × ${img.height}`;
				}
			};
			img.src = e.target.result;

			// Show the preview container
			imagePreview.classList.remove('qem-tw-hidden');
		};

		reader.readAsDataURL(file);
	}

	function resizeImage(file) {
		const reader = new FileReader();
		reader.onload = function(e) {
			const img = new Image();
			img.onload = function() {
				// Start with a reasonable scaling factor based on file size ratio
				let scaleFactor = Math.sqrt(MAX_FILE_SIZE / file.size);

				// Initial dimensions
				let width = Math.floor(img.width * scaleFactor);
				let height = Math.floor(img.height * scaleFactor);

				// Create canvas for resizing
				const canvas = document.createElement('canvas');

				// Function to actually perform the resize with given dimensions
				const performResize = (w, h, quality = 0.85) => {
					canvas.width = w;
					canvas.height = h;

					// Draw resized image on canvas
					const ctx = canvas.getContext('2d');
					ctx.clearRect(0, 0, w, h);
					ctx.drawImage(img, 0, 0, w, h);

					// Convert canvas to blob
					canvas.toBlob(function(blob) {
						console.log(`Resize attempt: ${w}x${h}, Quality: ${quality}, Size: ${blob.size / 1024}KB, Target: ${MAX_FILE_SIZE / 1024}KB`);

						// If the blob is still too large, try reducing further
						if (blob.size > MAX_FILE_SIZE) {
							// Try reducing quality first if it's a JPEG
							if (file.type === 'image/jpeg' && quality > 0.65) {
								// Reduce quality and try again with same dimensions
								performResize(w, h, quality - 0.1);
							} else {
								// Reduce dimensions by 10% and try again
								const newWidth = Math.floor(w * 0.9);
								const newHeight = Math.floor(h * 0.9);
								performResize(newWidth, newHeight, quality);
							}
							return;
						}

						// We've got a blob that's under the size limit
						// Create a new File object
						const resizedFile = new File([blob], file.name, {
							type: file.type,
							lastModified: new Date().getTime()
						});

						// Create a DataTransfer to set the files property of the file input
						const dataTransfer = new DataTransfer();
						dataTransfer.items.add(resizedFile);
						fileInput.files = dataTransfer.files;

						// Update UI
						if (fileNameDisplay) {
							fileNameDisplay.innerText = file.name + ' (resized)';
						}
						if (fileSelection) {
							fileSelection.classList.remove('qem-tw-hidden');
						}

						// Update preview with new image
						createImagePreview(resizedFile);

						// Reset original file
						originalFile = null;

						// Log the size difference for debugging
						console.log(`Original size: ${file.size / 1024}KB, Final resized: ${blob.size / 1024}KB`);
					}, file.type, quality);
				};

				// Start the resize process
				performResize(width, height);
			};
			img.src = e.target.result;
		};
		reader.readAsDataURL(file);
	}

	function clearFile() {
		fileInput.value = '';
		if (fileNameDisplay) {
			fileNameDisplay.innerText = '';
		}
		if (fileSelection) {
			fileSelection.classList.add('qem-tw-hidden');
		}

		// Clear and hide the image preview
		if (previewImg) {
			previewImg.src = '';
		}
		if (imagePreview) {
			imagePreview.classList.add('qem-tw-hidden');
		}
		if (imageSizeDisplay) {
			imageSizeDisplay.textContent = '';
		}
		if (imageDimensionsDisplay) {
			imageDimensionsDisplay.textContent = '';
		}

		originalFile = null;
	}
});
/* </fs_premium_only> */