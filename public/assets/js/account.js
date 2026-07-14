document.addEventListener('DOMContentLoaded', function () {
    // Tab switching functionality
    const categoryItems = document.querySelectorAll('.list-category .category-item');
    const filterItems = document.querySelectorAll('.list-filter .filter-item');

    categoryItems.forEach(category => {
        category.addEventListener('click', function () {
            // Remove active class from all category items
            categoryItems.forEach(item => item.classList.remove('active'));
            // Add active class to clicked item
            this.classList.add('active');

            // Get the data-item value
            const dataItem = this.getAttribute('data-item');

            // Hide all filter items
            filterItems.forEach(item => item.classList.remove('active'));

            // Show the matching filter item
            filterItems.forEach(item => {
                if (item.getAttribute('data-item') === dataItem) {
                    item.classList.add('active');
                }
            });
        });
    });

    // Order status filter tabs functionality
    const orderTabItems = document.querySelectorAll('.tab_order .menu-tab .tab-item');
    const orderItems = document.querySelectorAll('.list_order .order_item');

    orderTabItems.forEach(tab => {
        tab.addEventListener('click', function () {
            // Remove active class from all tabs
            orderTabItems.forEach(item => item.classList.remove('active'));
            // Add active class to clicked tab
            this.classList.add('active');

            // Move indicator
            const indicator = document.querySelector('.tab_order .menu-tab .indicator');
            if (indicator) {
                const tabIndex = Array.from(orderTabItems).indexOf(this);
                indicator.style.left = `${tabIndex * 20}%`; // 20% per tab (5 tabs = 100%)
            }

            // Get filter value
            const filterValue = this.textContent.toLowerCase().trim();

            // Filter orders
            orderItems.forEach(orderItem => {
                const orderStatus = orderItem.querySelector('.tag').textContent.toLowerCase().trim();

                if (filterValue === 'all') {
                    orderItem.style.display = 'block';
                } else if (filterValue === 'pending' && orderStatus === 'pending') {
                    orderItem.style.display = 'block';
                } else if (filterValue === 'delivery' && orderStatus === 'delivery') {
                    orderItem.style.display = 'block';
                } else if (filterValue === 'completed' && orderStatus === 'completed') {
                    orderItem.style.display = 'block';
                } else if (filterValue === 'canceled' && orderStatus === 'canceled') {
                    orderItem.style.display = 'block';
                } else {
                    orderItem.style.display = 'none';
                }
            });
        });
    });

    // Address form tabs functionality
    const addressTabButtons = document.querySelectorAll('.tab_address .tab_btn');
    const addressForms = document.querySelectorAll('.tab_address .form_address');

    addressTabButtons.forEach(button => {
        button.addEventListener('click', function () {
            const dataItem = this.getAttribute('data-item');

            // Toggle active class for buttons
            addressTabButtons.forEach(btn => {
                if (btn.getAttribute('data-item') === dataItem) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });

            // Toggle active class for forms
            addressForms.forEach(form => {
                if (form.getAttribute('data-item') === dataItem) {
                    form.classList.add('active');
                } else {
                    form.classList.remove('active');
                }
            });

            // Rotate icons
            const icons = document.querySelectorAll('.tab_address .ic_down');
            icons.forEach(icon => {
                if (this.contains(icon)) {
                    icon.classList.toggle('rotate-180');
                } else {
                    icon.classList.remove('rotate-180');
                }
            });
        });
    });

    // Order functionality is handled via AJAX in the view-order button

    // Order View functionality for account page
    const viewOrderButtons = document.querySelectorAll('.view-order');
    const viewBulkOrderButtons = document.querySelectorAll('.view-bulk-order');

    // Handle View Order button click
    viewOrderButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const orderId = this.getAttribute('data-order-id');

            // Show loading
            Swal.fire({
                title: 'Loading...',
                text: 'Fetching order details',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });

            // Fetch order details
            fetch(`/account/order/${orderId}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    Swal.close();

                    if (data.success) {
                        const order = data.order;

                        // Show order details modal
                        Swal.fire({
                            title: `<div class="order-detail-title">Order #${order.order_number}</div>`,
                            html: `
                            <div class="order-detail-container text-left" style="font-size: 14px;">
                                <div class="order-info-grid">
                                    <div class="info-item">
                                        <strong>Order Date:</strong>
                                        <p>${order.order_date}</p>
                                    </div>
                                    <div class="info-item">
                                        <strong>Status:</strong>
                                        <p><span class="badge ${getStatusBadgeClass(order.delivery_status)}">${getStatusText(order.delivery_status)}</span></p>
                                    </div>
                                </div>
                                <div class="order-items-section">
                                    <strong class="section-title">Items:</strong>
                                    ${order.items.map(item => {
                                const imagePath = item.product_image ? `${window.MAIN_URL}${item.product_image}` : `${window.MAIN_URL}/media/images/product/sp1.jpg`;
                                let colorHtml = '';
                                if (item.color_value) {
                                    const isHex = item.color_value.startsWith('#');
                                    colorHtml = `
                                                <div class="item-color">
                                                    <span>Color:</span>
                                                    <div class="color-swatch" style="background-color: ${item.color_value};" title="${item.color_value}"></div>
                                                    ${!isHex ? `<span class="color-name">${item.color_value}</span>` : ''}
                                                </div>
                                            `;
                                }
                                return `
                                            <div class="order-item-card">
                                                <div class="item-img">
                                                    <img src="${imagePath}" alt="${item.product_name}">
                                                </div>
                                                <div class="item-details">
                                                    <div class="item-name">${item.product_name}</div>
                                                    <div class="item-meta">
                                                        ${item.size_value ? `<span>Size: ${item.size_value}</span>` : ''}
                                                        ${colorHtml}
                                                    </div>
                                                    <div class="item-pricing">
                                                        <span>₹${item.unit_price.toFixed(2)} x ${item.quantity}</span>
                                                        <strong>₹${item.total_price.toFixed(2)}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        `;
                            }).join('')}
                                </div>
                                <div class="address-grid">
                                    <div class="info-item">
                                        <strong class="section-title">Billing Address:</strong>
                                        <div class="address-content">${order.billing_address ? order.billing_address.replace(/\n/g, '<br>') : 'No address available'}</div>
                                    </div>
                                    ${order.shipping_address ? `
                                    <div class="info-item">
                                        <strong class="section-title">Shipping Address:</strong>
                                        <div class="address-content">${order.shipping_address.replace(/\n/g, '<br>')}</div>
                                    </div>
                                    ` : ''}
                                </div>
                                <div class="order-summary-section">
                                    <div class="summary-row">
                                        <span>Subtotal:</span>
                                        <strong>₹${(order.total_amount || 0).toFixed(2)}</strong>
                                    </div>
                                    <div class="summary-row">
                                        <span>Shipping:</span>
                                        <strong>₹${(order.shipping_amount || 0).toFixed(2)}</strong>
                                    </div>
                                    <div class="summary-row total">
                                        <span>Total Amount:</span>
                                        <strong>₹${(order.grand_total_amount || 0).toFixed(2)}</strong>
                                    </div>
                                </div>
                                ${order.order_notes ? `
                                <div class="order-notes">
                                    <strong>Order Notes:</strong>
                                    <p>${order.order_notes}</p>
                                </div>
                                ` : ''}
                            </div>
                        `,
                            width: '700px',
                            showConfirmButton: true,
                            confirmButtonText: 'Close'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Failed to load order details'
                        });
                    }
                })
                .catch(error => {
                    Swal.close();
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to load order details. Please try again.'
                    });
                });
        });
    });



    // Handle View Bulk Order button click
    viewBulkOrderButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const bulkOrderId = this.getAttribute('data-bulk-order-id');

            // Show loading
            Swal.fire({
                title: 'Loading...',
                text: 'Fetching bulk order details',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });

            // Fetch bulk order details
            fetch(`/account/bulk-order/${bulkOrderId}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    Swal.close();

                    if (data.success) {
                        const bulkOrder = data.bulkOrder;

                        // Show bulk order details modal in a responsive format
                        Swal.fire({
                            title: `<div class="order-detail-title">Bulk Order #${bulkOrder.bulk_order_id}</div>`,
                            html: `
                            <div class="order-detail-container text-left" style="font-size: 14px;">
                                <div class="order-info-grid">
                                    <div class="info-item">
                                        <strong>Institution:</strong>
                                        <p>${bulkOrder.institution}</p>
                                    </div>
                                    <div class="info-item">
                                        <strong>Uniform Type:</strong>
                                        <p>${bulkOrder.uniform_type}</p>
                                    </div>
                                    <div class="info-item">
                                        <strong>Quantity:</strong>
                                        <p>${bulkOrder.quantity}</p>
                                    </div>
                                    <div class="info-item">
                                        <strong>Status:</strong>
                                        <p><span class="badge ${getBulkOrderStatusBadgeClass(bulkOrder.status)}">${bulkOrder.status.charAt(0).toUpperCase() + bulkOrder.status.slice(1)}</span></p>
                                    </div>
                                    <div class="info-item">
                                        <strong>Budget Range:</strong>
                                        <p>${bulkOrder.budget || 'N/A'}</p>
                                    </div>
                                    <div class="info-item">
                                        <strong>Created Date:</strong>
                                        <p>${bulkOrder.created_at}</p>
                                    </div>
                                </div>
                                <div class="order-notes">
                                    <strong class="section-title">Additional Requirements:</strong>
                                    <div class="address-content mt-1">
                                        ${bulkOrder.message ? bulkOrder.message.replace(/\n/g, '<br>') : 'None'}
                                    </div>
                                </div>
                            </div>
                        `,
                            width: '600px',
                            showConfirmButton: true,
                            confirmButtonText: 'Close'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Failed to load bulk order details'
                        });
                    }
                })
                .catch(error => {
                    Swal.close();
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to load bulk order details. Please try again.'
                    });
                });
        });
    });

    // Helper function to get status badge class
    function getStatusBadgeClass(status) {
        // Handle integer status codes
        switch (parseInt(status)) {
            case 0:
                return 'badge-warning'; // pending
            case 1:
                return 'badge-info'; // packing
            case 2:
                return 'badge-primary'; // dispatched
            case 3:
                return 'badge-warning'; // out of delivery
            case 4:
                return 'badge-success'; // delivery
            default:
                return 'badge-secondary';
        }
    }

    // Helper function to get status text
    function getStatusText(status) {
        switch (parseInt(status)) {
            case 0:
                return 'Pending';
            case 1:
                return 'Packing';
            case 2:
                return 'Dispatched';
            case 3:
                return 'Out of Delivery';
            case 4:
                return 'Delivered';
            default:
                return 'Pending';
        }
    }

    // Helper function to get bulk order status badge class
    function getBulkOrderStatusBadgeClass(status) {
        switch (status.toLowerCase()) {
            case 'pending':
                return 'badge-warning';
            case 'processing':
                return 'badge-info';
            case 'completed':
                return 'badge-success';
            case 'cancelled':
                return 'badge-danger';
            default:
                return 'badge-secondary';
        }
    }

    // Address editing functionality - using event delegation for dynamic content
    document.addEventListener('click', function (e) {
        // Handle Edit Address button click
        if (e.target.classList.contains('edit-address')) {
            e.preventDefault();
            const addressType = e.target.getAttribute('data-address-type');

            // Hide display, show form
            const displayDiv = document.getElementById(`${addressType}-address-display`);
            const formDiv = document.getElementById(`${addressType}-address-form`);

            if (displayDiv && formDiv) {
                displayDiv.classList.add('d-none');
                formDiv.classList.remove('d-none');
            }
        }

        // Handle Cancel Edit button click
        if (e.target.classList.contains('cancel-edit')) {
            e.preventDefault();
            const addressType = e.target.getAttribute('data-address-type');

            // Show display, hide form
            const displayDiv = document.getElementById(`${addressType}-address-display`);
            const formDiv = document.getElementById(`${addressType}-address-form`);

            if (displayDiv && formDiv) {
                displayDiv.classList.remove('d-none');
                formDiv.classList.add('d-none');
            }
        }
    });

    // Handle Address Form submission
    const billingAddressForm = document.getElementById('billing-address-form-element');
    const shippingAddressForm = document.getElementById('shipping-address-form-element');

    if (billingAddressForm) {
        billingAddressForm.addEventListener('submit', function (e) {
            e.preventDefault();
            handleAddressUpdate('billing', this);
        });
    }

    if (shippingAddressForm) {
        shippingAddressForm.addEventListener('submit', function (e) {
            e.preventDefault();
            handleAddressUpdate('shipping', this);
        });
    }

    function handleAddressUpdate(addressType, form) {
        const formData = new FormData(form);

        // Show loading
        Swal.fire({
            title: 'Updating...',
            text: 'Please wait',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });

        const csrfTokenUpdate = document.querySelector('meta[name="csrf-token"]');
        if (!csrfTokenUpdate) {
            console.error('CSRF token not found');
            Swal.close();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'CSRF token not found. Please refresh the page.'
            });
            return;
        }

        fetch('/account/update-address', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfTokenUpdate.getAttribute('content')
            },
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                Swal.close();

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: data.message
                    }).then(() => {
                        // Reload the page to show updated address
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Failed to update address'
                    });
                }
            })
            .catch(error => {
                Swal.close();
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to update address. Please try again.'
                });
            });
    }
});

