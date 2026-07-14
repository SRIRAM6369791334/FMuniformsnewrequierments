document.addEventListener('DOMContentLoaded', function () {
    const forgotPasswordLink = document.getElementById('forgot-password-link');
    const backToLoginLink = document.getElementById('back-to-login-link');
    const backToForgotLink = document.getElementById('back-to-forgot-link');
    const loginForm = document.getElementById('login-form');
    const forgotPasswordForm = document.getElementById('forgot-password-form');
    const verifyOtpForm = document.getElementById('verify-otp-form');

    if (forgotPasswordLink) {
        forgotPasswordLink.addEventListener('click', function (e) {
            e.preventDefault();
            loginForm.style.display = 'none';
            forgotPasswordForm.style.display = 'block';
        });
    }

    if (backToLoginLink) {
        backToLoginLink.addEventListener('click', function (e) {
            e.preventDefault();
            forgotPasswordForm.style.display = 'none';
            loginForm.style.display = 'block';
        });
    }

    if (backToForgotLink) {
        backToForgotLink.addEventListener('click', function (e) {
            e.preventDefault();
            verifyOtpForm.style.display = 'none';
            forgotPasswordForm.style.display = 'block';
        });
    }

    // Check if OTP was sent, show verify form
    if (window.otpSent && window.resetEmail) {
        loginForm.style.display = 'none';
        forgotPasswordForm.style.display = 'none';
        verifyOtpForm.style.display = 'block';
        document.getElementById('verify-email').value = window.resetEmail;
    }

    // Populate email field in verify form when forgot password form is submitted
    forgotPasswordForm.addEventListener('submit', function (e) {
        // Show loading
        Swal.fire({
            title: 'Processing...',
            text: 'Sending OTP...',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        const email = forgotPasswordForm.querySelector('input[name="email"]').value;
        document.getElementById('verify-email').value = email;
    });

    // Login form loader
    if (loginForm) {
        loginForm.addEventListener('submit', function () {
            Swal.fire({
                title: 'Logging In...',
                text: 'Please wait...',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        });
    }

    // Verify OTP form loader
    if (verifyOtpForm) {
        verifyOtpForm.addEventListener('submit', function () {
            Swal.fire({
                title: 'Verifying...',
                text: 'Please wait while we verify your OTP.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        });
    }
});
