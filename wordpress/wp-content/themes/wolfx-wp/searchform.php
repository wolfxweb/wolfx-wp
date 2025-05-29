<?php
$unique_id = wolfx_wp_unique_id('search-form-');
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <div class="input-group">
        <input type="search" id="<?php echo esc_attr($unique_id); ?>" class="form-control" placeholder="<?php echo esc_attr_x('Search &hellip;', 'placeholder', 'wolfx-wp'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-search"></i>
            <span class="visually-hidden"><?php echo esc_html_x('Search', 'submit button', 'wolfx-wp'); ?></span>
        </button>
    </div>
</form> 