<?php
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">
    <?php if (have_comments()) : ?>
        <h2 class="comments-title">
            <?php
            $comments_number = get_comments_number();
            if ('1' === $comments_number) {
                printf(
                    esc_html__('Um comentário em &ldquo;%1$s&rdquo;', 'wolfx-wp'),
                    '<span>' . get_the_title() . '</span>'
                );
            } else {
                printf(
                    esc_html(_n('%1$s comentário em &ldquo;%2$s&rdquo;', '%1$s comentários em &ldquo;%2$s&rdquo;', $comments_number, 'wolfx-wp')),
                    number_format_i18n($comments_number),
                    '<span>' . get_the_title() . '</span>'
                );
            }
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 60,
            ));
            ?>
        </ol>

        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
            <nav class="comment-navigation">
                <div class="nav-links">
                    <div class="nav-previous"><?php previous_comments_link(esc_html__('Comentários anteriores', 'wolfx-wp')); ?></div>
                    <div class="nav-next"><?php next_comments_link(esc_html__('Próximos comentários', 'wolfx-wp')); ?></div>
                </div>
            </nav>
        <?php endif; ?>

        <?php if (!comments_open()) : ?>
            <p class="no-comments"><?php esc_html_e('Os comentários estão fechados.', 'wolfx-wp'); ?></p>
        <?php endif; ?>
    <?php endif; ?>

    <?php
    comment_form(array(
        'title_reply'          => esc_html__('Deixe um comentário', 'wolfx-wp'),
        'title_reply_to'       => esc_html__('Deixe um comentário para %s', 'wolfx-wp'),
        'cancel_reply_link'    => esc_html__('Cancelar resposta', 'wolfx-wp'),
        'label_submit'         => esc_html__('Enviar comentário', 'wolfx-wp'),
        'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . esc_html__('Comentário', 'wolfx-wp') . '</label><textarea id="comment" name="comment" cols="45" rows="8" required></textarea></p>',
        'comment_notes_before' => '<p class="comment-notes"><span id="email-notes">' . esc_html__('Seu e-mail não será publicado.', 'wolfx-wp') . '</span>' . esc_html__('Campos obrigatórios são marcados com', 'wolfx-wp') . ' <span class="required">*</span></p>',
        'class_submit'         => 'submit btn btn-primary',
        'class_form'           => 'comment-form',
    ));
    ?>
</div> 