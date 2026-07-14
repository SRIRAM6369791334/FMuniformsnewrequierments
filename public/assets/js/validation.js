document.addEventListener('DOMContentLoaded', function() {
    // Login form validation
    const loginForm = document.querySelector('form[action*="login"]');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            const email = loginForm.querySelector('input[name="email"]');
            const password = loginForm.querySelector('input[name="password"]');

            let isValid = true;
            let errors = [];

            // Email validation
            if (!email.value.trim()) {
                errors.push('Email is required');
                isValid = false;
            } else if (!email.value.includes('@gmail.com')) {
                errors.push('Email must end with @gmail.com');
                isValid = false;
            }

            // Password validation
            if (!password.value.trim()) {
                errors.push('Password is required');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: errors.join('\n'),
                    confirmButtonText: 'OK'
                });
            }
        });
    }

    // Register form validation
    const registerForm = document.querySelector('form[action*="register"]');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            const firstName = registerForm.querySelector('input[name="first_name"]');
            const phoneNumber = registerForm.querySelector('input[name="phone_number"]');
            const email = registerForm.querySelector('input[name="email"]');
            const password = registerForm.querySelector('input[name="password"]');

            let isValid = true;
            let errors = [];

            // First name validation
            if (!firstName.value.trim() || firstName.value.trim().length < 2) {
                errors.push('First name is required and must be at least 2 characters');
                isValid = false;
            }

            // Phone number validation
            if (!phoneNumber.value.trim()) {
                errors.push('Phone number is required');
                isValid = false;
            } else if (!/^[0-9]{10}$/.test(phoneNumber.value.trim())) {
                errors.push('Phone number must be exactly 10 digits');
                isValid = false;
            }

            // Email validation
            if (!email.value.trim()) {
                errors.push('Email is required');
                isValid = false;
            } else if (!email.value.includes('@gmail.com')) {
                errors.push('Email must end with @gmail.com');
                isValid = false;
            }

            // Password validation
            if (!password.value.trim() || password.value.length < 8) {
                errors.push('Password is required and must be at least 8 characters');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: errors.join('\n'),
                    confirmButtonText: 'OK'
                });
            }
        });
    }
});
