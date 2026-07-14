document.addEventListener('DOMContentLoaded', function() {

    // Filter tabs functionality
    const filterButtons = document.querySelectorAll('.pro-tab-button .filter');
    filterButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            // Remove active class from all buttons
            filterButtons.forEach(function(btn) {
                btn.classList.remove('active');
            });

            // Add active class to clicked button
            this.classList.add('active');

            const filterValue = this.getAttribute('data-filter');

            // Update URL without page reload
            const url = new URL(window.location);
            if (filterValue === 'all') {
                url.searchParams.delete('filter');
            } else {
                url.searchParams.set('filter', filterValue);
            }
            window.history.pushState({}, '', url);

            // Filter categories
            filterCategories(filterValue);
        });
    });

    // Apply initial filter from URL
    const urlParams = new URLSearchParams(window.location.search);
    const currentFilter = urlParams.get('filter') || 'all';
    filterCategories(currentFilter);

    function filterCategories(filterValue) {
        const allCategories = document.querySelectorAll('.single-collection');

        if (filterValue === 'all') {
            // Show all categories
            allCategories.forEach(function(category) {
                const parentCol = category.closest('.col-sm-6');
                if (parentCol) {
                    // Check if it's a hidden category (index >= 8)
                    if (parentCol.classList.contains('hidden-category')) {
                        parentCol.style.display = 'none';
                    } else {
                        parentCol.style.display = 'block';
                    }
                }
            });
        } else {
            // Filter categories using category mappings
            const allowedCategories = categoryMappings[filterValue] || [];

            allCategories.forEach(function(category) {
                const categoryName = category.querySelector('h4').textContent.trim();
                const parentCol = category.closest('.col-sm-6');

                if (parentCol) {
                    if (allowedCategories.includes(categoryName)) {
                        parentCol.style.display = 'block';
                    } else {
                        parentCol.style.display = 'none';
                    }
                }
            });
        }
    }
});
