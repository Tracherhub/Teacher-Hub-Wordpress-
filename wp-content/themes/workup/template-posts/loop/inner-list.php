<?php 
global $post;
$thumbsize = !isset($thumbsize) ? workup_get_config( 'blog_item_thumbsize', 'full' ) : $thumbsize;
$thumb = workup_display_post_thumb($thumbsize);
?>
<article <?php post_class('post post-layout post-list-item'); ?>>
    <div class="list-inner">
        <?php
            if ( !empty($thumb) ) {
                ?>
                <div class="top-image">
                    <?php
                        echo trim($thumb);
                    ?>
                 </div>
                <?php
            }
        ?>
        <div class="<?php echo (!empty($thumb))?'col-content':'col-content-full'; ?>">
            <?php if (get_the_title()) { ?>
                <h4 class="entry-title">
                    <?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
                        <div class="stick-icon"><i class="ti-pin2"></i></div>
                    <?php endif; ?>
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h4>
            <?php } ?>
            <div class="top-info flex-middle-sm">
                <div class="flex-middle hidden-xs">
                    <div class="avatar-wrapper">
                        <?php echo get_avatar( get_the_author_meta( 'user_email' ),40 ); ?>
                    </div>
                    <div class="name-author">
                        <a class="text-theme" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo get_the_author(); ?></a>
                    </div>
                </div>
                <div class="date">
                    <i class="fa fa-calendar-check-o" aria-hidden="true"></i><?php the_time( get_option('date_format', 'd M, Y') ); ?>
                </div>
                <div class="category">
                    <i class="fa fa-folder-o" aria-hidden="true"></i><?php workup_post_categories_first($post); ?>
                </div>
            </div>
            <div class="description hidden-xs"><?php echo workup_substring( get_the_excerpt(),28, '...' ); ?></div>
            <div class="description visible-xs"><?php echo workup_substring( get_the_excerpt(),15, '...' ); ?></div>
            <a class="btn-readmore text-theme" href="<?php the_permalink(); ?>"><?php esc_html_e('Continue...', 'workup'); ?></a>
        </div>
    </div>
</article>