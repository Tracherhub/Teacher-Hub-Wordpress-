<?php
$post_format = get_post_format();
global $post;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="post-layout detail-top">
        <?php if( $post_format == 'link' ) {
            $format = workup_post_format_link_helper( get_the_content(), get_the_title() );
            $title = $format['title'];
            $link = workup_get_link_attributes( $title );
            $thumb = workup_post_thumbnail('', $link);
            echo trim($thumb);
        } elseif(has_post_thumbnail()) { ?>
            <div class="top-image">
                <div class="entry-thumb">
                    <?php
                        $thumb = workup_post_thumbnail();
                        echo trim($thumb);
                    ?>
                </div>
            </div>
        <?php } ?>
    </div>

	<div class="entry-content-detail <?php echo esc_attr((!has_post_thumbnail())?'not-img-featured':'' ); ?>">
         <div class="top-info">
            <span class="name-author">
                <strong class="subfix"><?php echo esc_html__('By','workup') ?></strong> <a class="text-theme" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo get_the_author(); ?></a>
            </span>
            <span class="space">|</span>
            <a href="<?php the_permalink(); ?>"><?php the_time( get_option('date_format', 'd M, Y') ); ?></a>
            <span class="space">|</span>
            <span class="comments"><?php comments_number( esc_html__('0 Comments', 'workup'), esc_html__('1 Comment', 'workup'), esc_html__('% Comments', 'workup') ); ?></span>
        </div>
        <?php if (get_the_title()) { ?>
            <h1 class="entry-title">
                <?php the_title(); ?>
            </h1>
        <?php } ?>
    	<div class="single-info info-bottom">
            <div class="entry-description">
                <?php
                    
                        the_content();
                ?>
            </div><!-- /entry-content -->
    		<?php
    		wp_link_pages( array(
    			'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'workup' ) . '</span>',
    			'after'       => '</div>',
    			'link_before' => '<span>',
    			'link_after'  => '</span>',
    			'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'workup' ) . ' </span>%',
    			'separator'   => '',
    		) );
    		?>
            <?php  
                $posttags = get_the_tags();
            ?>
            <?php if( !empty($posttags) || workup_get_config('show_blog_social_share', false) ){ ?>
        		<div class="tag-social clearfix">
                    <?php workup_post_tags(); ?>
        			<?php if( workup_get_config('show_blog_social_share', false) ) {
        				get_template_part( 'template-parts/sharebox' );
        			} ?>
        		</div>
            <?php } ?>
            
    	</div>
    </div>
</article>