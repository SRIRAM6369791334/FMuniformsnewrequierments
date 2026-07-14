// Contact form JavaScript
document.addEventListener('DOMContentLoaded', function () {
    // Auto-fill form for authenticated users
    if (window.contactUserData) {
        autoFillContactDetails(window.contactUserData);
    }

    // Contact form validation and submission
    const contactForm = document.getElementById('contact-form');
    const submitBtn = document.querySelector('.btn-two');

    if (contactForm && submitBtn) {
        submitBtn.addEventListener('click', function (e) {
            e.preventDefault();

            // Clear previous errors
            document.querySelectorAll('.error-message').forEach(el => {
                el.style.display = 'none';
                el.textContent = '';
            });

            const firstName = contactForm.querySelector('input[name="first_name"]');
            const lastName = contactForm.querySelector('input[name="last_name"]');
            const email = contactForm.querySelector('input[name="email"]');
            const subject = contactForm.querySelector('input[name="subject"]');
            const message = contactForm.querySelector('textarea[name="message"]');

            let isValid = true;

            function showError(fieldId, msg) {
                const el = document.getElementById('error-' + fieldId);
                if (el) {
                    el.textContent = msg;
                    el.style.display = 'block';
                }
                isValid = false;
            }

            // First name validation
            if (!firstName.value.trim() || firstName.value.trim().length < 2 || firstName.value.trim().length > 50) {
                showError('first_name', 'First name is required and must be between 2-50 characters');
            }

            // Last name validation (required)
            if (!lastName.value.trim() || lastName.value.trim().length < 1 || lastName.value.trim().length > 50) {
                showError('last_name', 'Last name is required and must be between 1-50 characters');
            }

            // Email validation
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!email.value.trim()) {
                showError('email', 'Email is required');
            } else if (!emailPattern.test(email.value.trim())) {
                showError('email', 'Please enter a valid email address');
            }

            // Subject validation
            if (!subject.value.trim() || subject.value.trim().length > 100) {
                showError('subject', 'Subject is required and must be maximum 100 characters');
            }

            // Message validation
            if (!message.value.trim() || message.value.trim().length > 1000) {
                showError('message', 'Message is required and must be maximum 1000 characters');
            }

            if (!isValid) {
                return;
            }

            // Disable submit button
            submitBtn.style.pointerEvents = 'none';
            submitBtn.textContent = 'Sending...';

            // Show loading popup
            Swal.fire({
                title: 'Sending Message...',
                text: 'Please wait...',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Prepare form data
            const formData = new FormData();
            formData.append('_token', contactForm.querySelector('input[name="_token"]').value);
            formData.append('first_name', firstName.value.trim());
            formData.append('last_name', lastName.value.trim());
            formData.append('email', email.value.trim());
            formData.append('subject', subject.value.trim());
            formData.append('message', message.value.trim());

            // Send AJAX request
            fetch(contactForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: data.message,
                            timer: 3000,
                            showConfirmButton: false,
                            allowOutsideClick: false
                        }).then(() => {
                            contactForm.reset();
                        });
                    } else {
                        if (data.errors) {
                            for (let field in data.errors) {
                                showError(field, data.errors[field][0]);
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An error occurred. Please try again.',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Network error. Please try again.',
                        confirmButtonText: 'OK'
                    });
                })
                .finally(() => {
                    // Re-enable submit button
                    submitBtn.style.pointerEvents = 'auto';
                    submitBtn.textContent = 'SUBMIT';
                });
        });
    }

    // Auto-fill function for contact form
    function autoFillContactDetails(user) {
        // Parse name into first and last name
        const nameParts = user.name ? user.name.split(' ') : ['', ''];
        $('input[name="first_name"]').val(nameParts[0] || '');
        $('input[name="last_name"]').val(nameParts.slice(1).join(' ') || '');

        // Fill email
        $('input[name="email"]').val(user.email || '');
    }
});
