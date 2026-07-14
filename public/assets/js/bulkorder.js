document.addEventListener('DOMContentLoaded', function () {
    // Bulk order form validation and submission
    const bulkOrderForm = document.getElementById('bulkorder-form');
    const submitBtn = document.getElementById('submit-btn');

    if (bulkOrderForm && submitBtn) {
        // Submit button click handler
        submitBtn.addEventListener('click', function (e) {
            e.preventDefault();

            // Clear previous errors
            document.querySelectorAll('.error-message').forEach(el => {
                el.style.display = 'none';
                el.textContent = '';
            });

            const firstName = bulkOrderForm.querySelector('input[name="first_name"]');
            const lastName = bulkOrderForm.querySelector('input[name="last_name"]');
            const email = bulkOrderForm.querySelector('input[name="email"]');
            const phone = bulkOrderForm.querySelector('input[name="phone"]');
            const institution = bulkOrderForm.querySelector('input[name="institution"]');
            const uniformType = bulkOrderForm.querySelector('select[name="uniform_type"]');
            const quantity = bulkOrderForm.querySelector('input[name="quantity"]');
            const budget = bulkOrderForm.querySelector('input[name="budget"]');
            const message = bulkOrderForm.querySelector('textarea[name="message"]');

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

            // Last name validation (optional)
            if (lastName.value.trim() && (lastName.value.trim().length < 1 || lastName.value.trim().length > 50)) {
                showError('last_name', 'Last name must be between 1-50 characters if provided');
            }

            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!email.value.trim() || !emailRegex.test(email.value)) {
                showError('email', 'Valid email is required');
            }

            // Phone validation
            const phoneValue = phone.value.trim();
            if (!phoneValue) {
                showError('phone', 'Phone number is required');
            } else if (!/^[0-9]{10}$/.test(phoneValue)) {
                showError('phone', 'Phone number must be exactly 10 digits');
            }

            // Institution validation
            if (!institution.value.trim() || institution.value.trim().length > 100) {
                showError('institution', 'Institution name is required and must be maximum 100 characters');
            }

            // Uniform type validation
            if (!uniformType.value) {
                showError('uniform_type', 'Please select a uniform type');
            }

            // Quantity validation
            if (!quantity.value || parseInt(quantity.value) < 100) {
                showError('quantity', 'Quantity is required and must be at least 100');
            }

            // Budget validation (optional)
            if (budget.value.trim() && budget.value.trim().length > 50) {
                showError('budget', 'Budget range must be maximum 50 characters if provided');
            }

            // Message validation
            if (!message.value.trim() || message.value.trim().length > 1000) {
                showError('message', 'Additional requirements are required and must be maximum 1000 characters');
            }

            if (!isValid) {
                return;
            }

            // Disable submit button
            submitBtn.style.pointerEvents = 'none';
            submitBtn.textContent = 'Submitting...';

            // Show loading popup
            Swal.fire({
                title: 'Processing...',
                text: 'Please wait while we submit your request.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Prepare form data
            const formData = new FormData(bulkOrderForm);

            // Send AJAX request
            fetch(bulkOrderForm.action, {
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
                            // Redirect to account page after success message
                            window.location.href = '/account';
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
                    submitBtn.textContent = 'SUBMIT REQUEST';
                });
        });
    }

    // 3-Slide Carousel with auto-slide functionality
    if (typeof allCategories !== 'undefined' && allCategories.length > 0) {
        const sliderTrack = document.getElementById('simpleSliderTrack');

        // Only run slider logic if the track element exists
        if (sliderTrack) {
            const sliderWrapper = sliderTrack.parentElement;
            let currentIndex = 0;
            let isTransitioning = false;
            let autoSlideInterval;
            const totalSlides = allCategories.length;
            const autoSlideDelay = 2000; // 2 seconds

            // Create slides with clones for infinite loop
            function createSlides() {
                let slidesHTML = '';

                // Add clones at the end for infinite loop
                const extendedCategories = [...allCategories, ...allCategories.slice(0, 3)];

                extendedCategories.forEach((item, index) => {
                    const originalIndex = index % totalSlides;
                    slidesHTML += `
                    <div class="simple-slide" data-index="${originalIndex}">
                        <a href="/shop?subcategory=${item.subcategory_slug}">
                            <div class="member-box">
                                <img src="${item.img}" alt="${item.name}">
                                <div class="member-details">
                                    <strong>${item.name}</strong>
                                    <small>${item.product_count} products</small>
                                </div>
                            </div>
                        </a>
                    </div>
                `;
                });
                sliderTrack.innerHTML = slidesHTML;
                updateSlide();
                startAutoSlide();
            }

            function updateSlide() {
                const slides = document.querySelectorAll('.simple-slide');
                slides.forEach((slide, index) => {
                    slide.classList.remove('active');
                    // Show 3 slides as active based on currentIndex
                    if (index >= currentIndex && index < currentIndex + 3) {
                        slide.classList.add('active');
                    }
                });

                // Move the track to show the current 3 slides
                const slideWidth = 33.333; // percentage
                const transformValue = -currentIndex * slideWidth;
                sliderTrack.style.transform = `translateX(${transformValue}%)`;
            }

            function nextSlide() {
                if (isTransitioning) return;
                isTransitioning = true;

                currentIndex++;
                if (currentIndex >= totalSlides) {
                    // When reaching the end, jump back to start without transition
                    currentIndex = 0;
                    sliderTrack.style.transition = 'none';
                    updateSlide();
                    setTimeout(() => {
                        sliderTrack.style.transition = 'transform 0.5s ease';
                        isTransitioning = false;
                    }, 50);
                } else {
                    updateSlide();
                    setTimeout(() => { isTransitioning = false; }, 500);
                }
            }

            function prevSlide() {
                if (isTransitioning) return;
                isTransitioning = true;

                currentIndex--;
                if (currentIndex < 0) {
                    // When going before start, jump to end without transition
                    currentIndex = totalSlides - 1;
                    sliderTrack.style.transition = 'none';
                    updateSlide();
                    setTimeout(() => {
                        sliderTrack.style.transition = 'transform 0.5s ease';
                        isTransitioning = false;
                    }, 50);
                } else {
                    updateSlide();
                    setTimeout(() => { isTransitioning = false; }, 500);
                }
            }

            function startAutoSlide() {
                stopAutoSlide(); // Clear any existing interval
                autoSlideInterval = setInterval(nextSlide, autoSlideDelay);
            }

            function stopAutoSlide() {
                if (autoSlideInterval) {
                    clearInterval(autoSlideInterval);
                    autoSlideInterval = null;
                }
            }

            // Pause on hover
            sliderWrapper.addEventListener('mouseenter', stopAutoSlide);
            sliderWrapper.addEventListener('mouseleave', startAutoSlide);

            // Button event listeners
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');

            prevBtn.addEventListener('click', () => {
                stopAutoSlide(); // Pause auto-slide
                prevSlide();
                setTimeout(startAutoSlide, 3000); // Resume after 3 seconds
            });

            nextBtn.addEventListener('click', () => {
                stopAutoSlide(); // Pause auto-slide
                nextSlide();
                setTimeout(startAutoSlide, 3000); // Resume after 3 seconds
            });

            // Initialize
            createSlides();
        }
    }
});

// Bulk Order Page Categories Carousel Animation
document.addEventListener('DOMContentLoaded', function () {
    const bulkContainer = document.getElementById('bulkCarouselContainer');
    const bulkWrapper = document.getElementById('bulkCarouselWrapper');

    if (bulkContainer && bulkWrapper) {
        let position = 0;
        let animationId;
        const speed = 0.5; // Adjust speed as needed (higher = faster)

        function animate() {
            position -= speed;

            // Reset position when half of the content has scrolled (since we duplicated the content)
            // We need to calculate the width of the first set of items
            const firstItemSetWidth = bulkContainer.scrollWidth / 2;

            if (Math.abs(position) >= firstItemSetWidth) {
                position = 0;
            }

            bulkContainer.style.transform = `translateX(${position}px)`;
            animationId = requestAnimationFrame(animate);
        }

        // Start animation
        animationId = requestAnimationFrame(animate);

        // Pause on hover
        bulkWrapper.addEventListener('mouseenter', () => {
            cancelAnimationFrame(animationId);
        });

        // Resume on mouse leave
        bulkWrapper.addEventListener('mouseleave', () => {
            animationId = requestAnimationFrame(animate);
        });
    }
});

