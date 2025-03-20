/**
 * WhoIsMailingMe Admin Scripts
 */
(function($) {
    'use strict';

    // Document ready
    $(function() {
        // Initialize preview functionality
        initSignaturePreview();
        
        // Initialize tabs if present
        if ($('.whoismailingme-tabs').length) {
            initTabs();
        }
    });

    /**
     * Initialize signature preview
     */
    function initSignaturePreview() {
        // Elements
        const $signatureText = $('textarea[name="whoismailingme_settings[signature_text]"]');
        const $includeUrl = $('input[name="whoismailingme_settings[include_url]"]');
        const $includeDate = $('input[name="whoismailingme_settings[include_date]"]');
        const $previewContent = $('.whoismailingme-preview-content');
        
        // Update preview on change
        $signatureText.on('input', updatePreview);
        $includeUrl.on('change', updatePreview);
        $includeDate.on('change', updatePreview);
        
        // Initial preview
        updatePreview();
        
        /**
         * Update the signature preview
         */
        function updatePreview() {
            if (!$previewContent.length) {
                return;
            }
            
            // Get values
            let signature = $signatureText.val();
            const includeUrl = $includeUrl.is(':checked');
            const includeDate = $includeDate.is(':checked');
            
            // Replace placeholders
            signature = signature.replace(/{site_name}/g, whoismailingme_data.site_name);
            signature = signature.replace(/{site_url}/g, whoismailingme_data.site_url);
            
            // Format HTML
            let html = '<div class="email-signature" style="margin-top: 20px; padding-top: 10px; border-top: 1px solid #ccc;">';
            html += signature.replace('//g', '<br>');
            
            // Add URL if enabled
            if (includeUrl) {
                html += '<br><a href="' + whoismailingme_data.site_url + '">' + whoismailingme_data.site_url + '</a>';
            }
            
            // Add date if enabled
            if (includeDate) {
                html += '<br>Sent on: ' + whoismailingme_data.current_date;
            }
            
            html += '</div>';
            
            // Update preview
            $previewContent.html(html);
        }
    }

    /**
     * Initialize tabs functionality
     */
    function initTabs() {
        const $tabs = $('.whoismailingme-tab');
        const $tabLinks = $('.whoismailingme-tab-link');
        
        // Hide all tabs except the first one
        $tabs.not(':first').hide();
        $tabLinks.first().addClass('nav-tab-active');
        
        // Handle tab clicks
        $tabLinks.on('click', function(e) {
            e.preventDefault();
            
            const target = $(this).attr('href');
            
            // Update active tab
            $tabLinks.removeClass('nav-tab-active');
            $(this).addClass('nav-tab-active');
            
            // Show target tab, hide others
            $tabs.hide();
            $(target).show();
            
            // Save active tab to localStorage
            if (typeof(Storage) !== 'undefined') {
                localStorage.setItem('whoismailingme_active_tab', target);
            }
        });
        
        // Restore active tab from localStorage
        if (typeof(Storage) !== 'undefined') {
            const activeTab = localStorage.getItem('whoismailingme_active_tab');
            if (activeTab) {
                $tabLinks.filter('[href="' + activeTab + '"]').trigger('click');
            }
        }
    }

})(jQuery);
