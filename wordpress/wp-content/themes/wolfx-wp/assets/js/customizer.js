/* global wp, jQuery */
/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function($) {
    // Site title and description.
    wp.customize('blogname', function(value) {
        value.bind(function(to) {
            $('.site-title a').text(to);
        });
    });
    wp.customize('blogdescription', function(value) {
        value.bind(function(to) {
            $('.site-description').text(to);
        });
    });

    // Header text color.
    wp.customize('header_textcolor', function(value) {
        value.bind(function(to) {
            if ('blank' === to) {
                $('.site-title, .site-description').css({
                    clip: 'rect(1px, 1px, 1px, 1px)',
                    position: 'absolute',
                });
            } else {
                $('.site-title, .site-description').css({
                    clip: 'auto',
                    position: 'relative',
                });
                $('.site-title a, .site-description').css({
                    color: to,
                });
            }
        });
    });

    // Theme colors
    function updateThemeColors() {
        var style = $('#wolfx-wp-customizer-css');
        if (style.length === 0) {
            style = $('<style id="wolfx-wp-customizer-css"></style>').appendTo('head');
        }

        var css = ':root {';
        css += '--bs-primary: ' + wp.customize('primary_color').get() + ';';
        css += '--bs-secondary: ' + wp.customize('secondary_color').get() + ';';
        css += '--bs-success: ' + wp.customize('success_color').get() + ';';
        css += '--bs-info: ' + wp.customize('info_color').get() + ';';
        css += '--bs-warning: ' + wp.customize('warning_color').get() + ';';
        css += '--bs-danger: ' + wp.customize('danger_color').get() + ';';
        css += '--bs-light: ' + wp.customize('light_color').get() + ';';
        css += '--bs-dark: ' + wp.customize('dark_color').get() + ';';
        css += '}';

        style.html(css);
    }

    // Update theme colors when any color setting changes
    wp.customize('primary_color', function(value) {
        value.bind(updateThemeColors);
    });
    wp.customize('secondary_color', function(value) {
        value.bind(updateThemeColors);
    });
    wp.customize('success_color', function(value) {
        value.bind(updateThemeColors);
    });
    wp.customize('info_color', function(value) {
        value.bind(updateThemeColors);
    });
    wp.customize('warning_color', function(value) {
        value.bind(updateThemeColors);
    });
    wp.customize('danger_color', function(value) {
        value.bind(updateThemeColors);
    });
    wp.customize('light_color', function(value) {
        value.bind(updateThemeColors);
    });
    wp.customize('dark_color', function(value) {
        value.bind(updateThemeColors);
    });

    // Initial update of theme colors
    updateThemeColors();
})(jQuery); 