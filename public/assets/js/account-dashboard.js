$(document).ready(function () {
    // Handle Dashboard card clicks to switch tabs (Orders and Bulk Orders)
    $('.dashboard-card[href^="#"]').on('click', function (e) {
        const targetId = $(this).attr('href');

        // Find the corresponding tab link in the sidebar
        const $targetTab = $(`.nav-tabs .nav-link[href="${targetId}"]`);

        if ($targetTab.length > 0) {
            e.preventDefault();
            // Use Bootstrap's native show method to switch tabs properly
            $targetTab.tab('show');
        }
    });
});
