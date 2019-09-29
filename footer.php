<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package Core
 * @since Core 1.0
 */
?>

        <?php // load footer if its not disabled
        $kp_classes  = get_post_meta( get_the_ID(), 'kp_classes', true );
        $tf = get_theme_mod( 'template-footer', '' );
        if(!preg_match("/nofooter/i", $kp_classes) && $tf) {
            $post = get_post( $tf );
            if($post) echo apply_filters( 'the_content', $post->post_content );
        } ?>

        <?php wp_footer(); ?>

    </div>
</body>
</html>