// Profile Image Upload Functions
function previewAndUploadImage(event) {
    const file = event.target.files[0];
    if (!file) return;

    // Validate file type
    if (!file.type.match('image.*')) {
        showUploadError('Please select a valid image file.');
        return;
    }

    // Validate file size (max 5MB)
    if (file.size > 5 * 1024 * 1024) {
        showUploadError('File size must be less than 5MB.');
        return;
    }

    // Preview image
    const reader = new FileReader();
    reader.onload = function (e) {
        document.getElementById('currentAvatar').src = e.target.result;
    };
    reader.readAsDataURL(file);

    // Upload file
    uploadImage(file);
}

function uploadImage(file) {
    const formData = new FormData();
    formData.append('profile_image', file);
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

    showUploadStatus('Uploading image...');

    fetch('/upload-profile-image', {
        method: 'POST',
        headers: {
            'Accept': 'application/json'
        },
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showUploadStatus(data.message || 'Profile image updated successfully!');
                setTimeout(() => hideUploadMessages(), 3000);
            } else {
                showUploadError(data.message || 'Failed to upload image.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showUploadError('An error occurred while uploading the image.');
        });
}

function showUploadStatus(message) {
    hideUploadMessages();
    const statusEl = document.getElementById('uploadStatus');
    statusEl.textContent = message;
    statusEl.classList.remove('hidden');
}

function showUploadError(message) {
    hideUploadMessages();
    const errorEl = document.getElementById('uploadError');
    errorEl.textContent = message;
    errorEl.classList.remove('hidden');
}

function hideUploadMessages() {
    const statusEl = document.getElementById('uploadStatus');
    const errorEl = document.getElementById('uploadError');
    if (statusEl) statusEl.classList.add('hidden');
    if (errorEl) errorEl.classList.add('hidden');
}
