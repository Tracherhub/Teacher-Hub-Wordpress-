<?php 
    $thumbsize = !isset($thumbsize) ? workup_get_config( 'blog_item_thumbsize', 'full' ) : $thumbsize;
    $thumb = workup_display_post_thumb($thumbsize);
?>
<article <?php post_class('post post-layout post-grid-v1'); ?>>
    <?php if($thumb) {?>
        <div class="top-image">
            <?php
                echo trim($thumb);
            ?>
         </div>
    <?php } ?>
    <div class="inner-bottom">
        <div class="top-info">
            <div class="avatar-wrapper <?php echo esc_attr( (!has_post_thumbnail())?'no-image':'' ); ?>">
                <?php echo get_avatar( get_the_author_meta( 'user_email' ),70 ); ?>
            </div>
            <div class="name-author">
                <strong class="subfix"><?php echo esc_html__('By','workup') ?></strong> <a class="text-theme" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo get_the_author(); ?></a>
            </div>
        </div>
        <div class="top-info-post-gird flex-middle justify-content-center">
            <div class="date">
                <i class="fa fa-calendar-check-o" aria-hidden="true"></i><?php the_time( get_option('date_format', 'd M, Y') ); ?>
            </div>
            <div class="category">
                <i class="fa fa-folder-o" aria-hidden="true"></i><?php workup_post_categories_first($post); ?>
            </div>
        </div>
        <?php if (get_the_title()) { ?>
            <h4 class="entry-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h4>
        <?php } ?>
        <div class="description hidden-xs"><?php echo workup_substring( get_the_excerpt(),10, '' ); ?></div>
        <a class="btn-readmore text-theme hidden-xs" href="<?php the_permalink(); ?>"><?php esc_html_e('Continue...', 'workup'); ?></a>
    </div>
</article>