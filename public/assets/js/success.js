document.addEventListener('DOMContentLoaded', function() {
    // Check if there's a success message (set by blade template)
    if (typeof window.successMessage !== 'undefined' && window.successMessage) {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: window.successMessage,
            timer: 2000,
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then(() => {
            window.location.href = '/shop';
        });
    }
});
