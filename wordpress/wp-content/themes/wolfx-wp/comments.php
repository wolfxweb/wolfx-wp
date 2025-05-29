<?php
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area mt-5">
    <?php if (have_comments()) : ?>
        <h2 class="comments-title h3 mb-4">
            <?php
            $wolfx_wp_comment_count = get_comments_number();
            if ('1' === $wolfx_wp_comment_count) {
                printf(
                    esc_html__('One comment on &ldquo;%1$s&rdquo;', 'wolfx-wp'),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            } else {
                printf(
                    esc_html(_nx('%1$s comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', $wolfx_wp_comment_count, 'comments title', 'wolfx-wp')),
                    number_format_i18n($wolfx_wp_comment_count),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            }
            ?>
        </h2>

        <ol class="comment-list list-unstyled">
            <?php
            wp_list_comments(array(
                'style'      => 'ol',
                'short_ping' => true,
                'avatar_size' => 60,
                'callback'   => 'wolfx_wp_comment_callback',
            ));
            ?>
        </ol>

        <?php
        the_comments_navigation(array(
            'prev_text' => '<i class="bi bi-arrow-left"></i> ' . esc_html__('Older comments', 'wolfx-wp'),
            'next_text' => esc_html__('Newer comments', 'wolfx-wp') . ' <i class="bi bi-arrow-right"></i>',
            'class'     => 'nav-links d-flex justify-content-between mt-4',
        ));

        if (!comments_open()) :
            ?>
            <p class="no-comments alert alert-warning mt-4"><?php esc_html_e('Comments are closed.', 'wolfx-wp'); ?></p>
        <?php
        endif;

    endif;

    comment_form(array(
        'class_form'           => 'comment-form mt-4',
        'title_reply'          => esc_html__('Leave a Comment', 'wolfx-wp'),
        'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title h4 mb-4">',
        'title_reply_after'    => '</h3>',
        'class_submit'         => 'btn btn-primary',
        'comment_field'        => '<div class="comment-form-comment mb-3"><label for="comment" class="form-label">' . _x('Comment', 'noun', 'wolfx-wp') . '</label><textarea id="comment" name="comment" class="form-control" rows="8" required></textarea></div>',
        'comment_notes_before' => '<p class="comment-notes text-muted mb-3">' . esc_html__('Your email address will not be published. Required fields are marked *', 'wolfx-wp') . '</p>',
        'fields'               => array(
            'author' => '<div class="comment-form-author mb-3"><label for="author" class="form-label">' . esc_html__('Name', 'wolfx-wp') . ' <span class="required">*</span></label><input id="author" name="author" type="text" class="form-control" value="' . esc_attr($commenter['comment_author']) . '" size="30" required /></div>',
            'email'  => '<div class="comment-form-email mb-3"><label for="email" class="form-label">' . esc_html__('Email', 'wolfx-wp') . ' <span class="required">*</span></label><input id="email" name="email" type="email" class="form-control" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" required /></div>',
            'url'    => '<div class="comment-form-url mb-3"><label for="url" class="form-label">' . esc_html__('Website', 'wolfx-wp') . '</label><input id="url" name="url" type="url" class="form-control" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" /></div>',
        ),
    ));
    ?>
</div> 