<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen_child
 * @since 1.0
 * @version 1.2
 */

?>


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="title-date">
        <div class="title">
            <?php
            //20190701:check wx_link firstly, if not, open default link
            $title_link=get_post_meta(get_the_id(),'wx_link',true);
            $title_link=$title_link ? $title_link:get_permalink();
            //20190701:add target="_blank" for open URL in new view
            the_title( '<a target="_blank" href="' . esc_url( $title_link ) . '" rel="bookmark">', '</a>' );
            ?>
        </div>
        <div class="date">
            <?php
               echo get_the_date();
            ?>
        </div>
    </div>
    
</article><!-- #post-<?php the_ID(); ?> -->