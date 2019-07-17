<?php
/**
 * Template part only for displaying faculty
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
    <div class="faculty">
        <div class="faculty-image">
            <?php
            $image_link=get_post_meta(get_the_id(),'wx_link',true);
            $image_link=$image_link ? $image_link:get_permalink();

            ?>
            <a target="_blank" href="<?php echo esc_url( $image_link ) ?>">
               <?php the_post_thumbnail(array(150,150)); ?>
            </a>
        </div>
        <div class="faculty-abstract">
            <?php the_excerpt(); ?>
        </div>
    </div>
    
</article><!-- #post-<?php the_ID(); ?> -->