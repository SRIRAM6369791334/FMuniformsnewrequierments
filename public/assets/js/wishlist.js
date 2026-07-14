/**
 * Wishlist functionality using AJAX
 * Handles adding, removing, and checking wishlist items
 */

$(document).ready(function() {
    // Initialize wishlist functionality
    initializeWishlist();

    // Handle wishlist button clicks
    $(document).on('click', '.wishlist-btn', function(e) {
        e.preventDefault();

        const $button = $(this);
        const productId = $button.data('product-id');
        const wishlistId = $button.data('wishlist-id');

        // If it's a remove button (has wishlist-id), remove from wishlist
        if (wishlistId) {
            removeFromWishlist(wishlistId, $button);
        } else {
            // Otherwise, toggle add/remove for the product
            toggleWishlist(productId, $button);
        }
    });
});

/**
 * Initialize wishlist - check status of all wishlist buttons on page load
 */
function initializeWishlist() {
    $('.wishlist-btn').each(function() {
        const $button = $(this);
        const productId = $button.data('product-id');

        if (productId && !$button.hasClass('remove-wishlist')) {
            checkWishlistStatus(productId, $button);
        }
    });
}

/**
 * Toggle product in/out of wishlist
 */
function toggleWishlist(productId, $button) {
    // First check if item is already in wishlist
    checkWishlistStatus(productId, $button, function(isInWishlist) {
        if (isInWishlist) {
            // Remove from wishlist
            removeProductFromWishlist(productId, $button);
        } else {
            // Add to wishlist
            addToWishlist(productId, $button);
        }
    });
}

/**
 * Add product to wishlist
 */
function addToWishlist(productId, $button) {
    // Disable button during request
    $button.prop('disabled', true);

    $.ajax({
        url: '/wishlist',
        method: 'POST',
        data: {
            product_id: productId,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                // Update UI
                updateWishlistButton($button, true);

                // Show success message
                Swal.fire({
                    icon: 'success',
                    title: 'Added to Wishlist!',
                    text: response.message,
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                // Show error message
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                });
            }
        },
        error: function(xhr) {
            console.error('Error adding to wishlist:', xhr);
            // Error message hidden for now
        },
        complete: function() {
            // Re-enable button
            $button.prop('disabled', false);
        }
    });
}

/**
 * Remove product from wishlist
 */
function removeProductFromWishlist(productId, $button) {
    // First get the wishlist item ID by checking status
    // This is a simplified approach - in practice, you might need to store wishlist IDs
    checkWishlistStatus(productId, $button, function(isInWishlist, wishlistData) {
        if (isInWishlist && wishlistData && wishlistData.id) {
            removeFromWishlist(wishlistData.id, $button);
        }
    });
}

/**
 * Remove item from wishlist by wishlist ID
 */
function removeFromWishlist(wishlistId, $button) {
    // Disable button during request
    $button.prop('disabled', true);

    $.ajax({
        url: '/wishlist/' + wishlistId,
        method: 'DELETE',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                // Update UI
                if ($button.hasClass('remove-wishlist')) {
                    // Remove the entire product item from wishlist page
                    $button.closest('.col-sm-6, .col-xl-4, .sin-product').fadeOut(300, function() {
                        $(this).remove();

                        // Check if wishlist is now empty
                        if ($('.wishlist-btn').length === 0) {
                            location.reload(); // Reload to show empty message
                        }
                    });
                } else {
                    // Update button state
                    updateWishlistButton($button, false);
                }

                // Show success message
                Swal.fire({
                    icon: 'success',
                    title: 'Removed from Wishlist!',
                    text: response.message,
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                });
            }
        },
        error: function(xhr) {
            let message = 'An error occurred while removing from wishlist.';

            if (xhr.responseJSON && xhr.responseJSON.message) {
                message = xhr.responseJSON.message;
            }

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: message
            });
        },
        complete: function() {
            // Re-enable button
            $button.prop('disabled', false);
        }
    });
}

/**
 * Check if product is in wishlist
 */
function checkWishlistStatus(productId, $button, callback) {
    $.ajax({
        url: '/wishlist/check',
        method: 'POST',
        data: {
            product_id: productId,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            const isInWishlist = response.in_wishlist;
            updateWishlistButton($button, isInWishlist);

            if (callback) {
                callback(isInWishlist, response);
            }
        },
        error: function(xhr) {
            console.error('Error checking wishlist status:', xhr);
            if (callback) {
                callback(false);
            }
        }
    });
}

/**
 * Update wishlist button appearance based on status
 */
function updateWishlistButton($button, isInWishlist) {
    const $icon = $button.find('i');

    if (isInWishlist) {
        $button.addClass('active');
        if ($icon.hasClass('flaticon-valentines-heart')) {
            $icon.removeClass('flaticon-valentines-heart').addClass('fas fa-heart');
        }
    } else {
        $button.removeClass('active');
        if ($icon.hasClass('fas fa-heart')) {
            $icon.removeClass('fas fa-heart').addClass('flaticon-valentines-heart');
        }
    }
}
