/**
 * Order Success Message Handler
 * Displays SweetAlert success messages for completed orders
 */

$(document).ready(function() {
    // Check for success messages from session (like after order placement)
    const successMessage = window.orderSuccessMessage;
    
    if (successMessage) {
        Swal.fire({
            icon: 'success',
            title: '🎉 Order Successful!',
            text: successMessage,
            confirmButtonText: 'Continue Shopping',
            confirmButtonColor: '#28a745',
            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Optional: redirect to shop or continue to account
                // window.location.href = window.shopRoute;
            }
        });
    }
});
