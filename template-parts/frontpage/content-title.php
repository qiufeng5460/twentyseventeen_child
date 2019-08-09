<?php
/**
 * Template part for displaying posts in frontpage
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen_child
 * @since 1.0
 * @version 1.2
 */

?>



    <div class="title-date">
        <div class="title">
            <?php
            //20190701:check wx_link firstly, if not, open default link
            $title_link=get_post_meta(get_the_id(),'wx_link',true);
            $title_link=$title_link ? $title_link:get_permalink();
            //20190701:add target="_blank" for open URL in new view
            //the_title( '<a target="_blank" href="' . esc_url( $title_link ) . '" rel="bookmark">', '</a>' );            
            ?>
            <a target="_blank" href="<?php echo esc_url( $title_link )?>"><?php echo wp_trim_words(get_the_title(),18)?></a>
        </div>
        <div class="date">
            <?php echo get_the_date(); ?>
        </div>
    </div>
    


