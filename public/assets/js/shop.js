$(document).ready(function () {
    console.log('Shop.js loaded successfully - v1.1');

    // Initialize cart button states on page load
    initializeCartButtonStates();

    // Handle category link clicks
    $('.category-link').on('click', function (e) {
        e.preventDefault();
        const categorySlug = $(this).data('category');

        // Toggle subcategory list
        const subcategoryList = $(this).siblings('.subcategory-list');
        subcategoryList.toggle();

        // If clicking on a category with subcategories, don't filter yet
        if ($(this).siblings('.subcategory-list').length > 0) {
            return;
        }

        // Filter by category
        if (typeof filterProducts === 'function') {
            filterProducts({ category: categorySlug });
        } else {
            window.location.href = `/shop?category=${categorySlug}`;
        }
    });

    // Handle subcategory link clicks
    $('.subcategory-link').on('click', function (e) {
        e.preventDefault();
        const categorySlug = $(this).data('category');
        const subcategorySlug = $(this).data('subcategory');

        // Filter by both category and subcategory
        if (typeof filterProducts === 'function') {
            filterProducts({
                category: categorySlug,
                subcategory: subcategorySlug
            });
        } else {
            window.location.href = `/shop?category=${categorySlug}&subcategory=${subcategorySlug}`;
        }
    });



    // Handle search form submission
    $('.sidebar-widget.sidebar-search form').on('submit', function (e) {
        e.preventDefault();
        const searchTerm = $(this).find('input[name="search"]').val();

        // Get current URL parameters
        const urlParams = new URLSearchParams(window.location.search);

        // Update search parameter
        if (searchTerm) {
            urlParams.set('search', searchTerm);
        } else {
            urlParams.delete('search');
        }

        // Reset to first page when searching
        urlParams.delete('page');

        // Navigate to new URL
        window.location.href = `${window.location.pathname}?${urlParams.toString()}`;
    });

    function filterProducts(params) {
        // Get current URL parameters
        const urlParams = new URLSearchParams(window.location.search);

        // Clear existing category/subcategory filters and reset page
        urlParams.delete('category');
        urlParams.delete('subcategory');
        urlParams.delete('page');

        // Add new filters
        Object.keys(params).forEach(key => {
            if (params[key]) {
                urlParams.set(key, params[key]);
            }
        });

        // Navigate to filtered URL
        window.location.href = `${window.location.pathname}?${urlParams.toString()}`;
    }

    // Price range slider functionality
    if ($('#slider-range').length) {
        // Get price range from data attributes
        var minPrice = parseFloat($('#slider-range').data('min')) || 0;
        var maxPrice = parseFloat($('#slider-range').data('max')) || 1000;

        // Get current URL parameters
        var urlParams = new URLSearchParams(window.location.search);
        var currentMinPrice = parseFloat(urlParams.get('min_price')) || minPrice;
        var currentMaxPrice = parseFloat(urlParams.get('max_price')) || maxPrice;

        // Ensure current values are within bounds
        currentMinPrice = Math.max(minPrice, Math.min(currentMinPrice, maxPrice));
        currentMaxPrice = Math.max(minPrice, Math.min(currentMaxPrice, maxPrice));

        // Initialize price range slider
        $("#slider-range").slider({
            range: true,
            min: minPrice,
            max: maxPrice,
            values: [currentMinPrice, currentMaxPrice],
            slide: function (event, ui) {
                $("#amount").val("₹" + ui.values[0] + " - ₹" + ui.values[1]);
            },
            stop: function (event, ui) {
                // Update URL with new price range
                var urlParams = new URLSearchParams(window.location.search);
                urlParams.set('min_price', ui.values[0]);
                urlParams.set('max_price', ui.values[1]);

                // Reset to first page when filtering by price
                urlParams.delete('page');

                // Navigate to filtered URL
                window.location.href = `${window.location.pathname}?${urlParams.toString()}`;
            }
        });

        // Set initial input value
        $("#amount").val("₹" + $("#slider-range").slider("values", 0) +
            " - ₹" + $("#slider-range").slider("values", 1));
    }

    // Quick View functionality
    $('.trigger').on('click', function (e) {
        e.preventDefault();
        const productId = $(this).data('product-id');

        // Make AJAX call to get product details
        $.ajax({
            url: `/shop/quick-view/${productId}`,
            method: 'GET',
            success: function (data) {
                // Populate modal with product data
                $('#quickViewImage').attr('src', data.product_image);
                $('#quickViewImage').attr('alt', data.product_name);
                $('#quickViewName').text(data.product_name);
                $('#quickViewCategory').text('Category: ' + data.category);
                $('#quickViewPrice').text('₹' + parseFloat(data.product_price).toFixed(2));
                $('#quickViewSpec').text(data.product_specification);

                // Set product ID on add to cart button for later use
                $('#quickViewAddToCart').data('product-id', data.product_id);

                // Show the modal
                $('#quickViewModal').modal('show');
            },
            error: function (xhr, status, error) {
                console.error('Error loading product details:', error);
                // Error message hidden for now
            }
        });
    });

    // Handle add to cart from quick view modal
    $('#quickViewAddToCart').on('click', function () {
        const productId = $(this).data('product-id');
        // Here you can implement add to cart functionality
        // For now, just close the modal and show a message
        $('#quickViewModal').modal('hide');
        Swal.fire({
            icon: 'info',
            title: 'Quick View Cart',
            text: 'Add to cart functionality for product ID: ' + productId + ' can be implemented here.',
        });
    });

    // Wishlist functionality
    $('.wishlist-btn').on('click', function (e) {
        e.preventDefault();
        const $btn = $(this);
        const productId = $btn.data('product-id');
        const wishlistId = $btn.data('wishlist-id'); // For removal from wishlist page

        // Check if this is a remove action (from wishlist page)
        if ($btn.hasClass('remove-wishlist')) {
            removeFromWishlist(wishlistId, $btn);
            return;
        }

        // Toggle wishlist (add/remove)
        toggleWishlist(productId, $btn);
    });

    function toggleWishlist(productId, $btn) {
        // Show loading
        Swal.fire({
            title: 'Updating Wishlist...',
            text: 'Please wait...',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // First check if item is already in wishlist
        $.ajax({
            url: '/wishlist/check',
            method: 'POST',
            data: {
                product_id: productId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.in_wishlist) {
                    // Remove from wishlist
                    removeFromWishlistByProduct(productId, $btn);
                } else {
                    // Add to wishlist
                    addToWishlist(productId, $btn);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error checking wishlist status:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Error checking wishlist status. Please try again.',
                });
            }
        });
    }

    function addToWishlist(productId, $btn) {
        $.ajax({
            url: '/wishlist',
            method: 'POST',
            data: {
                product_id: productId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    // Update button appearance to show it's in wishlist
                    $btn.addClass('in-wishlist');
                    Swal.fire({
                        icon: 'success',
                        title: 'Added to Wishlist!',
                        text: 'Item has been added to your wishlist.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.message || 'Error adding item to wishlist'
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error('Error adding to wishlist:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Error adding item to wishlist. Please try again.'
                });
            }
        });
    }

    function removeFromWishlistByProduct(productId, $btn) {
        // This is a simplified version - in a real app, you'd need to get the wishlist item ID
        // For now, we'll just show a message
        Swal.fire({
            icon: 'info',
            title: 'Remove from Wishlist',
            text: 'Remove from wishlist functionality would require getting the wishlist item ID. This is a placeholder.',
        });
    }

    function removeFromWishlist(wishlistId, $btn) {
        // Show loading
        Swal.fire({
            title: 'Removing...',
            text: 'Please wait...',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: `/wishlist/${wishlistId}`,
            method: 'DELETE',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    // Remove the product card from the page
                    $btn.closest('.col-sm-6, .col-xl-4').fadeOut();
                    Swal.fire({
                        icon: 'success',
                        title: 'Removed from Wishlist!',
                        text: 'Item has been removed from your wishlist.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.message || 'Error removing item from wishlist'
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error('Error removing from wishlist:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Error removing item from wishlist. Please try again.'
                });
            }
        });
    }

    // Cart functionality - Optimized single call to add to cart (handles duplicate checking server-side)
    // Use :not(#add-to-cart-btn) to avoid conflict with product detail page's specific handler
    $('.cart-btn:not(#add-to-cart-btn)').on('click', function (e) {
        e.preventDefault();
        const $btn = $(this);
        const productId = $btn.data('product-id');
        const firstVariantId = $btn.data('first-variant-id');

        // If button is "Out of Stock", show alert with option to view details
        if ($btn.text().trim() === 'Out of Stock') {
            Swal.fire({
                icon: 'warning',
                title: 'Out of Stock',
                text: 'This product is currently out of stock.',
                showCancelButton: true,
                confirmButtonText: 'GO SHOP',
                confirmButtonColor: '#e11e12',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to shop page
                    window.location.href = '/shop';
                }
                // If cancelled, do nothing - user stays on current page
            });
            return;
        }

        // If button is already "Cart In", show the alert instead of adding again
        if ($btn.hasClass('go-to-cart-btn')) {
            showCartInAlert();
            return;
        }

        // Get quantity from input if on product detail page, otherwise use 1
        let quantity = 1;
        if ($('#detail-qty-input').length > 0) {
            quantity = parseInt($('#detail-qty-input').val()) || 1;
        }

        // Get the variant to cart with selected quantity
        // Server-side logic now handles checking if item already exists
        if (firstVariantId && productId) {
            // Priority 1: Data attributes on the button (for Shop page simplicity)
            let selectedSize = $btn.data('size') || '';
            let selectedColor = $btn.data('color') || '';

            // Priority 2: Fallback to productVariants if available (for Product Detail page or other interactive pages)
            if (!selectedSize && !selectedColor && typeof window.productVariants !== 'undefined') {
                const selectedVariant = window.productVariants.find(v => v.id === firstVariantId);
                if (selectedVariant) {
                    selectedSize = selectedVariant.size_value || '';
                    selectedColor = selectedVariant.color_value || '';
                }
            }

            addToCart(productId, firstVariantId, selectedSize, selectedColor, quantity, $btn);
        } else {
            console.log('No product ID or first variant found for product');
        }
    });

    function addToCart(productId, variantId, selectedSize, selectedColor, quantity, $btn) {
        $btn.prop('disabled', true).text('Adding...');

        // Show loading
        Swal.fire({
            title: 'Adding to Cart...',
            text: 'Please wait...',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: '/cart',
            method: 'POST',
            data: {
                product_id: productId,
                product_variant_id: variantId,
                selected_size: selectedSize,
                selected_color: selectedColor,
                quantity: quantity,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.redirect_to_login) {
                    window.location.href = response.url;
                    return;
                }

                if (response.success) {
                    // Change button to "Cart In" and add special class
                    $btn.text('Already Cart In').addClass('go-to-cart-btn').removeClass('add-to-cart');
                    $btn.prop('disabled', false);

                    // Update cart count in header
                    updateCartCount(response.cart_count);

                    Swal.fire({
                        icon: 'success',
                        title: 'Added to Cart!',
                        text: 'Item has been added to your cart successfully.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.message || 'Error adding item to cart'
                    });
                    $btn.prop('disabled', false).text($btn.hasClass('btn-two') ? 'Add to cart' : 'add to cart');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error adding to cart:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Error adding item to cart. Please try again.'
                });
                $btn.prop('disabled', false).text($btn.hasClass('btn-two') ? 'Add to cart' : 'add to cart');
            }
        });
    }



    function initializeCartButtonStates() {
        // Collect all products to check in a single batch request
        const products = [];
        $('.cart-btn').each(function () {
            const $btn = $(this);
            const productId = $btn.data('product-id');
            const firstVariantId = $btn.data('first-variant-id');
            const stock = parseInt($btn.data('stock')) || 0;

            // First check stock status
            if (stock <= 0) {
                // Out of stock - update button immediately
                $btn.text('Out of Stock').removeClass('add-to-cart').addClass('out-of-stock-btn');
                $btn.css('background-color', '#6c757d').css('border-color', '#6c757d').css('color', '#fff');
                return; // Skip cart check for out of stock items
            }

            if (productId && firstVariantId) {
                products.push({
                    product_id: productId,
                    variant_id: firstVariantId
                });
            }
        });

        // Make single batch request instead of multiple individual requests
        if (products.length > 0) {
            $.ajax({
                url: '/cart/check-multiple',
                method: 'POST',
                data: {
                    products: products,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    // Update button states based on batch results
                    $('.cart-btn').each(function () {
                        const $btn = $(this);
                        const productId = $btn.data('product-id');
                        const firstVariantId = $btn.data('first-variant-id');
                        const stock = parseInt($btn.data('stock')) || 0;

                        // Skip if already marked as out of stock
                        if (stock <= 0) return;

                        if (productId && firstVariantId) {
                            const key = productId + '-' + firstVariantId;
                            if (response.results[key]) {
                                // Product is in cart, update button state
                                $btn.text('Already Cart In').addClass('go-to-cart-btn').removeClass('add-to-cart');
                            }
                        }
                    });
                },
                error: function (xhr, status, error) {
                    console.error('Error checking cart status for initialization:', error);
                }
            });
        }
    }

    function showCartInAlert() {
        Swal.fire({
            title: 'Product Cart In',
            text: 'This product is already in your cart. What would you like to do?',
            icon: 'info',
            showCancelButton: true,
            showDenyButton: false,
            confirmButtonText: 'Go to Cart',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#007bff',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to cart page
                window.location.href = '/cart';
            }
            // If cancelled, do nothing - user stays on current page
        });
    }

    function updateCartCount(count) {
        // Update any cart count indicators in the header/navbar
        $('.cart-count, .cart-counter').text(count);
        // Update header cart count
        $('.top-cart a').html('<i class="fa fa-shopping-cart" aria-hidden="true"></i> (' + count + ')');
    }

    // Cart page functionality
    $('.qty-input').on('change', function () {
        const cartId = $(this).data('cart-id');
        const quantity = $(this).val();

        updateCartItemQuantityInstant(cartId, quantity);
        updateQuantityButtonStates($(this));
    });

    // Handle quantity plus/minus buttons
    $('.qty-btn.qty-plus').on('click', function () {
        const cartId = $(this).data('cart-id');
        const $input = $(`input.qty-input[data-cart-id="${cartId}"]`);
        const currentVal = parseInt($input.val()) || 1;
        const maxVal = parseInt($input.data('max-stock')) || parseInt($input.attr('max')) || 99;

        if (currentVal < maxVal) {
            const newVal = currentVal + 1;
            $input.val(newVal);
            updateCartItemQuantityInstant(cartId, newVal);
            updateQuantityButtonStates($input);
        }
    });

    $('.qty-btn.qty-minus').on('click', function () {
        const cartId = $(this).data('cart-id');
        const $input = $(`input.qty-input[data-cart-id="${cartId}"]`);
        const currentVal = parseInt($input.val()) || 1;
        const minVal = parseInt($input.attr('min')) || 1;

        if (currentVal > minVal) {
            const newVal = currentVal - 1;
            $input.val(newVal);
            updateCartItemQuantityInstant(cartId, newVal);
            updateQuantityButtonStates($input);
        }
    });

    // Initialize quantity button states on page load
    $('.qty-input').each(function () {
        updateQuantityButtonStates($(this));
    });

    $('.remove-cart-item').on('click', function (e) {
        e.preventDefault();
        const cartId = $(this).data('cart-id');

        removeCartItemInstant(cartId);
    });

    function updateQuantityButtonStates($input) {
        const currentVal = parseInt($input.val()) || 1;
        const maxVal = parseInt($input.data('max-stock')) || parseInt($input.attr('max')) || 99;
        const minVal = parseInt($input.attr('min')) || 1;
        const cartId = $input.data('cart-id');

        const $plusBtn = $(`.qty-btn.qty-plus[data-cart-id="${cartId}"]`);
        const $minusBtn = $(`.qty-btn.qty-minus[data-cart-id="${cartId}"]`);

        // Disable plus button if at max stock
        if (currentVal >= maxVal) {
            $plusBtn.addClass('disabled').css('opacity', '0.5').css('cursor', 'not-allowed');
        } else {
            $plusBtn.removeClass('disabled').css('opacity', '1').css('cursor', 'pointer');
        }

        // Disable minus button if at minimum (1)
        if (currentVal <= minVal) {
            $minusBtn.addClass('disabled').css('opacity', '0.5').css('cursor', 'not-allowed');
        } else {
            $minusBtn.removeClass('disabled').css('opacity', '1').css('cursor', 'pointer');
        }
    }

    // Helper functions for real-time cart updates
    function calculateCartTotal() {
        let total = 0;
        $('.total-price-box .price').each(function () {
            const priceText = $(this).text().replace('₹', '').replace(',', '');
            const price = parseFloat(priceText) || 0;
            total += price;
        });
        return total;
    }

    function updateSubtotalDisplay(cartTotal) {
        const formattedTotal = '₹' + cartTotal.toFixed(2);
        $('.cart-subtotal li:contains("Sub-Total")').html('<span>Sub-Total:</span>' + formattedTotal);
        $('.cart-subtotal li:contains("Tax")').html('<span>Tax (0.00):</span>₹0.00');
        $('.cart-subtotal li:contains("Shipping Cost")').html('<span>Shipping Cost:</span>₹0.00');
        $('.cart-subtotal li:contains("TOTAL")').html('<span>TOTAL:</span>' + formattedTotal);
    }

    function updateCartItemQuantityInstant(cartId, quantity) {
        // Get unit price for this item
        const $row = $(`tr[data-cart-id="${cartId}"]`);
        const unitPriceText = $row.find('td ul li .price').text().replace('₹', '').replace(',', '');
        const unitPrice = parseFloat(unitPriceText) || 0;

        // Calculate new subtotal
        const newSubtotal = quantity * unitPrice;

        // Show loading state for this item
        // $row.find('.total-price-box .price').html('<i class="fas fa-spinner fa-spin"></i> Updating...');

        // Send AJAX request to update server (for validation and persistence)
        updateCartItemQuantity(cartId, quantity);
    }

    function updateCartItemQuantity(cartId, quantity) {
        $.ajax({
            url: `/cart/${cartId}`,
            method: 'PUT',
            data: {
                quantity: quantity,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    // Update the subtotal for this item
                    $(`tr[data-cart-id="${cartId}"] .total-price-box .price`).text('₹' + response.item_subtotal.toFixed(2));

                    // Update cart total using the corrected server values
                    updateSubtotalDisplay(response.cart_total);
                } else {
                    console.log('Quantity update failed:', response.message);
                    // Revert the input value if update failed
                    // Note: We can't easily revert without storing the old value
                }
            },
            error: function (xhr, status, error) {
                console.error('Error updating cart item:', error);
                // For quantity updates, don't show error popups - just log to console
                // Users can see the quantity didn't change if there was an error
            }
        });
    }

    function removeCartItemInstant(cartId) {
        Swal.fire({
            title: 'Remove Item',
            text: 'Are you sure you want to remove this item from your cart?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Instantly remove the row and update totals
                const $row = $(`tr[data-cart-id="${cartId}"]`);
                $row.fadeOut(300, function () {
                    $(this).remove();

                    // Recalculate cart total instantly
                    const cartTotal = calculateCartTotal();
                    updateSubtotalDisplay(cartTotal);

                    // If no items left, reload the page to show empty cart message
                    if ($('tr[data-cart-id]').length === 0) {
                        location.reload();
                    }
                });

                // Send AJAX request to update server
                $.ajax({
                    url: `/cart/${cartId}`,
                    method: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.success) {
                            // Update cart count
                            updateCartCount(response.cart_count);

                            // If server total differs, update it (though it shouldn't with instant calculation)
                            if (Math.abs(response.cart_total - calculateCartTotal()) > 0.01) {
                                updateSubtotalDisplay(response.cart_total);
                            }

                            Swal.fire({
                                icon: 'success',
                                title: 'Removed!',
                                text: 'Item has been removed from your cart.',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        } else {
                            // If server removal failed, we might need to restore the row
                            // For now, just show error and reload to sync
                            location.reload();
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message || 'Failed to remove item'
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error removing cart item:', error);
                        // On error, reload to sync with server state
                        location.reload();
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to remove item. Please try again.'
                        });
                    }
                });
            }
        });
    }

    // Handle sort by select change
    $('.orderby').on('change', function () {
        const sortValue = $(this).val();

        // Get current URL parameters
        const urlParams = new URLSearchParams(window.location.search);

        // Update sort parameter
        urlParams.set('sort', sortValue);

        // Reset to first page when sorting
        urlParams.delete('page');

        // Navigate to new URL
        window.location.href = `${window.location.pathname}?${urlParams.toString()}`;
    });

    // Handle "Go to Cart" button click (when button has been changed after adding to cart)
    $(document).on('click', '.go-to-cart-btn', function (e) {
        e.preventDefault();

        Swal.fire({
            title: 'Product Cart In',
            text: 'This product is already in your cart. What would you like to do?',
            icon: 'info',
            showCancelButton: true,
            showDenyButton: false,
            confirmButtonText: 'Go to Cart',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#007bff',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to cart page
                window.location.href = '/cart';
            }
            // If cancelled, do nothing - user stays on current page
        });
    });
});
